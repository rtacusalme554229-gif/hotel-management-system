@extends('layouts.guest')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #0f172a, #1e293b);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-5 bg-white">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-2 text-dark">Create Account</h2>
                            <p class="text-muted mb-0">Register to access the Hotel Management System</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input id="name"
                                       class="form-control form-control-lg rounded-3"
                                       type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       autofocus>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input id="email"
                                       class="form-control form-control-lg rounded-3"
                                       type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required>
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

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <input id="password_confirmation"
                                       class="form-control form-control-lg rounded-3"
                                       type="password"
                                       name="password_confirmation"
                                       required>
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-dark btn-lg rounded-3">
                                    Register
                                </button>
                            </div>

                            <p class="text-center text-muted mb-0">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Login</a>
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