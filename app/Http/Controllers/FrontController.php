<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\City;
use App\Models\Language;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get base cinema and city data
        $cinemas = Cinema::where('status', 1)->get();
        $cities = City::where('status', 1)->get();

        // Build the base movie query with joins
        $query = DB::table('movies as m')
            ->select(
                'm.id',
                'm.title',
                'm.language_ids',
                'mi.cover_image_path as cover_image',
                DB::raw('MIN(amd.show_date) as next_showing'),
                DB::raw('GROUP_CONCAT(DISTINCT c.city_id) as city_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT am.cinema_id) as cinema_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT amd.show_date) as available_dates')
            )
            ->leftJoin('movie_images as mi', 'm.cover_image_id', '=', 'mi.id')
            ->leftJoin('assign_movies as am', 'm.id', '=', 'am.movie_id')
            ->leftJoin('assign_movies_details as amd', 'am.id', '=', 'amd.assign_movies_id')
            ->leftJoin('cinemas as c', 'am.cinema_id', '=', 'c.id')
            ->where('m.status', 1)
            ->groupBy('m.id');

        // Apply filters
        if ($request->filled('city')) {
            $query->where('c.city_id', $request->city);
        }

        if ($request->filled('cinema')) {
            $query->where('am.cinema_id', $request->cinema);
        }

        if ($request->filled('date')) {
            $query->where('amd.show_date', $request->date);
        }

        // Get paginated results
        $movies = $query->take(3)->get();

        // Transform movie data
        $movies->transform(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'cover_image' => $movie->cover_image,
                'next_showing' => $movie->next_showing,
                'languages' => Language::whereIn('id', json_decode($movie->language_ids ?? '[]'))
                    ->pluck('name')
                    ->toArray(),
                'cities' => City::whereIn('id', explode(',', $movie->city_ids))
                    ->pluck('name')
                    ->toArray(),
                'cinemas' => Cinema::whereIn('id', explode(',', $movie->cinema_ids))
                    ->pluck('name')
                    ->toArray(),
                'available_dates' => array_unique(explode(',', $movie->available_dates))
            ];
        });

        // Get distinct available dates from all movies
        $availableDates = collect($movies)
            ->flatMap(fn($m) => $m['available_dates'])
            ->unique()
            ->sort()
            ->values();

        return view('frontend.dashboard.index', compact('movies', 'cinemas', 'cities', 'availableDates'));
    }
    public function filter(Request $request)
    {
        // Base query (same as index method)
        $query = DB::table('movies as m')
            ->select(
                'm.id',
                'm.title',
                'm.language_ids',
                'mi.cover_image_path as cover_image',
                DB::raw('MIN(amd.show_date) as next_showing'),
                DB::raw('GROUP_CONCAT(DISTINCT c.city_id) as city_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT am.cinema_id) as cinema_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT amd.show_date) as available_dates')
            )
            ->leftJoin('movie_images as mi', 'm.cover_image_id', '=', 'mi.id')
            ->leftJoin('assign_movies as am', 'm.id', '=', 'am.movie_id')
            ->leftJoin('assign_movies_details as amd', 'am.id', '=', 'amd.assign_movies_id')
            ->leftJoin('cinemas as c', 'am.cinema_id', '=', 'c.id')
            ->where('m.status', 1)
            ->groupBy('m.id');

        // Apply filters
        if ($request->filled('city')) {
            $query->where('c.city_id', $request->city);
        }

        if ($request->filled('cinema')) {
            $query->where('am.cinema_id', $request->cinema);
        }

        if ($request->filled('date')) {
            $query->where('amd.show_date', $request->date);
        }

        if ($request->filled('search')) {
            $query->where('m.title', 'like', '%' . $request->search . '%');
        }

        // Get results
        $movies = $query->take(3)->get();

        // Transform movies
        $movies->transform(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'cover_image' => $movie->cover_image,
                'next_showing' => $movie->next_showing,
                'languages' => Language::whereIn('id', json_decode($movie->language_ids ?? '[]'))
                    ->pluck('name')
                    ->toArray(),
                'cities' => City::whereIn('id', explode(',', $movie->city_ids))
                    ->pluck('name')
                    ->toArray(),
                'cinemas' => Cinema::whereIn('id', explode(',', $movie->cinema_ids))
                    ->pluck('name')
                    ->toArray(),
                'available_dates' => array_unique(explode(',', $movie->available_dates))
            ];
        });

        // Get available dates
        $availableDates = collect($movies)
            ->flatMap(fn($m) => $m['available_dates'])
            ->unique()
            ->sort()
            ->values();

        // Render HTML
        $moviesHtml = view('frontend.dashboard.partials._movies', compact('movies'))->render();

        return response()->json([
            'moviesHtml' => $moviesHtml,
            'availableDates' => $availableDates
        ]);
    }
}
