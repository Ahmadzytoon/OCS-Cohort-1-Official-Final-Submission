<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="h4 fw-bold mb-2">Forgot Password?</h2>
        <p class="text-muted small">No worries! Enter your email and we'll send you reset instructions.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}"
                required autofocus>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-3">
            <button type="submit" class="btn btn-primary-custom btn-lg">
                Email Password Reset Link
            </button>

            <a href="{{ route('login') }}" class="text-center text-muted text-decoration-none small">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>