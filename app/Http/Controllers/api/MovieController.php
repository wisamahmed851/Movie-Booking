<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\CinemaSeat;
use App\Models\City;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\MovieImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Svg\Tag\Rect;

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
        if ($request->has('date') || $request->has('cinema') || $request->has('city')) {
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

        return response()->json([
            'status' => 'success',
            'data' => $formattedData,
        ]);
    }
    public function checkout(Request $request)
    {
        /* // If it's a GET request, check for payment status in the query parameters
        if ($request->isMethod('get')) {
            $paymentStatus = $request->query('payment');
            $bookingStatus = $request->query('booking');
            $checkoutData = session('checkoutData');

            return view('frontend.checkOut.check-out', compact(
                'checkoutData',
                'paymentStatus',
                'bookingStatus'
            ));
        } */
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
        // dd($request->all());
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

        return response()->json([
            'status' => 'success',
            'data' => $checkoutData,
        ]);
    }
}
