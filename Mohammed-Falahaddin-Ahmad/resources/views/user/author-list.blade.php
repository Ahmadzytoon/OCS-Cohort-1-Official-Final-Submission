@extends('layouts.user')

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/pagination-style.css') }}">
@endpush
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
                <h1>Featured Author</h1>
                <div class="page-header">
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                        <li><a href="{{ route('user.home') }}">Home</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li>Author</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/author-list.css') }}">
@endpush

    <!-- Author List Section Start -->
    <section class="team-section fix section-padding">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="mb-5 wow fadeInUp" data-wow-delay=".3s">Our Authors</h2>
            </div>
            
            <div class="row g-4 justify-content-center">
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
                        <p>No authors available.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-area d-flex justify-content-center mt-5 author-pagination">
                {{ $authors->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>

</body>
@endsection