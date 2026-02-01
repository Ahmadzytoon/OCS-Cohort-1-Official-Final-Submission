@php
    /** @var \App\Models\User $user */
    $user = Auth::user();
@endphp

<nav class="navbar navbar-expand-lg fixed-top"
    style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px); border-bottom: 1px solid rgba(0,0,0,0.05); box-shadow: 0 2px 15px rgba(0,0,0,0.02); transition: all 0.3s ease; width: 100%;">
    <div class="container-fluid px-4 px-md-5">
        <!-- Logo (Left) -->
        <a class="navbar-brand font-heading fw-bold fs-4 text-uppercase ls-2 d-flex align-items-center"
            href="{{ url('/') }}" style="color: var(--color-ink-black);">
            <i class="fa-solid fa-gem me-2"></i> CHIC & CO.
        </a>

        <!-- Center Nav Items -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-lg-4 align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-uppercase ls-2 small fw-bold text-dark hover-gold underline-animation"
                        href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown">
                        Shop
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg rounded-4 p-2 mt-2 animate-fade-up">
                        <li><a class="dropdown-item py-2 rounded-3 small text-muted hover-bg-light"
                                href="{{ route('shop.index') }}">Entire Archive</a></li>
                        <li><a class="dropdown-item py-2 rounded-3 small text-muted hover-bg-light"
                                href="{{ route('shop.index', ['sort' => 'latest']) }}">New Arrivals</a></li>
                        <li>
                            <hr class="dropdown-divider opacity-50">
                        </li>
                        @foreach([
                            'soft' => ['label' => 'Soft Femme', 'emoji' => '🌸'],
                            'alt' => ['label' => 'Alt Girly', 'emoji' => '🖤'],
                            'luxury' => ['label' => 'Luxury Clean', 'emoji' => '✨'],
                            'mix' => ['label' => 'Modern Mix', 'emoji' => '🎭']
                        ] as $k => $info)
                            <li><a class="dropdown-item py-2 rounded-3 small text-muted hover-bg-light"
                                    href="{{ route('shop.index', ['aesthetic' => $k]) }}">
                                    <span class="me-2">{{ $info['emoji'] }}</span>{{ $info['label'] }}
                                </a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-uppercase ls-2 small fw-bold text-dark hover-gold underline-animation"
                        href="{{ route('personalized.feed') }}">
                        Curated Shop
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-uppercase ls-2 small fw-bold text-dark hover-gold underline-animation"
                        href="{{ route('sparkle.quiz') }}">
                        ✨ Identity
                    </a>
                </li>
            </ul>
        </div>

        <!-- Utility (Right) -->
        <div class="d-flex align-items-center gap-4">
            <!-- Home Icon -->
            <a href="{{ route('home') }}"
                class="text-dark opacity-50 hover-opacity-100 transition-premium d-flex align-items-center justify-content-center p-0"
                title="Home">
                <i class="fa-solid fa-house fs-5"></i>
            </a>

            <!-- Search -->
            <a href="javascript:void(0)"
                class="text-dark opacity-50 hover-opacity-100 transition-premium d-flex align-items-center justify-content-center p-0"
                onclick="document.getElementById('navSearchWrapper').classList.toggle('d-none')" role="button"
                title="Search">
                <i class="fa-solid fa-magnifying-glass fs-5"></i>
            </a>

            <!-- Wishlist -->
            <a href="{{ route('account.wishlist') }}"
                class="text-dark opacity-50 hover-opacity-100 transition-premium d-flex align-items-center justify-content-center p-0"
                title="Wishlist">
                <i class="fa-regular fa-heart fs-5"></i>
            </a>

            <!-- Profile -->
            <div class="nav-item dropdown profile-dropdown d-flex align-items-center">
                <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard')) : route('login') }}"
                    class="text-dark opacity-50 hover-opacity-100 transition-premium d-flex align-items-center justify-content-center p-0"
                    role="button">
                    <i class="fa-{{ auth()->check() ? 'solid' : 'regular' }} fa-user fs-5"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-3 mt-0 animate-fade-up">
                    @guest
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('login') }}">Sign In</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('register') }}">Join The List</a></li>
                    @else
                        <li><span class="dropdown-header extra-small text-uppercase ls-1 opacity-50 px-3">Authorized
                                Session</span></li>

                        @if($user->role === 'admin')
                            <li><a class="dropdown-item rounded-3 py-2 text-primary fw-bold"
                                    href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-toolbox me-2 opacity-50"></i>
                                    Curator Portal</a></li>
                        @else
                            <li><a class="dropdown-item rounded-3 py-2 fw-bold" href="{{ route('dashboard') }}"><i
                                        class="fa-solid fa-house me-2 opacity-50"></i> My Dashboard</a></li>
                        @endif

                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('profile') }}"><i
                                    class="fa-solid fa-id-card me-2 opacity-50"></i> Profile Curation</a></li>

                        <li>
                            <hr class="dropdown-divider opacity-10">
                        </li>
                        <li>
                            <form id="logout-form-nav" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="button" onclick="confirmLogout('logout-form-nav')"
                                    class="dropdown-item rounded-3 py-2 text-danger w-100 text-start border-0 bg-transparent">
                                    <i class="fa-solid fa-power-off me-2 opacity-50"></i> Departure
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>

            <!-- Cart -->
            <livewire:cart-count />

            <!-- Toggler -->
            <button class="navbar-toggler border-0 p-0 shadow-none d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars-staggered fs-4"></i>
            </button>
        </div>
    </div>

    <!-- Dropdown Search Bar -->
    <div id="navSearchWrapper" class="w-100 position-absolute start-0 bg-white border-bottom animate-fade-up d-none"
        style="top: 100%; z-index: 1000;">
        <div class="container py-3">
            <form action="{{ route('shop.index') }}" class="d-flex gap-3">
                <input type="text" name="search"
                    class="form-control border-0 bg-light rounded-pill px-4 py-2 shadow-none"
                    placeholder="Discover curated archives..." autofocus>
                <button type="submit" class="btn btn-dark rounded-pill px-4">Search</button>
            </form>
        </div>
    </div>
