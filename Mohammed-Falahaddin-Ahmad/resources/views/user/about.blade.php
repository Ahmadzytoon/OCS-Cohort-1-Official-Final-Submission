@extends('layouts.user')

@section('content')

<body>
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

    <!-- Breadcumb Section Start -->
    <div class="breadcrumb-wrapper bg-cover section-padding"
        style="background-image: url({{ asset('assets/user/images/hero/breadcrumb-bg.jpg') }});">
        <div class="container">
            <div class="page-heading">
                <h1>About Us</h1>
                <div class="page-header">
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                        <li><a href="{{ route('user.home') }}">Home</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li>About Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section Start -->
    <section class="about-section fix section-padding">
        <div class="container">
            <div class="about-wrapper">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="about-image">
                            <img src="{{ asset('assets/user/images/about.jpg') }}" alt="img">
                            <div class="video-box">
                                <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn ripple video-popup">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-content">
                            <div class="section-title">
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">About Readify <br> Books Store</h2>
                            </div>
                            <p class="mt-3 mt-md-0 wow fadeInUp" data-wow-delay=".5s">
                                Welcome to Readify, your premier destination for literary discovery. We believe that every book holds a world waiting to be explored, and our mission is to connect readers with stories that inspire, educate, and entertain.
                            </p>
                            <p class="mt-3 wow fadeInUp" data-wow-delay=".7s">
                                Founded with a passion for reading, Readify offers a carefully curated selection of titles across all genres. From timeless classics to contemporary bestsellers, we are dedicated to fostering a community of book lovers and providing an exceptional reading experience for everyone.
                            </p>
                            <a href="{{ route('user.shop') }}" class="link-btn wow fadeInUp" data-wow-delay=".8s">
                                Shop Now <i class="fa-regular fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cta Banner Section Start -->
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

    <!-- Testimonial Section Start -->
    <section class="testimonial-section fix section-padding pt-0">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="mb-3 wow fadeInUp" data-wow-delay=".3s">Customer Feedback</h2>
                <p class="wow fadeInUp" data-wow-delay=".5s">What our happy readers are saying about us.</p>
            </div>
            <div class="swiper testimonial-slider">
                <div class="swiper-wrapper">
                    @forelse($latestReviews as $review)
                    <div class="swiper-slide">
                        <div class="testimonial-card-items">
                            <p>
                                "{{ Str::limit($review->review_text, 150) }}"
                            </p>
                            <div class="client-info-wrapper d-flex align-items-center justify-content-between">
                                <div class="client-info">
                                    <div class="client-img bg-cover"
                                        style="background-image: url('{{ $review->user && filter_var($review->user->image, FILTER_VALIDATE_URL) ? $review->user->image : ($review->user && $review->user->image ? asset('storage/profile_images/' . $review->user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name ?? 'Guest') . '&background=random') }}');">
                                        <div class="icon">
                                            <img class="shape" src="{{ asset('assets/user/images/testimonial/shape.svg') }}" alt="img">
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h3>{{ $review->user->name ?? 'Guest User' }}</h3>
                                        <span>Verified Reader</span>
                                        <div class="star">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-regular fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="logo">
                                    <!-- Optional: Add a logo or remove -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="text-center">
                            <p>No reviews yet.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section Start -->
    <section class="team-section fix margin-bottom-30">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="mb-3 wow fadeInUp" data-wow-delay=".3s">Featured Authors</h2>
                <p class="wow fadeInUp" data-wow-delay=".5s">
                    Discover our talented authors and their inspiring works.
                </p>
            </div>
            
            <div class="row g-4 justify-content-center mt-4">
                @forelse($authors as $author)
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <a href="{{ route('user.team-details', $author) }}" class="featured-author-item text-center">
                            <div class="author-img-circle">
                                <img src="{{ filter_var($author->image, FILTER_VALIDATE_URL) ? $author->image : ($author->image ? asset('storage/' . $author->image) : 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&background=ff7b6b&color=fff&size=512') }}" alt="{{ $author->name }}">
                            </div>
                            <h6 class="author-name-only">{{ $author->name }}</h6>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center p-4">
                        <p>No featured authors available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/about.css') }}">
@endpush

</body>

@endsection