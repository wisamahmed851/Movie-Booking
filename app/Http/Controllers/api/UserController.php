<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(Request $request){
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'message' => 'User data retrieved successfully',
            'user' => $user,
        ]);
    }
}
