<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\City;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\MovieImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    //
    public function index()
    {
        $movies = Movie::with(['bannerImage', 'coverImage', 'sliderImages'])->get();

        $movies = $movies->map(function ($movie) {
            $movie->genres = $movie->genre_ids ?? [];
            $movie->languages = $movie->language_ids ?? [];

            // Fetch genre and language names
            $movie->genres = Genre::whereIn('id', $movie->genres)
                ->pluck('name')
                ->toArray();
            $movie->languages = Language::whereIn('id', $movie->languages)
                ->pluck('name')
                ->toArray();

            // Handle related images
            $movie->banner_image = $movie->bannerImage?->banner_image_path ?? null;
            $movie->cover_image = $movie->coverImage?->cover_image_path ?? null;

            // `slider_images` is already cast to an array in the MovieImage model
            $movie->slider_images = $movie->sliderImages?->slider_images ?? [];

            return $movie;
        });

        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $genres = Genre::where('status', 1)->get();
        $languages = Language::where('status', 1)->get();
        return view('admin.movies.create', compact('genres', 'languages'));
    }

    // Store the newly created movie
    public function store(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'trailer_url' => 'required|string',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'duration' => 'required|integer',
            'isTrending' => 'required|boolean',
            'isExclusive' => 'required|boolean',
            'genre_ids' => 'required|array',
            'language_ids' => 'required|array',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'slider_images' => 'required|array|min:1',
            'slider_images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        // Store images and get their paths
        $coverImage = $request->file('cover_image')->store('movie_images', 'public');
        $bannerImage = $request->file('banner_image')->store('movie_images', 'public');
        $sliderImages = [];
        foreach ($request->file('slider_images') as $image) {
            $sliderImages[] = $image->store('movie_images', 'public');
        }

        // Create movie image record
        $movieImage = MovieImage::create([
            'cover_image_path' => $coverImage,
            'banner_image_path' => $bannerImage,
            'slider_images' => $sliderImages,
        ]);
        // Create the movie
        $movie = Movie::create([
            'title' => $request->title,
            'trailler' => $request->trailer_url,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'duration' => $request->duration,
            'isTrending' => $request->isTrending,
            'isExclusive' => $request->isExclusive,
            'genre_ids' => $request->genre_ids,
            'language_ids' => $request->language_ids,
            'cover_image_id' => $movieImage->id,
            'banner_image_id' => $movieImage->id,
            'slider_image_id' => $movieImage->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Movie created successfully!',
            'movie' => $movie,
        ]);
    }

    public function edit($id)
    {
        $movie = Movie::with(['bannerImage', 'coverImage', 'sliderImages'])->findOrFail($id);
        $genres = Genre::where('status', 1)->get();
        $languages = Language::where('status', 1)->get();

        return view('admin.movies.edit', compact('movie', 'genres', 'languages'));
    }
    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);


        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'trailer' => 'required|string', // Match the field name
            'description' => 'required|string',
            'release_date' => 'required|date',
            'duration' => 'required|integer',
            'isTrending' => 'required|boolean',
            'isExclusive' => 'required|boolean',
            'genre_ids' => 'required|array',
            'language_ids' => 'required|array',
            'cover_image' => '|image|mimes:jpeg,png,jpg,gif',
            'banner_image' => '|image|mimes:jpeg,png,jpg,gif',
            'slider_images' => '|array|min:1',
            'slider_images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        // Update images
        $movieImage = $movie->bannerImage;

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($movieImage->cover_image_path);
            $movieImage->cover_image_path = $request->file('cover_image')->store('movie_images', 'public');
        }

        if ($request->hasFile('banner_image')) {
            Storage::disk('public')->delete($movieImage->banner_image_path);
            $movieImage->banner_image_path = $request->file('banner_image')->store('movie_images', 'public');
        }

        if ($request->hasFile('slider_images')) {
            foreach ($movieImage->slider_images as $sliderImage) {
                Storage::disk('public')->delete($sliderImage);
            }
            $sliderImages = [];
            foreach ($request->file('slider_images') as $image) {
                $sliderImages[] = $image->store('movie_images', 'public');
            }
            $movieImage->slider_images = $sliderImages;
        }

        $movieImage->save();

        // Update movie details
        $movie->update([
            'title' => $request->title,
            'trailler' => $request->trailer, // Use correct key
            'description' => $request->description,
            'release_date' => $request->release_date,
            'duration' => $request->duration,
            'isTrending' => $request->isTrending ? true : false, // Explicit boolean casting
            'isExclusive' => $request->isExclusive ? true : false,
            'genre_ids' => $request->genre_ids,
            'language_ids' => $request->language_ids,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Movie updated successfully!']);
    }

    public function status($id)
    {
        try {
            $movie = Movie::find($id);
            $movie->status = ($movie->status === 1) ? 0 : 1;
            $movie->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Movie status is updated',
                'data' => null
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }
    public function loadmovies(Request $request)
    {
        // Build the query for movies with relationships
        $query = Movie::with(['bannerImage', 'coverImage', 'sliderImages']);

        // Apply filters for languages
        if ($request->has('languages') && !empty($request->languages)) {
            foreach ($request->languages as $language) {
                $query->orWhereJsonContains('language_ids', $language);
            }
        }

        // Apply filters for genres
        if ($request->has('genres') && !empty($request->genres)) {
            foreach ($request->genres as $genre) {
                $query->orWhereJsonContains('genre_ids', $genre);
            }
        }
        if ($request->has('sortBy') && !empty($request->sortBy)) {
            switch ($request->sortBy) {
                case 'exclusive':
                    $query->where('isExclusive', 1);
                    break;
                case 'trending':
                    $query->where('isTrending', 1);
                    break;
            }
        }

        if ($request->has('Pagination') && !empty($request->Pagination)) {
            $movies = $query->paginate($request->Pagination, ['*'], 'page', $request->page);
        } else {
            $movies = $query->paginate(12);
        }
        // Paginate the results
        // Adjust the number of movies per page as needed

        // Transform the movies to include additional data
        $movies->getCollection()->transform(function ($movie) {
            $movie->genres = Genre::whereIn('id', $movie->genre_ids ?? [])->pluck('name')->toArray();
            $movie->languages = Language::whereIn('id', $movie->language_ids ?? [])->pluck('name')->toArray();
            $movie->banner_image = $movie->bannerImage?->banner_image_path ?? null;
            $movie->cover_image = $movie->coverImage?->cover_image_path ?? null;
            $movie->slider_images = $movie->sliderImages?->slider_images ?? [];
            return $movie;
        });

        // Generate pagination HTML (if necessary for frontend)
        $pagination = $movies->links('vendor.pagination.customePagination')->toHtml();

        $layout = $request->get('layouts', 'grid');
        $moviesHtml = view("frontend.movies.partials.{$layout}", compact('movies'))->render();

        // If it's an AJAX request, return JSON with movies and pagination
        if ($request->ajax()) {
            return response()->json([
                'moviesHtml' => $moviesHtml,
                'pagination' => $pagination,
            ]);
        }

        // If not an AJAX request, return a success response with the movies data
        return response()->json([
            'status' => 'success',
            'movies' => $movies,
        ]);
    }


    public function list(Request $request)
    {
        // Get languages and genres
        $languages = Language::where('status', 1)->get();
        $genres = Genre::where('status', 1)->get();

        // Build the query for movies based on the filters
        $query = Movie::with(['bannerImage', 'coverImage', 'sliderImages'])->where('status', 1);

        if ($request->has('languages')) {
            $query->whereIn('language_id', $request->languages);
        }

        if ($request->has('genres')) {
            $query->whereIn('genre_id', $request->genres);
        }

        // Fetch the movies with pagination
        $movies = $query->paginate(12);
        // Map movie data to include image paths on the actual items (not on the paginator)
        $movies->getCollection()->transform(function ($movie) {
            $movie->banner_image = $movie->bannerImage?->banner_image_path ?? null;
            $movie->cover_image = $movie->coverImage?->cover_image_path ?? null;
            return $movie;
        });

        // Get pagination links (works on the Paginator object, not the collection)
        $pagination = $movies->links('vendor.pagination.customePagination')->toHtml();

        // If the request is AJAX, return the filtered movie list and pagination
        if ($request->ajax()) {
            $moviesHtml = view('frontend.movies.partials.movies', compact('movies'))->render();

            return response()->json(['moviesHtml' => $moviesHtml, 'pagination' => $pagination]);
        }

        // For non-AJAX requests, return the view with the movies, genres, and languages
        return view('frontend.movies.grid', compact('movies', 'genres', 'languages', 'pagination'));
    }



    public function details($id)
    {
        $movie = Movie::with(['bannerImage', 'coverImage', 'sliderImages'])->findOrFail($id);
        $genres = Genre::where('status', 1)->whereIn('id', $movie->genre_ids)->get();
        $languages = Language::whereIn('id', $movie->language_ids)->get();
        $movie->slider_images = $movie->sliderImages?->slider_images ?? [];

        return view('frontend.movies.details', compact('movie', 'genres', 'languages'));
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
                'm.id as movie_id',
                'c.name as cinema_name',
                'amd.show_date',
                'amd.id as assigned_show_id',
                'ct.start_time',
                'ct.end_time'
            );

        // Apply filters if AJAX request
        if ($request->ajax()) {
            if ($request->has('date') && !empty($request->date)) {
                $query->where('amd.show_date', $request->date);
            }
            if ($request->has('cinema') && !empty($request->cinema)) {
                $query->where('c.id', $request->cinema);
            }
            if ($request->has('city') && !empty($request->city)) {
                $query->where('c.city_id', $request->city);
            }
        }
        $cinemasData = $query->orderBy('amd.show_date')->orderBy('ct.start_time')->get();

        // Format Data
        $formattedData = [
            'movie' => $cinemasData->first()->movie_title ?? 'Unknown',
            'movie_id' => $cinemasData->first()->movie_id ?? 'Unknown',
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

        // If AJAX request, return only partial view
        if ($request->ajax()) {
            return view('frontend.ticketBooking._cinema_list', compact('formattedData'))->render();
        }

        $cinemas = Cinema::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $availableDates = DB::table('assign_movies as am')
            ->where('am.movie_id', $id)
            ->join('assign_movies_details as amd', 'am.id', '=', 'amd.assign_movies_id')
            ->distinct('amd.show_date')
            ->pluck('amd.show_date');

        log::error($formattedData);

        return view('frontend.ticketBooking.ticketPlane', compact('formattedData', 'cinemas', 'cities', 'availableDates'));
    }


    function getMovieDetails($id)
    {
        $movie = Movie::with(['bannerImage', 'coverImage', 'sliderImages'])->findOrFail($id);
        $genres = Genre::where('status', 1)->whereIn('id', $movie->genre_ids)->get();
        $languages = Language::whereIn('id', $movie->language_ids)->get();
        $movie->slider_images = $movie->sliderImages?->slider_images ?? [];

        return response()->json([
            'status' => 'success',
            'movie' => $movie,
            'genres' => $genres,
            'languages' => $languages,
        ]);
    }

    public function seatsplan($id){
        
        return view('frontend.seatPlans.seatPlan');
    }
}
