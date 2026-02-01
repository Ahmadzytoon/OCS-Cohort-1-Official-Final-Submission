@extends('layouts.main.master')

@section('title', 'Home')

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-slider">
        <!-- Slide 1 -->
        <div class="hero-slide active" id="slide1">
            <div class="slide-overlay"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-10 mx-auto text-center">
                        <h1 class="hero-title">hello! this is lydia</h1>
                        <p class="hero-subtitle">most completed photography & magazine template with various options</p>
                        <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
                            @guest
                            <a href="{{ route('signup.step1') }}" class="cta-btn primary-btn">
                                <span>Get Started</span>
                                <i class="bi bi-person-plus btn-icon"></i>
                            </a>
                            <a href="{{ route('login') }}" class="cta-btn secondary-btn">
                                <span>Log In</span>
                                <i class="bi bi-box-arrow-in-right btn-icon"></i>
                            </a>
                            @else
                            <a href="{{ url('/customer/home') }}" class="cta-btn primary-btn">
                                <span>Go To Dashboard</span>
                                <i class="bi bi-speedometer2 btn-icon"></i>
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="cta-btn secondary-btn">
                                    <span>Logout</span>
                                    <i class="bi bi-box-arrow-right btn-icon"></i>
                                </button>
                            </form>
                            @endguest
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero-slide" id="slide2">
            <div class="slide-overlay"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-10 mx-auto text-center">
                        <h1 class="hero-title">built for creatives to showcase</h1>
                        <p class="hero-subtitle">their portfolio beautifully</p>
                        <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
                            @guest
                            <a href="{{ route('signup.step1') }}" class="cta-btn primary-btn">
                                <span>Get Started</span>
                                <i class="bi bi-person-plus btn-icon"></i>
                            </a>
                            <a href="{{ route('login') }}" class="cta-btn secondary-btn">
                                <span>Log In</span>
                                <i class="bi bi-box-arrow-in-right btn-icon"></i>
                            </a>
                            @else
                            <a href="{{ url('/customer/home') }}" class="cta-btn primary-btn">
                                <span>Go To Dashboard</span>
                                <i class="bi bi-speedometer2 btn-icon"></i>
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="cta-btn secondary-btn">
                                    <span>Logout</span>
                                    <i class="bi bi-box-arrow-right btn-icon"></i>
                                </button>
                            </form>
                            @endguest
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Slide Navigation -->
        <div class="slide-navigation">
            <button class="slide-prev" id="prevSlide">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="slide-next" id="nextSlide">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <!-- Slide Indicators -->
        <div class="slide-indicators">
            <button class="slide-indicator active" data-slide="0"></button>
            <button class="slide-indicator" data-slide="1"></button>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works-section" id="how-it-works">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-subtitle">Simple Process</span>
            <h2 class="section-title">How Lydia Works</h2>
            <p class="section-description">
                Book your perfect photography session in just four simple steps.
                From choosing your session type to receiving your final photos,
                we make the process seamless and stress-free.
            </p>
            <a href="{{ route('photographers') }}" class="cta-button">Browse Photographers</a>

        </div>

        <!-- Steps Container -->
        <div class="steps-container">
            <!-- Desktop connector line -->
            <div class="steps-connector"></div>

            <!-- Mobile connector line -->
            <div class="mobile-step-connector"></div>

            <div class="row">
                <!-- Step 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="step-card" data-step="1">
                        <div class="step-number">01</div>
                        <div class="step-icon">
                            <i class="bi bi-card-checklist"></i>
                        </div>
                        <h3 class="step-title">Choose a Session Type</h3>
                        <p class="step-description">
                            Select from graduation, wedding, family, personal,
                            or other photography sessions.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="step-card" data-step="2">
                        <div class="step-number">02</div>
                        <div class="step-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3 class="step-title">Browse Photographers</h3>
                        <p class="step-description">
                            View portfolios, ratings, and pricing from our
                            curated network of professional photographers.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="step-card" data-step="3">
                        <div class="step-number">03</div>
                        <div class="step-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h3 class="step-title">Book Your Session</h3>
                        <p class="step-description">
                            Select your preferred date & time, and submit
                            the booking request with your requirements.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="step-card" data-step="4">
                        <div class="step-number">04</div>
                        <div class="step-icon">
                            <i class="bi bi-images"></i>
                        </div>
                        <h3 class="step-title">Receive Your Photos</h3>
                        <p class="step-description">
                            Get your professionally edited photos delivered
                            securely through your Lydia account.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Types Section -->
<section class="booking-types-section" id="booking-types">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-subtitle">Our Services</span>
            <h2 class="section-title">Book Your Perfect Session</h2>
            <p class="section-description">
                From weddings to personal branding, we connect you with professional photographers
                who specialize in capturing your most important moments.
            </p>
        </div>

        <!-- Booking Cards Grid -->
        <div class="booking-cards-container">
            <div class="row g-4">
                <!-- Wedding Session -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="booking-card" data-card="1">
                        <div class="card-badge">Most Popular</div>
                        <div class="card-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Wedding Photography Session"
                                class="card-image">
                            <div class="card-overlay"></div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Wedding Session</h3>
                            <p class="card-description">
                                Capture the magic of your special day with our curated network of wedding photographers.
                            </p>
                            <a href="#" class="book-btn">
                                <span>Book Now</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Graduation Session -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="booking-card" data-card="2">
                        <div class="card-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Graduation Photography Session"
                                class="card-image">
                            <div class="card-overlay"></div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Graduation Session</h3>
                            <p class="card-description">
                                Celebrate academic achievements with professional portraits and campus photography.
                            </p>
                            <a href="#" class="book-btn">
                                <span>Book Now</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Family Session -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="booking-card" data-card="3">
                        <div class="card-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Family Photography Session"
                                class="card-image">
                            <div class="card-overlay"></div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Family Session</h3>
                            <p class="card-description">
                                Create timeless memories with your loved ones in natural, relaxed family portraits.
                            </p>
                            <a href="#" class="book-btn">
                                <span>Book Now</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kids Session -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="booking-card" data-card="4">
                        <div class="card-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Kids Photography Session"
                                class="card-image">
                            <div class="card-overlay"></div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Kids Session</h3>
                            <p class="card-description">
                                Capture your child's personality with fun, playful photography sessions tailored for kids.
                            </p>
                            <a href="#" class="book-btn">
                                <span>Book Now</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Personal Branding Session -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="booking-card" data-card="5">
                        <div class="card-badge">New</div>
                        <div class="card-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Personal Branding Photography Session"
                                class="card-image">
                            <div class="card-overlay"></div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Personal Branding</h3>
                            <p class="card-description">
                                Professional portraits for LinkedIn, websites, and personal branding materials.
                            </p>
                            <a href="#" class="book-btn">
                                <span>Book Now</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Maternity Session (Bonus) -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="booking-card" data-card="6">
                        <div class="card-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1518568814500-bf0f8d125f46?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Maternity Photography Session"
                                class="card-image">
                            <div class="card-overlay"></div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Maternity Session</h3>
                            <p class="card-description">
                                Beautifully capture the joy and anticipation of expecting a new family member.
                            </p>
                            <a href="#" class="book-btn">
                                <span>Book Now</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-5">
                <a href="#" class="view-all-btn">View All Session Types</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Photographers Section -->
<section class="photographers-section" id="featured-photographers">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-subtitle">Meet Our Experts</span>
            <h2 class="section-title">Featured Photographers</h2>
            <p class="section-description">
                Discover our curated selection of professional photographers, each with unique
                expertise and style to capture your special moments perfectly.
            </p>
        </div>

        <!-- Photographers Grid -->
        <div class="photographers-container">
            <div class="row g-4">
@forelse($featuredPhotographers as $index => $p)
    @php
        $name = $p->full_name ?? $p->name ?? 'Photographer';

        // 1) صورة البروفايل من جدول photographers
        $profileImagePath = optional($p->photographerProfile)->profile_image_path;

        // 2) أول صورة من portfolio كـ fallback
        $portfolioCoverPath = optional($p->portfolioItems->first())->image_path;

        // اختر الصورة بالترتيب: profile -> portfolio -> default
        if ($profileImagePath) {
            $image = asset('storage/' . $profileImagePath);
        } elseif ($portfolioCoverPath) {
            $image = asset('storage/' . $portfolioCoverPath);
        } else {
            $image = asset('images/default-photographer.jpg');
        }
    @endphp

    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="photographer-card" data-card="{{ $index + 1 }}">
            <div class="verified-badge" title="Verified Photographer">
                <i class="bi bi-check-lg"></i>
            </div>

            <div class="image-container">
                <img
                    src="{{ $image }}"
                    alt="{{ $name }}"
                    class="photographer-image">
                <div class="photographer-overlay"></div>
            </div>

            <div class="photographer-content">
                <h3 class="photographer-name">{{ $name }}</h3>

               <a href="{{ route('photographer.public.show', ['photographer' => $p->id]) }}" class="profile-btn">
    <span>View Profile</span>
    <i class="bi bi-arrow-right"></i>
</a>

            </div>
        </div>
    </div>

@empty
    <div class="col-12">
        <p class="text-center" style="margin:0;color:#64748b;">
            No approved photographers yet.
        </p>
    </div>
@endforelse



            <!-- View All Button -->
            <div class="text-center mt-5">
                <a href="{{ route('photographers') }}" class="view-all-btn">Browse All Photographers</a>
            </div>
        </div>
    </div>
</section>


