@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/home.css') }}">
@endpush

@section('content')
<!-- Cursor follower -->
<div class="cursor-follower"></div>

<!-- Preloader start -->
<div id="preloader" class="preloader">
    <div class="animation-preloader">
        <div class="spinner"></div>
        <div class="txt-loading">
            <span data-text-preloader="R" class="letters-loading">R</span>
            <span data-text-preloader="E" class="letters-loading">E</span>
            <span data-text-preloader="A" class="letters-loading">A</span>
            <span data-text-preloader="D" class="letters-loading">D</span>
            <span data-text-preloader="I" class="letters-loading">I</span>
            <span data-text-preloader="F" class="letters-loading">F</span>
            <span data-text-preloader="Y" class="letters-loading">Y</span>
        </div>
        <p class="text-center">Loading</p>
    </div>
    <div class="loader">
        <div class="row">
            <div class="col-3 loader-section section-left"><div class="bg"></div></div>
            <div class="col-3 loader-section section-left"><div class="bg"></div></div>
            <div class="col-3 loader-section section-right"><div class="bg"></div></div>
            <div class="col-3 loader-section section-right"><div class="bg"></div></div>
        </div>
    </div>
</div>

<!-- Back To Top start -->
<button id="back-top" class="back-to-top">
    <i class="fa-solid fa-chevron-up"></i>
</button>

<!-- Hero Section start -->
<div class="hero-section hero-1 fix bg-cover" style="background-image: url({{ asset('assets/user/images/hero/hero-bg-1.jpg') }});">
    <div class="book-shape float-bob-y">
        <img src="{{ asset('assets/user/images/hero/book-shape.png') }}" alt="img">
    </div>
    <div class="book-shape-2 float-bob-y">
        <img src="{{ asset('assets/user/images/hero/book-2.png') }}" alt="img">
    </div>
    <div class="container">
        <div class="row">
            <div class="hero-main-wrapper">
                <div class="hero-content">
                    <h4 class="wow fadeInUp" data-wow-delay=".2s">Editor's Choice Best Books <span>Up to 50% Off</span></h4>
                    <h1 class="wow fadeInUp" data-wow-delay=".4s">Your Next Favorite Book <br> Is Just a <span class="line-shape">Click Away <img src="{{ asset('assets/user/images/hero/line-shape.png') }}" alt="shape"></span></h1>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Discover hand-picked titles from top authors across all genres.
                        <br> Enjoy exclusive deals, limited-time discounts, and stories you'll love.</p>
                </div>
                <div class="hero-btn">
                    <a href="{{ route('user.shop') }}" class="theme-btn wow fadeInUp" data-wow-delay=".8s">Shop Now <i class="fa-solid fa-arrow-right-long"></i></a>
                    <a href="{{ route('user.shop') }}" class="theme-btn style-2 wow fadeInUp" data-wow-delay="1s">View All Books <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
                <div class="girl-img">
                    <img src="{{ asset('assets/user/images/hero-girl-1.png') }}" alt="img">
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Feature Section start -->
<section class="feature-section fix section-padding">
    <div class="container">
        <div class="feature-wrapper">
            <div class="feature-box-items wow fadeInUp" data-wow-delay=".2s">
                <div class="icon"><i class="icon-icon-1"></i></div>
                <div class="content"><h3>Return & refund</h3><p>Money back guarantee</p></div>
            </div>
            <div class="feature-box-items wow fadeInUp" data-wow-delay=".4s">
                <div class="icon"><i class="icon-icon-2"></i></div>
                <div class="content"><h3>Secure Payment</h3><p>30% off by subscribing</p></div>
            </div>
            <div class="feature-box-items wow fadeInUp" data-wow-delay=".6s">
                <div class="icon"><i class="icon-icon-3"></i></div>
                <div class="content"><h3>Quality Support</h3><p>Always online 24/7</p></div>
            </div>
            <div class="feature-box-items wow fadeInUp" data-wow-delay=".8s">
                <div class="icon"><i class="icon-icon-4"></i></div>
                <div class="content"><h3>Daily Offers</h3><p>20% off by subscribing</p></div>
            </div>
            <div class="feature-box-items wow fadeInUp" data-wow-delay="1s">
                <div class="icon"><i class="fa-solid fa-truck-fast"></i></div>
                <div class="content"><h3>Free Shipping</h3><p>On all orders</p></div>
            </div>
            <div class="feature-box-items wow fadeInUp" data-wow-delay="1.2s">
                <div class="icon"><i class="fa-solid fa-rotate-left"></i></div>
                <div class="content"><h3>Easy Returns</h3><p>30-day return policy</p></div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Books Section -->
