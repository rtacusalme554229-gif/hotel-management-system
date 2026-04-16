<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (
            Auth::check() &&
            in_array(trim(Auth::user()->role), ['staff', 'manager']) &&
            trim(Auth::user()->status) === 'active'
        ) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}