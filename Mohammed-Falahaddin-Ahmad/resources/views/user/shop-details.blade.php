@extends('layouts.user')

@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/shop-details.css') }}">
@endpush

    <!-- Breadcrumb Section Start -->
    <div class="breadcrumb-wrapper" style="background-color: #fff0ed; position: relative; padding: 100px 0;">
        <!-- Wavy Background Pattern (CSS approximated) -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: radial-gradient(#ff7b6b 1px, transparent 1px); background-size: 20px 20px; pointer-events: none;"></div>
        
        <div class="container text-center" style="position: relative; z-index: 2;">
            <div class="page-heading">
                <h1 class="mb-3" style="font-weight: 800; color: var(--charcoal); font-size: 40px;">Shop Details</h1>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb-items d-flex justify-content-center align-items-center mb-0 list-unstyled" style="gap: 10px; font-weight: 500;">
                        <li>
                            <a href="{{ route('user.home') }}" style="color: var(--charcoal); text-decoration: none;">
                                Home
                            </a>
                        </li>
                        <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #999;"></i>
                        <li style="color: var(--premium-pink);">
                            Shop Details
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Shop Details Section Start -->
    <section class="shop-details-section fix section-padding">
        <div class="container">
            <div class="shop-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="shop-details-image mb-0 w-100 text-center">
                            <img src="{{ $book->cover_image ? asset('uploads/books/' . $book->cover_image) : asset('assets/user/images/book/placeholder.png') }}"
                                 alt="{{ $book->title }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 500px; width: auto; object-fit: contain;">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="shop-details-content">
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <h2 class="mb-0" style="font-size: 36px; font-weight: 800;">{{ $book->title }}</h2>
                                </div>
                                
                                <div class="star-rating d-flex align-items-center gap-2 mb-4">
                                    <div class="stars" style="color: var(--premium-pink); font-size: 14px;">
                                        {!! $book->rating_stars_html !!}
                                    </div>
                                    <span class="text-muted" style="font-size: 14px;">({{ $approvedReviews->count() }} Customer Reviews)</span>
                                </div>

                                <div class="price-list mb-4 d-flex align-items-center gap-3">
                                    @if($book->activeDiscount)
                                        <h3 style="color: var(--premium-pink); font-size: 36px; font-weight: 800; margin: 0;">
                                            ${{ number_format($book->final_price, 2) }}
                                        </h3>
                                        <span class="text-muted text-decoration-line-through fs-5">
                                            ${{ number_format($book->price, 2) }}
                                        </span>
                                    @else
                                        <h3 style="color: var(--premium-pink); font-size: 36px; font-weight: 800; margin: 0;">
                                            ${{ number_format($book->price, 2) }}
                                        </h3>
                                    @endif

                                    <div class="ms-2">
                                        @if($book->stock_quantity > 0)
                                            <span class="fw-bold" style="color: #6ed14d; font-size: 16px;">(In Stock)</span>
                                        @else
                                            <span class="fw-bold" style="color: #dc3545; font-size: 16px;">(Out of Stock)</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Collapsed Description (Toggled by Button in Cart Component) -->
                                <div class="collapse mb-4" id="readMoreDescription">
                                    <div class="p-3 rounded-3 bg-light border" style="background: #fff9f8 !important; border-color: #ffe5e0 !important;">
                                        <p class="mb-0 text-muted" style="font-size: 15px; line-height: 1.6;">
                                            {{ Str::limit($book->description, 180) ?? 'A legendary quest to destroy the One Ring threatens Middle-earth.' }}
                                        </p>
                                    </div>
                                </div>

                                <livewire:user.add-to-cart :book="$book" :view="'details'" :key="'details-cart-'.$book->id" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features & Metadata Row (Unified for Symmetry) -->
                <div class="row g-4 mt-4 d-flex align-items-stretch">
                    <div class="col-lg-6">
                        <div class="features-box p-4 border rounded-4 bg-light shadow-sm h-100" style="background: #fdfdfd; border-color: #f0f0f0 !important;">
                            <div class="row overflow-hidden">
                                <div class="col-6">
                                    <ul class="list-unstyled mb-0 d-flex flex-column gap-4">
                                        <li class="d-flex align-items-center gap-2 text-nowrap">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 20px; height: 20px; border: 1px solid #ff7b6b; color: #ff7b6b; font-size: 10px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="text-muted fw-bold" style="font-size: 13px;">Free shipping over $150</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2 text-nowrap">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 20px; height: 20px; border: 1px solid #ff7b6b; color: #ff7b6b; font-size: 10px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="text-muted fw-bold" style="font-size: 13px;">30 days return policy</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2 text-nowrap">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 20px; height: 20px; border: 1px solid #ff7b6b; color: #ff7b6b; font-size: 10px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="text-muted fw-bold" style="font-size: 13px;">24/7 Customer Support</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-unstyled mb-0 d-flex flex-column gap-4">
                                        <li class="d-flex align-items-center gap-2 text-nowrap">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 20px; height: 20px; border: 1px solid #ff7b6b; color: #ff7b6b; font-size: 10px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="text-muted fw-bold" style="font-size: 13px;">Flash Discount: 30% Off</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2 text-nowrap">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 20px; height: 20px; border: 1px solid #ff7b6b; color: #ff7b6b; font-size: 10px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="text-muted fw-bold" style="font-size: 13px;">Safe & Secure Shopping</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2 text-nowrap">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 20px; height: 20px; border: 1px solid #ff7b6b; color: #ff7b6b; font-size: 10px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="text-muted fw-bold" style="font-size: 13px;">100% Original Product</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="metadata-box p-4 border rounded-4 bg-light shadow-sm h-100" style="background: #fdfdfd; border-color: #f0f0f0 !important;">
                            <div class="row g-4 mb-4">
                                <div class="col-md-3">
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px;">SKU:</span>
                                    <span class="text-muted" style="font-size: 13px;">{{ $book->isbn ?? 'FTC1020B65D' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px;">Tags:</span>
                                    <span class="text-muted" style="font-size: 13px;">Design</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px;">Total page:</span>
                                    <span class="text-muted" style="font-size: 13px;">{{ $book->pages ?? '330' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px;">Publish Years:</span>
                                    <span class="text-muted" style="font-size: 13px;">{{ $book->publish_date ?? '2021' }}</span>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px;">Category:</span>
                                    <span class="text-muted" style="font-size: 13px;">{{ $book->category ? $book->category->name : 'Kids Toys' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px;">Format:</span>
                                    <span class="text-muted" style="font-size: 13px;">{{ $book->format ?? 'Hardcover' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px;">Language:</span>
                                    <span class="text-muted" style="font-size: 13px;">{{ $book->language ?? 'English' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="d-block fw-bold text-dark" style="font-size: 13px;">Century:</span>
                                    <span class="text-muted" style="font-size: 13px;">United States</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            <!-- Tabs: Experience & Insight -->
            <div class="single-tab section-padding pb-0 mt-5">
                <ul class="nav premium-tabs mb-5" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#description" data-bs-toggle="tab" class="nav-link active">Synopsis</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#additional" data-bs-toggle="tab" class="nav-link">Specifications</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#review" data-bs-toggle="tab" class="nav-link">Reader Reviews ({{ $approvedReviews->count() }})</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Synopsis Tab -->
                    <div id="description" class="tab-pane fade show active">
                        <div class="synopsis-content shadow-sm p-5 border-0 rounded-4 bg-white" 
                             style="line-height: 2; font-size: 17px; color: #555;">
                             <h4 class="mb-4 text-dark fw-bold">About this Book</h4>
                            <p>{{ $book->long_description ?? $book->description ?? 'No detailed description available.' }}</p>
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    <div id="additional" class="tab-pane fade">
                        <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
                            <table class="table table-hover mb-0 bg-white">
                                <tbody style="font-size: 15px;">
                                    <tr><td class="ps-4 fw-bold text-muted w-25">Availability</td><td class="fw-bold {{ $book->stock_quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $book->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}</td></tr>
                                    <tr><td class="ps-4 fw-bold text-muted">Categories</td><td>{{ $book->category ? $book->category->getFullPath() : 'N/A' }}</td></tr>
                                    <tr><td class="ps-4 fw-bold text-muted">Publish Date</td><td>{{ $book->publish_date ?? 'N/A' }}</td></tr>
                                    <tr><td class="ps-4 fw-bold text-muted">Format</td><td>{{ $book->format ?? 'Hardcover' }}</td></tr>
                                    <tr><td class="ps-4 fw-bold text-muted">Language</td><td>{{ $book->language ?? 'English' }}</td></tr>
                                    <tr><td class="ps-4 fw-bold text-muted">Dimensions</td><td>{{ $book->dimensions ?? 'N/A' }}</td></tr>
                                    <tr><td class="ps-4 fw-bold text-muted">Weight</td><td>{{ $book->weight ?? 'N/A' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div id="review" class="tab-pane fade">
                        <div class="row g-4 overflow-hidden">
                            <div class="col-lg-7">
                                <h4 class="mb-4 d-flex align-items-center gap-2">
                                    <i class="fas fa-quote-left text-pink"></i> Reader Feedback
                                </h4>
                                <div class="reviews-stack d-flex flex-column gap-4">
                                    @forelse($approvedReviews as $review)
                                        <div class="review-card">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="reviewer-avatar">
                                                        {{ strtoupper(substr($review->customer_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $review->customer_name }}</h6>
                                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                                    </div>
                                                </div>
                                                <div class="text-warning small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="mb-0 text-muted italic" style="font-size: 15px; line-height: 1.6;">"{{ $review->comment }}"</p>
                                        </div>
                                    @empty
                                        <div class="text-center py-5 bg-white rounded-4 border">
                                            <img src="{{ asset('assets/user/images/book/no-review.svg') }}" style="width: 100px; opacity: 0.2;" class="mb-3">
                                            <p class="text-muted mb-0">Be the first to share your thoughts on this book.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="review-form-card premium-shadow p-5 rounded-4 bg-white border">
                                    <h4 class="mb-4 fw-bold">Share Your Review</h4>
                                    
                                    @guest
                                        <div class="text-center py-4 bg-light rounded-3">
                                            <p class="text-muted mb-3">Login to share your experience.</p>
                                            <a href="{{ route('login') }}" class="theme-btn btn-sm">Sign In</a>
                                        </div>
                                    @else
                                        @if($alreadyReviewed)
                                            <div class="alert alert-success border-0 rounded-3 text-center py-4">
                                                <i class="fas fa-check-circle fs-3 d-block mb-2"></i>
                                                <p class="mb-0 fw-bold">Review Received!</p>
                                                <small>Thank you for your valuable feedback.</small>
                                            </div>
                                        @elseif($hasPurchased)
                                            <form action="{{ route('user.reviews.store', $book) }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="form-label small fw-bold text-uppercase text-muted mb-3">Your Rating</label>
                                                    <div class="d-flex gap-2">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="btn-check" required>
                                                            <label for="star{{ $i }}" class="btn btn-outline-warning btn-sm px-3">
                                                                {{ $i }} <i class="fa-solid fa-star"></i>
                                                            </label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label small fw-bold text-uppercase text-muted">Your Thought</label>
                                                    <textarea name="comment" class="form-control" rows="4" placeholder="What did you like about this book?..." required></textarea>
                                                </div>
                                                <button type="submit" class="btn-premium btn-buy w-100 py-3">Publish Review</button>
                                            </form>
                                        @else
                                            <div class="alert alert-info border-0 rounded-3 text-center py-4">
                                                <i class="fas fa-lock-alt d-block mb-2 fs-3"></i>
                                                <p class="small mb-0">Reviews are restricted to verified purchasers of this book.</p>
                                            </div>
                                        @endif
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Curated Recommendations -->
<section class="related-products-section section-padding" style="background: #fff;">
    <div class="container">
        <div class="section-title text-center mb-5 wow fadeInUp">
            <h2 class="fw-900 mb-2" style="font-size: 32px; letter-spacing: -1px;">You May Also Like</h2>
            <div class="divider mx-auto mb-3" style="width: 60px; height: 3px; background: var(--premium-pink); border-radius: 50px;"></div>
            <p class="text-muted">Hand-picked selections based on your current interest</p>
        </div>

        <div class="swiper book-slider wow fadeInUp" data-wow-delay=".2s">
            <div class="swiper-wrapper">
                @foreach($relatedBooks as $relatedBook)
                    <div class="swiper-slide">
                        <div class="shop-box-items style-2">
                            <div class="book-thumb center">
                                <a href="{{ route('user.shop-details', $relatedBook) }}">
                                    <img src="{{ $relatedBook->cover_image ? asset('uploads/books/' . $relatedBook->cover_image) : asset('assets/user/images/book/placeholder.png') }}" 
                                         alt="{{ $relatedBook->title }}">
                                </a>
                                <ul class="shop-icon d-grid justify-content-center align-items-center">
                                    <li>
                                        <livewire:user.add-to-wishlist :book="$relatedBook" :key="'related-wishlist-'.$relatedBook->id" />
                                    </li>
                                    <li><a href="{{ route('user.shop-details', $relatedBook) }}"><i class="far fa-eye"></i></a></li>
                                </ul>
                            </div>
                            <div class="shop-content">
                                <div class="author-post">
                                    <span class="authot-list"><span class="content">{{ optional($relatedBook->author)->name ?? 'Author' }}</span></span>
                                </div>
                                <h3><a href="{{ route('user.shop-details', $relatedBook) }}">{{ Str::limit($relatedBook->title, 40) }}</a></h3>
                                
                                <div class="price-rating-row">
                                    <ul class="compact-price-list">
                                        @if($relatedBook->activeDiscount)
                                            <li class="new-price">${{ number_format($relatedBook->final_price, 2) }}</li>
                                            <li class="old-price"><del class="text-muted">${{ number_format($relatedBook->price, 2) }}</del></li>
                                        @else
                                            <li>${{ number_format($relatedBook->price, 2) }}</li>
                                        @endif
                                    </ul>
                                    {!! $relatedBook->single_star_rating_html !!}
                                </div>
                            </div>
                            <div class="shop-button">
                                <livewire:user.add-to-cart :book="$relatedBook" :key="'related-cart-'.$relatedBook->id" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


@endsection