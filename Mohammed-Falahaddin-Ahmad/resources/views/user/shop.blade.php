@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/discount-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/pagination-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/shop.css') }}">
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

<!-- Breadcumb Section Start -->
<div class="breadcrumb-wrapper bg-cover section-padding"
    style="background-image: url({{ asset('assets/user/images/hero/breadcrumb-bg.jpg') }});">
    <div class="container">
        <div class="page-heading">
            <h1>Shop Default</h1>
            <div class="page-header">
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li>Shop Default</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Shop Section Start -->
<section class="shop-section fix section-padding">
    <div class="container">
        <div class="shop-default-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="woocommerce-notices-wrapper wow fadeInUp" data-wow-delay=".3s">
                        <div class="form-clt">
                            <form action="{{ route('user.shop') }}" method="GET" class="d-inline">
                                @foreach(request()->except(['sort', 'page']) as $key => $val)
                                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                @endforeach
                                <select name="sort" class="nice-select" onchange="this.form.submit()">
                                    <option value="default" {{ ($sort ?? 'default') == 'default' ? 'selected' : '' }}>Default sorting</option>
                                    <option value="latest" {{ ($sort ?? 'default') == 'latest' ? 'selected' : '' }}>Sort by latest</option>
                                    <option value="price_low_high" {{ ($sort ?? 'default') == 'price_low_high' ? 'selected' : '' }}>Sort by price: low to high</option>
                                    <option value="price_high_low" {{ ($sort ?? 'default') == 'price_high_low' ? 'selected' : '' }}>Sort by price: high to low</option>
                                </select>
                            </form>
                            <div class="icon">
                                <a href="{{ route('user.shop-list') }}"><i class="fas fa-list"></i></a>
                            </div>
                            <div class="icon-2 active">
                                <a href="{{ route('user.shop') }}"><i class="fa-sharp fa-regular fa-grid-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-4 order-2 order-md-1 wow fadeInUp" data-wow-delay=".3s">
                    <div class="main-sidebar">
                        <!-- Search Widget -->
                        <div class="single-sidebar-widget">
                            <div class="wid-title"><h5>Search</h5></div>
                            <form action="{{ route('user.shop') }}" method="GET" class="search-toggle-box">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <div class="input-area search-container">
                                    <input class="search-input" type="text" name="q" placeholder="Keywords here...." value="{{ request('q') }}">
                                    <button class="cmn-btn search-icon" type="submit"><i class="far fa-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <!-- Categories Widget -->
                        <div class="single-sidebar-widget">
                            <div class="wid-title"><h5>Categories</h5></div>
                            <div class="categories-list">
                                <ul class="nav flex-column category-accordion">
                                    <li class="nav-item mb-2">
                                        <a class="nav-link main-category-link {{ !request('category') ? 'active' : '' }}" href="{{ request()->fullUrlWithoutQuery(['category', 'page']) }}">
                                            <i class="fas fa-th-large me-2"></i> All Categories
                                        </a>
                                    </li>

                                    @php
                                        // Configuration
                                        $displayLimit = 5;
                                        $visibleCategories = $categories->take($displayLimit);
                                        $hiddenCategories = $categories->skip($displayLimit);
                                        
                                        // Check if any hidden category is active to auto-expand
                                        $shouldExpandMore = false;
                                        foreach($hiddenCategories as $cat) {
                                            if (request('category') == $cat->id || $cat->children->contains('id', request('category'))) {
                                                $shouldExpandMore = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    {{-- Visible Categories --}}
                                    @foreach($visibleCategories as $category)
                                        @include('user.partials.category-item', ['category' => $category])
                                    @endforeach

                                    {{-- Hidden Categories --}}
                                    @if($hiddenCategories->count() > 0)
                                        <div class="collapse {{ $shouldExpandMore ? 'show' : '' }}" id="moreCategories">
                                            @foreach($hiddenCategories as $category)
                                                @include('user.partials.category-item', ['category' => $category])
                                            @endforeach
                                        </div>

                                        {{-- Toggle Button --}}
                                        <li class="nav-item mt-2 text-center">
                                            <button class="btn btn-sm btn-light w-100 fw-bold" 
                                                    style="color: var(--theme);"
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#moreCategories" 
                                                    aria-expanded="{{ $shouldExpandMore ? 'true' : 'false' }}"
                                                    id="btnShowMoreCats">
                                                {{ $shouldExpandMore ? 'Show Less' : 'Show More' }} <i class="fas {{ $shouldExpandMore ? 'fa-chevron-up' : 'fa-chevron-down' }} ms-1"></i>
                                            </button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Price Filter Widget -->
                        <div class="single-sidebar-widget">
                            <div class="wid-title"><h5>Filter by Price</h5></div>
                            <form action="{{ route('user.shop') }}" method="GET" class="price-filter-form">
                                @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $val)
                                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                @endforeach
                                <div class="d-flex gap-2 mb-3">
                                    <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}">
                                    <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                                <button type="submit" class="theme-btn btn-sm w-100">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="col-xl-9 col-lg-8 order-1 order-md-2">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-arts" role="tabpanel" tabindex="0">
                            <div class="row g-4">
                                @forelse($books as $book)
                                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                                        <div class="shop-box-items">
                                            <div class="book-thumb center">
                                                <a href="{{ route('user.shop-details', $book) }}">
                                                    @php
                                                        $coverImage = $book->cover_image;
                                                        $imagePath = asset('assets/user/images/book/placeholder.png');
                                                        if ($coverImage) {
                                                            if (file_exists(public_path('uploads/books/' . $coverImage))) $imagePath = asset('uploads/books/' . $coverImage);
                                                            elseif (file_exists(public_path('storage/' . $coverImage))) $imagePath = asset('storage/' . $coverImage);
                                                        }
                                                    @endphp
                                                    <img src="{{ $imagePath }}" alt="{{ $book->title }}" onerror="this.onerror=null; this.src='{{ asset('assets/user/images/book/placeholder.png') }}'">
                                                </a>
                                                <ul class="shop-icon d-grid justify-content-center align-items-center">
                                                    <li>
                                                        <livewire:user.add-to-wishlist :book="$book" :key="'shop-wishlist-'.$book->id" />
                                                    </li>
                                                    <li><a href="{{ route('user.shop-details', $book) }}"><i class="far fa-eye"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="shop-content">
                                                <div class="author-post">
                                                    <span class="authot-list">
                                                        <span class="content">{{ optional($book->author)->name ?? 'Author' }}</span>
                                                    </span>
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
                                                <livewire:user.add-to-cart :book="$book" :key="'shop-cart-'.$book->id" />
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-5">
                                        <h4>No books found matching your filters.</h4>
                                        <a href="{{ route('user.shop') }}" class="theme-btn mt-3">Clear Filters</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- PAGINATION -->
                    @if($books->hasPages())
                        <div class="pagination-area d-flex justify-content-center" style="margin-top: 80px !important; margin-bottom: 60px !important;">
                            {{ $books->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Wishlist JS -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Optional: Manual toggle handling if Bootstrap collapse events miss sync in some cases
        const toggles = document.querySelectorAll('.btn-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                // Toggle state is handled by Bootstrap, this is just for custom logic if needed
            });
        });
        // Show More / Show Less Toggle Text
        const moreCategories = document.getElementById('moreCategories');
        const btnShowMore = document.getElementById('btnShowMoreCats');

        if (moreCategories && btnShowMore) {
            moreCategories.addEventListener('shown.bs.collapse', () => {
                btnShowMore.innerHTML = 'Show Less <i class="fas fa-chevron-up ms-1"></i>';
            });
            moreCategories.addEventListener('hidden.bs.collapse', () => {
                btnShowMore.innerHTML = 'Show More <i class="fas fa-chevron-down ms-1"></i>';
            });
        }
    });
</script>

@endsection