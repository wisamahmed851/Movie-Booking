<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function about()
    {
        return view('frontend.pages.about-us');
    }
    public function contact()
    {
        return view('frontend.pages.contact-us');
    }
}