<!-- Featured Studios Section -->
<section class="studios-section" id="featured-studios">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-subtitle">Professional Spaces</span>
            <h2 class="section-title">Featured Photography Studios</h2>
            <p class="section-description">
                Discover premium photography studios equipped with state-of-the-art facilities
                and professional teams ready to bring your vision to life.
            </p>
        </div>

        <!-- Studios Grid -->
        <div class="studios-container">
            <div class="row g-4">
                <!-- Studio 1 -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="studio-card" data-card="1">
                        <div class="premium-badge">Premium</div>
                        <div class="studio-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1603575448878-868a20723f5d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="LensCraft Studios - Professional Photography Studio"
                                class="studio-image">
                            <div class="studio-overlay"></div>
                        </div>
                        <div class="studio-content">
                            <h3 class="studio-name">LensCraft Studios</h3>

                            <div class="studio-info">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <span class="info-text">Manhattan, New York</span>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-camera"></i>
                                    </div>
                                    <span class="info-text">12+ Session Types</span>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <span class="info-text">Team of 8 Photographers</span>
                                </div>
                            </div>

                            <div class="studio-features">
                                <span class="feature-tag">Natural Light</span>
                                <span class="feature-tag">Backdrops</span>
                                <span class="feature-tag">Props</span>
                                <span class="feature-tag">Changing Room</span>
                            </div>

                            <div class="studio-stats">
                                <div class="studio-stat">
                                    <span class="stat-value">4.9</span>
                                    <span class="stat-label">Rating</span>
                                </div>
                                <div class="studio-stat">
                                    <span class="stat-value">850+</span>
                                    <span class="stat-label">Sessions</span>
                                </div>
                                <div class="studio-stat">
                                    <span class="stat-value">5+</span>
                                    <span class="stat-label">Years</span>
                                </div>
                            </div>

                            <a href="#" class="studio-btn">
                                <span>View Studio</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Studio 2 -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="studio-card" data-card="2">
                        <div class="premium-badge">Premium</div>
                        <div class="studio-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1564497717650-489eb99e8d09?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Aperture Arts - Modern Photography Studio"
                                class="studio-image">
                            <div class="studio-overlay"></div>
                        </div>
                        <div class="studio-content">
                            <h3 class="studio-name">Aperture Arts</h3>

                            <div class="studio-info">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <span class="info-text">Williamsburg, Brooklyn</span>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-camera"></i>
                                    </div>
                                    <span class="info-text">15+ Session Types</span>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <span class="info-text">Team of 6 Photographers</span>
                                </div>
                            </div>

                            <div class="studio-features">
                                <span class="feature-tag">Cyc Wall</span>
                                <span class="feature-tag">Studio Lighting</span>
                                <span class="feature-tag">Makeup Station</span>
                                <span class="feature-tag">Wardrobe</span>
                            </div>

                            <div class="studio-stats">
                                <div class="studio-stat">
                                    <span class="stat-value">4.8</span>
                                    <span class="stat-label">Rating</span>
                                </div>
                                <div class="studio-stat">
                                    <span class="stat-value">720+</span>
                                    <span class="stat-label">Sessions</span>
                                </div>
                                <div class="studio-stat">
                                    <span class="stat-value">7+</span>
                                    <span class="stat-label">Years</span>
                                </div>
                            </div>

                            <a href="#" class="studio-btn">
                                <span>View Studio</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Studio 3 -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="studio-card" data-card="3">
                        <div class="premium-badge">Premium</div>
                        <div class="studio-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="ShutterSpace Studio - Luxury Photography Space"
                                class="studio-image">
                            <div class="studio-overlay"></div>
                        </div>
                        <div class="studio-content">
                            <h3 class="studio-name">ShutterSpace Studio</h3>

                            <div class="studio-info">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <span class="info-text">Chelsea, London</span>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-camera"></i>
                                    </div>
                                    <span class="info-text">10+ Session Types</span>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <span class="info-text">Team of 5 Photographers</span>
                                </div>
                            </div>

                            <div class="studio-features">
                                <span class="feature-tag">High Ceilings</span>
                                <span class="feature-tag">Natural Light</span>
                                <span class="feature-tag">Kitchenette</span>
                                <span class="feature-tag">Parking</span>
                            </div>

                            <div class="studio-stats">
                                <div class="studio-stat">
                                    <span class="stat-value">4.7</span>
                                    <span class="stat-label">Rating</span>
                                </div>
                                <div class="studio-stat">
                                    <span class="stat-value">620+</span>
                                    <span class="stat-label">Sessions</span>
                                </div>
                                <div class="studio-stat">
                                    <span class="stat-value">4+</span>
                                    <span class="stat-label">Years</span>
                                </div>
                            </div>

                            <a href="#" class="studio-btn">
                                <span>View Studio</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Studio 4 -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="studio-card" data-card="4">
                        <div class="premium-badge">Premium</div>
                        <div class="studio-image-container">
                            <img
                                src="https://images.unsplash.com/photo-1542744095-fcf48d80b0fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Frame & Focus Studio - Boutique Photography Space"
                                class="studio-image">
                            <div class="studio-overlay"></div>
                        </div>
                        <div class="studio-content">
                            <h3 class="studio-name">Frame & Focus Studio</h3>

                            <div class="studio-info">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <span class="info-text">West Hollywood, LA</span>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-camera"></i>
                                    </div>
                                    <span class="info-text">8+ Session Types</span>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <span class="info-text">Team of 4 Photographers</span>
                                </div>
                            </div>

                            <div class="studio-features">
                                <span class="feature-tag">Outdoor Garden</span>
                                <span class="feature-tag">Studio Props</span>
                                <span class="feature-tag">Client Lounge</span>
                                <span class="feature-tag">Music System</span>
                            </div>

                            <div class="studio-stats">
                                <div class="studio-stat">
                                    <span class="stat-value">4.9</span>
                                    <span class="stat-label">Rating</span>
                                </div>
                                <div class="studio-stat">
                                    <span class="stat-value">540+</span>
                                    <span class="stat-label">Sessions</span>
                                </div>
                                <div class="studio-stat">
                                    <span class="stat-value">3+</span>
                                    <span class="stat-label">Years</span>
                                </div>
                            </div>

                            <a href="#" class="studio-btn">
                                <span>View Studio</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-5">
                <a href="#" class="view-all-btn">Browse All Studios</a>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section" id="benefits">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-subtitle">Value Proposition</span>
            <h2 class="section-title">Why Choose lydiaPhoto?</h2>
            <p class="section-description">
                A photography marketplace designed to benefit everyone in the creative ecosystem.
                Whether you're looking to book a session or grow your photography business.
            </p>
        </div>

        <!-- Benefits Grid -->
        <div class="benefits-container">
            <div class="row g-4">
                <!-- Clients / Customers -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="user-type-card clients" data-card="clients">
                        <div class="card-header">
                            <div class="user-icon-container">
                                <i class="bi bi-person-check user-icon"></i>
                            </div>
                            <div>
                                <h3 class="user-title">For Clients</h3>
                                <p class="user-subtitle">Booking made simple & secure</p>
                            </div>
                        </div>

                        <div class="benefits-list">
                            <div class="benefit-item" data-benefit="1">
                                <div class="benefit-icon">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">Easy Booking Process</h4>
                                    <p class="benefit-description">
                                        Book photography sessions in minutes with our intuitive platform.
                                    </p>
                                </div>
                            </div>

                            <div class="benefit-item" data-benefit="2">
                                <div class="benefit-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">Secure Payments</h4>
                                    <p class="benefit-description">
                                        Your payments are protected with our secure escrow system.
                                    </p>
                                </div>
                            </div>

                            <div class="benefit-item" data-benefit="3">
                                <div class="benefit-icon">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">Verified Reviews</h4>
                                    <p class="benefit-description">
                                        Make informed decisions with genuine client reviews and ratings.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photographers -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="user-type-card photographers" data-card="photographers">
                        <div class="card-header">
                            <div class="user-icon-container">
                                <i class="bi bi-camera user-icon"></i>
                            </div>
                            <div>
                                <h3 class="user-title">For Photographers</h3>
                                <p class="user-subtitle">Grow your photography business</p>
                            </div>
                        </div>

                        <div class="benefits-list">
                            <div class="benefit-item" data-benefit="1">
                                <div class="benefit-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">More Client Reach</h4>
                                    <p class="benefit-description">
                                        Connect with clients actively looking for photography services.
                                    </p>
                                </div>
                            </div>

                            <div class="benefit-item" data-benefit="2">
                                <div class="benefit-icon">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">Guaranteed Payments</h4>
                                    <p class="benefit-description">
                                        Get paid on time with our secure payment processing system.
                                    </p>
                                </div>
                            </div>

                            <div class="benefit-item" data-benefit="3">
                                <div class="benefit-icon">
                                    <i class="bi bi-images"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">Showcase Your Portfolio</h4>
                                    <p class="benefit-description">
                                        Display your work beautifully to attract your ideal clients.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Studios -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="user-type-card studios" data-card="studios">
                        <div class="card-header">
                            <div class="user-icon-container">
                                <i class="bi bi-building user-icon"></i>
                            </div>
                            <div>
                                <h3 class="user-title">For Studios</h3>
                                <p class="user-subtitle">Expand your studio's visibility</p>
                            </div>
                        </div>

                        <div class="benefits-list">
                            <div class="benefit-item" data-benefit="1">
                                <div class="benefit-icon">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">Attract More Clients</h4>
                                    <p class="benefit-description">
                                        Get discovered by clients searching for professional studio spaces.
                                    </p>
                                </div>
                            </div>

                            <div class="benefit-item" data-benefit="2">
                                <div class="benefit-icon">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">Promote Your Sessions</h4>
                                    <p class="benefit-description">
                                        Highlight your unique studio offerings and special packages.
                                    </p>
                                </div>
                            </div>

                            <div class="benefit-item" data-benefit="3">
                                <div class="benefit-icon">
                                    <i class="bi bi-award"></i>
                                </div>
                                <div class="benefit-content">
                                    <h4 class="benefit-title">Build Credibility</h4>
                                    <p class="benefit-description">
                                        Establish trust with verified reviews and professional profiles.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing -->