<section class="shop-section section-padding fix pt-0">
    <div class="container">
        <div class="section-title-area">
            <div class="section-title">
                <h2 class="wow fadeInUp" data-wow-delay=".3s">Featured Books</h2>
            </div>
            <a href="{{ route('user.shop') }}" class="theme-btn style-2 fadeInUp" data-wow-delay=".5s">Explore More <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
        <div class="swiper book-slider">
            <div class="swiper-wrapper">
                @foreach($featuredBooks as $book)
                <div class="swiper-slide">
                    <div class="shop-box-items style-2">
                        <div class="book-thumb center">
                            <a href="{{ route('user.shop-details', $book) }}">
                                <img src="{{ $book->cover_image ? asset('uploads/books/' . $book->cover_image) : asset('assets/user/images/book/placeholder.png') }}" alt="{{ $book->title }}">
                            </a>
                            <ul class="shop-icon d-grid justify-content-center align-items-center">
                                <li>
                                    <livewire:user.add-to-wishlist :book="$book" :key="'featured-wishlist-'.$book->id" />
                                </li>
                                <li><a href="{{ route('user.shop-details', $book) }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                        <div class="shop-content">
                            <div class="author-post">
                                <span class="authot-list"><span class="content">{{ optional($book->author)->name ?? 'Author' }}</span></span>
                            </div>
                            <h3><a href="{{ route('user.shop-details', $book) }}">{{ Str::limit($book->title, 40) }}</a></h3>
                            
                            <div class="price-rating-row">
                                <ul class="compact-price-list">
                                    @if($book->activeDiscount)
                                        <li class="new-price">${{ number_format($book->final_price, 2) }}</li>
                                        <li class="old-price"><del class="text-muted">${{ number_format($book->price, 2) }}</del></li>
                                    @else
                                        <li>${{ number_format($book->price, 2) }}</li>
                                    @endif
                                </ul>
                                {!! $book->single_star_rating_html !!}
                            </div>
                        </div>
                        <div class="shop-button">
                            <livewire:user.add-to-cart :book="$book" :key="'featured-cart-'.$book->id" />
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Top Categories Section -->
<section class="book-catagories-section fix section-padding bg-cover"
    style="background-image: url({{ asset('assets/user/images/ReadBook.png') }});">
    <div class="container">
        <div class="book-catagories-wrapper">
            <div class="section-title text-center">
                <span class="icon"><img src="{{ asset('assets/user/images/icon/icon-24.svg') }}" alt="icon"></span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">Top Categories Book</h2>
            </div>
            <div class="swiper book-catagories-slider">
                <div class="swiper-wrapper">
                    @foreach($topCategories as $category)
                    <div class="swiper-slide">
                        <div class="book-catagories-items">
                            <div class="category-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="book-content">
                                <h6><a href="{{ route('user.shop', ['category' => $category->id]) }}">{{ $category->name }}</a></h6>
                                <div class="book-box">
                                    {{ $category->total_books_count }} Volumes
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Readit Top Books -->
<section class="shop-section section-padding fix">
    <div class="container">
        <div class="section-title-area">
            <div class="section-title mb- wow fadeInUp" data-wow-delay=".3s">
                <h2>Readit Top Books</h2>
            </div>
            <a href="{{ route('user.shop') }}" class="theme-btn style-2 wow fadeInUp" data-wow-delay=".5s">Explore More <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
        <div class="book-shop-wrapper">
            @foreach($readitTopBooks as $book)
            <div class="shop-box-items style-2">
                <div class="book-thumb center">
                    <a href="{{ route('user.shop-details', $book) }}">
                        <img src="{{ $book->cover_image ? asset('uploads/books/' . $book->cover_image) : asset('assets/user/images/book/placeholder.png') }}" alt="{{ $book->title }}">
                    </a>
                    <ul class="shop-icon d-grid justify-content-center align-items-center">
                        <li>
                            <livewire:user.add-to-wishlist :book="$book" :key="'readit-wishlist-'.$book->id" />
                        </li>
                        <li><a href="{{ route('user.shop-details', $book) }}"><i class="far fa-eye"></i></a></li>
                    </ul>
                </div>
                <div class="shop-content">
                    <div class="author-post">
                        <span class="authot-list"><span class="content">{{ optional($book->author)->name ?? 'Author' }}</span></span>
                    </div>
                    <h3><a href="{{ route('user.shop-details', $book) }}">{{ Str::limit($book->title, 40) }}</a></h3>

                    <div class="price-rating-row">
                        <ul class="compact-price-list">
                            @if($book->activeDiscount)
                                <li class="new-price">${{ number_format($book->final_price, 2) }}</li>
                                <li class="old-price"><del class="text-muted">${{ number_format($book->price, 2) }}</del></li>
                            @else
                                <li>${{ number_format($book->price, 2) }}</li>
                            @endif
                        </ul>
                        {!! $book->single_star_rating_html !!}
                    </div>
                </div>
                <div class="shop-button">
                    <livewire:user.add-to-cart :book="$book" :key="'readit-cart-'.$book->id" />
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="cta-banner-section fix section-padding pt-0">
    <div class="container">
        <div class="cta-banner-wrapper section-padding bg-cover" style="background-color: #ff7b6b; border-radius: 20px;">
            <div class="book-shape"><img src="{{ asset('assets/user/images/cta-book-2.png') }}" alt="shape-img"></div>
            <div class="book-shape-2"><img src="{{ asset('assets/user/images/cta-book.png') }}" alt="shape-img"></div>
            <div class="cta-content text-center">
                <span class="wow fadeInUp" data-wow-delay=".2s">Get 25% <img src="{{ asset('assets/user/images/line-shape.png') }}" alt=""></span>
                <h2 class="mb-40 wow fadeInUp" data-wow-delay=".4s">discount in all <br> kind of super Selling</h2>
                <a href="{{ route('user.shop') }}" class="theme-btn wow fadeInUp" data-wow-delay=".6s">Shop Now<i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Top Rating Books -->