</nav>

<style>
    .underline-animation {
        position: relative;
    }

    .underline-animation::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 1px;
        background: var(--color-ink-black);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .underline-animation:hover::after {
        width: 40%;
    }

    .ls-2 {
        letter-spacing: 2px !important;
    }

    .hover-gold:hover {
        color: var(--color-warm-gold) !important;
    }

    .transition-premium {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Premium Hover Dropdowns */
    .nav-item.dropdown {
        position: relative;
        height: var(--nav-height);
        /* Match navbar height */
        display: flex;
        align-items: center;
    }

    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-menu {
        display: block;
        opacity: 0;
        visibility: hidden;
        top: 100% !important;
        /* Force to bottom of parent (navbar) */
        margin-top: 0 !important;
        transform: translateY(10px);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        min-width: 240px;
        right: 0 !important;
        /* Anchor to the right of parent */
        left: auto !important;
        border-radius: 0 0 1.5rem 1.5rem !important;
        /* Premium bottom rounding */
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }

    /* Invisible bridge to prevent flickering */
    .dropdown-menu::before {
        content: '';
        position: absolute;
        top: -30px;
        left: 0;
        width: 100%;
        height: 30px;
        background: transparent;
    }

    .dropdown-item {
        transition: all 0.2s ease;
        font-weight: 500;
        color: #444;
        padding: 0.7rem 1.25rem !important;
        /* Balanced internal padding */
    }

    .dropdown-item:hover {
        background-color: var(--color-cloud) !important;
        color: var(--color-ink-black);
        padding-left: 1.5rem !important;
        /* Subtle slide effect */
    }
</style>