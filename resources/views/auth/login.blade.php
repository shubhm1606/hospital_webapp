@extends('layouts.app')

@section('title', 'Hospital Admin Login')

@section('content')
<div class="min-vh-100 d-flex align-items-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <!-- Hospital Branding Card -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <!-- You can replace this with your hospital logo -->
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2.5rem;">
                            <i class="fas fa-hospital-alt"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-primary">Civil Hospital</h3>
                    <p class="text-muted">Admin Portal Login</p>
                </div>

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-user-shield me-2"></i>
                            Administrator Login
                        </h4>
                    </div>

                    <div class="card-body p-5">
                        <!-- Success Message -->
                        @if (session('status'))
                            <div class="alert alert-success rounded-3">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-envelope me-2 text-primary"></i>{{ __('Email Address') }}
                                </label>
                                <input id="email" type="email" 
                                       class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       placeholder="admin@medicarehospital.com"
                                       required autocomplete="email" autofocus>
                                
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-lock me-2 text-primary"></i>{{ __('Password') }}
                                </label>
                                <input id="password" type="password" 
                                       class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="••••••••"
                                       required autocomplete="current-password">

                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none text-primary fw-medium" 
                                       href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold">
                                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login to Dashboard') }}
                                </button>
                            </div>
                        </form>

                        <!-- Footer Note -->
                        <!-- <div class="text-center mt-4">
                            @if (Route::has('register'))
                                <a class="text-decoration-none text-primary fw-medium" href="{{ route('register') }}">
                                    Create a new account
                                </a>
                            @endif
                        </div> -->

                        <div class="text-center mt-2">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt text-success"></i>
                                Secure Admin Access • Only authorized personnel
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4 text-muted">
                    <small>
                        © {{ date('Y') }} MediCare Hospital Management System. All rights reserved.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    .btn-primary {
        background-color: #1976d2;
        border: none;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background-color: #1565c0;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('scripts')
<script>
    // Optional: Add some nice focus effects
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.querySelector('label').style.color = '#1976d2';
        });
        input.addEventListener('blur', function() {
            this.parentElement.querySelector('label').style.color = '';
        });
    });
</script>
@endsection