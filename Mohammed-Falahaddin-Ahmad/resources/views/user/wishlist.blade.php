@extends('layouts.user')

@section('content')

<!-- Cursor follower -->
<div class="cursor-follower"></div>

<!-- Back To Top start -->
<button id="back-top" class="back-to-top">
    <i class="fa-solid fa-chevron-up"></i>
</button>

<!-- Breadcrumb Section Start -->
<div class="breadcrumb-wrapper bg-cover section-padding"
    style="background-image: url({{ asset('assets/user/images/hero/breadcrumb-bg.jpg') }});">
    <div class="container">
        <div class="page-heading">
            <h1>My Wishlist</h1>
            <div class="page-header">
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li>Wishlist</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Wishlist Section Start -->
<div class="wishlist-section section-padding">
    <div class="container">
        <div class="wishlist-wrapper">
            {{-- Success Alert --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($wishlist->count() > 0)
                <div class="row g-4">
                    @foreach($wishlist as $item)
                        @if($item->book)
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="wishlist-card shadow-sm h-100 position-relative">
                                    <a href="#" class="remove-btn position-absolute top-0 end-0 m-2 remove-from-wishlist" 
                                       data-id="{{ $item->book_id }}" title="Remove from wishlist">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    
                                    <div class="wishlist-thumb">
                                        @php
                                            $coverImage = $item->book->cover_image;
                                            $imagePath = asset('assets/user/images/book/placeholder.png');
                                            
                                            if ($coverImage) {
                                                if (file_exists(public_path('storage/' . $coverImage))) {
                                                    $imagePath = asset('storage/' . $coverImage);
                                                } 
                                                elseif (file_exists(public_path('uploads/books/' . $coverImage))) {
                                                    $imagePath = asset('uploads/books/' . $coverImage);
                                                } 
                                            }
                                        @endphp
                                        <a href="{{ route('user.shop-details', $item->book->id) }}">
                                            <img src="{{ $imagePath }}" alt="{{ $item->book->title }}" 
                                                 onerror="this.onerror=null; this.src='{{ asset('assets/user/images/book/placeholder.png') }}'">
                                        </a>
                                    </div>
                                    
                                    <div class="wishlist-content p-3 mt-2">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="book-title text-truncate mb-0" style="max-width: 100%;">
                                                <a href="{{ route('user.shop-details', $item->book->id) }}">{{ $item->book->title }}</a>
                                            </h6>
                                        </div>
                                        
                                        <div class="price-stock d-flex justify-content-between align-items-center mb-3">
                                            <span class="price fw-bold">${{ number_format($item->book->price, 2) }}</span>
                                            @if($item->book->stock_quantity > 0)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2">In Stock</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2">Out Stock</span>
                                            @endif
                                        </div>
                                        
                                        <div class="actions d-grid gap-2">
                                            <a href="{{ route('user.shop-details', $item->book->id) }}" class="theme-btn btn-sm style-2 text-center">
                                                Details
                                            </a>
                                            
                                            @auth
                                                <form action="{{ route('user.cart.add', $item->book->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="theme-btn btn-sm w-100 {{ $item->book->stock_quantity <= 0 ? 'bg-secondary disabled' : '' }}" {{ $item->book->stock_quantity <= 0 ? 'disabled' : '' }}>
                                                        <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}" class="theme-btn btn-sm text-center {{ $item->book->stock_quantity <= 0 ? 'bg-secondary disabled' : '' }}">
                                                    Add to Cart
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($wishlist->hasPages())
                    <div class="pagination-area d-flex justify-content-center mt-5">
                        {{ $wishlist->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="empty-wishlist text-center py-5 bg-light rounded shadow-sm">
                    <div class="mb-4">
                        <i class="fas fa-heart fa-4x text-muted opacity-25"></i>
                    </div>
                    <h4 class="fw-bold">Your Wishlist is Dreaming...</h4>
                    <p class="text-muted mb-4">It looks like you haven't added any books yet to your wishlist collection.</p>
                    <a href="{{ route('user.shop') }}" class="theme-btn">
                        <i class="fas fa-search me-1"></i> Discover New Books
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/wishlist.css') }}">
@endpush

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        document.querySelectorAll('.remove-from-wishlist').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const wishlistId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Remove Book?',
                    text: "Shall we remove this book from your wishlist?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff7c6b',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, remove',
                    cancelButtonText: 'Keep it',
                    borderRadius: '20px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/wishlist/remove/${wishlistId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed!',
                                    text: 'The book was removed from your collection.',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    borderRadius: '20px'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            });
        });
    });
</script>

@endsection