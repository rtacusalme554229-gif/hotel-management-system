@extends('layouts.guest')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #0f172a, #1e293b);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-5 bg-white">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-2 text-dark">Hotel Management System</h2>
                            <p class="text-muted mb-0">Secure login for admin, staff, and guests</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success mb-3">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input id="email"
                                       class="form-control form-control-lg rounded-3"
                                       type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input id="password"
                                       class="form-control form-control-lg rounded-3"
                                       type="password"
                                       name="password"
                                       required>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                    <label class="form-check-label text-muted" for="remember_me">
                                        Remember me
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-dark btn-lg rounded-3">
                                    Login
                                </button>
                            </div>

                            <p class="text-center text-muted mb-0">
                                Don’t have an account?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Register</a>
                            </p>
                        </form>
                    </div>
                </div>

                <p class="text-center text-white-50 mt-3 mb-0 small">
                    Professional hotel booking and management platform
                </p>
            </div>
        </div>
    </div>
</div>
@endsection