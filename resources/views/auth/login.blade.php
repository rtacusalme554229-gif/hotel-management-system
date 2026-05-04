@extends('layouts.guest')

@section('content')
<div class="auth-page">

    <div class="auth-left">

        <div class="brand-wrap">
            <div class="brand-icon">H</div>
            <div class="brand-text">
                <h3>StayEase Hotelb</h3>
                <p>Management System</p>
            </div>
        </div>

        <div>
            <div class="auth-title">
                <h1>Welcome back!</h1>
                <p>
                    Sign in to access your dashboard and manage your hotel operations seamlessly.
                </p>
            </div>

            <div class="auth-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h5>Secure & Role-based Access</h5>
                        <p>Protected login for staff, guests, and admins.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <h5>Reservation Management</h5>
                        <p>Manage bookings, check-ins, and more.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <div>
                        <h5>Reports & Insights</h5>
                        <p>Real-time reports and business analytics.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="security-note">
            <i class="bi bi-lock"></i>
            <span>Your security is our priority.</span>
        </div>

    </div>

    <div class="auth-right">
        <div class="auth-card">

            <div class="auth-card-logo">H</div>

            <div class="auth-heading">
                <h2>Sign In</h2>
                <p>Enter your credentials to continue.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success rounded-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="auth-input"
                            placeholder="Enter your email"
                        >
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="auth-input"
                            placeholder="Enter your password"
                        >
                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="auth-options">
                    <label>
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="auth-btn">
                    Sign In
                </button>

                <div class="auth-bottom">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="auth-link">
                        Create account
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection