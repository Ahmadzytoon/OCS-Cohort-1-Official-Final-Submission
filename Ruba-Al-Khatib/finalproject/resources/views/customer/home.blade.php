<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Laydia</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --icon-brown: #C4A484;
            --accent-brown: #a67c52;
            --accent-brown-light: #c5a07d;
            --text-white: #ffffff;
            --text-dark: #232222;
            --text-light: rgba(255, 255, 255, 0.8);
            --bg-dark: #faf7f8;
            --bg-overlay: rgba(0, 0, 0, 0.4);
            --lydia-dark: #faf7f8;
            --lydia-dark-light: #faf7f8;
            --lydia-gray: #64748b;
            --lydia-light: #e2e8f0;
            --lydia-accent: #a67c52;
            --lydia-accent-light: #c4a484;
            --lydia-white: #f8fafc;
            --lydia-shadow: rgba(0, 0, 0, 0.2);
            --lydia-star: #fbbf24;
            --lydia-error: #f87171;
            --lydia-success: #4ade80;

            --primary-brown: #a67c52;
            --primary-brown-light: #c5a07d;
            --primary-brown-lighter: #C4A484;
            --light-bg: #faf7f8;
            --card-bg: #FFFFFF;
            --border-color: #e2e8f0;
            --font-heading: 'Playfair Display', Georgia, serif;
            --font-body: 'Inter', 'Segoe UI', system-ui, sans-serif;
            --section-padding: 80px 20px;
            --container-max: 1200px;
            --card-radius: 12px;
            --shadow-light: 0 4px 12px rgba(166, 124, 82, 0.08);
            --shadow-medium: 0 8px 24px rgba(166, 124, 82, 0.12);
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: var(--font-body);
            color: var(--text-dark);
            background-color: var(--lydia-dark);
            line-height: 1.6;
        }
        .container { max-width: var(--container-max); margin: 0 auto; padding: 0 20px; }

        h1, h2, h3, h4 { font-family: var(--font-heading); font-weight: 600; line-height: 1.3; color: var(--text-dark); }
        h1 { font-size: 3rem; margin-bottom: 1rem; }
        h2 { font-size: 2.5rem; margin-bottom: 1.5rem; text-align: center; }
        h3 { font-size: 1.5rem; margin-bottom: 1rem; }
        p { margin-bottom: 1.5rem; color: var(--lydia-gray); }

        .section-title { position: relative; margin-bottom: 3rem; }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--lydia-accent);
            border-radius: 2px;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-primary { background-color: var(--lydia-accent); color: var(--text-white); }
        .btn-primary:hover { background-color: var(--accent-brown); transform: translateY(-2px); box-shadow: var(--shadow-medium); }
        .btn-outline { background-color: transparent; color: var(--lydia-accent); border: 2px solid var(--lydia-accent); }
        .btn-outline:hover { background-color: var(--lydia-accent); color: var(--text-white); transform: translateY(-2px); }

        .navbar {
            background-color: var(--card-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-container {
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }
        .logo {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--lydia-accent);
            text-decoration: none;
        }
        .logo span { color: var(--icon-brown); }

        .nav-menu { display:flex; list-style:none; gap:2rem; }
        .nav-link { text-decoration:none; color: var(--text-dark); font-weight: 500; transition: color 0.3s; }
        .nav-link:hover { color: var(--lydia-accent); }

        .customer-nav-actions { display:flex; align-items:center; gap:1.5rem; }
        .customer-info { display:flex; align-items:center; gap:0.75rem; }
        .customer-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background-color: var(--lydia-accent-light);
            display:flex; align-items:center; justify-content:center;
            color: var(--text-white); font-weight: 700;
        }
        .customer-name { font-weight: 600; color: var(--text-dark); }

        .logout-btn {
            padding: 8px 20px;
            background-color: transparent;
            color: var(--lydia-accent);
            border: 2px solid var(--lydia-accent);
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        .logout-btn:hover { background-color: var(--lydia-accent); color: var(--text-white); }

        .nav-toggle { display:none; background:none; border:none; font-size:1.5rem; color: var(--lydia-accent); cursor:pointer; }

        .customer-hero {
            background: linear-gradient(rgba(250, 247, 248, 0.95), rgba(250, 247, 248, 0.95)),
                        url('https://images.unsplash.com/photo-1545235617-9465d2a55698?auto=format&fit=crop&w=2080&q=80') no-repeat center center/cover;
            padding: 100px 20px;
            text-align: center;
            margin-bottom: 40px;
        }
        .customer-hero-content { max-width: 800px; margin: 0 auto; }
        .customer-hero h1 { color: var(--text-dark); margin-bottom: 1.5rem; }
        .customer-hero p { font-size: 1.2rem; max-width: 700px; margin: 0 auto 2rem; color: var(--lydia-gray); }

        .hero-stats { display:flex; justify-content:center; gap:3rem; margin-top:3rem; flex-wrap: wrap; }
        .stat-item { text-align:center; }
        .stat-number { font-size: 2.5rem; font-weight: 700; color: var(--lydia-accent); display:block; }
        .stat-label { color: var(--lydia-gray); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }

        .quick-actions { padding: var(--section-padding); background-color: var(--card-bg); }
        .actions-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:25px; margin-top:40px; }
        .action-card {
            background-color: var(--light-bg);
            border-radius: var(--card-radius);
            padding: 30px;
            text-align:center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--border-color);
            text-decoration: none;
            color: inherit;
            display:block;
        }
        .action-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-medium); border-color: var(--lydia-accent-light); }
        .action-icon {
            background-color: var(--card-bg);
            width:70px; height:70px; border-radius: 50%;
            display:flex; align-items:center; justify-content:center;
            margin: 0 auto 20px;
            border: 2px solid var(--lydia-accent-light);
        }
        .action-icon i { font-size: 28px; color: var(--lydia-accent); }

        .featured-photographers { padding: var(--section-padding); background-color: var(--light-bg); }
        .photographers-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; margin-top: 40px; }
        .photographer-card {
            background-color: var(--card-bg);
            border-radius: var(--card-radius);
            overflow:hidden;
            box-shadow: var(--shadow-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .photographer-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-medium); }
        .photographer-image { height: 200px; overflow:hidden; }
        .photographer-image img { width:100%; height:100%; object-fit:cover; transition: transform 0.5s ease; }
        .photographer-card:hover .photographer-image img { transform: scale(1.05); }
        .photographer-info { padding: 25px; }
        .photographer-name { font-size: 1.3rem; margin-bottom: 0.5rem; }
        .photographer-specialty { color: var(--lydia-accent); font-weight: 600; margin-bottom: 0.75rem; display:block; }
        .photographer-rating { display:flex; align-items:center; gap:5px; margin-bottom: 1rem; }
        .star { color: var(--lydia-star); }
        .rating-value { font-weight: 600; margin-left: 5px; }
        .photographer-price { font-size:1.2rem; font-weight: 700; color: var(--lydia-accent); margin-bottom: 1rem; }
        .photographer-actions { display:flex; justify-content: space-between; align-items:center; gap:10px; flex-wrap: wrap; }

        .featured-studios { padding: var(--section-padding); background-color: var(--card-bg); }
        .studios-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; margin-top: 40px; }
        .studio-card {
            background-color: var(--light-bg);
            border-radius: var(--card-radius);
            overflow:hidden;
            box-shadow: var(--shadow-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .studio-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-medium); }
        .studio-image { height: 200px; overflow:hidden; }
        .studio-image img { width:100%; height:100%; object-fit:cover; transition: transform 0.5s ease; }
        .studio-card:hover .studio-image img { transform: scale(1.05); }
        .studio-info { padding: 25px; }
        .studio-name { font-size: 1.3rem; margin-bottom: 0.75rem; }
        .studio-location { color: var(--lydia-gray); margin-bottom:1rem; display:flex; align-items:center; gap:8px; }
        .studio-amenities { display:flex; flex-wrap: wrap; gap:10px; margin-bottom: 1.5rem; }
        .amenity-tag {
            background-color: var(--card-bg);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            color: var(--lydia-accent);
            border: 1px solid var(--lydia-accent-light);
        }

        .upcoming-bookings { padding: var(--section-padding); background-color: var(--light-bg); }
        .bookings-list { max-width: 800px; margin: 40px auto 0; }
        .booking-item {
            background-color: var(--card-bg);
            border-radius: var(--card-radius);
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-light);
            display:flex;
            justify-content: space-between;
            align-items:center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .booking-info h4 { margin-bottom: 0.5rem; }
        .booking-meta { display:flex; gap:20px; color: var(--lydia-gray); font-size:0.9rem; flex-wrap: wrap; }
        .booking-status { padding: 5px 15px; border-radius: 50px; font-weight: 600; font-size: 0.85rem; }
        .status-confirmed { background-color: rgba(74, 222, 128, 0.1); color: var(--lydia-success); }
        .status-pending { background-color: rgba(251, 191, 36, 0.1); color: var(--lydia-star); }

        .footer { background-color: var(--text-dark); color: var(--text-white); padding: 60px 20px 30px; }
        .footer-content {
            max-width: var(--container-max);
            margin: 0 auto;
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-column h3 { color: var(--text-white); font-size: 1.3rem; margin-bottom: 25px; position: relative; }
        .footer-column h3::after {
            content:'';
            position:absolute;
            bottom:-8px; left:0;
            width:40px; height:2px;
            background-color: var(--lydia-accent);
        }
        .footer-links { list-style:none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: #DDD; text-decoration:none; transition: color 0.3s; }
        .footer-links a:hover { color: var(--lydia-accent-light); }
        .copyright {
            text-align:center;
            padding-top:30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color:#BBB;
            font-size:0.9rem;
        }

        @media (max-width: 992px) {
            h1 { font-size: 2.5rem; }
            h2 { font-size: 2rem; }
            .hero-stats { gap: 2rem; }
        }
        @media (max-width: 768px) {
            .nav-menu {
                display:none;
                position:absolute;
                top:70px; left:0;
                width:100%;
                background-color: var(--card-bg);
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            }
            .nav-menu.active { display:flex; }

            .customer-nav-actions {
                display:none;
                position:absolute;
                top:70px; left:0;
                width:100%;
                background-color: var(--card-bg);
                padding: 20px;
                box-shadow: 0 10px 15px rgba(0,0,0,0.1);
                flex-direction: column;
                align-items: flex-start;
            }
            .customer-nav-actions.active { display:flex; }

            .nav-toggle { display:block; }

            .booking-item { flex-direction: column; align-items: flex-start; }
            .customer-info { margin-bottom: 15px; }
        }
        @media (max-width: 576px) {
            h1 { font-size: 2rem; }
            h2 { font-size: 1.8rem; }
            .customer-hero { padding: 80px 20px; }
            .hero-stats { flex-direction: column; gap: 1.5rem; }
            .stat-number { font-size: 2rem; }
        }
    </style>
</head>
<body>

@php
    $user = auth()->user();
    $fullName = $user->full_name ?? $user->name ?? 'Customer';
    $firstName = trim(explode(' ', $fullName)[0] ?? $fullName);
    $initials = strtoupper(substr($firstName, 0, 1));
@endphp

    <!-- Customer Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('customer.home') }}" class="logo">Capture<span>Hub</span></a>

            <button class="nav-toggle" id="navToggle" type="button">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('customer.home') }}" class="nav-link active">Home</a></li>

                {{-- مؤقتاً لحد ما تعمل صفحات browse --}}
                <li><a href="{{ route('photographers') }}" class="nav-link">Photographers</a></li>
                <li><a href="{{ route('studio') }}" class="nav-link">Studios</a></li>

                <li><a href="#" class="nav-link">My Bookings</a></li>
                <li><a href="#" class="nav-link">Profile</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link">Help Center</a></li>
            </ul>

            <div class="customer-nav-actions" id="customerActions">
                <div class="customer-info">
                    <div class="customer-avatar">{{ $initials }}</div>
                    <span class="customer-name">{{ $fullName }}</span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Customer Hero Section -->
    <section class="customer-hero">
        <div class="container">
            <div class="customer-hero-content">
                <h1>Welcome back, {{ $firstName }}!</h1>
                <p>Ready to capture your next special moment? Discover amazing photographers and studios, manage your bookings, and create unforgettable memories.</p>
                <a href="{{ route('photographers') }}" class="btn btn-primary">Book a Photographer</a>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">3</span>
                        <span class="stat-label">Upcoming Bookings</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">12</span>
                        <span class="stat-label">Total Bookings</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">4.8</span>
                        <span class="stat-label">Avg. Rating</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <div class="container">
            <h2 class="section-title">Quick Actions</h2>
            <div class="actions-grid">

                <a href="{{ route('photographers') }}" class="action-card">
                    <div class="action-icon"><i class="fas fa-search"></i></div>
                    <h3>Find a Photographer</h3>
                    <p>Browse portfolios and book professional photographers for your events</p>
                </a>

                <a href="{{ route('studio') }}" class="action-card">
                    <div class="action-icon"><i class="fas fa-building"></i></div>
                    <h3>Book a Studio</h3>
                    <p>Find and reserve the perfect studio space for your photography session</p>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3>My Bookings</h3>
                    <p>View, manage, and reschedule your upcoming photography sessions</p>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon"><i class="fas fa-user-circle"></i></div>
                    <h3>My Profile</h3>
                    <p>Update your personal information, preferences, and notification settings</p>
                </a>

            </div>
        </div>
    </section>

    <!-- Featured Photographers (static for now) -->
    <section class="featured-photographers">
        <div class="container">
            <h2 class="section-title">Featured Photographers</h2>
            <p class="text-center" style="max-width:700px;margin:0 auto 20px;">
                Discover top-rated photographers recommended for you based on your booking history and preferences.
            </p>

            <div class="photographers-grid">
                {{-- keep your demo cards as-is --}}
                <div class="photographer-card">
                    <div class="photographer-image">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=774&q=80" alt="Michael Rodriguez">
                    </div>
                    <div class="photographer-info">
                        <h3 class="photographer-name">Michael Rodriguez</h3>
                        <span class="photographer-specialty">Wedding & Portrait Photography</span>
                        <div class="photographer-rating">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star-half-alt"></i></span>
                            <span class="rating-value">4.7</span>
                            <span class="review-count">(128 reviews)</span>
                        </div>
                        <div class="photographer-price">From $150/hour</div>
                        <div class="photographer-actions">
                            <a href="{{ route('photographers') }}" class="btn btn-outline" style="padding:8px 20px;">View Profile</a>
                            <a href="{{ route('photographers') }}" class="btn btn-primary" style="padding:8px 20px;">Book Now</a>
                        </div>
                    </div>
                </div>

                <div class="photographer-card">
                    <div class="photographer-image">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?auto=format&fit=crop&w=774&q=80" alt="Sarah Johnson">
                    </div>
                    <div class="photographer-info">
                        <h3 class="photographer-name">Sarah Johnson</h3>
                        <span class="photographer-specialty">Family & Lifestyle Photography</span>
                        <div class="photographer-rating">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="rating-value">5.0</span>
                            <span class="review-count">(94 reviews)</span>
                        </div>
                        <div class="photographer-price">From $120/hour</div>
                        <div class="photographer-actions">
                            <a href="{{ route('photographers') }}" class="btn btn-outline" style="padding:8px 20px;">View Profile</a>
                            <a href="{{ route('photographers') }}" class="btn btn-primary" style="padding:8px 20px;">Book Now</a>
                        </div>
                    </div>
                </div>

                <div class="photographer-card">
                    <div class="photographer-image">
                        <img src="https://images.unsplash.com/photo-1507591064344-4c6ce005-128?auto=format&fit=crop&w=1770&q=80" alt="David Chen">
                    </div>
                    <div class="photographer-info">
                        <h3 class="photographer-name">David Chen</h3>
                        <span class="photographer-specialty">Commercial & Product Photography</span>
                        <div class="photographer-rating">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="far fa-star"></i></span>
                            <span class="rating-value">4.2</span>
                            <span class="review-count">(67 reviews)</span>
                        </div>
                        <div class="photographer-price">From $180/hour</div>
                        <div class="photographer-actions">
                            <a href="{{ route('photographers') }}" class="btn btn-outline" style="padding:8px 20px;">View Profile</a>
                            <a href="{{ route('photographers') }}" class="btn btn-primary" style="padding:8px 20px;">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center" style="margin-top: 50px; text-align:center;">
                <a href="{{ route('photographers') }}" class="btn btn-outline">View All Photographers</a>
            </div>
        </div>
    </section>

    <!-- Featured Studios (static for now) -->
    <section class="featured-studios">
        <div class="container">
            <h2 class="section-title">Featured Studios</h2>
            <p class="text-center" style="max-width:700px;margin:0 auto 20px;">
                Beautifully equipped photography studios available for booking in your area.
            </p>

            <div class="studios-grid">
                <div class="studio-card">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1560448204-603b3fc33ddc?auto=format&fit=crop&w=1770&q=80" alt="Urban Light Studio">
                    </div>
                    <div class="studio-info">
                        <h3 class="studio-name">Urban Light Studio</h3>
                        <div class="studio-location"><i class="fas fa-map-marker-alt"></i><span>Downtown • 2 miles away</span></div>
                        <div class="studio-amenities">
                            <span class="amenity-tag">Natural Light</span>
                            <span class="amenity-tag">Changing Room</span>
                            <span class="amenity-tag">Props Available</span>
                        </div>
                        <div style="font-size:1.2rem;font-weight:700;color:var(--lydia-accent);margin-bottom:1.5rem;">$75/hour</div>
                        <div class="studio-actions">
                            <a href="{{ route('studio') }}" class="btn btn-outline" style="padding:8px 20px;">View Details</a>
                            <a href="{{ route('studio') }}" class="btn btn-primary" style="padding:8px 20px;">Book Studio</a>
                        </div>
                    </div>
                </div>

                <div class="studio-card">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=1858&q=80" alt="Creative Space Studio">
                    </div>
                    <div class="studio-info">
                        <h3 class="studio-name">Creative Space Studio</h3>
                        <div class="studio-location"><i class="fas fa-map-marker-alt"></i><span>Arts District • 4 miles away</span></div>
                        <div class="studio-amenities">
                            <span class="amenity-tag">Cyc Wall</span>
                            <span class="amenity-tag">Professional Lighting</span>
                            <span class="amenity-tag">Makeup Station</span>
                        </div>
                        <div style="font-size:1.2rem;font-weight:700;color:var(--lydia-accent);margin-bottom:1.5rem;">$95/hour</div>
                        <div class="studio-actions">
                            <a href="{{ route('studio') }}" class="btn btn-outline" style="padding:8px 20px;">View Details</a>
                            <a href="{{ route('studio') }}" class="btn btn-primary" style="padding:8px 20px;">Book Studio</a>
                        </div>
                    </div>
                </div>

                <div class="studio-card">
                    <div class="studio-image">
                        <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=1770&q=80" alt="Minimalist Studio">
                    </div>
                    <div class="studio-info">
                        <h3 class="studio-name">Minimalist Studio</h3>
                        <div class="studio-location"><i class="fas fa-map-marker-alt"></i><span>Westside • 6 miles away</span></div>
                        <div class="studio-amenities">
                            <span class="amenity-tag">Minimalist Design</span>
                            <span class="amenity-tag">High Ceilings</span>
                            <span class="amenity-tag">Parking Available</span>
                        </div>
                        <div style="font-size:1.2rem;font-weight:700;color:var(--lydia-accent);margin-bottom:1.5rem;">$65/hour</div>
                        <div class="studio-actions">
                            <a href="{{ route('studio') }}" class="btn btn-outline" style="padding:8px 20px;">View Details</a>
                            <a href="{{ route('studio') }}" class="btn btn-primary" style="padding:8px 20px;">Book Studio</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center" style="margin-top: 50px; text-align:center;">
                <a href="{{ route('studio') }}" class="btn btn-outline">View All Studios</a>
            </div>
        </div>
    </section>

    <!-- Upcoming Bookings (static for now) -->
    <section class="upcoming-bookings">
        <div class="container">
            <h2 class="section-title">Upcoming Bookings</h2>
            <p class="text-center" style="max-width:700px;margin:0 auto 20px;">
                Your scheduled photography sessions and studio bookings.
            </p>

            <div class="bookings-list">
                <div class="booking-item">
                    <div class="booking-info">
                        <h4>Family Portrait Session</h4>
                        <p>With Sarah Johnson • Studio: Urban Light</p>
                        <div class="booking-meta">
                            <span><i class="far fa-calendar"></i> June 15, 2023</span>
                            <span><i class="far fa-clock"></i> 2:00 PM - 4:00 PM</span>
                            <span><i class="fas fa-dollar-sign"></i> $240</span>
                        </div>
                    </div>
                    <div class="booking-status status-confirmed">Confirmed</div>
                </div>

                <div class="booking-item">
                    <div class="booking-info">
                        <h4>Graduation Photos</h4>
                        <p>With Michael Rodriguez • Outdoor Location</p>
                        <div class="booking-meta">
                            <span><i class="far fa-calendar"></i> June 22, 2023</span>
                            <span><i class="far fa-clock"></i> 10:00 AM - 12:00 PM</span>
                            <span><i class="fas fa-dollar-sign"></i> $300</span>
                        </div>
                    </div>
                    <div class="booking-status status-confirmed">Confirmed</div>
                </div>

                <div class="booking-item">
                    <div class="booking-info">
                        <h4>Product Photography</h4>
                        <p>Studio: Creative Space • No photographer assigned yet</p>
                        <div class="booking-meta">
                            <span><i class="far fa-calendar"></i> June 30, 2023</span>
                            <span><i class="far fa-clock"></i> 9:00 AM - 1:00 PM</span>
                            <span><i class="fas fa-dollar-sign"></i> $380</span>
                        </div>
                    </div>
                    <div class="booking-status status-pending">Awaiting Photographer</div>
                </div>
            </div>

            <div class="text-center" style="margin-top: 40px; text-align:center;">
                <a href="#" class="btn btn-outline">View All Bookings</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>CaptureHub</h3>
                    <p>Your trusted photography marketplace for memorable moments. Connecting clients with exceptional photographers and studios.</p>
                </div>

                <div class="footer-column">
                    <h3>Customer Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('customer.home') }}">Dashboard</a></li>
                        <li><a href="{{ route('photographers') }}">Find Photographers</a></li>
                        <li><a href="{{ route('studio') }}">Find Studios</a></li>
                        <li><a href="#">My Bookings</a></li>
                        <li><a href="#">My Profile</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Help & Support</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('contact') }}">Help Center</a></li>
                        <li><a href="{{ route('contact') }}">Contact Support</a></li>
                        <li><a href="{{ route('contact') }}">FAQs</a></li>
                        <li><a href="{{ route('contact') }}">Cancellation Policy</a></li>
                        <li><a href="{{ route('contact') }}">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope"></i> support@capturehub.com</li>
                        <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Photography Ave, Studio City</li>
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; 2023 CaptureHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('navToggle')?.addEventListener('click', function() {
            document.getElementById('navMenu')?.classList.toggle('active');
            document.getElementById('customerActions')?.classList.toggle('active');

            const icon = this.querySelector('i');
            if (!icon) return;

            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('navMenu')?.classList.remove('active');
                document.getElementById('customerActions')?.classList.remove('active');
                const i = document.querySelector('#navToggle i');
                i?.classList.remove('fa-times');
                i?.classList.add('fa-bars');
            });
        });
    </script>
</body>
</html>
