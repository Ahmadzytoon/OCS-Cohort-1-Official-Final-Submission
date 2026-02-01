@extends('photographer.layout')

@section('title', 'Portfolio Details')

@section('styles')
    <style>
        /* ===== Design System Variables ===== */
        :root {
            --primary-accent: #a67c52;
            --secondary-accent: #c4a484;
            --background: #faf7f8;
            --text-dark: #232222;
            --text-gray: #64748b;
            --white: #ffffff;
            --success: #4ade80;
            --error: #f87171;
            --warning: #fbbf24;
            
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
            --light-gray: #f3f4f6;
            --hover-bg: #f9fafb;
            
            --font-heading: 'Playfair Display', Georgia, serif;
            --font-body: 'Inter', 'Segoe UI', system-ui, sans-serif;
            
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
            --spacing-xl: 3rem;
            
            --radius-sm: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-body);
            color: var(--text-dark);
            background-color: var(--background);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 600;
            line-height: 1.3;
            color: var(--text-dark);
        }
        
        h1 { font-size: 2.5rem; margin-bottom: var(--spacing-md); }
        h2 { font-size: 2rem; margin-bottom: var(--spacing-md); }
        h3 { font-size: 1.5rem; margin-bottom: var(--spacing-sm); }
        
        p { margin-bottom: var(--spacing-sm); color: var(--text-gray); }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--spacing-md);
        }
        
        /* ===== Buttons ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all var(--transition-normal);
            font-family: var(--font-body);
            text-decoration: none;
        }
        
        .btn-primary {
            background-color: var(--primary-accent);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }
        
        .btn-outline:hover {
            background-color: var(--light-gray);
            border-color: var(--primary-accent);
        }
        
        .btn-sm { padding: 0.5rem 1rem; font-size: 0.875rem; }
        
        /* ===== Page Header ===== */
        .page-header {
            padding: var(--spacing-xl) 0 var(--spacing-lg);
            background-color: var(--white);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: var(--spacing-xl);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: var(--spacing-md);
        }
        
        /* ===== Two Column Layout ===== */
        .two-column-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-xl);
            margin-bottom: var(--spacing-xl);
        }
        
        /* ===== Cards ===== */
        .card {
            background-color: var(--card-bg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: var(--spacing-lg);
            border: 1px solid var(--border-color);
            margin-bottom: var(--spacing-lg);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--spacing-md);
            padding-bottom: var(--spacing-sm);
            border-bottom: 1px solid var(--border-color);
        }
        
        /* ===== Profile Card ===== */
        .profile-header {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            padding-bottom: var(--spacing-lg);
            border-bottom: 1px solid var(--border-color);
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--secondary-accent);
        }
        
        .profile-info h1 {
            margin-bottom: var(--spacing-xs);
        }
        
        .profile-role {
            color: var(--primary-accent);
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }
        
        .rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-bottom: var(--spacing-sm);
        }
        
        .star { color: #fbbf24; }
        
        /* ===== Info Items ===== */
        .info-item {
            display: flex;
            margin-bottom: var(--spacing-md);
            padding-bottom: var(--spacing-md);
            border-bottom: 1px solid var(--light-gray);
        }
        
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-label {
            width: 180px;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .info-value {
            flex: 1;
            color: var(--text-gray);
        }
        
        /* ===== Tags ===== */
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-xs);
            margin-top: var(--spacing-xs);
        }
        
        .tag {
            background-color: rgba(166, 124, 82, 0.1);
            color: var(--primary-accent);
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            border: 1px solid rgba(166, 124, 82, 0.2);
        }
        
        /* ===== Social Links ===== */
        .social-links {
            display: flex;
            gap: var(--spacing-sm);
            margin-top: var(--spacing-md);
        }
        
        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-gray);
            color: var(--text-dark);
            text-decoration: none;
            transition: all var(--transition-fast);
        }
        
        .social-link:hover {
            background-color: var(--primary-accent);
            color: var(--white);
            transform: translateY(-2px);
        }
        
        /* ===== Portfolio Grid ===== */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
        }
        
        .portfolio-item {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            aspect-ratio: 1;
        }
        
        .portfolio-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-normal);
        }
        
        .portfolio-item:hover .portfolio-image {
            transform: scale(1.05);
        }
        
        /* ===== Responsive ===== */
        @media (max-width: 1024px) {
            .two-column-layout {
                grid-template-columns: 1fr;
                gap: var(--spacing-lg);
            }
        }
        
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            h1 { font-size: 2rem; }
            h2 { font-size: 1.75rem; }
        }
        
        @media (max-width: 576px) {
            .container { padding: 0 var(--spacing-sm); }
            .card { padding: var(--spacing-md); }
            .portfolio-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        /* ===== Utility Classes ===== */
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: var(--spacing-xs); }
        .mb-2 { margin-bottom: var(--spacing-sm); }
        .mb-3 { margin-bottom: var(--spacing-md); }
        .mb-4 { margin-bottom: var(--spacing-lg); }
        .mb-5 { margin-bottom: var(--spacing-xl); }
        .mt-1 { margin-top: var(--spacing-xs); }
        .mt-2 { margin-top: var(--spacing-sm); }
        .mt-3 { margin-top: var(--spacing-md); }
        .mt-4 { margin-top: var(--spacing-lg); }
        .mt-5 { margin-top: var(--spacing-xl); }
        .d-flex { display: flex; }
        .align-items-center { align-items: center; }
        .justify-content-between { justify-content: space-between; }
        .gap-1 { gap: var(--spacing-xs); }
        .gap-2 { gap: var(--spacing-sm); }
        .gap-3 { gap: var(--spacing-md); }
        .gap-4 { gap: var(--spacing-lg); }
        .w-100 { width: 100%; }
        .text-center { text-align: center; }
    </style>
    @endsection
@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <div>
                    <h1>Profile Overview</h1>
                    <p class="mb-0">View and manage your photographer profile</p>
                </div>
                <a href="/photographer/profile/edit" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Two Column Layout -->
            <div class="two-column-layout">
                <!-- Left Column -->
                <div class="left-column">
                    <!-- Profile Information Card -->
                    <div class="card">
                        <div class="profile-header">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" 
                                 alt="Michael Rodriguez" class="profile-avatar">
                            <div class="profile-info">
                                <h1>Michael Rodriguez</h1>
                                <p class="profile-role">Professional Wedding & Portrait Photographer</p>
                                <div class="rating">
                                    <span class="star"><i class="fas fa-star"></i></span>
                                    <span class="star"><i class="fas fa-star"></i></span>
                                    <span class="star"><i class="fas fa-star"></i></span>
                                    <span class="star"><i class="fas fa-star"></i></span>
                                    <span class="star"><i class="fas fa-star-half-alt"></i></span>
                                    <span>4.7 (128 reviews)</span>
                                </div>
                                <p class="mb-0">Member since 2022</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">Michael Rodriguez</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">michael.rodriguez@example.com</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Bio</div>
                            <div class="info-value">
                                Award-winning wedding and portrait photographer with 8 years of experience. 
                                Specializing in capturing authentic moments and creating timeless memories. 
                                Based in New York but available for travel worldwide.
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">City</div>
                            <div class="info-value">New York, NY</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Years of Experience</div>
                            <div class="info-value">8 years</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Photography Types</div>
                            <div class="info-value">
                                <div class="tags-container">
                                    <span class="tag">Wedding</span>
                                    <span class="tag">Portrait</span>
                                    <span class="tag">Family</span>
                                    <span class="tag">Engagement</span>
                                    <span class="tag">Maternity</span>
                                    <span class="tag">Commercial</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Starting Price</div>
                            <div class="info-value">
                                <strong style="font-size: 1.25rem; color: var(--primary-accent);">$150/hour</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Social Links</h3>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Instagram</div>
                            <div class="info-value">
                                <a href="https://instagram.com/michael.photo" target="_blank" style="color: var(--primary-accent); text-decoration: none;">
                                    @michael.photo
                                </a>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Website</div>
                            <div class="info-value">
                                <a href="https://michaelrodriguez.com" target="_blank" style="color: var(--primary-accent); text-decoration: none;">
                                    michaelrodriguez.com
                                </a>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Behance</div>
                            <div class="info-value">
                                <a href="https://behance.net/michaelrodriguez" target="_blank" style="color: var(--primary-accent); text-decoration: none;">
                                    behance.net/michaelrodriguez
                                </a>
                            </div>
                        </div>
                        
                        <div class="social-links">
                            <a href="https://instagram.com/michael.photo" class="social-link" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://michaelrodriguez.com" class="social-link" target="_blank">
                                <i class="fas fa-globe"></i>
                            </a>
                            <a href="https://behance.net/michaelrodriguez" class="social-link" target="_blank">
                                <i class="fab fa-behance"></i>
                            </a>
                            <a href="https://facebook.com/michael.photo" class="social-link" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/michael_photo" class="social-link" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <!-- Portfolio Preview Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Portfolio Preview</h3>
                            <a href="/photographer/portfolio" class="btn btn-outline btn-sm">
                                <i class="fas fa-images"></i> Manage Portfolio
                            </a>
                        </div>
                        
                        <p>Showcasing your best work helps attract new clients. Keep your portfolio updated with recent projects.</p>
                        
                        <div class="portfolio-grid">
                            <div class="portfolio-item">
                                <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                                     alt="Wedding Photography" class="portfolio-image">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                                     alt="Portrait Photography" class="portfolio-image">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://images.unsplash.com/photo-1511988617509-a57c8a288659?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                                     alt="Family Photography" class="portfolio-image">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://images.unsplash.com/photo-1492681290082-e932832832c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                                     alt="Product Photography" class="portfolio-image">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://images.unsplash.com/photo-1520854221256-17463ccb8b9d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                                     alt="Event Photography" class="portfolio-image">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://images.unsplash.com/photo-1507591064344-4c6ce005-128?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                                     alt="Commercial Photography" class="portfolio-image">
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="/photographer/portfolio" class="btn btn-primary w-100">
                                <i class="fas fa-plus"></i> Add More Photos
                            </a>
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Profile Stats</h3>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--spacing-md);">
                            <div class="text-center">
                                <div style="font-size: 2rem; font-weight: 700; color: var(--primary-accent);">128</div>
                                <div style="font-size: 0.875rem; color: var(--text-gray);">Total Reviews</div>
                            </div>
                            <div class="text-center">
                                <div style="font-size: 2rem; font-weight: 700; color: var(--primary-accent);">4.7</div>
                                <div style="font-size: 0.875rem; color: var(--text-gray);">Average Rating</div>
                            </div>
                            <div class="text-center">
                                <div style="font-size: 2rem; font-weight: 700; color: var(--primary-accent);">342</div>
                                <div style="font-size: 0.875rem; color: var(--text-gray);">Portfolio Views</div>
                            </div>
                            <div class="text-center">
                                <div style="font-size: 2rem; font-weight: 700; color: var(--primary-accent);">24</div>
                                <div style="font-size: 0.875rem; color: var(--text-gray);">Bookings This Month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        // Sample profile data
        const profileData = {
            name: "Michael Rodriguez",
            email: "michael.rodriguez@example.com",
            bio: "Award-winning wedding and portrait photographer with 8 years of experience. Specializing in capturing authentic moments and creating timeless memories. Based in New York but available for travel worldwide.",
            city: "New York, NY",
            experience: "8 years",
            photographyTypes: ["Wedding", "Portrait", "Family", "Engagement", "Maternity", "Commercial"],
            startingPrice: "$150/hour",
            social: {
                instagram: "@michael.photo",
                website: "michaelrodriguez.com",
                behance: "behance.net/michaelrodriguez",
                facebook: "facebook.com/michael.photo",
                twitter: "@michael_photo"
            },
            stats: {
                reviews: 128,
                rating: 4.7,
                views: 342,
                bookings: 24
            }
        };

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Update profile stats
            document.querySelectorAll('.text-center')[0].querySelector('div').textContent = profileData.stats.reviews;
            document.querySelectorAll('.text-center')[1].querySelector('div').textContent = profileData.stats.rating;
            document.querySelectorAll('.text-center')[2].querySelector('div').textContent = profileData.stats.views;
            document.querySelectorAll('.text-center')[3].querySelector('div').textContent = profileData.stats.bookings;
        });
    </script>
@endsection