<section class="pricing" id="pricing">
  <div class="containerr">
    <div class="section-titlee">
      <h2>Simple & Transparent Pricing</h2>
      <p>Clear plans, no hidden fees — choose what fits your needs.</p>
    </div>

    <div class="pricing-tabs">
      <button class="tab-btn active" data-pricing="customer">For Clients</button>
      <button class="tab-btn" data-pricing="photographer">For Photographers</button>
      <button class="tab-btn" data-pricing="studio">For Studios</button>
    </div>

    @php
      $customerPlans = $plans['customer'] ?? collect();
      $photographerPlans = $plans['photographer'] ?? collect();
      $studioPlans = $plans['studio'] ?? collect();

      $p_customer_basic   = $customerPlans->firstWhere('code', 'basic');
      $p_customer_premium = $customerPlans->firstWhere('code', 'premium');
      $p_customer_vip     = $customerPlans->firstWhere('code', 'vip');

      $p_photo_free    = $photographerPlans->firstWhere('code', 'free');
      $p_photo_pro     = $photographerPlans->firstWhere('code', 'pro');
      $p_photo_premium = $photographerPlans->firstWhere('code', 'premium');

      $p_studio_starter = $studioPlans->firstWhere('code', 'starter');
      $p_studio_pro     = $studioPlans->firstWhere('code', 'pro');
      $p_studio_premium = $studioPlans->firstWhere('code', 'premium');

      $isLoggedIn = auth()->check();
    @endphp

    <!-- ===================== -->
    <!-- CUSTOMERS PRICING -->
    <!-- ===================== -->
    <div class="pricing-container" data-pricing-content="customer">
      {{-- Basic --}}
      <div class="pricing-card">
        <div class="pricing-header">
          <h3>Basic</h3>
          <div class="price">0 JOD</div>
          <p>Free forever</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Browse photographers & studios</li>
          <li><i class="fas fa-check"></i> View portfolios & services</li>
          <li><i class="fas fa-check"></i> Basic search & filters</li>
          <li><i class="fas fa-check"></i> Request a booking</li>
          <li class="disabled"><i class="fas fa-times"></i> Priority booking</li>
          <li class="disabled"><i class="fas fa-times"></i> Booking protection</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-outline">Login to Get Started</a>
        @elseif(!$p_customer_basic)
          <button class="btn btn-outline" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_customer_basic->id }}">
            <button type="submit" class="btn btn-outline">Get Started</button>
          </form>
        @endif
      </div>

      {{-- Premium --}}
      <div class="pricing-card popular">
        <div class="popular-badge">Best Value</div>
        <div class="pricing-header">
          <h3>Premium</h3>
          <div class="price">4 JOD<span>/month</span></div>
          <p>Cancel anytime</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Everything in Basic</li>
          <li><i class="fas fa-check"></i> Priority booking slots</li>
          <li><i class="fas fa-check"></i> Advanced filters</li>
          <li><i class="fas fa-check"></i> Booking protection</li>
          <li><i class="fas fa-check"></i> Easier rescheduling</li>
          <li><i class="fas fa-check"></i> Faster support</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-primary">Login to Subscribe</a>
        @elseif(!$p_customer_premium)
          <button class="btn btn-primary" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_customer_premium->id }}">
            <button type="submit" class="btn btn-primary">Choose Premium</button>
          </form>
        @endif
      </div>

      {{-- VIP --}}
      <div class="pricing-card">
        <div class="pricing-header">
          <h3>VIP</h3>
          <div class="price">8 JOD<span>/month</span></div>
          <p>For frequent bookings</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Everything in Premium</li>
          <li><i class="fas fa-check"></i> Highest priority booking</li>
          <li><i class="fas fa-check"></i> Dedicated support</li>
          <li><i class="fas fa-check"></i> Exclusive deals (limited)</li>
          <li><i class="fas fa-check"></i> Faster confirmations</li>
          <li><i class="fas fa-check"></i> Early access to new studios</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-outline">Login to Subscribe</a>
        @elseif(!$p_customer_vip)
          <button class="btn btn-outline" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_customer_vip->id }}">
            <button type="submit" class="btn btn-outline">Go VIP</button>
          </form>
        @endif
      </div>
    </div>

    <!-- ===================== -->
    <!-- PHOTOGRAPHERS PRICING -->
    <!-- ===================== -->
    <div class="pricing-container" data-pricing-content="photographer" style="display:none;">
      {{-- Free --}}
      <div class="pricing-card">
        <div class="pricing-header">
          <h3>Free</h3>
          <div class="price">0 JOD</div>
          <p>Start listing & test the platform</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Basic public profile</li>
          <li><i class="fas fa-check"></i> Portfolio (up to 8 photos)</li>
          <li><i class="fas fa-check"></i> Receive up to 2 booking requests / month</li>
          <li><i class="fas fa-check"></i> Basic booking management</li>
          <li class="disabled"><i class="fas fa-times"></i> Client chat & quick replies</li>
          <li class="disabled"><i class="fas fa-times"></i> Featured listing & analytics</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-outline">Login to Start</a>
        @elseif(!$p_photo_free)
          <button class="btn btn-outline" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_photo_free->id }}">
            <button type="submit" class="btn btn-outline">Start Free</button>
          </form>
        @endif
      </div>

      {{-- Pro --}}
      <div class="pricing-card popular">
        <div class="popular-badge">Most Popular</div>
        <div class="pricing-header">
          <h3>Pro</h3>
          <div class="price">12 JOD<span>/month</span></div>
          <p>For photographers who book regularly</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Unlimited portfolio & services</li>
          <li><i class="fas fa-check"></i> Full calendar & availability</li>
          <li><i class="fas fa-check"></i> Unlimited booking requests</li>
          <li><i class="fas fa-check"></i> Client chat + notifications</li>
          <li><i class="fas fa-check"></i> Lower platform commission</li>
          <li><i class="fas fa-check"></i> Reviews & social proof tools</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-primary">Login to Subscribe</a>
        @elseif(!$p_photo_pro)
          <button class="btn btn-primary" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_photo_pro->id }}">
            <button type="submit" class="btn btn-primary">Go Pro</button>
          </form>
        @endif
      </div>

      {{-- Premium --}}
      <div class="pricing-card">
        <div class="pricing-header">
          <h3>Premium</h3>
          <div class="price">25 JOD<span>/month</span></div>
          <p>Boost visibility & grow faster</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Everything in Pro</li>
          <li><i class="fas fa-check"></i> Featured badge & priority listing</li>
          <li><i class="fas fa-check"></i> Advanced analytics & insights</li>
          <li><i class="fas fa-check"></i> Custom booking page</li>
          <li><i class="fas fa-check"></i> Lowest platform commission</li>
          <li><i class="fas fa-check"></i> Priority support</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-outline">Login to Subscribe</a>
        @elseif(!$p_photo_premium)
          <button class="btn btn-outline" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_photo_premium->id }}">
            <button type="submit" class="btn btn-outline">Become Premium</button>
          </form>
        @endif
      </div>
    </div>

    <!-- ===================== -->
    <!-- STUDIOS PRICING -->
    <!-- ===================== -->
    <div class="pricing-container" data-pricing-content="studio" style="display:none;">
      {{-- Starter --}}
      <div class="pricing-card">
        <div class="pricing-header">
          <h3>Starter</h3>
          <div class="price">20 JOD<span>/month</span></div>
          <p>Perfect for a small studio</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Studio profile + services</li>
          <li><i class="fas fa-check"></i> 1 calendar (single schedule)</li>
          <li><i class="fas fa-check"></i> Up to 2 team members</li>
          <li><i class="fas fa-check"></i> Booking requests & management</li>
          <li class="disabled"><i class="fas fa-times"></i> Multi-photographer scheduling</li>
          <li class="disabled"><i class="fas fa-times"></i> Advanced analytics</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-outline">Login to Subscribe</a>
        @elseif(!$p_studio_starter)
          <button class="btn btn-outline" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_studio_starter->id }}">
            <button type="submit" class="btn btn-outline">Start Starter</button>
          </form>
        @endif
      </div>

      {{-- Studio Pro --}}
      <div class="pricing-card popular">
        <div class="popular-badge">Most Popular</div>
        <div class="pricing-header">
          <h3>Studio Pro</h3>
          <div class="price">45 JOD<span>/month</span></div>
          <p>For studios with multiple bookings daily</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Multiple calendars & time slots</li>
          <li><i class="fas fa-check"></i> Up to 8 team members</li>
          <li><i class="fas fa-check"></i> Multi-photographer scheduling</li>
          <li><i class="fas fa-check"></i> Client chat + automated updates</li>
          <li><i class="fas fa-check"></i> Lower platform commission</li>
          <li><i class="fas fa-check"></i> Reviews & highlights</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-primary">Login to Subscribe</a>
        @elseif(!$p_studio_pro)
          <button class="btn btn-primary" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_studio_pro->id }}">
            <button type="submit" class="btn btn-primary">Choose Studio Pro</button>
          </form>
        @endif
      </div>

      {{-- Studio Premium --}}
      <div class="pricing-card">
        <div class="pricing-header">
          <h3>Studio Premium</h3>
          <div class="price">80 JOD<span>/month</span></div>
          <p>Scale your studio with priority exposure</p>
        </div>

        <ul class="pricing-features">
          <li><i class="fas fa-check"></i> Everything in Studio Pro</li>
          <li><i class="fas fa-check"></i> Featured studio placement</li>
          <li><i class="fas fa-check"></i> Advanced analytics & reports</li>
          <li><i class="fas fa-check"></i> Custom booking page + branding</li>
          <li><i class="fas fa-check"></i> Lowest platform commission</li>
          <li><i class="fas fa-check"></i> Priority support</li>
        </ul>

        @if(!$isLoggedIn)
          <a href="{{ route('login') }}" class="btn btn-outline">Login to Subscribe</a>
        @elseif(!$p_studio_premium)
          <button class="btn btn-outline" disabled>Plan unavailable</button>
        @else
          <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $p_studio_premium->id }}">
            <button type="submit" class="btn btn-outline">Become Studio Premium</button>
          </form>
        @endif
      </div>
    </div>

    <!-- Mini note under pricing -->
    <div class="section-titlee" style="margin-top:18px;">
      <p style="opacity:.85;">
        No hidden fees. Upgrade, downgrade, or cancel anytime. Payments are secure and transparent.
      </p>
    </div>
  </div>
