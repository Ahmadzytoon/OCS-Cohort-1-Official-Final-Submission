@extends('layouts.auth.master')

@section('title', 'Sign Up - Step 1')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
@endsection

@section('content')
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Join LYDIAPhoto</h1>
                <p class="auth-subtitle">Create your account and start your photography journey</p>
            </div>

            {{-- Global errors --}}
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

            {{-- Success flash --}}
            @if (session('success'))
                <div class="response-message success" style="display:block;">
                    {{ session('success') }}
                </div>
            @endif

            <form id="signupForm" class="auth-form" method="POST" action="{{ route('signup.step1.store') }}">
                @csrf

                <!-- Full Name -->
                <div class="form-group">
                    <label for="fullName" class="form-label">
                        <i class="bi bi-person"></i>
                        <span>Full Name</span>
                        <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="fullName"
                        name="fullName"
                        class="form-input @error('fullName') error @enderror"
                        placeholder="Enter your full name"
                        value="{{ old('fullName') }}"
                        required
                    >
                    @error('fullName')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="signupEmail" class="form-label">
                        <i class="bi bi-envelope"></i>
                        <span>Email Address</span>
                        <span class="required">*</span>
                    </label>
                    <input
                        type="email"
                        id="signupEmail"
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
                    <label for="signupPassword" class="form-label">
                        <i class="bi bi-lock"></i>
                        <span>Password</span>
                        <span class="required">*</span>
                    </label>
                    <input
                        type="password"
                        id="signupPassword"
                        name="password"
                        class="form-input @error('password') error @enderror"
                        placeholder="Create a strong password"
                        required
                    >
                    @error('password')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="confirmPassword" class="form-label">
                        <i class="bi bi-lock-fill"></i>
                        <span>Confirm Password</span>
                        <span class="required">*</span>
                    </label>
                    <input
                        type="password"
                        id="confirmPassword"
                        name="confirmPassword"
                        class="form-input @error('confirmPassword') error @enderror"
                        placeholder="Confirm your password"
                        required
                    >
                    @error('confirmPassword')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Account Type Selection -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-person-badge"></i>
                        <span>Account Type</span>
                        <span class="required">*</span>
                    </label>

                    <div class="account-type-selection" id="accountTypeSelection">
                        <div class="account-type" data-type="customer">
                            <div class="account-icon"><i class="bi bi-person"></i></div>
                            <div class="account-name">User</div>
                            <div class="account-desc">Book photography sessions</div>
                        </div>

                        <div class="account-type" data-type="photographer">
                            <div class="account-icon"><i class="bi bi-camera"></i></div>
                            <div class="account-name">Photographer</div>
                            <div class="account-desc">Offer your services</div>
                        </div>

                        <div class="account-type" data-type="studio">
                            <div class="account-icon"><i class="bi bi-building"></i></div>
                            <div class="account-name">Studio</div>
                            <div class="account-desc">Manage a photography studio</div>
                        </div>
                    </div>

                    <input type="hidden" id="accountType" name="accountType" value="{{ old('accountType','customer') }}">

                    @error('accountType')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Terms & Conditions -->
                <div class="checkbox-group" id="termsCheckbox">
                    <div class="custom-checkbox"></div>
                    <span class="checkbox-label">
                        I agree to the <a href="#" class="auth-link">Terms & Conditions</a> and <a href="#" class="auth-link">Privacy Policy</a>
                        <span class="required">*</span>
                    </span>
                </div>

                {{-- Laravel accepted rule: لازم يكون checkbox name="terms" و value=1 --}}
                <input type="hidden" id="termsHidden" name="terms" value="{{ old('terms') ? '1' : '' }}">

                @error('terms')
                    <div class="error-message" style="display:block;">{{ $message }}</div>
                @enderror

                <!-- Submit -->
                <button type="submit" class="submit-btn" id="signupBtn">
                    <span>Create Account</span>
                    <i class="bi bi-arrow-right btn-icon"></i>
                </button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="{{ url('/login') }}" class="auth-link">Sign in here</a></p>
            </div>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="footer-container">
        <p class="footer-text">© 2025 LYDIAPhoto. All rights reserved.</p>
    </div>
</footer>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const accountTypes = document.querySelectorAll('.account-type');
    const accountTypeInput = document.getElementById('accountType');

    // restore old selection
    const oldType = accountTypeInput.value || 'customer';
    accountTypes.forEach(t => {
        t.classList.toggle('selected', t.getAttribute('data-type') === oldType);
    });

    accountTypes.forEach(type => {
        type.addEventListener('click', function() {
            accountTypes.forEach(t => t.classList.remove('selected'));
            this.classList.add('selected');
            accountTypeInput.value = this.getAttribute('data-type');
        });
    });

    // terms checkbox
    const termsBox = document.getElementById('termsCheckbox');
    const termsHidden = document.getElementById('termsHidden');
    const checkEl = termsBox.querySelector('.custom-checkbox');

    // restore old terms
    if (termsHidden.value === '1') checkEl.classList.add('checked');

    termsBox.addEventListener('click', function() {
        checkEl.classList.toggle('checked');
        termsHidden.value = checkEl.classList.contains('checked') ? '1' : '';
    });
});
</script>
@endsection
