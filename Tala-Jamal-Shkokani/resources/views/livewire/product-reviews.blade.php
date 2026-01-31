<div class="mt-5 pt-5 border-top">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="h3 mb-2" style="font-family: 'Playfair Display', serif; font-weight: 700;">Client Impressions
            </h2>
            <div class="d-flex align-items-center gap-2">
                <div class="text-warning">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa-{{ $i <= round($averageRating) ? 'solid' : 'regular' }} fa-star"
                            style="font-size: 0.9rem;"></i>
                    @endfor
                </div>
                <span class="text-muted small ms-2 fw-medium" style="letter-spacing: 0.5px;">{{ $reviews->count() }}
                    Shared Experiences</span>
            </div>
        </div>
        @auth
            @if($canReview)
                <button wire:click="$toggle('showForm')" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold"
                    style="font-size: 0.85rem; letter-spacing: 0.5px; transition: all 0.3s ease;">
                    <i class="fa-regular fa-pen-to-square me-2"></i> {{ $showForm ? 'Cancel' : 'Write a Review' }}
                </button>
            @else
                <button disabled class="btn btn-light text-muted rounded-pill px-4 py-2 border-0"
                    title="Only verified owners can review" style="font-size: 0.85rem; background: #f8f9fa;">
                    <i class="fa-solid fa-lock me-2 opacity-50"></i> Verified Owners Only
                </button>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm"
                style="font-size: 0.85rem; letter-spacing: 0.5px;">
                Sign in to Review
            </a>
        @endauth
    </div>

    @if($showForm)
        <div class="card border-0 shadow-sm rounded-4 mb-5 animate-fade-in"
            style="background: linear-gradient(135deg, #ffffff 0%, #fcfcfc 100%);">
            <div class="card-body p-4 p-md-5">
                <h5 class="mb-4 fw-bold font-serif" style="font-family: 'Playfair Display', serif;">Share Your Perspective
                </h5>
                <form wire:submit.prevent="submitReview">
                    <div class="mb-4">
                        <label class="small text-uppercase ls-1 fw-bold mb-3 d-block text-muted"
                            style="font-size: 0.7rem;">Your Rating</label>
                        <div class="d-flex gap-3 text-warning fs-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $rating ? 'solid' : 'regular' }} fa-star cursor-pointer hover-scale"
                                    wire:click="$set('rating', {{ $i }})" style="transition: transform 0.2s;"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="small text-uppercase ls-1 fw-bold mb-3 d-block text-muted"
                            style="font-size: 0.7rem;">Your Thoughts</label>
                        <textarea wire:model="comment" class="form-control border-0 bg-light p-4 rounded-4 shadow-inner"
                            rows="4"
                            placeholder="How did this piece make you feel? Describe the fit, fabric, and emotion..."
                            style="font-size: 0.95rem; line-height: 1.6;"></textarea>
                        @error('comment') <span class="text-danger small mt-2 d-block"><i
                        class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}</span> @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-dark rounded-pill px-5 py-3 fw-bold shadow-lg hover-lift">
                            Submit Experience
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="row g-4">
        @forelse($reviews as $review)
            <div class="col-12">
                <div class="p-4 bg-white rounded-4 border shadow-sm h-100 transition-all hover-shadow">
                    <div class="d-flex justify-content-between mb-3 align-items-start">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-soft-blush rounded-circle d-flex align-items-center justify-content-center text-dark fw-bold"
                                style="width: 45px; height: 45px; font-size: 1rem; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.05); background: rgba(246, 166, 178, 0.15);">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ $review->user->name }}
                                </h6>
                                <span class="text-success extra-small fw-bold"
                                    style="font-size: 0.65rem; letter-spacing: 0.5px;">✓ VERIFIED OWNER</span>
                            </div>
                        </div>
                        <div class="text-warning small bg-light px-2 py-1 rounded-pill">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"
                                    style="font-size: 0.75rem;"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-muted mb-3" style="font-size: 0.95rem; line-height: 1.7;">"{{ $review->comment }}"</p>
                    <div class="d-flex justify-content-end">
                        <div class="extra-small text-uppercase ls-1 text-muted opacity-50 fw-bold"
                            style="font-size: 0.65rem;">
                            {{ $review->created_at->format('F d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 80px; height: 80px;">
                    <i class="fa-regular fa-comment-dots fa-2x text-muted opacity-50"></i>
                </div>
                <h6 class="fw-bold mb-2">No Impressions Yet</h6>
                <p class="text-muted small mb-0">Be the first to share an experience with this luxury piece.</p>
            </div>
        @endforelse
    </div>

    <style>
        .hover-scale:hover {
            transform: scale(1.2) !important;
            color: #ffc107 !important;
        }

        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.03);
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .hover-shadow:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
            transform: translateY(-2px);
        }

        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</div>