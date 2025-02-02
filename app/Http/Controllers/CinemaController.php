<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\CinemaSeat;
use App\Models\cinemaSeatDetails;
use App\Models\CinemaSeatsCategories;
use App\Models\CinemaTiming;
use App\Models\City;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\MovieImage;
use App\Models\SeatCategory;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CinemaController extends Controller
{
    //
    public function index()
    {
        $cinemas = Cinema::with(['timings', 'CinemaSeatsCategories'])->get();

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
            $cinema->seats_info = $cinema->CinemaSeatsCategories->map(function ($seatCategory) {
                return [
                    'category' => $seatCategory->seat_category,
                    'no_of_seats' => $seatCategory->no_of_seats,
                    'price' => $seatCategory->price_per_seat,
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

    // Store method
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
            'silver_row' => 'nullable|string|max:1',
            'silver_seats' => 'nullable|integer|min:1',
            'silver_price' => 'nullable|numeric|min:0',
            'gold_row' => 'nullable|string|max:1',
            'gold_seats' => 'nullable|integer|min:1',
            'gold_price' => 'nullable|numeric|min:0',
            'platinum_row' => 'nullable|string|max:1',
            'platinum_seats' => 'nullable|integer|min:1',
            'platinum_price' => 'nullable|numeric|min:0',
        ]);

        try {
            // Begin a transaction
            DB::beginTransaction();

            // Create the cinema
            $cinema = Cinema::create([
                'name' => $validatedData['title'],
                'address' => $validatedData['address'],
                'description' => $validatedData['description'],
                'city_id' => $validatedData['city_id'],
                'status' => 1, // Active by default
            ]);

            Log::info('Cinema created successfully:', ['cinema' => $cinema]);

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
                Log::info('Show timings inserted successfully:', ['timings' => $timings]);
            }

            Log::info('Processing seat categories:', [
                'silver' => [
                    'row' => $request->silver_row,
                    'seats' => $request->silver_seats,
                    'price' => $request->silver_price,
                ],
                'gold' => [
                    'row' => $request->gold_row,
                    'seats' => $request->gold_seats,
                    'price' => $request->gold_price,
                ],
                'platinum' => [
                    'row' => $request->platinum_row,
                    'seats' => $request->platinum_seats,
                    'price' => $request->platinum_price,
                ]
            ]);

            // Insert seats for Silver, Gold, and Platinum categories
            $this->createSeats($cinema->id, 'silver', $request->silver_row, $request->silver_seats, $request->silver_price);
            $this->createSeats($cinema->id, 'gold', $request->gold_row, $request->gold_seats, $request->gold_price);
            $this->createSeats($cinema->id, 'platinum', $request->platinum_row, $request->platinum_seats, $request->platinum_price);

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Cinema, show timings, and seats were successfully created!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Error creating cinema: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());

            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the cinema. Please try again later.',
            ], 500);
        }
    }

    // Create seats method
    private function createSeats($cinemaId, $category, $row, $seats, $price)
    {
        if ($row && $seats && $price) {
            $seatCategory = CinemaSeatsCategories::create([
                'cinema_id' => $cinemaId,
                'seat_category' => $category,
                'no_of_seats' => $seats,
                'price_per_seat' => $price,
                'series_alphabet' => $row,
            ]);

            if (!$seatCategory) {
                Log::error("Seat category '$category' not found.");
                return;
            }

            Log::info("Seat category '$category' found:", ['seatCategory' => $seatCategory]);
            Log::info("Creating seats for $category: Row $row, Seats $seats, Price $price");

            // Create the seat records
            $seatEntries = [];
            for ($i = 1; $i <= $seats; $i++) {
                $seatEntries[] = [
                    'cinema_id' => $cinemaId,
                    'cinema_seats_categories_id' => $seatCategory->id,
                    'seat_number' => $row . $i, // Combine row and seat number (e.g., A1, A2, ...)
                    'status' => 1, // Active
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert all the seats in a single query
            CinemaSeat::insert($seatEntries);
            Log::info("Inserted seats for $category successfully", ['seatEntries' => $seatEntries]);
        }
    }



    public function edit($id)
    {
        // Find the cinema record by ID, with associated timings and seat categories
        $cinema = Cinema::with(['timings', 'CinemaSeatsCategories'])->findOrFail($id);

        // Fetch all cities to populate the city dropdown in the edit form
        $cities = City::where('status', 1)->get();

        // Format timings
        foreach ($cinema->timings as $timing) {
            $timing->start_time = Carbon::parse($timing->start_time)->format('H:i');
            $timing->end_time = Carbon::parse($timing->end_time)->format('H:i');
        }
        // Pass cinema, cities, and seat categories to the view
        return view('admin.cinemas.edit', compact('cinema', 'cities'));
    }


    public function update(Request $request, $id)
    {
        // Validate the incoming request data (including seat fields)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'description' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'start_time.*' => 'required|date_format:H:i',
            'end_time.*' => 'required|date_format:H:i',
            'silver_row' => 'nullable|string|max:1',
            'silver_seats' => 'nullable|integer|min:1',
            'silver_price' => 'nullable|numeric|min:0',
            'gold_row' => 'nullable|string|max:1',
            'gold_seats' => 'nullable|integer|min:1',
            'gold_price' => 'nullable|numeric|min:0',
            'platinum_row' => 'nullable|string|max:1',
            'platinum_seats' => 'nullable|integer|min:1',
            'platinum_price' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Update cinema details
            $cinema = Cinema::findOrFail($id);
            $cinema->update([
                'name' => $validatedData['title'],
                'address' => $validatedData['address'],
                'description' => $validatedData['description'],
                'city_id' => $validatedData['city_id'],
            ]);

            // Update show timings
            CinemaTiming::where('cinema_id', $cinema->id)->delete();
            if ($request->has('start_time')) {
                $timings = [];
                foreach ($request->start_time as $key => $startTime) {
                    $timings[] = [
                        'cinema_id' => $cinema->id,
                        'start_time' => $startTime,
                        'end_time' => $request->end_time[$key],
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                CinemaTiming::insert($timings);
            }

            // Process seat categories
            foreach (['silver', 'gold', 'platinum'] as $category) {
                $enableKey = "enable_$category";
                $rowKey = "{$category}_row";
                $seatsKey = "{$category}_seats";
                $priceKey = "{$category}_price";

                // If category is enabled and fields are filled
                if ($request->has($enableKey) && $request->filled([$rowKey, $seatsKey, $priceKey])) {
                    // Update or create seat category
                    $seatCategory = CinemaSeatsCategories::updateOrCreate(
                        [
                            'cinema_id' => $cinema->id,
                            'seat_category' => $category
                        ],
                        [
                            'series_alphabet' => $request->$rowKey,
                            'no_of_seats' => $request->$seatsKey,
                            'price_per_seat' => $request->$priceKey
                        ]
                    );

                    // Delete existing seats
                    CinemaSeat::where('cinema_seats_categories_id', $seatCategory->id)->delete();

                    // Generate new seats
                    $seatEntries = [];
                    for ($i = 1; $i <= $request->$seatsKey; $i++) {
                        $seatEntries[] = [
                            'cinema_id' => $cinema->id,
                            'cinema_seats_categories_id' => $seatCategory->id,
                            'seat_number' => $request->$rowKey . $i,
                            'status' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    CinemaSeat::insert($seatEntries);
                } else {
                    // Delete category and seats if disabled
                    $seatCategory = CinemaSeatsCategories::where('cinema_id', $cinema->id)
                        ->where('seat_category', $category)
                        ->first();

                    if ($seatCategory) {
                        CinemaSeat::where('cinema_seats_categories_id', $seatCategory->id)->delete();
                        $seatCategory->delete();
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Cinema, show timings, and seats were successfully updated!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating cinema: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating. Please try again.',
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

    public function destroy($id){
        //
        try {
            $cinema = Cinema::find($id);
            if (!$cinema) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cinema not found',
                    'data' => null
                ]);
            }
            $cinema->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Cinema is deleted',
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
}
