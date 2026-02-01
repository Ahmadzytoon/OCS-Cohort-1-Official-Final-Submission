@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/navbar.css') }}">
@endpush

<!-- Header Section Start (navbar) -->
<header class="header-1">
    <div class="container-fluid">
        <div class="mega-menu-wrapper" style="padding: 5px 0;">
            <div class="header-main d-flex justify-content-between align-items-center" style="gap: 40px;">

                <!-- LOGO -->
                <div class="logo">
                    <a href="{{ route('user.home') }}" class="header-logo d-flex align-items-center gap-2 text-decoration-none">
                        <img src="{{ asset('uploads/books/main logo icon.jpg') }}" alt="Readify Icon" style="height: 55px; width: auto; border-radius: 8px;">
                        <span class="readify-text">Readify</span>
                    </a>
                </div>

                <!-- MENU -->
                <div class="mean__menu-wrapper">
                    <div class="main-menu">
                        <nav id="mobile-menu" style="display: block;">
                            <ul>
                                <li><a href="{{ route('user.home') }}">Home</a></li>

                                <li>
                                    <a href="{{ route('user.shop') }}">
                                        Shop
                                        <i class="fas fa-angle-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('user.shop') }}">Shop</a></li>
                                        <li><a href="{{ route('user.checkout') }}">Checkout</a></li>
                                    </ul>
                                </li>

                                <li class="has-dropdown">
                                    <a href="{{ route('user.about') }}">
                                        Pages
                                        <i class="fas fa-angle-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('user.about') }}">About Us</a></li>
                                        <li><a href="{{ route('user.team') }}">Author</a></li>
                                        <li><a href="{{ route('user.faq') }}">Faq's</a></li>
                                    </ul>
                                </li>

                                <li><a href="{{ route('user.contact') }}">Contact</a></li>

                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="header-right d-flex justify-content-end align-items-center">
                    <!-- SEARCH ICON -->
                    <a href="#0" class="search-trigger search-icon style-2 d-xl-none">
                        <i class="fa-regular fa-magnifying-glass"></i>
                    </a>

                    {{-- AUTH/PROFILE MENU --}}
                    @auth
                        <div class="nav-user-dropdown-wrapper mx-3">
                            <a href="#" class="nav-user-icon" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                                <li class="px-3 py-2 border-bottom mb-2">
                                    <span class="fw-bold fs-6">Hi, {{ auth()->user()->name }}</span>
                                </li>
                                <li><a class="dropdown-item py-2" href="{{ route('user.profile') }}"><i class="fa-regular fa-circle-user me-2"></i>My Profile</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('user.orders') }}"><i class="fa-regular fa-box me-2"></i>My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="nav-user-dropdown-wrapper mx-3">
                            <a href="{{ route('login') }}" class="nav-user-icon">
                                <i class="fa-regular fa-user"></i>
                            </a>
                        </div>
                    @endauth

                    <div class="header-icon-wrapper mx-3">
                        <a href="{{ route('user.wishlist') }}" class="nav-user-icon position-relative" id="wishlist-link">
                            <i class="fa-regular fa-heart"></i>
                            <livewire:user.wishlist-counter />
                        </a>
                    </div>

                    {{-- CART ICON & DROPDOWN --}}
                    <div class="menu-cart">
                        @php
                            if (auth()->check()) {
                                $cart = \App\Models\Cart::where('user_id', auth()->id())
                                            ->with(['items.book' => function($q) {
                                                $q->where('status', 'Active');
                                            }])
                                            ->first();
                                
                                $cartItems = $cart 
                                    ? $cart->items->filter(fn($item) => $item->book !== null) 
                                    : collect();
                                
                                $cartCount = $cartItems->sum('quantity');
                                $cartTotal = $cartItems->sum(fn($item) => $item->book->price * $item->quantity);
                            } else {
                                $cartItems = collect();
                                $cartCount = 0;
                                $cartTotal = 0;
                            }
                        @endphp

                        <div class="cart-box">
                            @if($cartItems->count())
                                <ul>
                                    @foreach($cartItems as $item)
                                        <li>
                                            <img 
                                                src="{{ $item->book->cover_image 
                                                    ? asset('storage/' . $item->book->cover_image) 
                                                    : asset('assets/user/images/book/placeholder.png') }}" 
                                                alt="{{ $item->book->title }}">
                                            <div class="cart-product">
                                                <div class="cart-ctx">
                                                    <a href="{{ route('user.shop-details', $item->book->id) }}">
                                                        {{ $item->book->title }}
                                                    </a>
                                                    <span>${{ number_format($item->book->price, 2) }}</span>
                                                </div>
                                                <form action="{{ route('user.cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-transparent border-0" title="Remove item">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="shopping-items">
                                    <span>Total:</span>
                                    <span>${{ number_format($cartTotal, 2) }}</span>
                                </div>
                                <div class="cart-button mb-4">
                                    <a href="{{ route('user.shop-cart') }}" class="theme-btn">View Cart</a>
                                </div>
                            @else
                                <p class="text-center px-3 py-2">Your cart is empty</p>
                            @endif
                        </div>

                        <a href="{{ route('user.shop-cart') }}" class="cart-icon">
                            <i class="fa-sharp fa-regular fa-bag-shopping"></i>
                            <livewire:user.cart-counter />
                        </a>
                    </div>

                    <!-- MOBILE MENU -->
                    <div class="header__hamburger d-xl-none my-auto">
                        <div class="sidebar__toggle">
                            <i class="fas fa-bars"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

