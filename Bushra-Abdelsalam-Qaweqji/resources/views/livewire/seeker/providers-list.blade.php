<section>
    <section class="cc-section pt-4" id="cleanersPage">
        <div class="container">
            <div class="row g-4">
                <aside class="col-12 col-lg-3">
                    <div class="cc-filter-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Filters</h5>
                            <button type="button" class="btn btn-link p-0 small text-decoration-none"
                                wire:click="resetFilters">
                                Reset
                            </button>
                        </div>

                        <div class="mb-4">
                            <div class="fw-semibold mb-2">ZIP Code</div>
                            <input name="zip_code" type="text" class="form-control" placeholder="Enter ZIP code..."
                                wire:model.live="zip_code">
                            <div class="form-text">Leave empty to show all locations.</div>
                        </div>

                        <div class="mb-4">
                            <div class="fw-semibold mb-2">Service Type</div>

                            <div class="vstack gap-2">
                                <label class="d-flex align-items-center gap-2">
                                    <input type="radio" name="service" value="all" wire:model.live="service">
                                    <span>All Services</span>
                                </label>

                                <label class="d-flex align-items-center gap-2">
                                    <input type="radio" name="service" value="HOME_CLEAN" wire:model.live="service">
                                    <span>Housekeeping</span>
                                </label>

                                <label class="d-flex align-items-center gap-2">
                                    <input type="radio" name="service" value="CAR_CLEAN" wire:model.live="service">
                                    <span>Car Washing</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="fw-semibold mb-2">Price Order</div>
                            <select class="form-select" name="price_sort" wire:model.live="price_sort">
                                <option value="">No price sorting</option>
                                <option value="low_high">Lowest to Highest</option>
                                <option value="high_low">Highest to Lowest</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="fw-semibold mb-2">Minimum Rating</div>

                            @for ($i = 5; $i >= 1; $i--)
                                <label class="d-flex align-items-center gap-2 mb-2">
                                    <input type="radio" name="rating_min" value="{{ $i }}"
                                        wire:model.live="rating_min">

                                    <span class="cc-stars-sm" aria-hidden="true">
                                        @for ($s = 1; $s <= 5; $s++)
                                            @if ($s <= $i)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </span>

                                    <span class="small text-muted">{{ $i }}+</span>
                                </label>
                            @endfor

                        </div>
                    </div>
                </aside>

                <div class="col-12 col-lg-9">
                    {{-- <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                        <div class="text-muted">
                            Showing <span class="fw-semibold">{{ $providers->total() }}</span> cleaners
                        </div>
                    </div> --}}

                    <div class="row g-4" id="ccCards">
                        @forelse ($providers as $p)
                            @php
                                $user = $p->user;
                                $tags = $p->services->pluck('category.name')->unique()->values();
                                $rating = number_format((float) $p->avg_rating, 1);
                                $fullStars = (int) floor((float) $p->avg_rating);
                                $fullStars = max(0, min(5, $fullStars));
                                $emptyStars = 5 - $fullStars;
                                $fallbackIndex = $loop->index % 21;
                                $fallbackImage = asset('provider/img/image' . $fallbackIndex . '.png');
                                $profileImageSrc = $p->profile_image_url ?? $fallbackImage;
                            @endphp

                            <div class="col-12 col-md-6 col-xl-4 cc-card-col">
                                <div class="card cc-list-card h-100 d-flex flex-column">
                                    <div class="cc-list-img d-flex">
                                        <img src="{{ $profileImageSrc }}" class="w-100 h-100" alt="Cleaner">

                                        {{-- <span class="cc-verified-badge">Verified</span> --}}
                                        @if ($p->min_rate)
                                            <span class="cc-price-pill">{{ (int) $p->min_rate }}JD/hr</span>
                                        @endif
                                    </div>

                                    <div class="card-body p-3 d-flex flex-column flex-grow-1">
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $user?->name ?? 'Cleaner' }}</h6>

                                            <div class="cc-stars-sm" aria-hidden="true">
                                                @for ($s = 1; $s <= 5; $s++)
                                                    @if ($s <= $fullStars)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <ul class="list-unstyled text-muted small mb-3 cc-meta">
                                                <li>Zip: {{ $p->zip_code }}</li>
                                            </ul>

                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                @foreach ($tags as $tag)
                                                    <span class="badge cc-tag">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                        </div>

                                        <a href="{{ route('seeker.provider-details', $p->user_id) }}"
                                            class="btn btn-primary w-100 cc-btn-primary cc-profile-btn mt-auto">
                                            View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border">
                                    No cleaners found{{ $zip_code ? " in zip code {$zip_code}" : '' }}.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $providers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
