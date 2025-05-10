<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        // If it's an API request, return 401 instead of redirecting to login
        if (! $request->expectsJson()) {
            abort(401, 'Unauthorized');
        }

        return null;
    }
}
