<div class="w-100">
    <div class="mb-5">
        <h2 class="display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">The List</h2>
        <p class="text-muted">Join our exclusive community for curated fashion edits.</p>
    </div>

    <form wire:submit.prevent="register">
        <!-- Name -->
        <div class="mb-4">
            <label class="small text-muted text-uppercase ls-1 fw-bold mb-2 ms-3">Full Identity</label>
            <input wire:model.live.debounce.500ms="name" type="text"
                class="form-control @error('name') is-invalid @enderror" placeholder="Tala Shkokani" autofocus>
            @error('name')
                <div class="invalid-feedback ms-3">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="small text-muted text-uppercase ls-1 fw-bold mb-2 ms-3">Email Address</label>
            <input wire:model.live.debounce.500ms="email" type="email"
                class="form-control @error('email') is-invalid @enderror" placeholder="tala@chic.co">
            @error('email')
                <div class="invalid-feedback ms-3">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="small text-muted text-uppercase ls-1 fw-bold mb-2 ms-3">Password</label>
            <input wire:model.live.debounce.500ms="password" type="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
            @error('password')
                <div class="invalid-feedback ms-3">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-5">
            <label class="small text-muted text-uppercase ls-1 fw-bold mb-2 ms-3">Verify Password</label>
            <input wire:model.live.debounce.500ms="password_confirmation" type="password" class="form-control"
                placeholder="••••••••">
        </div>

        <!-- Submit -->
        <div class="mb-4">
            <button type="submit" class="btn btn-luxury" wire:loading.attr="disabled">
                <span wire:loading.remove>Request Membership</span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Processing...
                </span>
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <span class="text-muted small">Already prioritized?</span>
            <a href="{{ route('login') }}"
                class="ms-1 small fw-bold text-dark text-decoration-none text-uppercase ls-1 border-bottom border-dark pb-1">
                Secure Login
            </a>
        </div>
    </form>
</div>