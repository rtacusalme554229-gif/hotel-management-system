<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && trim((string) Auth::user()->role) === 'guest') {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}