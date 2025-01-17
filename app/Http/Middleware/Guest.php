<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is authenticated, redirect them to the dashboard
        if (Auth::check()) {
            return redirect(route('dashboard.index'))->with('error', 'You are already logged in.');
        }

        // Allow the request to proceed if the user is a guest
        return $next($request);
    }
}
