<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request); // Proceed if authenticated
        }
        if($request->ajax()){
            return response()->json([
                'status' => 'error',
                'message' => 'You dnt have access to this route',
                'data' => null
            ]);
        }

        return redirect()->route('user.login')->with('error', 'You need to log in first.');
    }
}
