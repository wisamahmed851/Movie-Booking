<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignMovie;
use App\Models\AssignMovies;
use App\Models\AssignMoviesDetail;
use App\Models\AssignMoviesDetails;
use App\Models\Cinema;
use App\Models\Movie;
use Exception;

class AssignMoviesController extends Controller
{
    public function index()
    {
        // Fetch all assigned movies with their related data
        $assignMovies = AssignMovies::with(['movie', 'cinema', 'details.cinemaTiming'])->get();



        return view('admin.assigMovies.index', compact('assignMovies'));
    }

    public function create()
    {
        // Fetch all movies and cinemas with timings
        $movies = Movie::with('coverImage')->get();
        $cinemas = Cinema::with('timings')->get();

        return view('admin.assigMovies.create', compact('movies', 'cinemas'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'cinemas' => 'required|array',
            'cinemas.*' => 'exists:cinemas,id',
            'cinema_timings' => 'required|array',
            'cinema_timings.*' => 'array',
            'cinema_timings.*.*' => 'exists:cinema_timings,id',
            'show_dates' => 'required|array',
            'show_dates.*' => 'array',
            'show_dates.*.*' => 'date',
        ]);

        // Prepare data for conflict check
        $conflictCheckData = [];

        foreach ($request->cinemas as $cinemaId) {
            foreach ($request->cinema_timings[$cinemaId] as $index => $timingId) {
                $showDate = $request->show_dates[$cinemaId][$index];
                $conflictCheckData[] = [
                    'cinema_timings_id' => $timingId,
                    'show_date' => $showDate,
                ];
            }
        }

        // Check for conflicting show timings using a single query
        $conflicts = AssignMoviesDetails::where(function ($query) use ($conflictCheckData) {
            foreach ($conflictCheckData as $data) {
                $query->orWhere(function ($q) use ($data) {
                    $q->where('cinema_timings_id', $data['cinema_timings_id'])
                        ->where('show_date', $data['show_date']);
                });
            }
        })->get();

        // If conflicts exist, return error response
        if ($conflicts->isNotEmpty()) {
            $conflictingCinemas = $conflicts->map(function ($conflict) {
                return Cinema::find($conflict->assignMovie->cinema_id)->name;
            })->unique()->implode(', ');

            return response()->json([
                'status' => 'error',
                'message' => 'The selected timing and date are already booked for cinemas: ' . $conflictingCinemas,
            ]); // 422 Unprocessable Entity
        }

        // Assign movie to selected cinemas
        foreach ($request->cinemas as $cinemaId) {
            // Find or create the AssignMovies entry for this movie and cinema
            $assignMovie = AssignMovies::firstOrCreate(
                [
                    'movie_id' => $request->movie_id,
                    'cinema_id' => $cinemaId,
                ],
                [
                    'status' => 1, // Default status to Active
                ]
            );

            // Create assign_movies_details records for each timing
            foreach ($request->cinema_timings[$cinemaId] as $index => $timingId) {
                AssignMoviesDetails::create([
                    'assign_movies_id' => $assignMovie->id,
                    'cinema_timings_id' => $timingId,
                    'show_date' => $request->show_dates[$cinemaId][$index],
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Movie has been successfully assigned to cinemas!',
        ]);
    }

    public function edit($id)
    {
        // Fetch the assigned movie record
        $assignMovie = AssignMovies::with(['movie', 'cinema', 'details.cinemaTiming.cinema'])->findOrFail($id);

        $assignedCinemas = $assignMovie->details->pluck('cinema_timing.cinema_id')->unique()->toArray();
        // Fetch all movies and cinemas with timings
        $movies = Movie::all();
        $cinemas = Cinema::with('timings')->where('id', $assignMovie->cinema_id)->get();

        // Get the list of assigned cinemas

        return view('admin.assigMovies.edit', compact('assignMovie', 'movies', 'cinemas', 'assignedCinemas'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'cinemas' => 'required|array',
            'cinemas.*' => 'exists:cinemas,id',
            'cinema_timings' => 'required|array',
            'cinema_timings.*' => 'array',
            'cinema_timings.*.*' => 'exists:cinema_timings,id',
            'show_dates' => 'required|array',
            'show_dates.*' => 'array',
            'show_dates.*.*' => 'date',
        ]);

        // Fetch the assigned movie record
        $assignMovie = AssignMovies::findOrFail($id);

        // Check for conflicting show timings
        foreach ($request->cinemas as $cinemaId) {
            foreach ($request->cinema_timings[$cinemaId] as $index => $timingId) {
                $showDate = $request->show_dates[$cinemaId][$index];
                $cinemaName = Cinema::find($cinemaId)->name;

                // Check if the timing and date are already booked for this cinema
                $conflict = AssignMoviesDetails::where('cinema_timings_id', $timingId)
                    ->where('show_date', $showDate)
                    ->where('assign_movies_id', '!=', $assignMovie->id)
                    ->exists();

                if ($conflict) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'The selected timing and date are already booked for cinema: ' . $cinemaName,
                    ], 422); // 422 Unprocessable Entity
                }
            }
        }

        // Update the assign_movies record
        $assignMovie->update([
            'movie_id' => $request->movie_id,
        ]);

        // Delete existing assign_movies_details records
        $assignMovie->details()->delete();

        // Create new assign_movies_details records for each timing
        foreach ($request->cinemas as $cinemaId) {
            foreach ($request->cinema_timings[$cinemaId] as $index => $timingId) {
                AssignMoviesDetails::create([
                    'assign_movies_id' => $assignMovie->id,
                    'cinema_timings_id' => $timingId,
                    'show_date' => $request->show_dates[$cinemaId][$index],
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Movie assignment has been successfully updated!',
        ]);
    }
    public function status(Request $request, $id)
    {
        $assignMovie = AssignMovies::findOrFail($id);
        $assignMovie->status = $request->status;
        $assignMovie->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully.',
        ]);
    }

    public function destroy($id){
        try{
            $assignMovie = AssignMovies::find($id);
            if(!$assignMovie){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Assign Movie not found',
                    'data' => null
                ]);
            }
            $assignMovie->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Assign Movie is deleted',
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