</section>

<!-- Tabs Script (simple) -->
<script>
  const tabBtns = document.querySelectorAll(".tab-btn");
  const pricingBlocks = document.querySelectorAll(".pricing-container[data-pricing-content]");

  tabBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      tabBtns.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const target = btn.getAttribute("data-pricing");

      pricingBlocks.forEach(block => {
        block.style.display = (block.getAttribute("data-pricing-content") === target) ? "grid" : "none";
      });
    });
  });
</script>



<!-- Testimonials Section -->
<section class="testimonials-section" id="testimonials">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-subtitle">Social Proof</span>
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="section-description">
                Real stories from photographers, studios, and clients who have experienced
                the lydiaPhoto difference in their creative journey.
            </p>
        </div>

        <!-- Testimonials Carousel -->
        <div class="testimonials-container">
            <div class="row" id="testimonialCarousel">
                <!-- Testimonial 1 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card" data-card="1">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                    alt="Sarah Johnson">
                            </div>
                            <div class="customer-details">
                                <h3 class="customer-name">Sarah Johnson</h3>
                                <p class="customer-session">Wedding Photography Client</p>
                            </div>
                        </div>

                        <div class="testimonial-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                            </div>
                            <span class="rating-text">5.0</span>
                        </div>

                        <div class="testimonial-text">
                            <p class="testimonial-quote">
                                "Booking our wedding photographer through lydiaPhoto was seamless.
                                The platform made it easy to compare portfolios and prices.
                                Our photos are absolutely stunning!"
                            </p>
                        </div>

                        <div class="session-info">
                            <div class="session-type">
                                <i class="bi bi-camera session-icon"></i>
                                <span class="session-name">Wedding Session</span>
                            </div>
                            <div class="session-date">May 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card" data-card="2">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                    alt="Michael Chen">
                            </div>
                            <div class="customer-details">
                                <h3 class="customer-name">Michael Chen</h3>
                                <p class="customer-session">Portrait Photographer</p>
                            </div>
                        </div>

                        <div class="testimonial-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-half star"></i>
                            </div>
                            <span class="rating-text">4.5</span>
                        </div>

                        <div class="testimonial-text">
                            <p class="testimonial-quote">
                                "As a photographer, lydiaPhoto has transformed my business.
                                I've doubled my client bookings and the secure payment system
                                gives me peace of mind."
                            </p>
                        </div>

                        <div class="session-info">
                            <div class="session-type">
                                <i class="bi bi-person session-icon"></i>
                                <span class="session-name">Portrait Photography</span>
                            </div>
                            <div class="session-date">Joined March 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card" data-card="3">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                <img src="https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                    alt="Priya Patel">
                            </div>
                            <div class="customer-details">
                                <h3 class="customer-name">Priya Patel</h3>
                                <p class="customer-session">Family Session Client</p>
                            </div>
                        </div>

                        <div class="testimonial-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star star empty"></i>
                            </div>
                            <span class="rating-text">4.0</span>
                        </div>

                        <div class="testimonial-text">
                            <p class="testimonial-quote">
                                "Found the perfect photographer for our family portraits.
                                The booking process was straightforward and the photographer
                                was professional and great with our kids."
                            </p>
                        </div>

                        <div class="session-info">
                            <div class="session-type">
                                <i class="bi bi-people session-icon"></i>
                                <span class="session-name">Family Session</span>
                            </div>
                            <div class="session-date">July 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card" data-card="4">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                    alt="David Wilson">
                            </div>
                            <div class="customer-details">
                                <h3 class="customer-name">David Wilson</h3>
                                <p class="customer-session">Studio Owner</p>
                            </div>
                        </div>

                        <div class="testimonial-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                            </div>
                            <span class="rating-text">5.0</span>
                        </div>

                        <div class="testimonial-text">
                            <p class="testimonial-quote">
                                "Our studio's bookings have increased by 40% since joining lydiaPhoto.
                                The platform attracts serious clients who appreciate professional photography."
                            </p>
                        </div>

                        <div class="session-info">
                            <div class="session-type">
                                <i class="bi bi-building session-icon"></i>
                                <span class="session-name">Studio Partner</span>
                            </div>
                            <div class="session-date">Joined January 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 5 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card" data-card="5">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                    alt="Emma Rodriguez">
                            </div>
                            <div class="customer-details">
                                <h3 class="customer-name">Emma Rodriguez</h3>
                                <p class="customer-session">Graduation Session Client</p>
                            </div>
                        </div>

                        <div class="testimonial-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-half star"></i>
                            </div>
                            <span class="rating-text">4.5</span>
                        </div>

                        <div class="testimonial-text">
                            <p class="testimonial-quote">
                                "The graduation photographer I found here captured my special day perfectly.
                                Easy to book, professional service, and beautiful photos I'll cherish forever."
                            </p>
                        </div>

                        <div class="session-info">
                            <div class="session-type">
                                <i class="bi bi-mortarboard session-icon"></i>
                                <span class="session-name">Graduation Session</span>
                            </div>
                            <div class="session-date">June 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 6 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card" data-card="6">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                <img src="https://images.unsplash.com/photo-1507591064344-4c6ce005b128?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                    alt="James Miller">
                            </div>
                            <div class="customer-details">
                                <h3 class="customer-name">James Miller</h3>
                                <p class="customer-session">Event Photographer</p>
                            </div>
                        </div>

                        <div class="testimonial-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                                <i class="bi bi-star-fill star"></i>
                            </div>
                            <span class="rating-text">5.0</span>
                        </div>

                        <div class="testimonial-text">
                            <p class="testimonial-quote">
                                "The best platform for professional photographers.
                                Client communication is smooth and payments are always on time.
                                Highly recommended!"
                            </p>
                        </div>

                        <div class="session-info">
                            <div class="session-type">
                                <i class="bi bi-calendar-event session-icon"></i>
                                <span class="session-name">Event Photography</span>
                            </div>
                            <div class="session-date">Joined February 2023</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
            <div class="carousel-controls">
                <button class="carousel-btn" id="prevTestimonial">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="carousel-dots" id="testimonialDots">
                    <button class="carousel-dot active" data-slide="0"></button>
                    <button class="carousel-dot" data-slide="1"></button>
                    <button class="carousel-dot" data-slide="2"></button>
                </div>

                <button class="carousel-btn" id="nextTestimonial">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section" id="cta">
    <!-- Floating elements -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>

    <div class="container">
        <div class="cta-container">
            <div class="cta-content">
                <h2 class="cta-headline">Book Your Session With The Best Photographers In Your City</h2>

                <p class="cta-subheadline">
                    Join thousands of satisfied clients who have captured their special moments
                    through our curated network of professional photographers and studios.
                </p>

                <div class="cta-buttons">
                    <a href="#" class="cta-btn primary-btn" id="bookNowBtn">
                        <span>Book a Session Now</span>
                        <i class="bi bi-calendar-check btn-icon"></i>
                    </a>

                    <a href="#" class="cta-btn secondary-btn" id="joinPhotographerBtn">
                        <span>Join as Photographer</span>
                        <i class="bi bi-camera btn-icon"></i>
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="trust-indicators">
                    <div class="trust-item">
                        <i class="bi bi-shield-check trust-icon"></i>
                        <span>Secure Booking & Payments</span>
                    </div>
                    <div class="trust-item">
                        <i class="bi bi-star trust-icon"></i>
                        <span>4.9/5 Average Rating</span>
                    </div>
                    <div class="trust-item">
                        <i class="bi bi-people trust-icon"></i>
                        <span>500+ Professional Photographers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-section" id="about">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-subtitle">Our Story</span>
            <h2 class="section-title">About lydiaPhoto</h2>
            <p class="section-description">
                Building connections between moments and memories through the art of photography.
            </p>
        </div>

        <!-- About Content -->
        <div class="about-content">
            <!-- Decorative Elements -->
            <div class="about-decoration decoration-1"></div>
            <div class="about-decoration decoration-2"></div>

            <div class="about-card">
                <div class="about-grid">
                    <!-- Text Column -->
                    <div class="about-text">
                        <h3 class="about-headline">Connecting <span>Creativity</span> with <span>Opportunity</span></h3>

                        <p class="about-paragraph">
                            lydiaPhoto was born from a simple vision: to create a seamless bridge between
                            people who want to capture life's precious moments and talented photographers
                            who can turn those moments into lasting memories.
                        </p>

                        <p class="about-paragraph">
                            We noticed that finding the right photographer was often a challenging
                            experience—filled with uncertainty about quality, pricing, and reliability.
                            Meanwhile, talented photographers struggled to reach clients who would
                            appreciate their unique style and expertise.
                        </p>

                        <div class="vision-points">
                            <div class="vision-item" data-item="1">
                                <div class="vision-icon">
                                    <i class="bi bi-lightbulb"></i>
                                </div>
                                <div class="vision-content">
                                    <h4>Our Vision</h4>
                                    <p>
                                        To become the most trusted photography marketplace where every
                                        moment can be beautifully captured by the perfect photographer.
                                    </p>
                                </div>
                            </div>

                            <div class="vision-item" data-item="2">
                                <div class="vision-icon">
                                    <i class="bi bi-bullseye"></i>
                                </div>
                                <div class="vision-content">
                                    <h4>Our Mission</h4>
                                    <p>
                                        Simplify the photography booking process while empowering
                                        photographers to grow their businesses and showcase their art.
                                    </p>
                                </div>
                            </div>

                            <div class="vision-item" data-item="3">
                                <div class="vision-icon">
                                    <i class="bi bi-heart"></i>
                                </div>
                                <div class="vision-content">
                                    <h4>Our Promise</h4>
                                    <p>
                                        Quality, reliability, and exceptional experiences for both
                                        clients and photographers through our carefully curated platform.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visual Column -->
                    <div class="about-visual">
                        <div class="visual-container">
                            <img
                                src="https://images.unsplash.com/photo-1554048612-b6a482bc67e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Photographer capturing special moments"
                                class="visual-image">
                            <div class="visual-overlay">
                                <h3>Capturing Life's Most Precious Moments</h3>
                                <p>Professional photography made accessible, reliable, and memorable</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Bar -->
                <div class="stats-bar">
                    <div class="stat-item">
                        <span class="stat-valuee" id="stat1">500+</span>
                        <span class="stat-label">Professional Photographers</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-valuee" id="stat2">10K+</span>
                        <span class="stat-label">Successful Sessions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-valuee" id="stat3">98%</span>
                        <span class="stat-label">Client Satisfaction</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-valuee" id="stat4">50+</span>
                        <span class="stat-label">Cities Covered</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-subtitle">Get In Touch</span>
            <h2 class="section-title">Contact Us</h2>
            <p class="section-description">
                Have questions or need assistance? We're here to help you with booking,
                partnerships, or any inquiries about our platform.
            </p>
        </div>

        <!-- Contact Content -->
        <div class="contact-content">
            <div class="contact-card">
                <div class="contact-grid">
                    <!-- Contact Form -->
                    <div class="form-container">
                        <form id="contactForm" class="contact-form">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <span>Full Name</span>
                                    <span class="required">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-input"
                                    placeholder="Enter your full name"
                                    required>
                                <div class="error-message" id="nameError">Please enter your name</div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <span>Email Address</span>
                                    <span class="required">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-input"
                                    placeholder="Enter your email address"
                                    required>
                                <div class="error-message" id="emailError">Please enter a valid email address</div>
                            </div>

                            <div class="form-group">
                                <label for="message" class="form-label">
                                    <span>Your Message</span>
                                    <span class="required">*</span>
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    class="form-input"
                                    placeholder="Tell us how we can help you..."
                                    rows="5"
                                    required></textarea>
                                <div class="error-message" id="messageError">Please enter your message</div>
                            </div>

                            <button type="submit" class="submit-btn" id="submitBtn">
                                <span>Send Message</span>
                                <i class="bi bi-send btn-icon"></i>
                            </button>

                            <div class="response-message" id="responseMessage"></div>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="contact-info">
                        <div class="info-header">
                            <h3>How Can We Help?</h3>
                            <p>
                                Whether you're a client looking for the perfect photographer,
                                a photographer wanting to join our platform, or have any other
                                questions—we're ready to assist.
                            </p>
                        </div>

                        <div class="contact-methods">
                            <div class="contact-method" data-method="1">
                                <div class="method-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="method-content">
                                    <h4>Email Us</h4>
                                    <p>For general inquiries and support</p>
                                    <a href="mailto:hello@lydiaphoto.com" class="method-link">
                                        hello@lydiaphoto.com
                                    </a>
                                </div>
                            </div>

                            <div class="contact-method" data-method="2">
                                <div class="method-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div class="method-content">
                                    <h4>Call Us</h4>
                                    <p>Monday to Friday, 9AM - 6PM</p>
                                    <a href="tel:+962798706042" class="method-link">
                                        +962 (79) 870-6042
                                    </a>
                                </div>
                            </div>

                            <div class="contact-method" data-method="3">
                                <div class="method-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="method-content">
                                    <h4>Response Time</h4>
                                    <p>We typically respond within</p>
                                    <p class="method-link" style="text-decoration: none; cursor: default;">
                                        24 hours
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- هون بنحط footer القالب نفسه عشان يطلع زي ما هو --}}
@section('footer')
<!-- Footer Section -->
<!-- Footer Section -->
<footer class="footer-section" id="footer">
    <!-- Decorative Elements -->
    <div class="footer-decoration decoration-1"></div>
    <div class="footer-decoration decoration-2"></div>

    <div class="container">
        <!-- Main Footer -->
        <div class="footer-main">
            <div class="footer-grid">
                <!-- Brand Column -->
                <div class="footer-brand footer-column" data-column="brand">
                    <a href="#" class="footer-logo">
                        <div class="logo-icon">L</div>
                        <div class="logo-text">lydia<span>Photo</span></div>
                    </a>

                    <p class="footer-tagline">
                        Connecting clients with professional photographers and studios.
                        Capture your perfect moments with ease and confidence.
                    </p>

                    <!-- Social Links (Mobile placement) -->
                    <div class="social-links mobile-only">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links Column -->
                <div class="footer-column" data-column="quick-links">
                    <h3>Quick Links</h3>
                    <div class="footer-links">
                        <a href="#" class="footer-link">
                            <i class="bi bi-house-door"></i>
                            <span>Home</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-camera"></i>
                            <span>Browse Photographers</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-building"></i>
                            <span>Browse Studios</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-play-circle"></i>
                            <span>How It Works</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-info-circle"></i>
                            <span>About Us</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-chat-dots"></i>
                            <span>Contact</span>
                        </a>
                    </div>
                </div>

                <!-- Session Types Column -->
                <div class="footer-column" data-column="sessions">
                    <h3>Session Types</h3>
                    <div class="footer-links">
                        <a href="#" class="footer-link">
                            <i class="bi bi-heart"></i>
                            <span>Wedding Sessions</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-mortarboard"></i>
                            <span>Graduation Sessions</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-people"></i>
                            <span>Family Sessions</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-balloon"></i>
                            <span>Kids Sessions</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-person-badge"></i>
                            <span>Personal Branding</span>
                        </a>
                        <a href="#" class="footer-link">
                            <i class="bi bi-calendar-event"></i>
                            <span>Event Photography</span>
                        </a>
                    </div>
                </div>

                <!-- Contact & Social Column -->
                <div class="footer-column" data-column="contact-social">
                    <h3>Stay Connected</h3>

                    <!-- Social Links -->
                    <div class="social-links desktop-only">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="newsletter-form">
                        <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 10px;">
                            Subscribe to get updates on new photographers and special offers.
                        </p>
                        <input
                            type="email"
                            class="newsletter-input"
                            placeholder="Your email address"
                            aria-label="Email for newsletter">
                        <button type="button" class="newsletter-btn">
                            <span>Subscribe</span>
                            <i class="bi bi-envelope-arrow-up"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="copyright">
                    © 2025 <a href="#">lydiaPhoto</a>. All rights reserved.
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

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="bi bi-chevron-up"></i>
    </a>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@section('script')
