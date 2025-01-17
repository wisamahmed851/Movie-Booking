<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect(route('auth.login'))->with('error', 'You must be logged in.');
        }

        $role = Auth::user()->role;

        if ($role === 0) { // Admin can access everything
            return $next($request);
        }

        if ($role === 1) { // User role restrictions
            if ($request->is('admin')) {
                return redirect(route('front.index'))->with('error', 'Unauthorized access.');
            }

            return $next($request);
        }

        return redirect(route('auth.login'))->with('error', 'Unauthorized access.');
    }
}
