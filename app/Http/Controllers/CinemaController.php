<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\CinemaTiming;
use App\Models\City;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\MovieImage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use DB;

class CinemaController extends Controller
{
    //
    public function index()
    {
        $cinemas = Cinema::with(['timings'])->get();

        $cinemas = $cinemas->map(function ($cinema) {

            // Fetch city name if city relationship or lookup is required
            $cinema->city_name = City::find($cinema->city_id)?->name ?? 'Unknown City';

            // Map timings
            $cinema->timings = $cinema->timings->map(function ($timing) {
                return [
                    'start_time' => $timing->start_time,
                    'end_time' => $timing->end_time,
                    'status' => $timing->status ? 'Active' : 'Inactive',
                ];
            });

            // Handle cinema status
            $cinema->status_label = $cinema->status ? 'Active' : 'Inactive';

            return $cinema;
        });

        return view('admin.cinemas.index', compact('cinemas'));
    }


    public function create()
    {
        $cities = City::where('status', 1)->get();
        return view('admin.cinemas.create', compact('cities'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'description' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'start_time.*' => 'required|date_format:H:i',
            'end_time.*' => 'required|date_format:H:i',
        ]);

        try {
            // Begin a transaction
            \DB::beginTransaction();

            // Create the cinema
            $cinema = Cinema::create([
                'name' => $validatedData['title'],
                'address' => $validatedData['address'],
                'description' => $validatedData['description'],
                'city_id' => $validatedData['city_id'],
                'status' => 1, // Active by default
            ]);

            // Insert show timings
            if ($request->has('start_time') && $request->has('end_time')) {
                $timings = [];
                foreach ($request->start_time as $key => $startTime) {
                    $timings[] = [
                        'cinema_id' => $cinema->id,
                        'start_time' => $startTime,
                        'end_time' => $request->end_time[$key],
                        'status' => 1, // Active by default
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                CinemaTiming::insert($timings);
            }

            // Commit the transaction
            \DB::commit();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Cinema and its show timings were successfully created!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            \DB::rollBack();

            // Log the error for debugging
            \Log::error('Error creating cinema: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the cinema. Please try again later.',
            ], 500);
        }
    }


    public function edit($id)
    {
        // Find the cinema record by ID
        $cinema = Cinema::with(['timings'])->findOrFail($id);

        // Fetch all cities to populate the city dropdown in the edit form
        $cities = City::where('status', 1)->get();

        foreach ($cinema->timings as $timing) {
            $timing->start_time = Carbon::parse($timing->start_time)->format('H:i');
            $timing->end_time = Carbon::parse($timing->end_time)->format('H:i');
        }

        // Pass cinema and cities to the view
        return view('admin.cinemas.edit', compact('cinema', 'cities'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'description' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'start_time.*' => 'required|date_format:H:i',
            'end_time.*' => 'required|date_format:H:i',
        ]);

        try {
            // Begin a transaction
            \DB::beginTransaction();

            // Find the cinema and update its details
            $cinema = Cinema::findOrFail($id);
            $cinema->update([
                'name' => $validatedData['title'],
                'address' => $validatedData['address'],
                'description' => $validatedData['description'],
                'city_id' => $validatedData['city_id'],
            ]);

            // Update the show timings
            if ($request->has('start_time') && $request->has('end_time')) {
                // First, delete existing timings
                CinemaTiming::where('cinema_id', $cinema->id)->delete();

                // Insert updated timings
                $timings = [];
                foreach ($request->start_time as $key => $startTime) {
                    $timings[] = [
                        'cinema_id' => $cinema->id,
                        'start_time' => $startTime,
                        'end_time' => $request->end_time[$key],
                        'status' => 1, // Active by default
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                CinemaTiming::insert($timings);
            }

            // Commit the transaction
            \DB::commit();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Cinema and its show timings were successfully updated!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            \DB::rollBack();

            // Log the error for debugging
            \Log::error('Error updating cinema: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the cinema. Please try again later.',
            ], 500);
        }
    }




    public function status($id)
    {
        try {
            $movie = Cinema::find($id);
            $movie->status = ($movie->status === 1) ? 0 : 1;
            $movie->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Cinema status updated successfully!',
                'data' => null
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }


    public function list(Request $request)
    {
        // Get languages and genres
        $languages = Language::where('status', 1)->get();
        $genres = Genre::where('status', 1)->get();

        // Build the query for movies based on the filters
        $query = Movie::with(['bannerImage', 'coverImage', 'sliderImages']);

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
}
