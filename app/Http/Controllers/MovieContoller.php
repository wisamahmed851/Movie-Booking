<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\MovieImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class MovieContoller extends Controller
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
            'description' => 'required|string',
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
            'description' => $request->description,
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
            'description' => 'required|string',
            'genre_ids' => 'required|array',
            'language_ids' => 'required|array',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'slider_images' => 'nullable|array',
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
            'description' => $request->description,
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
    public function grid()
    {
        return view('frontend.movies.grid');
    }
    public function details()
    {
        return view('frontend.movies.details');
    }
}
