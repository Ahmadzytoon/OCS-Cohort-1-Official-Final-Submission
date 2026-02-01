@extends('layouts.main.master')

@section('title', 'Photographers')

@section('css')
<link rel="stylesheet" href="{{ asset('css/photographers.css') }}">
@endsection



@section('content')
<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <div class="header-content">
            <h1 class="page-title">Find Your Perfect Photographer</h1>
            <p class="page-subtitle">
                Browse talented photographers, explore their portfolios, and book your session in minutes.
            </p>

            <!-- Search and Filters (CONNECTED TO BACKEND) -->
            <form method="GET" action="{{ route('photographers') }}" class="search-container">
                <div class="search-bar">
                    <input type="text" name="q" class="search-input"
                        value="{{ request('q') }}"
                        placeholder="Search by name, location, or style...">
                    <button class="search-btn" type="submit">
                        <i class="bi bi-search"></i>
                        <span>Search</span>
                    </button>
                </div>

                <div class="filters-row">
                    <div class="filter-group">
                        <div class="filter-label">Location</div>
                        <select class="filter-select" name="city" onchange="this.form.submit()">
                            <option value="">Any Location</option>
                            @foreach(($cities ?? []) as $c)
                            <option value="{{ $c }}" @selected(request('city')==$c)>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Photography Type</div>
                        <select class="filter-select" name="type" onchange="this.form.submit()">
                            <option value="">Any Type</option>
                            <option value="wedding" @selected(request('type')=='wedding' )>Wedding</option>
                            <option value="portrait" @selected(request('type')=='portrait' )>Portrait</option>
                            <option value="family" @selected(request('type')=='family' )>Family</option>
                            <option value="graduation" @selected(request('type')=='graduation' )>Graduation</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Price Min</div>
                        <input class="filter-select" type="number" name="min_price"
                            value="{{ request('min_price') }}" placeholder="0">
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Price Max</div>
                        <input class="filter-select" type="number" name="max_price"
                            value="{{ request('max_price') }}" placeholder="5000">
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Sort</div>
                        <select class="filter-select" name="sort" onchange="this.form.submit()">
                            <option value="">Default</option>
                            <option value="price_low" @selected(request('sort')=='price_low' )>Price: Low to High</option>
                            <option value="price_high" @selected(request('sort')=='price_high' )>Price: High to Low</option>
                        </select>
                    </div>

                    <div class="filter-group" style="display:flex; gap:10px; align-items:flex-end;">
                        <button class="search-btn" type="submit" style="padding: 12px 18px; font-size: 0.95rem;">
                            Apply
                        </button>

                        <a href="{{ route('photographers') }}" class="search-btn"
                            style="padding: 12px 18px; font-size: 0.95rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="main-content container">
    <div class="content-wrapper">

        <!-- Photographers Grid -->
        <section class="photographers-grid">
            <div class="grid-header">
                <div class="results-count">
                    @php
                    $total = $photographers?->total() ?? 0;
                    $from = $photographers?->firstItem() ?? 0;
                    $to = $photographers?->lastItem() ?? 0;
                    @endphp
                    Showing <span>{{ $from }}</span> - <span>{{ $to }}</span> of <span>{{ $total }}</span> photographers
                </div>

                <!-- (اختياري) إذا بدك select sort بنفس التصميم القديم -->
                <div>
                    <form method="GET" action="{{ route('photographers') }}">
                        {{-- حافظ على باقي الفلاتر --}}
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        <input type="hidden" name="city" value="{{ request('city') }}">
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">

                        <select class="sort-select" name="sort" onchange="this.form.submit()">
                            <option value="" @selected(request('sort')=='' )>Default</option>
                            <option value="price_low" @selected(request('sort')=='price_low' )>Price: Low to High</option>
                            <option value="price_high" @selected(request('sort')=='price_high' )>Price: High to Low</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="cards-grid" id="photographersGrid">
                @forelse($photographers as $u)
                @php
                $p = $u->photographerProfile;
                $imgs = $p ? ($previews[$p->id] ?? collect()) : collect();

                // Avatar
                $avatar = null;
                if ($p?->avatar) $avatar = asset('storage/'.$p->avatar);
                elseif ($p?->profile_image_path) $avatar = asset('storage/'.$p->profile_image_path);
                elseif (!empty($u->profile_image)) $avatar = asset('storage/'.$u->profile_image);
                else $avatar = asset('images/default-avatar.png');

                // types from photographers.photography_types (comma separated)

                $rawTypes = $p?->photography_types;

                // لو جاي Array (بسبب cast) خليه زي ما هو
                if (is_string($rawTypes)) {
                // لو String JSON جرّب نفكّه
                $decoded = json_decode($rawTypes, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $rawTypes = $decoded;
                }
                }

                // هسا جهز list نهائي
                $types = collect(
                is_array($rawTypes)
                ? $rawTypes
                : explode(',', (string)$rawTypes)
                )->map(fn($t) => trim((string)$t))
                ->filter()
                ->take(3);
                @endphp


                <div class="photographer-card">
                    <div class="card-header">
                        <div class="photographer-avatar">
                            <img src="{{ $avatar }}" alt="{{ $u->full_name }}">
                        </div>

                        <div class="photographer-info">
                            <h3 class="photographer-name">{{ $u->full_name }}</h3>

                            <div class="photographer-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>{{ $p?->city ?? '—' }}</span>
                            </div>

                            <div class="photographer-rating">
                                <span class="rating-count">New</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="specialty-tags">
                            @forelse($types as $t)
                            <span class="specialty-tag">{{ $t }}</span>
                            @empty
                            <span class="specialty-tag">General</span>
                            @endforelse
                        </div>

                        <div class="price-range-display">
                            <span class="price-label">Starting from</span>
                            <span class="price-value">
                                {{ $p?->starting_price ? $p->starting_price.' JOD' : '—' }}
                            </span>
                        </div>

                        <div class="portfolio-preview">
                            @forelse($imgs as $img)
                            <div class="portfolio-image">
                                <img src="{{ asset('storage/'.$img->image_path) }}" alt="Portfolio">
                            </div>
                            @empty
                            {{-- لو ما في صور portfolio --}}
                            <div class="portfolio-image">
                                <img src="{{ asset('images/placeholder-portfolio.png') }}" alt="No portfolio">
                            </div>
                            <div class="portfolio-image">
                                <img src="{{ asset('images/placeholder-portfolio.png') }}" alt="No portfolio">
                            </div>
                            <div class="portfolio-image">
                                <img src="{{ asset('images/placeholder-portfolio.png') }}" alt="No portfolio">
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="card-btn view-profile"
                            href="{{ route('photographer.public.show', $u->id) }}">
                            View Profile
                        </a>


                        <a class="card-btn book-now" href="#">
                            Book Now
                        </a>
                    </div>
                </div>
                @empty
                <p style="padding:20px;">No photographers found.</p>
                @endforelse
            </div>

            <div class="pagination">
                {{ $photographers->links() }}
            </div>
        </section>
    </div>
