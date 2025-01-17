<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieContoller extends Controller
{
    //

    public function grid(){
        return view('frontend.movies.grid');
    }
}
