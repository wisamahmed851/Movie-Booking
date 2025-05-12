<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\City;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\MovieImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    //
    public function movies(Request $request)
    {
        $query = Movie::with(['coverImage', 'assignMovies.assignMovieDetails', 'assignMovies.cinema.city'])
            ->where('status', 1);

        if ($request->has('sortBy') && !empty($request->sortBy)) {
            if ($request->sortBy == 'exclusive') {
                $query->where('isExclusive', 1);
            } elseif ($request->sortBy == 'trending') {
                $query->where('isTrending', 1);
            }
        }

        $movies = $query->paginate($request->Pagination ?? 12);

        $movies->getCollection()->transform(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'cover_image' => $movie->coverImage->cover_image_path ?? null,
                'duration' => $movie->duration,
                'release_date' => $movie->release_date,
                'average_rating' => $movie->average_rating,
                'tomatometer' => $movie->tomatometer,
                'trailer' => $movie->trailler,
                'ratings_count' => $movie->ratings_count,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $movies->items(),
            'pagination' => [
                'current_page' => $movies->currentPage(),
                'last_page' => $movies->lastPage(),
                'per_page' => $movies->perPage(),
                'total' => $movies->total(),
            ]
        ]);
    }

    public function loadmovies(Request $request)
    {
        $query = Movie::with(['bannerImage', 'coverImage', 'sliderImages'])
            ->where('status', 1);

        if ($request->has('languages') && !empty($request->languages)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->languages as $language) {
                    $q->orWhereJsonContains('language_ids', $language);
                }
            });
        }

        if ($request->has('genres') && !empty($request->genres)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->genres as $genre) {
                    $q->orWhereJsonContains('genre_ids', $genre);
                }
            });
        }

        if ($request->has('sortBy') && !empty($request->sortBy)) {
            if ($request->sortBy == 'exclusive') {
                $query->where('isExclusive', 1);
            } elseif ($request->sortBy == 'trending') {
                $query->where('isTrending', 1);
            }
        }

        $movies = $query->paginate($request->Pagination ?? 12);

        $movies->getCollection()->transform(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'cover_image' => $movie->coverImage->cover_image_path ?? null,
                'banner_image' => $movie->bannerImage->banner_image_path ?? null,
                // 'slider_images' => $movie->sliderImages->pluck('slider_images')->toArray() ?? [],
                'genres' => Genre::whereIn('id', $movie->genre_ids ?? [])->pluck('name')->toArray(),
                'languages' => Language::whereIn('id', $movie->language_ids ?? [])->pluck('name')->toArray(),
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $movies->items(),
            'pagination' => [
                'current_page' => $movies->currentPage(),
                'last_page' => $movies->lastPage(),
                'per_page' => $movies->perPage(),
                'total' => $movies->total(),
            ]
        ]);
    }
    public function details($id)
    {
        $movie = Movie::with(['bannerImage', 'coverImage', 'sliderImages'])->findOrFail($id);
        $genres = Genre::where('status', 1)->whereIn('id', $movie->genre_ids)->get();
        $languages = Language::whereIn('id', $movie->language_ids)->get();
        $movie->slider_images = $movie->sliderImages?->slider_images ?? [];
        return response()->json([
            'movie' => $movie,
            'genres' => $genres,
            'languages' => $languages
        ]);
    }
    public function ticketplan(Request $request, $id)
    {
        $query = DB::table('assign_movies as am')
            ->where('am.movie_id', $id)
            ->join('assign_movies_details as amd', 'am.id', '=', 'amd.assign_movies_id')
            ->join('cinema_timings as ct', 'amd.cinema_timings_id', '=', 'ct.id')
            ->join('cinemas as c', 'am.cinema_id', '=', 'c.id')
            ->join('movies as m', 'am.movie_id', '=', 'm.id')
            ->select(
                'm.title as movie_title',
                'm.language_ids as language_ids',
                'm.id as movie_id',
                'm.banner_image_id as banner_image_id',
                'c.name as cinema_name',
                'amd.show_date',
                'amd.id as assigned_show_id',
                'ct.start_time',
                'ct.end_time'
            );

        // Apply filters if AJAX request

        if ($request->has('date') && !empty($request->date)) {
            $query->where('amd.show_date', $request->date);
        }
        if ($request->has('cinema') && !empty($request->cinema)) {
            $query->where('c.id', $request->cinema);
        }
        if ($request->has('city') && !empty($request->city)) {
            $query->where('c.city_id', $request->city);
        }

        $cinemasData = $query->orderBy('amd.show_date')->orderBy('ct.start_time')->get();

        $movie = Movie::find($id);
        $languagesName = [];
        $bannerImage = MovieImage::find($movie->banner_image_id);

        if ($bannerImage && $bannerImage->banner_image_path) {
            $bannerImage = $bannerImage->banner_image_path;
        }
        if ($movie->language_ids) {
            $languagesName = Language::whereIn('id', $movie->language_ids)->pluck('name')->toArray();
        }
        // Format Data
        $formattedData = [
            'movie' => $cinemasData->first()->movie_title ?? 'Unknown',
            'movie_id' => $cinemasData->first()->movie_id ?? 'Unknown',
            'languages' => $languagesName,
            'banner_image' => $bannerImage ?? null,
            'cinemas' => [],
        ];
        

        foreach ($cinemasData as $data) {
            $formattedData['cinemas'][$data->cinema_name][] = [
                'show_date' => $data->show_date,
                'assigned_show_id' => $data->assigned_show_id,
                'start_time' => $data->start_time,
                'end_time' => $data->end_time
            ];
        }
        if($request->has('date') || $request->has('cinema') || $request->has('city')){
            return response()->json([
            'status' => 'success',
            'data' => [
                'formattedData' => $formattedData,
            ]
        ]);
        }


        $cinemas = Cinema::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $availableDates = DB::table('assign_movies as am')
            ->where('am.movie_id', $id)
            ->join('assign_movies_details as amd', 'am.id', '=', 'amd.assign_movies_id')
            ->distinct('amd.show_date')
            ->pluck('amd.show_date');

        return response()->json([
            'status' => 'success',
            'data' => [
                'formattedData' => $formattedData,
                'cinemas' => $cinemas,
                'cities' => $cities,
                'availableDates' => $availableDates
            ]
        ]);
    }
}