</main>

<!-- How to Choose Section -->
<section class="choose-section">
    <div class="container">
        <h2 class="section-title">How to Choose a Photographer</h2>

        <div class="choose-grid">
            <div class="choose-card">
                <div class="choose-icon">
                    <i class="bi bi-images"></i>
                </div>
                <h3 class="choose-title">Check Portfolio Quality</h3>
                <p class="choose-description">
                    Review their previous work to ensure their style matches your vision and expectations.
                </p>
            </div>

            <div class="choose-card">
                <div class="choose-icon">
                    <i class="bi bi-star"></i>
                </div>
                <h3 class="choose-title">Read Client Reviews</h3>
                <p class="choose-description">
                    Check ratings and read detailed reviews from previous clients about their experience.
                </p>
            </div>

            <div class="choose-card">
                <div class="choose-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h3 class="choose-title">Compare Prices</h3>
                <p class="choose-description">
                    Review pricing packages and ensure they fit within your budget while meeting your needs.
                </p>
            </div>

            <div class="choose-card">
                <div class="choose-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <h3 class="choose-title">Message Before Booking</h3>
                <p class="choose-description">
                    Communicate directly with photographers to discuss your specific requirements and expectations.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Can't Decide?</h2>
            <p class="cta-description">
                Let us help you find the best photographer for your occasion.
                Our team can match you with the perfect professional based on your specific needs.
            </p>
            <a class="cta-btn" href="{{ route('contact') ?? '#' }}">
                <span>Contact Us for Assistance</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endsection

