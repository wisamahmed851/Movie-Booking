<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\City;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use Illuminate\Http\Request;

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
}
