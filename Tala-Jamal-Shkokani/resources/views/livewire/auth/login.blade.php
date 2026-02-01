<div class="w-100">
    <div class="mb-5">
        @if(request('context') === 'quiz')
            <h2 class="display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">Aesthetic Calibration</h2>
            <p class="text-muted">Verified access is required to generate, save, and curate your personalised style DNA.</p>
        @else
            <h2 class="display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">Welcome Back</h2>
            <p class="text-muted">Enter your email and password to access your account.</p>
        @endif
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-4 small rounded-0 border-0 bg-light" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form wire:submit.prevent="login">
        <!-- Email -->
        <div class="mb-4">
            <label class="small text-muted text-uppercase ls-1 fw-bold mb-2 ms-3">Email Address</label>
            <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="client@chic.co">
            @error('email')
                <div class="invalid-feedback ms-3">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="small text-muted text-uppercase ls-1 fw-bold mb-2 ms-3">Password</label>
            <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="••••••••">
            @error('password')
                <div class="invalid-feedback ms-3">{{ $message }}</div>
            @enderror
        </div>

        <!-- Options -->
        <div class="d-flex justify-content-between align-items-center mb-5 px-2">
            <div class="form-check">
                <input wire:model="remember" class="form-check-input shadow-none" type="checkbox" id="remember_me"
                    style="cursor: pointer;">
                <label class="form-check-label small text-muted text-uppercase ls-1" for="remember_me"
                    style="cursor: pointer;">
                    Keep me signed in
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="small text-muted text-decoration-none text-uppercase ls-1 hover-opacity-100">
                    Recover Key
                </a>
            @endif
        </div>

        <!-- Submit -->
        <div class="mb-4">
            <button type="submit" class="btn btn-luxury" wire:loading.attr="disabled">
                <span wire:loading.remove>Enter Identity</span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Verifying...
                </span>
            </button>
        </div>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="text-center">
                <span class="text-muted small">Not yet curated?</span>
                <a href="{{ route('register') }}"
                    class="ms-1 small fw-bold text-dark text-decoration-none text-uppercase ls-1 border-bottom border-dark pb-1">
                    Join The List
                </a>
            </div>
        @endif
    </form>
</div>