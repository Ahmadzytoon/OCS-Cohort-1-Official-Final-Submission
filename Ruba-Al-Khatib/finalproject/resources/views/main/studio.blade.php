@extends('layouts.main.master')

@section('title', 'Studios')

@section('css')
<link rel="stylesheet" href="{{ asset('css/studios.css') }}">
@endsection

@section('content')
<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <div class="header-content">
            <h1 class="page-title">Find Your Perfect Photography Studio</h1>
            <p class="page-subtitle">
                Browse professional photography studios with state-of-the-art equipment and perfect lighting setups for your sessions.
            </p>

            <!-- Search and Filters -->
            <div class="search-container">
                <div class="search-bar">
                    <input type="text" class="search-input" placeholder="Search studio by name, location, or specialty...">
                    <button class="search-btn">
                        <i class="bi bi-search"></i>
                        <span>Search Studios</span>
                    </button>
                </div>

                <div class="filters-row">
                    <div class="filter-group">
                        <div class="filter-label">City</div>
                        <select class="filter-select">
                            <option value="">All Cities</option>
                            <option value="nyc">New York</option>
                            <option value="la">Los Angeles</option>
                            <option value="chi">Chicago</option>
                            <option value="mia">Miami</option>
                            <option value="sf">San Francisco</option>
                            <option value="hou">Houston</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Studio Type</div>
                        <select class="filter-select">
                            <option value="">All Types</option>
                            <option value="professional">Professional Studio</option>
                            <option value="boutique">Boutique Studio</option>
                            <option value="natural-light">Natural Light Studio</option>
                            <option value="cyc">Cyclorama Studio</option>
                            <option value="commercial">Commercial Studio</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Price Range</div>
                        <select class="filter-select">
                            <option value="">All Prices</option>
                            <option value="0-100">$0 - $100/hr</option>
                            <option value="100-200">$100 - $200/hr</option>
                            <option value="200-300">$200 - $300/hr</option>
                            <option value="300+">$300+/hr</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Services</div>
                        <select class="filter-select">
                            <option value="">All Services</option>
                            <option value="portrait">Portrait Sessions</option>
                            <option value="product">Product Photography</option>
                            <option value="fashion">Fashion Shoots</option>
                            <option value="corporate">Corporate Headshots</option>
                            <option value="events">Event Space</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="main-content container">
    <div class="content-wrapper">
        <!-- Filters Sidebar -->
        <aside class="filters-sidebar">
            <div class="filter-card">
                <h3 class="filter-title"><i class="bi bi-geo-alt"></i> Location</h3>
                <div class="filter-options">
                    <div class="filter-option" data-filter="location" data-value="any">
                        <span class="option-label">
                            <div class="custom-checkbox checked"></div>
                            <span>All Locations</span>
                        </span>
                        <span class="option-count">(86)</span>
                    </div>
                    <div class="filter-option" data-filter="location" data-value="nyc">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>New York</span>
                        </span>
                        <span class="option-count">(24)</span>
                    </div>
                    <div class="filter-option" data-filter="location" data-value="la">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Los Angeles</span>
                        </span>
                        <span class="option-count">(18)</span>
                    </div>
                    <div class="filter-option" data-filter="location" data-value="chi">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Chicago</span>
                        </span>
                        <span class="option-count">(14)</span>
                    </div>
                    <div class="filter-option" data-filter="location" data-value="mia">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Miami</span>
                        </span>
                        <span class="option-count">(12)</span>
                    </div>
                </div>
            </div>

            <div class="filter-card">
                <h3 class="filter-title"><i class="bi bi-building"></i> Studio Type</h3>
                <div class="filter-options">
                    <div class="filter-option" data-filter="type" data-value="any">
                        <span class="option-label">
                            <div class="custom-checkbox checked"></div>
                            <span>All Types</span>
                        </span>
                    </div>
                    <div class="filter-option" data-filter="type" data-value="professional">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Professional Studio</span>
                        </span>
                        <span class="option-count">(42)</span>
                    </div>
                    <div class="filter-option" data-filter="type" data-value="boutique">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Boutique Studio</span>
                        </span>
                        <span class="option-count">(24)</span>
                    </div>
                    <div class="filter-option" data-filter="type" data-value="natural-light">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Natural Light Studio</span>
                        </span>
                        <span class="option-count">(18)</span>
                    </div>
                    <div class="filter-option" data-filter="type" data-value="cyc">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Cyclorama Studio</span>
                        </span>
                        <span class="option-count">(12)</span>
                    </div>
                </div>
            </div>

            <div class="filter-card">
                <h3 class="filter-title"><i class="bi bi-currency-dollar"></i> Price Range (per hour)</h3>
                <div class="price-range">
                    <div class="price-inputs">
                        <input type="number" class="price-input" placeholder="Min" id="minPrice" value="0">
                        <span>-</span>
                        <input type="number" class="price-input" placeholder="Max" id="maxPrice" value="500">
                    </div>
                    <button class="search-btn" style="padding: 12px 20px; font-size: 0.95rem;">
                        Apply Price Filter
                    </button>
                </div>
            </div>

            <div class="filter-card">
                <h3 class="filter-title"><i class="bi bi-star"></i> Rating</h3>
                <div class="filter-options">
                    <div class="filter-option" data-filter="rating" data-value="any">
                        <span class="option-label">
                            <div class="custom-checkbox checked"></div>
                            <span>Any Rating</span>
                        </span>
                    </div>
                    <div class="filter-option" data-filter="rating" data-value="5">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>★★★★★ 5 Stars</span>
                        </span>
                        <span class="option-count">(32)</span>
                    </div>
                    <div class="filter-option" data-filter="rating" data-value="4">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>★★★★☆ 4+ Stars</span>
                        </span>
                        <span class="option-count">(38)</span>
                    </div>
                    <div class="filter-option" data-filter="rating" data-value="3">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>★★★☆☆ 3+ Stars</span>
                        </span>
                        <span class="option-count">(16)</span>
                    </div>
                </div>
            </div>

            <div class="filter-card">
                <h3 class="filter-title"><i class="bi bi-tools"></i> Equipment Available</h3>
                <div class="filter-options">
                    <div class="filter-option" data-filter="equipment" data-value="any">
                        <span class="option-label">
                            <div class="custom-checkbox checked"></div>
                            <span>All Equipment</span>
                        </span>
                    </div>
                    <div class="filter-option" data-filter="equipment" data-value="profoto">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Profoto Lighting</span>
                        </span>
                        <span class="option-count">(42)</span>
                    </div>
                    <div class="option-label">
                        <div class="custom-checkbox"></div>
                        <span>Backdrops Included</span>
                        </span>
                        <span class="option-count">(58)</span>
                    </div>
                    <div class="filter-option" data-filter="equipment" data-value="cyc-wall">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Cyc Wall</span>
                        </span>
                        <span class="option-count">(24)</span>
                    </div>
                    <div class="filter-option" data-filter="equipment" data-value="dressing-room">
                        <span class="option-label">
                            <div class="custom-checkbox"></div>
                            <span>Dressing Room</span>
                        </span>
                        <span class="option-count">(36)</span>
                    </div>
                </div>
            </div>

            <button class="search-btn" style="width: 100%; padding: 16px 20px; margin-top: 10px;">
                <i class="bi bi-funnel"></i>
                <span>Apply All Filters</span>
            </button>
        </aside>

        <!-- Studios Grid -->
        <section class="studios-grid">
            <div class="grid-header">
                <div class="results-count">
                    Showing <span>8</span> of <span>86</span> studios
                </div>
                <div>
                    <select class="sort-select">
                        <option value="popular">Most Popular</option>
                        <option value="rating">Highest Rated</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="cards-grid" id="studiosGrid">
                <!-- Studio Card 1 -->
                <div class="studio-card" data-studio="1">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Luminous Studios">
                    </div>

                    <div class="card-header">
                        <div class="studio-avatar">
                            <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="Luminous Studios">
                        </div>
                        <div class="studio-info">
                            <h3 class="studio-name">Luminous Studios</h3>
                            <div class="studio-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>New York, NY</span>
                            </div>
                            <div class="studio-rating">
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <span class="rating-count">4.7 (89 reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="services-tags">
                            <span class="service-tag">Portrait Sessions</span>
                            <span class="service-tag">Fashion Shoots</span>
                            <span class="service-tag">Product Photography</span>
                        </div>

                        <div class="price-range-display">
                            <span class="price-label">Starting from</span>
                            <span class="price-value">$180/hr</span>
                        </div>

                        <div class="studio-features">
                            <div class="feature">
                                <i class="bi bi-lightning-charge"></i>
                                <span>Profoto Lighting</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-palette"></i>
                                <span>Cyclorama Wall</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-people"></i>
                                <span>Up to 10 people</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-clock"></i>
                                <span>24/7 Access</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="card-btn view-profile">View Studio</button>
                        <button class="card-btn book-now">Book Now</button>
                    </div>
                </div>

                <!-- Studio Card 2 -->
                <div class="studio-card" data-studio="2">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Natural Light Loft">
                    </div>

                    <div class="card-header">
                        <div class="studio-avatar">
                            <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="Natural Light Loft">
                        </div>
                        <div class="studio-info">
                            <h3 class="studio-name">Natural Light Loft</h3>
                            <div class="studio-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Los Angeles, CA</span>
                            </div>
                            <div class="studio-rating">
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <span class="rating-count">5.0 (124 reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="services-tags">
                            <span class="service-tag">Natural Light</span>
                            <span class="service-tag">Lifestyle Shoots</span>
                            <span class="service-tag">Editorial</span>
                        </div>

                        <div class="price-range-display">
                            <span class="price-label">Starting from</span>
                            <span class="price-value">$250/hr</span>
                        </div>

                        <div class="studio-features">
                            <div class="feature">
                                <i class="bi bi-sun"></i>
                                <span>North-facing Windows</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-house-door"></i>
                                <span>Living Room Setup</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-flower1"></i>
                                <span>Garden Access</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-thermometer-sun"></i>
                                <span>Climate Controlled</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="card-btn view-profile">View Studio</button>
                        <button class="card-btn book-now">Book Now</button>
                    </div>
                </div>

                <!-- Studio Card 3 -->
                <div class="studio-card" data-studio="3">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Urban Studios Chicago">
                    </div>

                    <div class="card-header">
                        <div class="studio-avatar">
                            <img src="https://images.unsplash.com/photo-1570125909517-53cb21c89ff2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="Urban Studios Chicago">
                        </div>
                        <div class="studio-info">
                            <h3 class="studio-name">Urban Studios Chicago</h3>
                            <div class="studio-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Chicago, IL</span>
                            </div>
                            <div class="studio-rating">
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                                <span class="rating-count">4.2 (76 reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="services-tags">
                            <span class="service-tag">Industrial Style</span>
                            <span class="service-tag">Corporate Headshots</span>
                            <span class="service-tag">Product Shoots</span>
                        </div>

                        <div class="price-range-display">
                            <span class="price-label">Starting from</span>
                            <span class="price-value">$150/hr</span>
                        </div>

                        <div class="studio-features">
                            <div class="feature">
                                <i class="bi bi-bricks"></i>
                                <span>Exposed Brick Walls</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-lightning"></i>
                                <span>High-speed Internet</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-car-front"></i>
                                <span>Free Parking</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-cup-straw"></i>
                                <span>Coffee Bar</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="card-btn view-profile">View Studio</button>
                        <button class="card-btn book-now">Book Now</button>
                    </div>
                </div>

                <!-- Studio Card 4 -->
                <div class="studio-card" data-studio="4">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1570125909517-53cb21c89ff2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Miami Beach Studios">
                    </div>

                    <div class="card-header">
                        <div class="studio-avatar">
                            <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="Miami Beach Studios">
                        </div>
                        <div class="studio-info">
                            <h3 class="studio-name">Miami Beach Studios</h3>
                            <div class="studio-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Miami, FL</span>
                            </div>
                            <div class="studio-rating">
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <span class="rating-count">4.6 (92 reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="services-tags">
                            <span class="service-tag">Beach Shoots</span>
                            <span class="service-tag">Fashion</span>
                            <span class="service-tag">Swimwear</span>
                        </div>

                        <div class="price-range-display">
                            <span class="price-label">Starting from</span>
                            <span class="price-value">$220/hr</span>
                        </div>

                        <div class="studio-features">
                            <div class="feature">
                                <i class="bi bi-water"></i>
                                <span>Ocean View</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-tropical-storm"></i>
                                <span>Infinity Pool</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-umbrella"></i>
                                <span>Outdoor Sets</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-person-workspace"></i>
                                <span>Makeup Station</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="card-btn view-profile">View Studio</button>
                        <button class="card-btn book-now">Book Now</button>
                    </div>
                </div>

                <!-- Studio Card 5 -->
                <div class="studio-card" data-studio="5">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="San Francisco Pro Studio">
                    </div>

                    <div class="card-header">
                        <div class="studio-avatar">
                            <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="San Francisco Pro Studio">
                        </div>
                        <div class="studio-info">
                            <h3 class="studio-name">San Francisco Pro Studio</h3>
                            <div class="studio-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>San Francisco, CA</span>
                            </div>
                            <div class="studio-rating">
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <span class="rating-count">5.0 (68 reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="services-tags">
                            <span class="service-tag">Tech Product Shoots</span>
                            <span class="service-tag">Corporate</span>
                            <span class="service-tag">Video Production</span>
                        </div>

                        <div class="price-range-display">
                            <span class="price-label">Starting from</span>
                            <span class="price-value">$300/hr</span>
                        </div>

                        <div class="studio-features">
                            <div class="feature">
                                <i class="bi bi-camera-video"></i>
                                <span>Video Ready</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-mic"></i>
                                <span>Sound Booth</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-pc-display"></i>
                                <span>Editing Station</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-wifi"></i>
                                <span>Gigabit Internet</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="card-btn view-profile">View Studio</button>
                        <button class="card-btn book-now">Book Now</button>
                    </div>
                </div>

                <!-- Studio Card 6 -->
                <div class="studio-card" data-studio="6">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Houston Boutique Studio">
                    </div>

                    <div class="card-header">
                        <div class="studio-avatar">
                            <img src="https://images.unsplash.com/photo-1570125909517-53cb21c89ff2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="Houston Boutique Studio">
                        </div>
                        <div class="studio-info">
                            <h3 class="studio-name">Houston Boutique Studio</h3>
                            <div class="studio-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Houston, TX</span>
                            </div>
                            <div class="studio-rating">
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <span class="rating-count">4.5 (45 reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="services-tags">
                            <span class="service-tag">Portrait</span>
                            <span class="service-tag">Family Photography</span>
                            <span class="service-tag">Maternity</span>
                        </div>

                        <div class="price-range-display">
                            <span class="price-label">Starting from</span>
                            <span class="price-value">$120/hr</span>
                        </div>

                        <div class="studio-features">
                            <div class="feature">
                                <i class="bi bi-house-heart"></i>
                                <span>Cozy Atmosphere</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-balloon-heart"></i>
                                <span>Prop Collection</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-people"></i>
                                <span>Family Friendly</span>
                            </div>
                            <div class="feature">
                                <i class="bi bi-palette"></i>
                                <span>Multiple Backdrops</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="card-btn view-profile">View Studio</button>
                        <button class="card-btn book-now">Book Now</button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="page-btn disabled">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">4</button>
                <button class="page-btn">5</button>
                <button class="page-btn">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </section>
    </div>
</main>

<!-- Why Choose Studios Section -->
<section class="choose-section">
    <div class="container">
        <h2 class="section-title">Why Book a Professional Studio?</h2>

        <div class="choose-grid">
            <div class="choose-card">
                <div class="choose-icon">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <h3 class="choose-title">Professional Equipment</h3>
                <p class="choose-description">
                    Access high-end lighting, backdrops, and equipment without the investment of purchasing your own.
                </p>
            </div>

            <div class="choose-card">
                <div class="choose-icon">
                    <i class="bi bi-sun"></i>
                </div>
                <h3 class="choose-title">Perfect Lighting</h3>
                <p class="choose-description">
                    Consistent, controllable lighting setups for professional results every time, regardless of weather.
                </p>
            </div>

            <div class="choose-card">
                <div class="choose-icon">
                    <i class="bi bi-palette"></i>
                </div>
                <h3 class="choose-title">Versatile Spaces</h3>
                <p class="choose-description">
                    Multiple set options, cyclorama walls, and professional backdrops for varied shooting needs.
                </p>
            </div>

            <div class="choose-card">
                <div class="choose-icon">
                    <i class="bi bi-clock"></i>
                </div>
                <h3 class="choose-title">Flexible Scheduling</h3>
                <p class="choose-description">
                    Book by the hour with flexible scheduling options, including evenings and weekends.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Need Help Choosing?</h2>
            <p class="cta-description">
                Our studio specialists can help you find the perfect space for your photography needs.
                Contact us for personalized recommendations.
            </p>
            <button class="cta-btn">
                <span>Get Studio Recommendations</span>
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </div>
</section>

@endsection
<!-- Footer -->
@section('footer')
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
    // Studios Listing Page Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Filter checkbox functionality
        const filterOptions = document.querySelectorAll('.filter-option');

        filterOptions.forEach(option => {
            option.addEventListener('click', function() {
                const checkbox = this.querySelector('.custom-checkbox');
                const filterType = this.getAttribute('data-filter');
                const filterValue = this.getAttribute('data-value');

                // If clicking "Any" option, uncheck others in same group
                if (filterValue === 'any') {
                    const sameGroupOptions = document.querySelectorAll(`[data-filter="${filterType}"]`);
                    sameGroupOptions.forEach(opt => {
                        opt.querySelector('.custom-checkbox').classList.remove('checked');
                    });
                    checkbox.classList.add('checked');
                } else {
                    // Uncheck "Any" option in same group
                    const anyOption = document.querySelector(`[data-filter="${filterType}"][data-value="any"]`);
                    if (anyOption) {
                        anyOption.querySelector('.custom-checkbox').classList.remove('checked');
                    }

                    // Toggle current option
                    checkbox.classList.toggle('checked');

                    // If no options checked, check "Any" option
                    const groupOptions = document.querySelectorAll(`[data-filter="${filterType}"]:not([data-value="any"])`);
                    const anyChecked = Array.from(groupOptions).some(opt =>
                        opt.querySelector('.custom-checkbox').classList.contains('checked')
                    );

                    if (!anyChecked && anyOption) {
                        anyOption.querySelector('.custom-checkbox').classList.add('checked');
                    }
                }

                // Update results count (simulated)
                updateResultsCount();
            });
        });

        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const searchBtn = document.querySelector('.search-btn');

        searchBtn.addEventListener('click', function() {
            performSearch();
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        function performSearch() {
            const searchTerm = searchInput.value.trim();
            if (searchTerm) {
                console.log(`Searching studios for: ${searchTerm}`);
                // In production, this would trigger an API call

                // Show loading state
                searchBtn.innerHTML = '<i class="bi bi-hourglass-split"></i><span>Searching...</span>';
                searchBtn.disabled = true;

                // Simulate search delay
                setTimeout(() => {
                    searchBtn.innerHTML = '<i class="bi bi-search"></i><span>Search Studios</span>';
                    searchBtn.disabled = false;

                    // Show search results (simulated)
                    showResponse(`Found studios matching: ${searchTerm}`, true);
                }, 1000);
            }
        }

        // Price range filter
        const minPriceInput = document.getElementById('minPrice');
        const maxPriceInput = document.getElementById('maxPrice');

        // Ensure min is less than max
        minPriceInput.addEventListener('change', function() {
            const min = parseInt(this.value) || 0;
            const max = parseInt(maxPriceInput.value) || 500;

            if (min > max) {
                this.value = max;
            }
        });

        maxPriceInput.addEventListener('change', function() {
            const max = parseInt(this.value) || 500;
            const min = parseInt(minPriceInput.value) || 0;

            if (max < min) {
                this.value = min;
            }
        });

        // Apply all filters button
        const applyFiltersBtn = document.querySelector('.search-btn[style*="width: 100%"]');
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', applyAllFilters);
        }

        function applyAllFilters() {
            console.log('Applying all studio filters...');

            // Get active filters
            const activeFilters = {
                location: [],
                type: [],
                rating: [],
                equipment: []
            };

            // Collect checked filter options
            document.querySelectorAll('.custom-checkbox.checked').forEach(checkbox => {
                const option = checkbox.closest('.filter-option');
                const filterType = option.getAttribute('data-filter');
                const filterValue = option.getAttribute('data-value');

                if (filterValue !== 'any') {
                    activeFilters[filterType].push(filterValue);
                }
            });

            // Get price range
            const minPrice = minPriceInput.value;
            const maxPrice = maxPriceInput.value;

            console.log('Active Studio Filters:', activeFilters);
            console.log(`Price Range: $${minPrice} - $${maxPrice}/hr`);

            // In production, this would trigger filtering of results
            applyFiltersBtn.innerHTML = '<i class="bi bi-funnel"></i><span>Applying Filters...</span>';

            setTimeout(() => {
                applyFiltersBtn.innerHTML = '<i class="bi bi-funnel"></i><span>Filters Applied</span>';

                // Reset button text after 2 seconds
                setTimeout(() => {
                    applyFiltersBtn.innerHTML = '<i class="bi bi-funnel"></i><span>Apply All Filters</span>';
                }, 2000);

                // Show success message
                showResponse('Studio filters applied successfully!', true);
            }, 1000);
        }

        // Sort functionality
        const sortSelect = document.querySelector('.sort-select');
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            console.log(`Sorting studios by: ${sortValue}`);

            // In production, this would trigger re-sorting of results
            // For now, just show a loading indicator
            const originalValue = this.value;
            this.disabled = true;

            setTimeout(() => {
                this.disabled = false;
                console.log(`Studios sorted by ${this.options[this.selectedIndex].text}`);
                showResponse(`Sorted studios by: ${this.options[this.selectedIndex].text}`, true);
            }, 500);
        });

        // Studio card interactions
        const studioCards = document.querySelectorAll('.studio-card');

        studioCards.forEach(card => {
            // View Studio button
            const viewProfileBtn = card.querySelector('.view-profile');
            if (viewProfileBtn) {
                viewProfileBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const studioId = card.getAttribute('data-studio');
                    const studioName = card.querySelector('.studio-name').textContent;
                    console.log(`Viewing studio profile for ${studioName} (ID: ${studioId})`);

                    // Show loading state
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-hourglass-split"></i> Loading...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                        showResponse(`Viewing studio: ${studioName}`, true);
                    }, 1000);
                });
            }

            // Book Now button
            const bookNowBtn = card.querySelector('.book-now');
            if (bookNowBtn) {
                bookNowBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const studioId = card.getAttribute('data-studio');
                    const studioName = card.querySelector('.studio-name').textContent;
                    console.log(`Starting booking for studio ${studioName} (ID: ${studioId})`);

                    // Show loading state
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                        showResponse(`Starting booking for ${studioName}`, true);
                    }, 1000);
                });
            }

            // Studio image click
            const studioImage = card.querySelector('.studio-image');
            if (studioImage) {
                studioImage.addEventListener('click', function() {
                    const studioId = card.getAttribute('data-studio');
                    const studioName = card.querySelector('.studio-name').textContent;
                    console.log(`Viewing studio gallery for ${studioName}`);
                    // In production, open lightbox or gallery
                    showResponse(`Viewing gallery for ${studioName}`, true);
                });
            }
        });

        // Pagination
        const pageButtons = document.querySelectorAll('.page-btn:not(.disabled)');
        pageButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (this.classList.contains('disabled')) return;

                // Remove active class from all buttons
                pageButtons.forEach(btn => btn.classList.remove('active'));

                // Add active class to clicked button (if it's a number button)
                if (!this.querySelector('i')) {
                    this.classList.add('active');
                }

                const pageText = this.textContent.trim();
                console.log(`Navigating to page ${pageText}`);

                // In production, this would load the page data
                // For now, simulate loading
                const grid = document.getElementById('studiosGrid');
                grid.style.opacity = '0.7';

                setTimeout(() => {
                    grid.style.opacity = '1';
                    showResponse(`Now viewing page ${pageText}`, true);
                }, 500);
            });
        });

        // CTA button
        const ctaBtn = document.querySelector('.cta-btn');
        if (ctaBtn) {
            ctaBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Getting studio recommendations...');

                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                this.disabled = true;

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    showResponse('Studio recommendations sent to your email!', true);
                }, 1500);
            });
        }

        // Update results count function
        function updateResultsCount() {
            const resultsCount = document.querySelector('.results-count span');
            if (resultsCount) {
                // Simulate filter count update
                const newCount = Math.floor(Math.random() * 20) + 70;
                resultsCount.textContent = newCount;

                // Update the "Showing X of Y" text
                const showingSpan = resultsCount.previousElementSibling;
                if (showingSpan && showingSpan.textContent.includes('Showing')) {
                    showingSpan.textContent = `Showing 8 of ${newCount}`;
                }
            }
        }

        // Response message function
        function showResponse(message, isSuccess = true) {
            // Create response message element if it doesn't exist
            let responseElement = document.querySelector('.response-message');
            if (!responseElement) {
                responseElement = document.createElement('div');
                responseElement.className = 'response-message';
                responseElement.style.cssText = `
                        position: fixed;
                        top: 100px;
                        right: 20px;
                        z-index: 1000;
                        padding: 15px 20px;
                        border-radius: 12px;
                        font-weight: 500;
                        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                        max-width: 300px;
                        animation: slideIn 0.3s ease;
                    `;
                document.body.appendChild(responseElement);
            }

            responseElement.textContent = message;
            responseElement.style.backgroundColor = isSuccess ? 'rgba(40, 167, 69, 0.1)' : 'rgba(220, 53, 69, 0.1)';
            responseElement.style.border = isSuccess ? '1px solid #28a745' : '1px solid #dc3545';
            responseElement.style.color = isSuccess ? '#28a745' : '#dc3545';

            // Auto-hide after 3 seconds
            setTimeout(() => {
                responseElement.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    responseElement.remove();
                }, 300);
            }, 3000);
        }

        // Add CSS animations for response messages
        const style = document.createElement('style');
        style.textContent = `
                @keyframes slideIn {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes slideOut {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
            `;
        document.head.appendChild(style);

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
    });
    document.addEventListener("DOMContentLoaded", () => {
        const el = document.querySelector(".cta-content");
        if (!el) return;

        const show = () => {
            const rect = el.getBoundingClientRect();
            const inView = rect.top < window.innerHeight * 0.85;
            if (inView) el.classList.add("visible");
        };

        show();
        window.addEventListener("scroll", show);
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
</script>
@endsection