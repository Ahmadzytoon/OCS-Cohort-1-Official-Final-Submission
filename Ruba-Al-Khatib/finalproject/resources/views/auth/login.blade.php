@extends('layouts.auth.master')

@section('title', 'Login | LYDIAPhoto')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
@endsection

@section('content')
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Welcome Back</h1>
                <p class="auth-subtitle">Sign in to your LYDIAPhoto account</p>
            </div>

            {{-- Response / Errors --}}
            @if (session('success'))
                <div class="response-message success" style="display:block;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="response-message error" style="display:block;">
                    <strong>Fix these issues:</strong>
                    <ul style="margin:10px 0 0 18px;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Social Login (هاد UI بس هسا مش مربوط) -->
           <div class="social-login">
    <a href="{{ route('social.redirect', 'google') }}" class="social-btn google">
        <i class="bi bi-google social-icon"></i>
        <span>Google</span>
    </a>

    <a href="{{ route('social.redirect', 'facebook') }}" class="social-btn facebook">
        <i class="bi bi-facebook social-icon"></i>
        <span>Facebook</span>
    </a>
</div>


            <div class="divider">
                <span>Or continue with email</span>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.store') }}" class="auth-form" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="loginEmail" class="form-label">
                        <i class="bi bi-envelope"></i>
                        <span>Email Address</span>
                        <span class="required">*</span>
                    </label>
                    <input
                        type="email"
                        id="loginEmail"
                        name="email"
                        class="form-input @error('email') error @enderror"
                        placeholder="Enter your email address"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <label for="loginPassword" class="form-label">
                            <i class="bi bi-lock"></i>
                            <span>Password</span>
                            <span class="required">*</span>
                        </label>
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                    <input
                        type="password"
                        id="loginPassword"
                        name="password"
                        class="form-input @error('password') error @enderror"
                        placeholder="Enter your password"
                        required
                    >
                    @error('password')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <label class="checkbox-group" style="cursor:pointer; user-select:none;">
                    <input type="checkbox" name="remember" value="1" style="display:none;" id="rememberInput">
                    <div class="custom-checkbox" id="rememberBox"></div>
                    <span class="checkbox-label">Remember me for 30 days</span>
                </label>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn" id="loginBtn">
                    <span>Sign In</span>
                    <i class="bi bi-arrow-right btn-icon"></i>
                </button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account?
                    <a href="{{ route('signup.step1') }}" class="auth-link">Create one now</a>
                </p>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rememberBox = document.getElementById('rememberBox');
    const rememberInput = document.getElementById('rememberInput');

    // Toggle Remember
    if (rememberBox && rememberInput) {
        rememberBox.addEventListener('click', function() {
            rememberBox.classList.toggle('checked');
            rememberInput.checked = rememberBox.classList.contains('checked');
        });
    }
});
</script>
@endsection
