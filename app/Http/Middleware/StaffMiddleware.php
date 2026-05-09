<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        if (! in_array(trim($user->role), ['staff', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        /*
        |--------------------------------------------------------------------------
        | Block inactive staff while already logged in
        |--------------------------------------------------------------------------
        */
        if (isset($user->status) && strtolower($user->status) === 'inactive') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->withErrors([
                'email' => 'Your staff account is inactive. Please contact the administrator.',
            ]);
        }

        return $next($request);
    }
}