<!-- Footer -->
@section('footer')
<footer class="footer-section" id="footer">
    <div class="footer-decoration decoration-1"></div>
    <div class="footer-decoration decoration-2"></div>

    <div class="container">
        <div class="footer-main">
            <div class="footer-grid">
                <div class="footer-brand footer-column" data-column="brand">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <div class="logo-icon">L</div>
                        <div class="logo-text">lydia<span>Photo</span></div>
                    </a>

                    <p class="footer-tagline">
                        Connecting clients with professional photographers and studios.
                        Capture your perfect moments with ease and confidence.
                    </p>

                    <div class="social-links mobile-only">
                        <a href="#" class="social-link" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="footer-column" data-column="quick-links">
                    <h3>Quick Links</h3>
                    <div class="footer-links">
                        <a href="{{ route('home') }}" class="footer-link"><i class="bi bi-house-door"></i><span>Home</span></a>
                        <a href="{{ route('photographers') }}" class="footer-link"><i class="bi bi-camera"></i><span>Browse Photographers</span></a>
                        <a href="{{ route('studio') }}" class="footer-link"><i class="bi bi-building"></i><span>Browse Studios</span></a>
                        <a href="{{ route('about') }}" class="footer-link"><i class="bi bi-info-circle"></i><span>About Us</span></a>
                        <a href="{{ route('contact') }}" class="footer-link"><i class="bi bi-chat-dots"></i><span>Contact</span></a>
                    </div>
                </div>

                <div class="footer-column" data-column="sessions">
                    <h3>Session Types</h3>
                    <div class="footer-links">
                        <a href="{{ route('photographers', ['type'=>'wedding']) }}" class="footer-link"><i class="bi bi-heart"></i><span>Wedding Sessions</span></a>
                        <a href="{{ route('photographers', ['type'=>'graduation']) }}" class="footer-link"><i class="bi bi-mortarboard"></i><span>Graduation Sessions</span></a>
                        <a href="{{ route('photographers', ['type'=>'family']) }}" class="footer-link"><i class="bi bi-people"></i><span>Family Sessions</span></a>
                        <a href="{{ route('photographers', ['type'=>'portrait']) }}" class="footer-link"><i class="bi bi-person-badge"></i><span>Portrait</span></a>
                    </div>
                </div>

                <div class="footer-column" data-column="contact-social">
                    <h3>Stay Connected</h3>

                    <div class="social-links desktop-only">
                        <a href="#" class="social-link" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    </div>

                    <div class="newsletter-form">
                        <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 10px;">
                            Subscribe to get updates on new photographers and special offers.
                        </p>
                        <input type="email" class="newsletter-input" placeholder="Your email address" aria-label="Email for newsletter">
                        <button type="button" class="newsletter-btn">
                            <span>Subscribe</span>
                            <i class="bi bi-envelope-arrow-up"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="copyright">
                    © 2025 <a href="{{ route('home') }}">lydiaPhoto</a>. All rights reserved.
                </div>

                <div class="legal-links">
                    <a href="#" class="legal-link">Privacy Policy</a>
                    <a href="#" class="legal-link">Terms & Conditions</a>
                    <a href="#" class="legal-link">Cookie Policy</a>
                    <a href="#" class="legal-link">Accessibility</a>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="bi bi-chevron-up"></i>
    </a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navbar = document.querySelector('.navbar');
        if (!navbar) return;

        if (window.location.pathname !== '/') {
            navbar.classList.add('scrolled');
        }
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Back to top
        const backToTopBtn = document.getElementById('backToTop');
        if (backToTopBtn) {
            window.addEventListener('scroll', () => {
                backToTopBtn.classList.toggle('visible', window.scrollY > 500);
            });
            backToTopBtn.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Newsletter (fake UI)
        const newsletterBtn = document.querySelector('.newsletter-btn');
        const newsletterInput = document.querySelector('.newsletter-input');

        if (newsletterBtn && newsletterInput) {
            newsletterBtn.addEventListener('click', function() {
                const email = newsletterInput.value.trim();
                if (!email) return newsletterInput.focus();

                newsletterBtn.disabled = true;
                newsletterBtn.innerHTML = '<span>Subscribing...</span><i class="bi bi-hourglass-split"></i>';

                setTimeout(() => {
                    newsletterBtn.innerHTML = '<span>Subscribed!</span><i class="bi bi-check-circle"></i>';
                    newsletterInput.value = '';
                    setTimeout(() => {
                        newsletterBtn.innerHTML = '<span>Subscribe</span><i class="bi bi-envelope-arrow-up"></i>';
                        newsletterBtn.disabled = false;
                    }, 1500);
                }, 800);
            });
        }
    });
</script>
@endsection