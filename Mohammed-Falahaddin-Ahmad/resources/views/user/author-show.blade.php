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
                <h1>Author Profile</h1>
                <div class="page-header">
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                        <li><a href="{{ route('user.home') }}">Home</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li><a href="{{ route('user.team') }}">Author</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li>{{ $author->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/author-show.css') }}">
@endpush
    <section class="author-profile-header fix section-padding pb-0">
        <div class="container">
            <div class="author-profile-wrapper">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-3">
                        <div class="author-avatar">
                            <img src="{{ filter_var($author->image, FILTER_VALIDATE_URL) ? $author->image : ($author->image ? asset('storage/' . $author->image) : 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&background=ff7b6b&color=fff&size=512') }}" alt="{{ $author->name }}" class="rounded-circle img-fluid shadow-sm">
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="author-info">
                            <h2 class="mb-1">{{ $author->name }}</h2>
                            <p class="mt-4 lead text-muted">
                                {{ $author->biography ?? 'No biography available. This author has not yet shared their story.' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="author-stats mt-4 p-4 bg-light rounded shadow-sm">
                    <div class="row text-center">
                        <div class="col-md-12">
                            <h3 class="mb-0">{{ $author->books_count }} Book{{ $author->books_count != 1 ? 's' : '' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Books by Author -->
    <section class="shop-section fix section-padding">
        <div class="container">
            <div class="section-title-area">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">Books By {{ $author->name }}</h2>
                </div>
            </div>
            @if($author->books->isNotEmpty())
                <div class="swiper book-slider">
                    <div class="swiper-wrapper">
                        @foreach($author->books as $book)
                            <div class="swiper-slide">
                                <div class="shop-box-items style-2">
                                    <div class="book-thumb center">
                                        <a href="{{ route('user.shop-details', $book) }}">
                                            <img src="{{ $book->cover_image ? asset('uploads/books/' . $book->cover_image) : asset('assets/user/images/book/placeholder.png') }}" alt="{{ $book->title }}">
                                        </a>
                                        @if($book->price < 35)
                                            <ul class="post-box">
                                                <li>Hot</li>
                                                @if($book->price < 30)
                                                    <li>-{{ round((1 - $book->price / 39.99) * 100) }}%</li>
                                                @endif
                                            </ul>
                                        @endif
                                        <ul class="shop-icon d-grid justify-content-center align-items-center">
                                            <li>
                                                <livewire:user.add-to-wishlist :book="$book" :key="'author-wishlist-'.$book->id" />
                                            </li>
                                            <li><a href="{{ route('user.shop-details', $book) }}"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="shop-content">
                                        <h5>{{ optional($book->category)->name ?? 'Uncategorized' }}</h5>
                                        <h3><a href="{{ route('user.shop-details', $book) }}">{{ Str::limit($book->title, 40) }}</a></h3>
                                        <ul class="price-list">
                                            @if($book->activeDiscount)
                                                <li>${{ number_format($book->final_price, 2) }}</li>
                                                <li><del>${{ number_format($book->price, 2) }}</del></li>
                                            @else
                                                <li>${{ number_format($book->price, 2) }}</li>
                                            @endif
                                        </ul>
                                        <ul class="author-post">
                                            <li class="authot-list">
                                                <span class="content">{{ optional($book->author)->name ?? 'Author' }}</span>
                                            </li>
                                            <li class="star">
                                                {!! $book->single_star_rating_html !!}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="shop-button">
                                        <livewire:user.add-to-cart :book="$book" :key="'author-cart-'.$book->id" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <p>No books published by this author yet.</p>
                </div>
            @endif
        </div>
    </section>

</body>
@endsection