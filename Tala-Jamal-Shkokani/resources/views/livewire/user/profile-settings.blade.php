<div>
    <h4 class="mb-4 font-heading">My Style Identity</h4>
    <div class="row g-4">
        <div class="col-md-7">
            <div class="card card-premium p-5 h-100">
                <form wire:submit.prevent="updateProfile">
                    <div class="text-center mb-5">
                        <div class="display-1 mb-3 animate-fade-up">
                            @php
                                $emojis = [
                                    'soft' => '🌸',
                                    'alt' => '🖤',
                                    'luxury' => '✨',
                                    'mix' => '🎭'
                                ];
                            @endphp
                            {{ $emojis[$style_persona] ?? '✨' }}
                        </div>
                        <h3 class="text-uppercase ls-1 fw-bold font-heading">
                            @php
                                $names = [
                                    'soft' => 'Soft Femme',
                                    'alt' => 'Alt Girly',
                                    'luxury' => 'Luxury Clean',
                                    'mix' => 'Modern Mix'
                                ];
                            @endphp
                            {{ $names[$style_persona] ?? 'The Discoverer' }}
                        </h3>
                        <p class="text-muted small text-uppercase ls-1">Curated Personality Identity</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Display
                                Name</label>
                            <input type="text" wire:model.live.debounce.500ms="name"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name') <span class="text-danger extra-small ms-3">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Email
                                Identity</label>
                            <input type="email" wire:model.live.debounce.500ms="email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email') <span class="text-danger extra-small ms-3">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-12 mt-4 pt-4 border-top">
                            <h6 class="text-uppercase extra-small ls-2 fw-bold mb-3">Security & Access</h6>
                        </div>

                        <div class="col-12">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Current
                                Key</label>
                            <input type="password" wire:model.live.debounce.500ms="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                placeholder="••••••••">
                            @error('current_password') <span class="text-danger extra-small ms-3">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">New Key</label>
                            <input type="password" wire:model.live.debounce.500ms="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                            @error('password') <span class="text-danger extra-small ms-3">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Verify
                                Key</label>
                            <input type="password" wire:model.live.debounce.500ms="password_confirmation"
                                class="form-control" placeholder="••••••••">
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-premium w-100" wire:loading.attr="disabled">
                                <span wire:loading.remove>Synchronize Identity</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2" role="status"
                                        aria-hidden="true"></span>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-premium p-4 mb-4">
                <h5 class="mb-3 font-heading">Style Calibration</h5>
                <p class="small text-muted mb-4">Manual override for your aesthetic identity. Refine your curation
                    preferences here.</p>
                <select wire:model.live="style_persona" class="form-select mb-4">
                    <option value="">Select Persona</option>
                    <option value="soft">Soft Femme 🌸</option>
                    <option value="alt">Alt Girly 🖤</option>
                    <option value="luxury">Luxury Clean ✨</option>
                    <option value="mix">Modern Mix 🎭</option>
                </select>
                <div class="p-3 rounded-4 bg-light border">
                    <p class="extra-small text-muted mb-0">
                        <b>Concierge Note:</b> Synchronizing your persona will immediately update your "My Edit"
                        personalized gallery.
                    </p>
                    <a href="{{ route('sparkle.quiz') }}"
                        class="small text-dark fw-bold text-decoration-none d-block mt-3 text-uppercase ls-1">
                        <i class="fa-solid fa-wand-magic-sparkles me-2 text-primary"></i> Retake Digital Quiz
                    </a>
                </div>
            </div>

            <div class="card card-premium p-4">
                <h5 class="mb-3 font-heading">Your Heritage</h5>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-dark p-2 border fw-normal text-uppercase ls-1"
                        style="font-size: 0.65rem;">Member since
                        {{ auth()->user()->created_at->format('M Y') }}</span>
                    <span class="badge bg-light text-dark p-2 border fw-normal text-uppercase ls-1"
                        style="font-size: 0.65rem;">{{ auth()->user()->orders->count() }} Shared Experiences</span>
                    <span class="badge bg-light text-dark p-2 border fw-normal text-uppercase ls-1"
                        style="font-size: 0.65rem;">{{ auth()->user()->wishlist->count() }} Curations</span>
                </div>
            </div>
        </div>
    </div>
</div>