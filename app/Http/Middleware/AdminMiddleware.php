<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (
            Auth::check() &&
            trim(Auth::user()->role) === 'admin' &&
            trim(Auth::user()->status) === 'active'
        ) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}