<script>
    console.log("script.js loaded ✅");
    document.addEventListener("DOMContentLoaded", () => {
        // كود الـ Home JS هون


        // Scroll animation for step cards

        const stepCards = document.querySelectorAll('.step-card');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.9 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkStepVisibility() {
            stepCards.forEach(card => {
                if (isElementInViewport(card)) {
                    card.classList.add('visible');
                }
            });
        }

        // Add staggered delay for each card
        stepCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.1}s`;
        });

        // Check visibility on load and scroll
        checkStepVisibility();
        window.addEventListener('scroll', checkStepVisibility);

        // Add hover effect for step cards
        stepCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
            });

            card.addEventListener('mouseleave', function() {
                const step = this.getAttribute('data-step');
                this.style.transitionDelay = `${(step-1) * 0.1}s`;
            });
        });






        // Scroll animation for booking cards

        const bookingCards = document.querySelectorAll('.booking-card');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkBookingCardVisibility() {
            bookingCards.forEach(card => {
                if (isElementInViewport(card)) {
                    card.classList.add('visible');
                }
            });
        }

        // Add staggered delay for each card
        bookingCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.1}s`;
        });

        // Check visibility on load and scroll
        checkBookingCardVisibility();
        window.addEventListener('scroll', checkBookingCardVisibility);

        // Card hover effect enhancements
        bookingCards.forEach(card => {
            const bookBtn = card.querySelector('.book-btn');

            card.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
                if (bookBtn) bookBtn.style.transitionDelay = '0.1s';
            });

            card.addEventListener('mouseleave', function() {
                const cardNum = this.getAttribute('data-card');
                this.style.transitionDelay = `${(cardNum-1) * 0.1}s`;
                if (bookBtn) bookBtn.style.transitionDelay = '0s';
            });
        });

        // Book button interactions
        const bookButtons = document.querySelectorAll('.book-btn');
        bookButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Get the session type from the card title
                const card = this.closest('.booking-card');
                const cardTitle = card.querySelector('.card-title').textContent;

                // In a real implementation, this would navigate to booking page
                // with the session type pre-selected
                console.log(`Starting booking process for: ${cardTitle}`);

                // Visual feedback
                this.style.backgroundColor = '#c4a484';
                setTimeout(() => {
                    this.style.backgroundColor = '';
                }, 300);
            });
        });

        // View All button interaction
        // View All booking button
        const viewAllBookingBtn = document.querySelector('.view-all-btn');
        if (viewAllBookingBtn) {
            viewAllBookingBtn.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Navigating to all session types page...');
            });
        }


        // Card click interaction (optional - if you want whole card to be clickable)
        bookingCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on the book button
                if (!e.target.closest('.book-btn')) {
                    const cardTitle = this.querySelector('.card-title').textContent;
                    console.log(`Viewing details for: ${cardTitle}`);

                    // Visual feedback
                    this.style.transform = 'translateY(-12px) scale(1.02)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 200);
                }
            });
        });

        // Scroll animation for photographer cards

        const photographerCards = document.querySelectorAll('.photographer-card');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkPhotographerCardVisibility() {
            photographerCards.forEach(card => {
                if (isElementInViewport(card)) {
                    card.classList.add('visible');
                }
            });
        }

        // Add staggered delay for each card
        photographerCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.1}s`;
        });

        // Check visibility on load and scroll
        checkPhotographerCardVisibility();
        window.addEventListener('scroll', checkPhotographerCardVisibility);

        // Card hover effect enhancements
        photographerCards.forEach(card => {
            const profileBtn = card.querySelector('.profile-btn');

            card.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
                if (profileBtn) profileBtn.style.transitionDelay = '0.1s';
            });

            card.addEventListener('mouseleave', function() {
                const cardNum = this.getAttribute('data-card');
                this.style.transitionDelay = `${(cardNum-1) * 0.1}s`;
                if (profileBtn) profileBtn.style.transitionDelay = '0s';
            });
        });

        // Profile button interactions
        // Profile button: خليه يشتغل كـ <a> طبيعي (بدون منع التنقل)
document.querySelectorAll('.profile-btn').forEach(link => {
    link.addEventListener('click', function (e) {
        // بس امنع كليك الكارد (لو الكارد نفسه عليه click)
        e.stopPropagation();

        // OPTIONAL: تأثير بسيط بدون ما يمنع التنقل
        this.classList.add('clicked');
        setTimeout(() => this.classList.remove('clicked'), 200);

        // لا تعمل preventDefault => خلي المتصفح يروح على href طبيعي
    });
});


        // View All button interaction
        // View All photographers button
        const viewAllPhotographersBtn = document.querySelector('.view-all-btn');
        if (viewAllPhotographersBtn) {
            viewAllPhotographersBtn.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Navigating to photographers directory...');
            });
        }


        // Card click interaction (optional - if you want whole card to be clickable)
        photographerCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on the profile button
                if (!e.target.closest('.profile-btn')) {
                    const photographerName = this.querySelector('.photographer-name').textContent;
                    console.log(`Viewing details for: ${photographerName}`);

                    // Visual feedback
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 200);
                }
            });
        });


        // Scroll animation for studio cards
        const studioCards = document.querySelectorAll('.studio-card');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkStudioCardVisibility() {
            studioCards.forEach(card => {
                if (isElementInViewport(card)) {
                    card.classList.add('visible');
                }
            });
        }

        // Add staggered delay for each card
        studioCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.1}s`;
        });

        // Check visibility on load and scroll
        checkStudioCardVisibility();
        window.addEventListener('scroll', checkStudioCardVisibility);

        // Card hover effect enhancements
        studioCards.forEach(card => {
            const studioBtn = card.querySelector('.studio-btn');

            card.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
                if (studioBtn) studioBtn.style.transitionDelay = '0.1s';
            });

            card.addEventListener('mouseleave', function() {
                const cardNum = this.getAttribute('data-card');
                this.style.transitionDelay = `${(cardNum-1) * 0.1}s`;
                if (studioBtn) studioBtn.style.transitionDelay = '0s';
            });
        });

        // Studio button interactions
        const studioButtons = document.querySelectorAll('.studio-btn');
        studioButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Get the studio name from the card
                const card = this.closest('.studio-card');
                const studioName = card.querySelector('.studio-name').textContent;

                // In a real implementation, this would navigate to studio profile page
                console.log(`Viewing studio profile: ${studioName}`);

                // Visual feedback
                this.style.backgroundColor = '#c4a484';
                setTimeout(() => {
                    this.style.backgroundColor = '';
                }, 300);
            });
        });

        // View All button interaction
        const viewAllBtn = document.querySelector('.view-all-btn');
        if (viewAllBtn) {
            viewAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                // In a real implementation, this would navigate to studios directory
                alert('Navigating to studios directory...');
            });
        }

        // Card click interaction (optional - if you want whole card to be clickable)
        studioCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on the studio button
                if (!e.target.closest('.studio-btn')) {
                    const studioName = this.querySelector('.studio-name').textContent;
                    console.log(`Viewing details for: ${studioName}`);

                    // Visual feedback
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 200);
                }
            });
        });


        const badges = document.querySelectorAll('.premium-badge');
        badges.forEach(badge => {
            badge.setAttribute('title', 'Premium verified studio');
        });


        // Scroll animation for cards and benefit items

        const userCards = document.querySelectorAll('.user-type-card');
        const benefitItems = document.querySelectorAll('.benefit-item');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkUserTypeVisibility() {
            // Check user cards
            userCards.forEach(card => {
                if (isElementInViewport(card)) {
                    card.classList.add('visible');

                    // Once card is visible, animate its benefit items
                    const cardBenefits = card.querySelectorAll('.benefit-item');
                    cardBenefits.forEach((benefit, index) => {
                        setTimeout(() => {
                            benefit.classList.add('visible');
                        }, 100 * index);
                    });
                }
            });

            // Check individual benefit items (for cases where card might already be visible)
            benefitItems.forEach(item => {
                if (isElementInViewport(item) && !item.classList.contains('visible')) {
                    setTimeout(() => {
                        item.classList.add('visible');
                    }, 100);
                }
            });
        }

        // Add staggered delay for each card
        userCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.15}s`;
        });

        // Add staggered delay for benefit items within each card
        userCards.forEach(card => {
            const benefits = card.querySelectorAll('.benefit-item');
            benefits.forEach((item, index) => {
                item.style.transitionDelay = `${index * 0.1}s`;
            });
        });

        // Check visibility on load and scroll
        checkUserTypeVisibility();
        window.addEventListener('scroll', checkUserTypeVisibility);

        // Card hover effect enhancements
        userCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
            });

            card.addEventListener('mouseleave', function() {
                const cardType = this.getAttribute('data-card');
                let delayIndex = 0;
                if (cardType === 'clients') delayIndex = 0;
                if (cardType === 'photographers') delayIndex = 1;
                if (cardType === 'studios') delayIndex = 2;
                this.style.transitionDelay = `${delayIndex * 0.15}s`;
            });
        });

        // Benefit item hover effect
        benefitItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
            });

            item.addEventListener('mouseleave', function() {
                const benefitNum = this.getAttribute('data-benefit');
                this.style.transitionDelay = `${(benefitNum-1) * 0.1}s`;
            });
        });

        // CTA button interactions
        const primaryBtn = document.querySelector('.primary-btn');
        const secondaryBtn = document.querySelector('.secondary-btn');

        if (primaryBtn) {
            primaryBtn.addEventListener('click', function(e) {
                e.preventDefault();
                // In a real implementation, this would navigate to booking page
                alert('Navigating to booking page...');
            });
        }

        if (secondaryBtn) {
            secondaryBtn.addEventListener('click', function(e) {
                e.preventDefault();
                // In a real implementation, this would navigate to photographer signup
                alert('Navigating to photographer registration...');
            });
        }

        // Add visual feedback for benefit items on click
        benefitItems.forEach(item => {
            item.addEventListener('click', function() {
                const benefitTitle = this.querySelector('.benefit-title').textContent;
                console.log(`Benefit clicked: ${benefitTitle}`);

                // Visual feedback
                const icon = this.querySelector('.benefit-icon');
                icon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    icon.style.transform = '';
                }, 300);
            });
        });


        // Testimonial Carousel Functionality

        const testimonialCards = document.querySelectorAll('.testimonial-card');
        const prevBtn = document.getElementById('prevTestimonial');
        const nextBtn = document.getElementById('nextTestimonial');
        const dots = document.querySelectorAll('.carousel-dot');

        let currentSlide = 0;
        let slidesPerView = 3; // Default for desktop

        // Function to update slides per view based on screen size
        function updateSlidesPerView() {
            if (window.innerWidth >= 1200) {
                slidesPerView = 3; // Desktop: 3 testimonials
            } else if (window.innerWidth >= 768) {
                slidesPerView = 2; // Tablet: 2 testimonials
            } else {
                slidesPerView = 1; // Mobile: 1 testimonial
            }

            // Update carousel dots based on visible slides
            updateCarouselDots();
        }

        // Function to calculate total slides based on visible items
        function calculateTotalSlides() {
            return Math.ceil(testimonialCards.length / slidesPerView);
        }

        // Function to update carousel dots
        function updateCarouselDots() {
            const totalSlides = calculateTotalSlides();
            const dotsContainer = document.getElementById('testimonialDots');

            // Clear existing dots
            dotsContainer.innerHTML = '';

            // Create new dots
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('button');
                dot.className = `carousel-dot ${i === currentSlide ? 'active' : ''}`;
                dot.setAttribute('data-slide', i);
                dot.innerHTML = '';

                dot.addEventListener('click', function() {
                    goToSlide(i);
                });

                dotsContainer.appendChild(dot);
            }
        }

        // Function to go to specific slide
        function goToSlide(slideIndex) {
            const totalSlides = calculateTotalSlides();

            // Ensure slide index is within bounds
            if (slideIndex < 0) {
                currentSlide = totalSlides - 1;
            } else if (slideIndex >= totalSlides) {
                currentSlide = 0;
            } else {
                currentSlide = slideIndex;
            }

            // Calculate scroll position
            const container = document.getElementById('testimonialCarousel');
            const cardWidth = testimonialCards[0].offsetWidth + 30; // Width + gap
            const scrollPosition = currentSlide * slidesPerView * cardWidth;

            // Scroll to position
            container.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });

            // Update active dot
            updateActiveDot();
        }

        // Function to update active dot
        function updateActiveDot() {
            const dots = document.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                if (index === currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        // Function to go to next slide
        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        // Function to go to previous slide
        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        // Event listeners for navigation buttons
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);

        // Auto-advance carousel (optional)
        let autoSlideInterval = setInterval(nextSlide, 5000);

        // Pause auto-advance on hover
        const carousel = document.getElementById('testimonialCarousel');
        carousel.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });

        carousel.addEventListener('mouseleave', () => {
            autoSlideInterval = setInterval(nextSlide, 5000);
        });

        // Scroll animation for testimonial cards
        function checkTestimonialCardVisibility() {
            testimonialCards.forEach(card => {
                if (isElementInViewport(card)) {
                    card.classList.add('visible');
                }
            });
        }

        // Add staggered delay for each card
        testimonialCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.1}s`;
        });

        // Check visibility on load and scroll
        checkTestimonialCardVisibility();
        window.addEventListener('scroll', checkTestimonialCardVisibility);

        // Update slides per view on load and resize
        updateSlidesPerView();
        window.addEventListener('resize', function() {
            updateSlidesPerView();
            goToSlide(currentSlide); // Re-center on current slide
        });

        // Card hover effect
        testimonialCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
            });

            card.addEventListener('mouseleave', function() {
                const cardNum = this.getAttribute('data-card');
                this.style.transitionDelay = `${(cardNum-1) * 0.1}s`;
            });
        });

        // Detect scroll position for dot updates
        carousel.addEventListener('scroll', function() {
            const scrollPosition = carousel.scrollLeft;
            const cardWidth = testimonialCards[0].offsetWidth + 30;
            const newSlide = Math.round(scrollPosition / (cardWidth * slidesPerView));

            if (newSlide !== currentSlide) {
                currentSlide = newSlide;
                updateActiveDot();
            }
        });






        // Scroll animation for CTA section

        const ctaContent = document.querySelector('.cta-content');
        const ctaButtons = document.querySelectorAll('.cta-btn');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkCtaVisibility() {
            if (isElementInViewport(ctaContent)) {
                ctaContent.classList.add('visible');

                // Animate buttons with staggered delay
                ctaButtons.forEach((btn, index) => {
                    setTimeout(() => {
                        btn.classList.add('visible');
                    }, 300 + (index * 200));
                });
            }
        }

        // Add staggered delay for buttons
        ctaButtons.forEach((btn, index) => {
            btn.style.transitionDelay = `${index * 0.2}s`;
        });

        // Check visibility on load and scroll
        checkCtaVisibility();
        window.addEventListener('scroll', checkCtaVisibility);

        // Button interactions
        const bookNowBtn = document.getElementById('bookNowBtn');
        const joinPhotographerBtn = document.getElementById('joinPhotographerBtn');

        if (bookNowBtn) {
            bookNowBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Visual feedback
                this.style.transform = 'translateY(-3px) scale(1.03)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);

                // In a real implementation, this would navigate to booking page
                console.log('Navigating to booking page...');
                // window.location.href = '/booking';
            });
        }

        if (joinPhotographerBtn) {
            joinPhotographerBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Visual feedback
                this.style.transform = 'translateY(-3px) scale(1.03)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);

                // In a real implementation, this would navigate to photographer registration
                console.log('Navigating to photographer registration...');
                // window.location.href = '/photographer/signup';
            });
        }

        // Add hover effect for content card
        ctaContent.addEventListener('mouseenter', function() {
            this.style.transitionDelay = '0s';
        });

        ctaContent.addEventListener('mouseleave', function() {
            this.style.transitionDelay = '0.4s';
        });

        // Add parallax effect for background on scroll
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallaxElement = document.querySelector('.cta-section');

            // Only apply parallax on larger screens
            if (window.innerWidth > 768) {
                parallaxElement.style.backgroundPosition = `center ${scrolled * 0.05}px`;
            }
        });

        // Button click animations
        ctaButtons.forEach(btn => {
            btn.addEventListener('mousedown', function() {
                this.style.transform = 'scale(0.98)';
            });

            btn.addEventListener('mouseup', function() {
                this.style.transform = '';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });


        // Scroll animation for about section

        const aboutCard = document.querySelector('.about-card');
        const visionItems = document.querySelectorAll('.vision-item');
        const stats = document.querySelectorAll('.stat-value');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkAboutVisibility() {
            if (isElementInViewport(aboutCard)) {
                aboutCard.classList.add('visible');

                // Animate vision items with staggered delay
                visionItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.classList.add('visible');
                    }, 300 + (index * 200));
                });

                // Animate stats with counting animation
                if (!aboutCard.classList.contains('animated')) {
                    aboutCard.classList.add('animated');
                    animateStats();
                }
            }
        }

        // Add staggered delay for vision items
        visionItems.forEach((item, index) => {
            item.style.transitionDelay = `${index * 0.2}s`;
        });

        // Check visibility on load and scroll
        checkAboutVisibility();
        window.addEventListener('scroll', checkAboutVisibility);

        // Counting animation for stats
        function animateStats() {
            const targetValues = {
                stat1: 500,
                stat2: 10000,
                stat3: 98,
                stat4: 50
            };

            const suffixes = {
                stat1: '+',
                stat2: '+',
                stat3: '%',
                stat4: '+'
            };

            const duration = 2000; // 2 seconds
            const frameDuration = 1000 / 60; // 60fps
            const totalFrames = Math.round(duration / frameDuration);

            stats.forEach(statElement => {
                const statId = statElement.id;
                const target = targetValues[statId];
                const suffix = suffixes[statId];
                let frame = 0;

                const counter = setInterval(() => {
                    frame++;
                    const progress = frame / totalFrames;
                    const current = Math.round(target * progress);

                    statElement.textContent = current + suffix;

                    if (frame === totalFrames) {
                        clearInterval(counter);
                    }
                }, frameDuration);
            });
        }

        // Vision item hover effect
        visionItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
            });

            item.addEventListener('mouseleave', function() {
                const itemNum = this.getAttribute('data-item');
                this.style.transitionDelay = `${(itemNum-1) * 0.2}s`;
            });

            // Click interaction for vision items
            item.addEventListener('click', function() {
                const title = this.querySelector('h4').textContent;
                const description = this.querySelector('p').textContent;
                console.log(`${title}: ${description}`);

                // Visual feedback
                const icon = this.querySelector('.vision-icon');
                icon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    icon.style.transform = '';
                }, 300);
            });
        });

        // Visual image hover enhancement
        const visualContainer = document.querySelector('.visual-container');
        const visualImage = document.querySelector('.visual-image');

        if (visualContainer && visualImage) {
            visualContainer.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.3s ease';
            });

            visualContainer.addEventListener('mouseleave', function() {
                setTimeout(() => {
                    this.style.transition = '';
                }, 800);
            });
        }

        // Parallax effect for decorative elements on scroll
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const aboutSection = document.getElementById('about');
            const aboutRect = aboutSection.getBoundingClientRect();

            // Only animate if section is in view
            if (aboutRect.top < window.innerHeight && aboutRect.bottom > 0) {
                const decoration1 = document.querySelector('.decoration-1');
                const decoration2 = document.querySelector('.decoration-2');

                if (decoration1) {
                    decoration1.style.transform = `translateY(${scrolled * 0.05}px) rotate(${scrolled * 0.02}deg)`;
                }

                if (decoration2) {
                    decoration2.style.transform = `translateY(${scrolled * 0.03}px) rotate(${scrolled * -0.01}deg)`;
                }
            }
        });


        // Scroll animation for contact section

        const contactCard = document.querySelector('.contact-card');
        const contactMethods = document.querySelectorAll('.contact-method');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkContactVisibility() {
            if (isElementInViewport(contactCard)) {
                contactCard.classList.add('visible');

                // Animate contact methods with staggered delay
                contactMethods.forEach((method, index) => {
                    setTimeout(() => {
                        method.classList.add('visible');
                    }, 300 + (index * 200));
                });
            }
        }

        // Add staggered delay for contact methods
        contactMethods.forEach((method, index) => {
            method.style.transitionDelay = `${index * 0.2}s`;
        });

        // Check visibility on load and scroll
        checkContactVisibility();
        window.addEventListener('scroll', checkContactVisibility);

        // Form validation and submission
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const responseMessage = document.getElementById('responseMessage');

        // Form fields
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const messageInput = document.getElementById('message');

        // Error fields
        const nameError = document.getElementById('nameError');
        const emailError = document.getElementById('emailError');
        const messageError = document.getElementById('messageError');

        // Validation functions
        function validateName() {
            const name = nameInput.value.trim();
            if (name === '') {
                showError(nameInput, nameError, 'Name is required');
                return false;
            }
            if (name.length < 2) {
                showError(nameInput, nameError, 'Name must be at least 2 characters');
                return false;
            }
            showSuccess(nameInput);
            hideError(nameError);
            return true;
        }

        function validateEmail() {
            const email = emailInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === '') {
                showError(emailInput, emailError, 'Email is required');
                return false;
            }
            if (!emailRegex.test(email)) {
                showError(emailInput, emailError, 'Please enter a valid email address');
                return false;
            }
            showSuccess(emailInput);
            hideError(emailError);
            return true;
        }

        function validateMessage() {
            const message = messageInput.value.trim();
            if (message === '') {
                showError(messageInput, messageError, 'Message is required');
                return false;
            }
            if (message.length < 10) {
                showError(messageInput, messageError, 'Message must be at least 10 characters');
                return false;
            }
            showSuccess(messageInput);
            hideError(messageError);
            return true;
        }

        // Helper functions for validation UI
        function showError(input, errorElement, message) {
            input.classList.add('error');
            input.classList.remove('success');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        function showSuccess(input) {
            input.classList.remove('error');
            input.classList.add('success');
        }

        function hideError(errorElement) {
            errorElement.style.display = 'none';
        }

        function showResponse(message, isSuccess = true) {
            responseMessage.textContent = message;
            responseMessage.className = `response-message ${isSuccess ? 'success' : 'error'}`;
            responseMessage.style.display = 'block';

            // Scroll to response message
            responseMessage.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        // Real-time validation
        nameInput.addEventListener('blur', validateName);
        emailInput.addEventListener('blur', validateEmail);
        messageInput.addEventListener('blur', validateMessage);

        // Clear validation on focus
        [nameInput, emailInput, messageInput].forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error', 'success');
                const errorId = this.id + 'Error';
                const errorElement = document.getElementById(errorId);
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            });
        });

        // Form submission
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate all fields
            const isNameValid = validateName();
            const isEmailValid = validateEmail();
            const isMessageValid = validateMessage();

            if (isNameValid && isEmailValid && isMessageValid) {
                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Sending...</span><i class="bi bi-hourglass-split btn-icon"></i>';

                // Simulate form submission (in production, this would be an AJAX request)
                setTimeout(() => {
                    // Show success message
                    showResponse('Thank you for your message! We will get back to you within 24 hours.', true);

                    // Reset form
                    contactForm.reset();

                    // Remove success classes
                    [nameInput, emailInput, messageInput].forEach(input => {
                        input.classList.remove('success');
                    });

                    // Re-enable button
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<span>Send Message</span><i class="bi bi-send btn-icon"></i>';
                    }, 2000);

                    // Hide response message after 5 seconds
                    setTimeout(() => {
                        responseMessage.style.display = 'none';
                    }, 5000);

                }, 1500); // Simulate network delay
            } else {
                showResponse('Please fix the errors in the form before submitting.', false);
            }
        });

        // Contact method hover effect
        contactMethods.forEach(method => {
            method.addEventListener('mouseenter', function() {
                this.style.transitionDelay = '0s';
            });

            method.addEventListener('mouseleave', function() {
                const methodNum = this.getAttribute('data-method');
                this.style.transitionDelay = `${(methodNum-1) * 0.2}s`;
            });

            // Click interaction for contact methods
            method.addEventListener('click', function() {
                const title = this.querySelector('h4').textContent;
                const link = this.querySelector('.method-link');

                if (link && (link.href.includes('mailto:') || link.href.includes('tel:'))) {
                    console.log(`Opening: ${link.href}`);
                    // In a real scenario, this would navigate to mail or phone
                }

                // Visual feedback
                const icon = this.querySelector('.method-icon');
                icon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    icon.style.transform = '';
                }, 300);
            });
        });


        // Scroll animation for footer columns

        const footerColumns = document.querySelectorAll('.footer-column');
        const backToTopBtn = document.getElementById('backToTop');

        // Function to check if element is in viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.9 &&
                rect.bottom >= 0
            );
        }

        // Function to add visible class when in viewport
        function checkColumnVisibility() {
            footerColumns.forEach(column => {
                if (isElementInViewport(column)) {
                    column.classList.add('visible');
                }
            });

            // Show/hide back to top button
            if (window.scrollY > 500) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        }

        // Add staggered delay for each column
        footerColumns.forEach((column, index) => {
            column.style.transitionDelay = `${index * 0.1}s`;
        });

        // Check visibility on load and scroll
        checkColumnVisibility();
        window.addEventListener('scroll', checkColumnVisibility);

        // Back to top functionality
        backToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Newsletter subscription
        const newsletterBtn = document.querySelector('.newsletter-btn');
        const newsletterInput = document.querySelector('.newsletter-input');

        if (newsletterBtn && newsletterInput) {
            newsletterBtn.addEventListener('click', function() {
                const email = newsletterInput.value.trim();

                if (!email) {
                    newsletterInput.focus();
                    newsletterInput.style.borderColor = '#f87171';
                    return;
                }

                // Simple email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    newsletterInput.style.borderColor = '#f87171';
                    return;
                }

                // Visual feedback
                newsletterBtn.innerHTML = '<span>Subscribing...</span><i class="bi bi-hourglass-split"></i>';
                newsletterBtn.disabled = true;

                // Simulate subscription (in production, this would be an AJAX request)
                setTimeout(() => {
                    newsletterBtn.innerHTML = '<span>Subscribed!</span><i class="bi bi-check-circle"></i>';
                    newsletterBtn.style.backgroundColor = '#4ade80';
                    newsletterInput.value = '';

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        newsletterBtn.innerHTML = '<span>Subscribe</span><i class="bi bi-envelope-arrow-up"></i>';
                        newsletterBtn.style.backgroundColor = '';
                        newsletterBtn.disabled = false;
                    }, 2000);
                }, 1500);
            });

            // Reset border color on input
            newsletterInput.addEventListener('focus', function() {
                this.style.borderColor = '';
            });
        }

        // Footer link hover effects
        const footerLinks = document.querySelectorAll('.footer-link');
        footerLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transitionDelay = '0s';
                }
            });

            link.addEventListener('mouseleave', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transitionDelay = '0.1s';
                }
            });

            // Click tracking for analytics (in production)
            link.addEventListener('click', function(e) {
                const linkText = this.querySelector('span').textContent;
                console.log(`Footer link clicked: ${linkText}`);
            });
        });

        // Social link interactions
        const socialLinks = document.querySelectorAll('.social-link');
        socialLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const platform = this.getAttribute('aria-label');
                console.log(`Social link clicked: ${platform}`);
                // In production, this would track social media clicks
            });
        });

        // Legal link interactions
        const legalLinks = document.querySelectorAll('.legal-link');
        legalLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const page = this.textContent;
                console.log(`Legal page clicked: ${page}`);
            });
        });

        // Logo click
        const footerLogo = document.querySelector('.footer-logo');
        if (footerLogo) {
            footerLogo.addEventListener('click', function(e) {
                console.log('Footer logo clicked - navigating to homepage');
            });
        }





        // Pricing tabs
        const pricingTabs = document.querySelectorAll('[data-pricing]');

        pricingTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const pricingType = tab.getAttribute('data-pricing');

                // Update active tab
                pricingTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // In a real application, this would update the pricing cards
                // For this demo, we'll just show an alert
                alert(`Loading ${pricingType} pricing...`);
            });
        });

        // Search functionality
        const searchBtn = document.querySelector('.search-btn');
        const searchInput = document.querySelector('.search-input');

        if (searchBtn && searchInput) {
            searchBtn.addEventListener('click', () => {
                const query = searchInput.value.trim();
                if (query) alert(`Searching for: "${query}"`);
                else alert('Please enter a search term');
            });

            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') searchBtn.click();
            });
        }


    });

    document.addEventListener("DOMContentLoaded", () => {
        const navbar = document.querySelector(".navbar");
        if (!navbar) return;

        function updateNavbar() {
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        }

        updateNavbar();
        window.addEventListener("scroll", updateNavbar);
    });

    document.addEventListener("DOMContentLoaded", () => {
        const slides = Array.from(document.querySelectorAll(".hero-slide"));
        const prevBtn = document.getElementById("prevSlide");
        const nextBtn = document.getElementById("nextSlide");
        const indicators = Array.from(document.querySelectorAll(".slide-indicator"));

        if (!slides.length || !prevBtn || !nextBtn) {
            console.warn("Hero slider elements not found.");
            return;
        }

        let current = slides.findIndex(s => s.classList.contains("active"));
        if (current === -1) current = 0;

        const show = (index) => {
            slides.forEach(s => s.classList.remove("active"));
            indicators.forEach(d => d.classList.remove("active"));

            current = (index + slides.length) % slides.length;

            slides[current].classList.add("active");
            if (indicators[current]) indicators[current].classList.add("active");
        };

        nextBtn.addEventListener("click", (e) => {
            e.preventDefault();
            show(current + 1);
        });

        prevBtn.addEventListener("click", (e) => {
            e.preventDefault();
            show(current - 1);
        });

        indicators.forEach((dot, i) => {
            dot.addEventListener("click", () => show(i));
        });

        // Optional auto slide:
        // setInterval(() => show(current + 1), 6000);
    });
</script>
@endsection