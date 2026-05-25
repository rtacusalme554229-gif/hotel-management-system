@extends('layouts.guest')

@section('content')
<div class="auth-page">

    <div class="auth-left register-bg">

        <div class="brand-wrap">
            <div class="brand-icon">
                <i class="bi bi-building"></i>
            </div>
            <div class="brand-text">
                <h3>Pinnacle Hotel and Suites </h3>
                <p>Management System</p>
            </div>
        </div>

        <div>
            <div class="auth-title">
                <h1>Create an account</h1>
                <p>
                    Join us today and experience seamless hotel booking and management.
                </p>
            </div>

            <div class="auth-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <h5>Easy Registration</h5>
                        <p>Create your guest account in just a few steps.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h5>Browse Rooms</h5>
                        <p>Explore rooms and make reservations with ease.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div>
                        <h5>Secure Payments</h5>
                        <p>Track payment status and reservation progress.</p>
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

            <a href="{{ url('/') }}" class="back-home-link">
                <i class="bi bi-arrow-left"></i>
                Back to Home
            </a>

            <div class="auth-heading">
                <h2>Create Account</h2>
                <p>Fill in your details to get started.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="bi bi-person"></i>
                        </span>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            class="auth-input"
                            placeholder="Enter your full name"
                        >
                    </div>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

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
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="bi bi-telephone"></i>
                        </span>
                        <input
                            id="phone_number"
                            type="text"
                            name="phone_number"
                            value="{{ old('phone_number') }}"
                            required
                            class="auth-input"
                            placeholder="Enter your phone number"
                        >
                    </div>
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="bi bi-geo-alt"></i>
                        </span>
                        <input
                            id="address"
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                            required
                            class="auth-input"
                            placeholder="Enter your address"
                        >
                    </div>
                    @error('address')
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
                            autocomplete="new-password"
                            class="auth-input"
                            placeholder="Create a password"
                        >
                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="auth-input"
                            placeholder="Confirm your password"
                        >
                        <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="auth-btn">
                    Create Account
                </button>

                <div class="auth-bottom">
                    Already have an account?
                    <a href="{{ route('login') }}" class="auth-link">
                        Sign in
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection