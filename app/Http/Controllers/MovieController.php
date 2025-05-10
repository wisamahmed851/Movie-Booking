<?php

namespace App\Http\Controllers;

use App\Models\BookingDetails;
use App\Models\Bookings;
use App\Models\Cinema;
use App\Models\CinemaSeat;
use App\Models\City;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\MovieImage;
use Barryvdh\DomPDF\Facade\PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stripe\Stripe;

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
    public function destroy(string $id)
    {
        //
        try {
            $movie = Movie::find($id);
            if (!$movie) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Movie not found',
                    'data' => null
                ]);
            }
            $movie->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Movie is deleted',
                'data' => null
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
                'data' => null
            ]);
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
        $cinemas = Cinema::where('status', 1)->get();
        $cities = City::where('status', 1)->get();

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
        return view('frontend.movies.grid', compact('movies', 'cities', 'cinemas', 'genres', 'languages', 'pagination'));
    }

    public function movies(Request $request)
    {
        // Fetch filters
        $languages = Language::where('status', 1)->get();
        $genres = Genre::where('status', 1)->get();
        $cinemas = Cinema::where('status', 1)->get();
        $cities = City::where('status', 1)->get();

        // Build the base query using DB::table
        $query = DB::table('movies as m')
            ->select(
                'm.id',
                'm.title',
                'm.language_ids',
                'm.duration',
                'm.release_date',
                'm.ratings_count',
                'm.average_rating',
                'm.tomatometer',
                'm.trailler',
                'mi.cover_image_path as cover_image',
                DB::raw('MIN(amd.show_date) as next_showing'),
                DB::raw('GROUP_CONCAT(DISTINCT c.city_id) as city_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT am.cinema_id) as cinema_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT amd.show_date ORDER BY amd.show_date ASC) as available_dates')
            )
            ->leftJoin('movie_images as mi', 'm.cover_image_id', '=', 'mi.id')
            ->leftJoin('assign_movies as am', 'm.id', '=', 'am.movie_id')
            ->leftJoin('assign_movies_details as amd', 'am.id', '=', 'amd.assign_movies_id')
            ->leftJoin('cinemas as c', 'am.cinema_id', '=', 'c.id')
            ->where('m.status', 1)
            ->groupBy('m.id');

        // Apply filters
        if ($request->has('languages') && !empty($request->languages)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->languages as $language) {
                    $q->orWhereJsonContains('m.language_ids', $language);
                }
            });
        }

        if ($request->has('genres') && !empty($request->genres)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->genres as $genre) {
                    $q->orWhereJsonContains('m.genre_ids', $genre);
                }
            });
        }

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

        if ($request->has('cities') && !empty($request->cities)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->cities as $city) {
                    $q->orWhereRaw("FIND_IN_SET(?, city_ids)", [$city]);
                }
            });
        }

        if ($request->has('cinemas') && !empty($request->cinemas)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->cinemas as $cinema) {
                    $q->orWhereRaw("FIND_IN_SET(?, cinema_ids)", [$cinema]);
                }
            });
        }

        // Sorting
        if ($request->has('sortBy') && !empty($request->sortBy)) {
            switch ($request->sortBy) {
                case 'exclusive':
                    $query->where('m.isExclusive', 1);
                    break;
                case 'trending':
                    $query->where('m.isTrending', 1);
                    break;
            }
        }

        // Pagination handling
        if ($request->has('Pagination') && !empty($request->Pagination)) {
            $movies = $query->paginate($request->Pagination, ['*'], 'page', $request->page);
        } else {
            $movies = $query->paginate(12);
        }


        // Transform the result
        $movies->getCollection()->transform(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'cover_image' => $movie->cover_image,
                'duration' => $movie->duration,
                'release_date' => $movie->release_date,
                'average_rating' => $movie->average_rating,
                'tomatometer' => $movie->tomatometer,
                'trailer' => $movie->trailler,
                'ratings_count' => $movie->ratings_count,

                'next_showing' => $movie->next_showing,
                'languages' => Language::whereIn('id', json_decode($movie->language_ids ?? '[]'))->pluck('name')->toArray(),
                'cities' => City::whereIn('id', explode(',', $movie->city_ids))->pluck('name')->toArray(),
                'cinemas' => Cinema::whereIn('id', explode(',', $movie->cinema_ids))->pluck('name')->toArray(),
                'available_dates' => array_unique(explode(',', $movie->available_dates))
            ];
        });

        // Get distinct available dates from all movies
        $availableDates = collect($movies->items())
            ->flatMap(fn($m) => $m['available_dates'])
            ->unique()
            ->sort()
            ->values();

        // Get pagination HTML
        $pagination = $movies->links('vendor.pagination.customePagination')->toHtml();

        // Handle AJAX response
        if ($request->ajax()) {
            $layout = $request->get('layouts', 'grid');
            $moviesHtml = view("frontend.movies.partials.{$layout}", compact('movies'))->render();

            return response()->json([
                'moviesHtml' => $moviesHtml,
                'pagination' => $pagination,
            ]);
        }

        // Default page load
        return view('frontend.movies.grid', compact('movies', 'cities', 'cinemas', 'genres', 'languages', 'pagination', 'availableDates'));
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
    public function rate(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5'
        ]);

        $rating = $movie->ratings()->updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['rating' => $validated['rating']]
        );

        // Update movie ratings
        $movie->ratings_count = $movie->ratings()->count();
        $movie->average_rating = $movie->ratings()->avg('rating');
        $movie->save();

        return back()->with('success', 'Thanks for rating this movie!');
    }
    public function seatsplan($id)
    {
        $query = DB::table('assign_movies_details as amd')
            ->where('amd.id', $id)
            ->join('cinema_timings as ct', 'amd.cinema_timings_id', '=', 'ct.id')
            ->join('assign_movies as am', 'amd.assign_movies_id', '=', 'am.id')
            ->join('cinemas as c', 'am.cinema_id', '=', 'c.id')
            ->join('movies as m', 'am.movie_id', '=', 'm.id')
            ->select(
                'm.title as movie_title',
                'amd.id as assign_movies_details_id',
                'm.language_ids as language_ids',
                'm.id as movie_id',
                'm.banner_image_id as banner_image_id',
                'c.id as cinema_id', // Fetching cinema ID
                'c.name as cinema_name',
                'amd.show_date',
                'ct.start_time',
                'ct.end_time'
            )
            ->first(); // Get only one record (specific show)

        if (!$query) {
            return abort(404, 'Show not found'); // Handle missing show
        }

        // Fetch all seat numbers for this cinema
        $seats = DB::table('cinema_seats as cs')
            ->join('cinema_seats_categories as csc', 'cs.cinema_seats_categories_id', '=', 'csc.id')
            ->leftJoin('booking_details as bd', 'cs.id', '=', 'bd.seat_id')
            ->leftJoin('bookings as b', function ($join) use ($id) {
                $join->on('bd.booking_id', '=', 'b.id')
                    ->where('b.assign_movies_details_id', '=', $id);
            })
            ->where('cs.cinema_id', $query->cinema_id)
            ->select(
                'cs.id',
                'cs.seat_number',
                'csc.seat_category',
                'csc.price_per_seat',
                'cs.cinema_id',
                DB::raw('MAX(CASE WHEN b.id IS NOT NULL THEN 1 ELSE 0 END) as is_booked')
            )
            ->groupBy('cs.id', 'cs.seat_number', 'csc.seat_category', 'csc.price_per_seat', 'cs.cinema_id')
            ->get();
        // Group seats by category
        $groupedSeats = $seats->groupBy('seat_category');

        $sortedSeats = [];
        $categoriesOrder = ['silver', 'gold', 'platinum']; // Define the desired order
        foreach ($categoriesOrder as $category) {
            if (isset($groupedSeats[$category])) {
                $sortedSeats[$category] = $groupedSeats[$category];
            }
        }
        // Fetch language names
        $languagesName = [];
        if ($query->language_ids) {
            $languagesName = Language::whereIn('id', explode(',', $query->language_ids))->pluck('name')->toArray();
        }
        Log::info($sortedSeats);

        // Fetch banner image
        $bannerImage = MovieImage::find($query->banner_image_id);
        $bannerImagePath = $bannerImage ? $bannerImage->banner_image_path : null;
        // Prepare response data
        $formattedData = [
            'movie' => $query->movie_title ?? 'Unknown',
            'movie_id' => $query->movie_id ?? 'Unknown',
            'languages' => $languagesName,
            'banner_image' => $bannerImagePath,
            'show_date' => $query->show_date,
            'start_time' => $query->start_time,
            'cinema_name' => $query->cinema_name,
            'assign_movies_details_id' => $query->assign_movies_details_id,
            'seats' => $sortedSeats, // Grouped seat list
        ];

        return view('frontend.seatPlans.seatPlan', compact('formattedData'));
    }
    public function checkout(Request $request)
    {
        // If it's a GET request, check for payment status in the query parameters
        if ($request->isMethod('get')) {
            $paymentStatus = $request->query('payment');
            $bookingStatus = $request->query('booking');
            $checkoutData = session('checkoutData');

            return view('frontend.checkOut.check-out', compact(
                'checkoutData',
                'paymentStatus',
                'bookingStatus'
            ));
        }

        // Validate the request
        $request->validate([
            'selected_seats' => 'required',
            'total_price' => 'required|numeric',
            'movie_id' => 'required|exists:movies,id',
            'movie_title' => 'required',
            'show_date' => 'required|date',
            'start_time' => 'required',
            'cinema_name' => 'required',
            'banner_image' => 'required',
            'assign_movies_details_id' => 'required',
        ]);

        // Fetch seat details from the database with a join on cinema_seats_categories
        $seatIds = explode(',', $request->input('selected_seats'));
        $seats = CinemaSeat::whereIn('cinema_seats.id', $seatIds)
            ->join('cinema_seats_categories', 'cinema_seats.cinema_seats_categories_id', '=', 'cinema_seats_categories.id')
            ->select(
                'cinema_seats.id as seat_id',
                'cinema_seats.seat_number',
                'cinema_seats_categories.price_per_seat',
                'cinema_seats_categories.id as cinema_seats_categories_id',
                'cinema_seats_categories.seat_category as category_name' // Ensure you have a 'name' column for the category
            )
            ->get();

        // Group seats by their category
        $groupedSeats = $seats->groupBy('category_name');

        // Calculate total price based on fetched seats
        $totalPrice = $seats->sum('price_per_seat');

        // Fetch movie image
        $movieImage = DB::table('movies as m')
            ->where('m.id', $request->movie_id)
            ->join('movie_images as mi', 'm.banner_image_id', '=', 'mi.id')
            ->select('mi.banner_image_path as image_path')
            ->first();

        // Prepare the data for the view
        $checkoutData = [
            'grouped_seats' => $groupedSeats,
            'total_price' => $totalPrice,
            'movie_id' => $request->input('movie_id'),
            'movie_image' => $movieImage ? $movieImage->image_path : null,
            'assign_movies_details_id' => $request->input('assign_movies_details_id'),
            'movie_title' => $request->input('movie_title'),
            'show_date' => $request->input('show_date'),
            'start_time' => $request->input('start_time'),
            'cinema_name' => $request->input('cinema_name'),
            'banner_image' => $request->input('banner_image'),
        ];

        // Store the checkout data in the session
        session(['checkoutData' => $checkoutData]);

        return view('frontend.checkOut.check-out', compact('checkoutData'));
    }
    public function processPayment(Request $request)
    {
        \Log::info('Stripe Secret Key', ['key' => env('STRIPE_SECRET')]);

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Movie Booking',
                        ],
                        'unit_amount' => intval($request->amount), // Convert to cents

                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('movies.check-out') . '?payment=success',
                'cancel_url' => route('movies.check-out') . '?payment=failed',
            ]);

            \Log::info('Stripe session created', ['session' => $session]);

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            \Log::error('Payment process failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function confirmBooking(Request $request)
    {
        DB::beginTransaction();

        $validated = $request->validate([
            'assign_movies_details_id' => 'required|exists:assign_movies_details,id',
            'total_price' => 'required|numeric',
            'selected_seats' => 'required|json',
        ]);

        // Create the booking entry
        $booking = Bookings::create([
            'user_id' => Auth::id(),
            'assign_movies_details_id' => $validated['assign_movies_details_id'],
            'total_price' => $validated['total_price'],
            'booking_date' => now(),
        ]);

        // Decode the grouped seats JSON data
        $groupedSeats = json_decode($validated['selected_seats'], true);

        // Iterate over each seat category and process the seats
        foreach ($groupedSeats as $category => $seats) {
            foreach ($seats as $seat) {
                BookingDetails::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seat['seat_id'],  // Ensure your frontend sends this correctly
                    'cinema_seats_categories_id' => $seat['cinema_seats_categories_id'],
                ]);
            }
        }

        DB::commit();

        // Store the last booking ID in session for further use
        session(['last_booking_id' => $booking->id]);

        return redirect()->route('movies.check-out', ['booking' => 'success']);
    }

    public function viewTicket($id)
    {
        $booking = DB::table('bookings as b')
            ->where('b.id', $id)
            ->join('booking_details as bd', 'b.id', '=', 'bd.booking_id')
            ->join('assign_movies_details as amd', 'b.assign_movies_details_id', '=', 'amd.id')
            ->join('cinema_timings as ct', 'amd.cinema_timings_id', '=', 'ct.id')
            ->join('assign_movies as am', 'amd.assign_movies_id', '=', 'am.id')
            ->join('cinemas as c', 'am.cinema_id', '=', 'c.id')
            ->join('movies as m', 'am.movie_id', '=', 'm.id')
            ->select(
                'b.id as booking_id',
                'm.title as movie_title',
                'm.language_ids as language_ids',
                'm.id as movie_id',
                'c.name as cinema_name',
                'amd.show_date',
                'amd.id as assigned_show_id',
                'ct.start_time as show_start_time',
                'ct.end_time as show_end_time',
                'b.total_price',
                'b.booking_date'
            )
            ->first();

        $seats = DB::table('cinema_seats as cs')
            ->join('booking_details as bd', 'cs.id', '=', 'bd.seat_id')
            ->join('cinema_seats_categories as csc', 'cs.cinema_seats_categories_id', '=', 'csc.id')
            ->where('bd.booking_id', $id)
            ->select(
                'cs.seat_number',
                'csc.seat_category',
                'csc.price_per_seat' // Fetch the price from the 'cinema_seats_categories' table
            )
            ->get();



        // Generate the PDF
        return PDF::loadView('frontend.pdf.ticket', compact('booking', 'seats'))->stream('ticket.pdf');
    }


    public function downloadTicket($id)
    {
        $booking = DB::table('bookings as b')
            ->where('b.id', $id)
            ->join('booking_details as bd', 'b.id', '=', 'bd.booking_id')
            ->join('assign_movies_details as amd', 'b.assign_movies_details_id', '=', 'amd.id')
            ->join('cinema_timings as ct', 'amd.cinema_timings_id', '=', 'ct.id')
            ->join('assign_movies as am', 'amd.assign_movies_id', '=', 'am.id')
            ->join('cinemas as c', 'am.cinema_id', '=', 'c.id')
            ->join('movies as m', 'am.movie_id', '=', 'm.id')
            ->select(
                'b.id as booking_id',
                'm.title as movie_title',
                'm.language_ids as language_ids',
                'm.id as movie_id',
                'c.name as cinema_name',
                'amd.show_date',
                'amd.id as assigned_show_id',
                'ct.start_time as show_start_time',
                'ct.end_time as show_end_time',
                'b.total_price',
                'b.booking_date'
            )
            ->first();

        $seats = DB::table('cinema_seats as cs')
            ->join('booking_details as bd', 'cs.id', '=', 'bd.seat_id')
            ->join('cinema_seats_categories as csc', 'cs.cinema_seats_categories_id', '=', 'csc.id')
            ->where('bd.booking_id', $id)
            ->select(
                'cs.seat_number',
                'csc.seat_category',
                'csc.price_per_seat' // Fetch the price from the 'cinema_seats_categories' table
            )
            ->get();

        return PDF::loadView('frontend.pdf.ticket', compact('booking', 'seats'))->download('ticket-' . $id . '.pdf');
    }
}
