<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\City;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        return response()->json([
            'movies' => $movies,
            'cinemas' => $cinemas,
            'cities' => $cities,
            'available_dates' => $availableDates
        ]);
        // return view('frontend.dashboard.index', compact('movies', 'cinemas', 'cities', 'availableDates'));
    }
    
    public function filter(Request $request)
    {
        // Start Eloquent Query
        $query = Movie::with(['coverImage', 'assignMovies.cinema', 'assignMovies.details'])
            ->where('status', 1);

        // Apply filters
        if ($request->filled('city')) {
            $query->whereHas('assignMovies.cinema', function ($q) use ($request) {
                $q->where('city_id', $request->city);
            });
        }

        if ($request->filled('cinema')) {
            $query->whereHas('assignMovies', function ($q) use ($request) {
                $q->where('cinema_id', $request->cinema);
            });
        }

        if ($request->filled('date')) {
            $query->whereHas('assignMovies.details', function ($q) use ($request) {
                $q->where('show_date', $request->date);
            });
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Fetch only 3 results
        $movies = $query->take(3)->get();

        // Transform each movie
        $movies->transform(function ($movie) {
            // Gather all show dates from details
            $dates = $movie->assignMovies->flatMap(function ($am) {
                return $am->details->pluck('show_date');
            });

            // Gather all city IDs
            $cityIds = $movie->assignMovies->pluck('cinema.city_id')->filter()->unique()->values();

            // Gather all cinema IDs
            $cinemaIds = $movie->assignMovies->pluck('cinema_id')->filter()->unique()->values();

            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'cover_image' => $movie->coverImage->cover_image_path ?? null,
                'next_showing' => $dates->min(),
                'languages' => Language::whereIn('id', $movie->language_ids ?? [])->pluck('name')->toArray(),
                'cities' => City::whereIn('id', $cityIds)->pluck('name')->toArray(),
                'cinemas' => Cinema::whereIn('id', $cinemaIds)->pluck('name')->toArray(),
                'available_dates' => $dates->unique()->values()->toArray()
            ];
        });

        // Get all unique dates from movies
        $availableDates = $movies->flatMap(fn($m) => $m['available_dates'])
            ->unique()
            ->sort()
            ->values();

        return response()->json([
            'moviesHtml' => $movies,
            'availableDates' => $availableDates
        ]);
    }
}
