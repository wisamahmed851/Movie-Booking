<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        try{
            if (!Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You must be logged in to submit this form.',
                    'data' => null
                ]); // 401 Unauthorized
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:15',
                'message' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                    'data' => null
                ]);
            }
            $contact = ContactUs::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Your message has been sent successfully',
                'data' => null
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'Error',
                'message' => $ex->getMessage(),
                'data' => null
            ]);
        }
    }
}
