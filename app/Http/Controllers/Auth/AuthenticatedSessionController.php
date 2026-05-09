<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Block inactive staff / manager accounts
        |--------------------------------------------------------------------------
        */
        if (
            $user &&
            in_array(trim($user->role), ['staff', 'manager']) &&
            isset($user->status) &&
            strtolower($user->status) === 'inactive'
        ) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Your staff account is inactive. Please contact the administrator.',
            ])->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect based on role
        |--------------------------------------------------------------------------
        */
        if ($user && trim($user->role) === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        if ($user && in_array(trim($user->role), ['staff', 'manager'])) {
            return redirect()->intended('/staff/dashboard');
        }

        return redirect()->intended('/guest/dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}