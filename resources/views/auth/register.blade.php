@extends('layouts.guest')

@section('content')
<div class="auth-page">

    <div class="auth-left register-bg">

        <div class="brand-wrap">
            <div class="brand-icon">H</div>
            <div class="brand-text">
                <h3>StayEase Hotel</h3>
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
                        <p>Create your account in just a few steps.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h5>Browse Rooms</h5>
                        <p>Explore rooms and make reservations.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div>
                        <h5>Secure Payments</h5>
                        <p>Safe and secure payment transactions.</p>
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

            <div class="auth-heading">
                <h2>Create Account</h2>
                <p>Fill in your details to get started.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- NAME --}}
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="auth-input" required placeholder="Enter your full name">
                    </div>
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="auth-input" required placeholder="Enter your email">
                    </div>
                </div>

                {{-- PHONE --}}
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="bi bi-telephone"></i></span>
                        <input type="text" name="phone_number" class="auth-input" required placeholder="Enter phone number">
                    </div>
                </div>

                {{-- ADDRESS --}}
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" name="address" class="auth-input" required placeholder="Enter your address">
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" name="password" class="auth-input" required placeholder="Create a password">

                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="bi bi-lock"></i></span>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="auth-input" required placeholder="Confirm your password">

                        <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                {{-- BUTTON --}}
                <button type="submit" class="auth-btn">
                    Create Account
                </button>

                {{-- LOGIN LINK --}}
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