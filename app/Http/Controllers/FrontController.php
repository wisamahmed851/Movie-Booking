<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\City;
use App\Models\Language;
use App\Models\Movie;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index()
    {

        $cinemas = Cinema::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $movies = Movie::with('coverImage')
            ->where('status', 1)
            ->take(3)
            ->get();

        $movies->transform(function ($movie) {
            $movie->cover_image = $movie->coverImage?->cover_image_path ?? null;
            return $movie;
        });

        return view('frontend.dashboard.index', compact('movies', 'cinemas', 'cities'));
    }
}