<section class="top-ratting-book-section fix section-padding bg-cover"
    style="background-image: url({{ asset('assets/user/images/ratting-bg.jpg') }});">
    <div class="container">
        <div class="top-ratting-book-wrapper">
            <div class="section-title-area">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">Top Rating Books</h2>
                </div>
                <a href="{{ route('user.shop') }}" class="theme-btn wow fadeInUp" data-wow-delay=".5s">view more books <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
            <div class="row g-4">
                @foreach($topRatingBooks as $book)
                <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="shop-box-items horizontal-card">
                        <div class="book-thumb">
                            <a href="{{ route('user.shop-details', $book) }}">
                                <img src="{{ $book->cover_image ? asset('uploads/books/' . $book->cover_image) : asset('assets/user/images/top-book/01.png') }}" alt="{{ $book->title }}">
                            </a>
                            <ul class="shop-icon d-grid justify-content-center align-items-center">
                                <li>
                                    <livewire:user.add-to-wishlist :book="$book" :key="'top-rating-wishlist-'.$book->id" />
                                </li>
                                <li><a href="{{ route('user.shop-details', $book) }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                        <div class="shop-content">
                            <div class="author-post">
                                <span class="authot-list"><span class="content">{{ optional($book->author)->name ?? 'Author' }}</span></span>
                            </div>
                            <h3><a href="{{ route('user.shop-details', $book) }}">{{ Str::limit($book->title, 60) }}</a></h3>
                            
                            <div class="price-rating-row">
                                <ul class="compact-price-list">
                                    @if($book->activeDiscount)
                                        <li class="new-price">${{ number_format($book->final_price, 2) }}</li>
                                        <li class="old-price"><del class="text-muted">${{ number_format($book->price, 2) }}</del></li>
                                    @else
                                        <li>${{ number_format($book->price, 2) }}</li>
                                    @endif
                                </ul>
                                {!! $book->single_star_rating_html !!}
                            </div>
                            <div class="shop-button mt-3">
                                <livewire:user.add-to-cart :book="$book" :key="'top-rating-cart-'.$book->id" />
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<!-- Top Selling Books -->
<section class="shop-section section-padding fix">
    <div class="container">
        <div class="section-title-area">
            <div class="section-title wow fadeInUp" data-wow-delay=".3s">
                <h2>Top Selling Books</h2>
            </div>
            <a href="{{ route('user.shop') }}" class="theme-btn style-2 wow fadeInUp" data-wow-delay=".5s">Explore More <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
        <div class="swiper book-slider">
            <div class="swiper-wrapper">
                @foreach($topSellingBooks as $book)
                <div class="swiper-slide">
                    <div class="shop-box-items style-2">
                        <div class="book-thumb center">
                            <a href="{{ route('user.shop-details', $book) }}">
                                <img src="{{ $book->cover_image ? asset('uploads/books/' . $book->cover_image) : asset('assets/user/images/book/placeholder.png') }}" alt="{{ $book->title }}">
                            </a>
                          
                            <ul class="shop-icon d-grid justify-content-center align-items-center">
                                <li>
                                    <livewire:user.add-to-wishlist :book="$book" :key="'top-selling-wishlist-'.$book->id" />
                                </li>
                                <li><a href="{{ route('user.shop-details', $book) }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                        <div class="shop-content">
                            <div class="author-post">
                                <span class="authot-list"><span class="content">{{ optional($book->author)->name ?? 'Author' }}</span></span>
                            </div>
                            <h3><a href="{{ route('user.shop-details', $book) }}">{{ Str::limit($book->title, 40) }}</a></h3>
                            
                            <div class="price-rating-row">
                                <ul class="compact-price-list">
                                    @if($book->activeDiscount)
                                        <li class="new-price">${{ number_format($book->final_price, 2) }}</li>
                                        <li class="old-price"><del class="text-muted">${{ number_format($book->price, 2) }}</del></li>
                                    @else
                                        <li>${{ number_format($book->price, 2) }}</li>
                                    @endif
                                </ul>
                                {!! $book->single_star_rating_html !!}
                            </div>
                        </div>
                        <div class="shop-button">
                            <livewire:user.add-to-cart :book="$book" :key="'top-selling-cart-'.$book->id" />
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Featured Authors -->
<section class="team-section fix section-padding pt-0 margin-bottom-30">
    <div class="container">
        <div class="section-title text-center">
            <h2 class="mb-3 wow fadeInUp" data-wow-delay=".3s">Featured Author</h2>
            <p class="wow fadeInUp" data-wow-delay=".5s">Meet our curated selection of visionary writers and influential thought leaders.<br> Explore their deep catalogs of inspiring works and academic masterpieces.</p>
        </div>
        
        <div class="row g-4 justify-content-center mt-4">
            @foreach($featuredAuthors as $author)
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <a href="{{ route('user.team-details', $author) }}" class="featured-author-item text-center">
                        <div class="author-img-circle">
                            <img src="{{ filter_var($author->image, FILTER_VALIDATE_URL) ? $author->image : ($author->image ? asset('storage/' . $author->image) : 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&background=ff7b6b&color=fff&size=512') }}" alt="{{ $author->name }}">
                        </div>
                        <h6 class="author-name-only">{{ $author->name }}</h6>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>



@endsection