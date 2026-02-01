@extends('layouts.main.master')

@section('title', ($photographer->full_name ?? 'Photographer') . ' | LYDIA')

@section('content')
@php
    // صورة البروفايل
    $avatar = ($profile && $profile->profile_image_path)
        ? asset('storage/' . $profile->profile_image_path)
        : asset('images/default-photographer.jpg');

    $types = [];
    if ($profile && is_array($profile->photography_types)) $types = $profile->photography_types;

    $city  = $profile->city ?? '—';
    $price = $profile->starting_price ?? 0;
    $exp   = $profile->years_of_experience ?? 0;

    // روابط السوشال
    $instagram = $profile->instagram_url ?? null;
    $website   = $profile->website_url ?? null;
    $behance   = $profile->behance_url ?? null;

    $photosCount = $portfolio->count();
@endphp

<style>
    /* Modern Color Palette */
    :root {
        --primary: #8B7355; /* Warm brown for photography */
        --primary-light: #C4A484;
        --primary-dark: #6B5B40;
        --secondary: #2C3E50; /* Dark blue for contrast */
        --accent: #E74C3C; /* Accent for calls-to-action */
        --light: #F8F9FA;
        --gray-light: #E9ECEF;
        --gray: #6C757D;
        --gray-dark: #343A40;
        --white: #FFFFFF;
        --shadow: rgba(0, 0, 0, 0.08);
        --shadow-hover: rgba(0, 0, 0, 0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --radius: 12px;
        --radius-lg: 20px;
    }

    .photographer-portfolio {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        min-height: 100vh;
        color: var(--gray-dark);
        line-height: 1.6;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, 
            rgba(139, 115, 85, 0.95) 0%, 
            rgba(44, 62, 80, 0.95) 100%),
            url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=1920');
        background-size: cover;
        background-position: center;
        color: var(--white);
        padding: 80px 20px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, 
            rgba(139, 115, 85, 0.3) 0%, 
            rgba(44, 62, 80, 0.3) 100%);
        z-index: 1;
    }

    .hero-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .hero-content {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 60px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .hero-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 40px;
        }
    }

    /* Profile Avatar */
    .profile-avatar-container {
        position: relative;
    }

    .profile-avatar {
        width: 280px;
        height: 280px;
        border-radius: 50%;
        overflow: hidden;
        border: 6px solid var(--white);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        background: var(--light);
        transition: var(--transition);
        position: relative;
    }

    .profile-avatar:hover {
        transform: scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    /* Profile Info */
    .profile-info h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .profile-subtitle {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 30px;
        font-weight: 400;
    }

    .profile-meta {
        display: flex;
        gap: 40px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .meta-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .meta-text {
        display: flex;
        flex-direction: column;
    }

    .meta-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--white);
    }

    .meta-label {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Tags */
    .expertise-tags {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .expertise-tag {
        background: rgba(255, 255, 255, 0.1);
        color: var(--white);
        padding: 10px 24px;
        border-radius: 50px;
        font-size: 0.95rem;
        font-weight: 500;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        transition: var(--transition);
    }

    .expertise-tag:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    /* CTA Buttons */
    .hero-actions {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 16px 40px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        font-size: 1rem;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        letter-spacing: 0.5px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--accent) 0%, #C0392B 100%);
        color: var(--white);
        box-shadow: 0 8px 24px rgba(231, 76, 60, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(231, 76, 60, 0.4);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: var(--white);
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-3px);
    }

    /* Main Content */
    .main-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 20px;
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 60px;
    }

    @media (max-width: 1024px) {
        .main-content {
            grid-template-columns: 1fr;
        }
    }

    /* Left Column - Content Sections */
    .content-section {
        margin-bottom: 60px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        position: relative;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 2px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--secondary);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .section-title i {
        color: var(--primary);
        font-size: 1.8rem;
    }

    /* About Section */
    .about-content {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 10px 30px var(--shadow);
        border: 1px solid var(--gray-light);
    }

    .bio-text {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--gray-dark);
        margin-bottom: 40px;
    }

  
    /* Portfolio Section */
    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }

    .portfolio-item {
        position: relative;
        border-radius: var(--radius);
        overflow: hidden;
        aspect-ratio: 4/3;
        cursor: pointer;
        transition: var(--transition);
    }

    .portfolio-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 50%);
        opacity: 0;
        transition: var(--transition);
        z-index: 1;
    }

    .portfolio-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    .portfolio-item:hover::before {
        opacity: 1;
    }

    .portfolio-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .portfolio-item:hover img {
        transform: scale(1.1);
    }

    /* Empty State */
    .empty-portfolio {
        text-align: center;
        padding: 80px 20px;
        background: var(--light);
        border-radius: var(--radius-lg);
        border: 2px dashed var(--gray-light);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gray-light);
        margin-bottom: 20px;
    }

    .empty-text h3 {
        font-size: 1.5rem;
        color: var(--gray-dark);
        margin-bottom: 10px;
    }

    .empty-text p {
        color: var(--gray);
        max-width: 400px;
        margin: 0 auto;
    }

    /* Right Column - Sidebar */
    .sidebar-section {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px var(--shadow);
        border: 1px solid var(--gray-light);
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-title i {
        color: var(--primary);
    }

    /* Contact Info */
    .contact-list {
        list-style: none;
        padding: 0;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px 0;
        border-bottom: 1px solid var(--gray-light);
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .contact-details {
        flex: 1;
    }

    .contact-label {
        font-size: 0.875rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .contact-value {
        font-weight: 600;
        color: var(--secondary);
        font-size: 1.1rem;
    }

    /* Pricing Card */
    .pricing-card {
        background: linear-gradient(135deg, var(--secondary) 0%, #1a2530 100%);
        color: var(--white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        text-align: center;
    }

    .price-amount {
        font-size: 3.5rem;
        font-weight: 700;
        margin: 20px 0;
        color: var(--white);
    }

    .price-label {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 5px;
    }

    .price-note {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 20px;
        font-style: italic;
    }

    /* Booking CTA */
    .booking-cta {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .booking-cta::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        opacity: 0.5;
    }

    .booking-cta h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .booking-cta p {
        opacity: 0.9;
        margin-bottom: 30px;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    .btn-cta {
        background: var(--white);
        color: var(--primary-dark);
        font-weight: 600;
        padding: 16px 40px;
        border-radius: 50px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: var(--transition);
        position: relative;
        z-index: 1;
    }

    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        background: var(--light);
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .lightbox.show {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    .lightbox-content {
        max-width: 90vw;
        max-height: 90vh;
        position: relative;
        animation: zoomIn 0.3s ease;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        object-fit: contain;
    }

    .lightbox-close {
        position: absolute;
        top: -60px;
        right: 0;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        transition: var(--transition);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
        pointer-events: none;
    }

    .lightbox-nav button {
        pointer-events: all;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        transition: var(--transition);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-nav button:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section {
            padding: 60px 20px;
        }

        .profile-avatar {
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }

        .profile-info h1 {
            font-size: 2.5rem;
        }

        .profile-meta {
            justify-content: center;
            gap: 30px;
        }

        .hero-actions {
            justify-content: center;
        }

        .main-content {
            padding: 60px 20px;
        }

        .section-title {
            font-size: 1.75rem;
        }

        .about-content,
        .sidebar-section {
            padding: 30px 20px;
        }

        .portfolio-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
    }

    @media (max-width: 480px) {
        .profile-info h1 {
            font-size: 2rem;
        }

        .profile-meta {
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .hero-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .portfolio-grid {
            grid-template-columns: 1fr;
        }

        .price-amount {
            font-size: 2.5rem;
        }
    }

    /* Utility Classes */
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .text-gradient {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ===============================
   NAVBAR SCROLL BEHAVIOR
   (Profile page only)
================================ */

/* الحالة الافتراضية – فوق الصفحة */
 .navbar {
  background: transparent;
  box-shadow: none;
  border-bottom: 1px solid transparent;
  transition: all 0.3s ease;
}

/* ألوان النص فوق (شفاف) */
 .navbar a,
 .navbar .nav-link,
 .navbar .logo-text {
  color: #ffffff;
  transition: color 0.3s ease;
}

/* ===============================
   بعد الـ scroll
================================ */
 .navbar.nav-scrolled {
  background: rgba(41, 41, 41, 0.65);
  backdrop-filter: blur(10px);
  box-shadow: 0 8px 22px rgba(0,0,0,.08);
  border-bottom: 1px solid rgba(0,0,0,.08);
}

/* لون النص بعد السكروول */
 .navbar.nav-scrolled a,
 .navbar.nav-scrolled .nav-link,
 .navbar.nav-scrolled .logo-text {
  color: #232222;
}

/* Hover بعد السكروول */
.navbar.nav-scrolled a:hover,
 .navbar.nav-scrolled .nav-link:hover {
  color: #a67c52;
}

/* =========================
   Social Links Grid (Profile)
   ========================= */

.social-links-grid{
  display:grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 14px;
  margin-top: 16px;
}

/* Responsive */
@media (max-width: 992px){
  .social-links-grid{
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}
@media (max-width: 576px){
  .social-links-grid{
    grid-template-columns: 1fr;
  }
}

/* Card Link */
.social-link-card{
  display:flex;
  align-items:center;
  gap: 14px;
  padding: 16px 18px;
  border-radius: 14px;
  background: #ffffff;
  border: 1px solid rgba(166, 124, 82, 0.22);
  text-decoration:none;
  transition: 0.25s ease;
  min-height: 74px;
}

.social-link-card:hover{
  transform: translateY(-2px);
  border-color: rgba(166, 124, 82, 0.45);
  box-shadow: 0 10px 22px rgba(0,0,0,0.08);
}

/* Icon box */
.social-link-card .social-icon{
  width: 48px;
  height: 48px;
  border-radius: 14px;
  display:flex;
  align-items:center;
  justify-content:center;
  background: rgba(166,124,82,0.12);
  color: #a67c52;
  flex: 0 0 auto;
  font-size: 20px;
}

/* Text */
.social-link-card .social-text{
  flex:1;
  min-width:0;
  display:flex;
  flex-direction:column;
  gap: 4px;
}

.social-link-card .social-title,
.social-link-card .social-platform{
  font-weight: 700;
  color:#232222;
  line-height:1.1;
}

.social-link-card .social-handle{
  color:#64748b;
  font-size: 14px;
  overflow:hidden;
  text-overflow:ellipsis;
  white-space:nowrap;
}

/* External icon (optional) */
.social-link-card .social-arrow{
  color:#a67c52;
  opacity:.8;
  font-size: 16px;
}


.booking-form{
  margin-top: 14px;
  position: relative;
  z-index: 2;
  text-align: left;
}

.booking-grid{
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-top: 14px;
}

.booking-form .field label{
  display:block;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: .6px;
  text-transform: uppercase;
  color: rgba(255,255,255,.85);
  margin-bottom: 6px;
}

.booking-form input,
.booking-form select,
.booking-form textarea{
  width: 100%;
  padding: 12px 14px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,.25);
  background: rgba(255,255,255,.12);
  color: #fff;
  outline: none;
  transition: .2s ease;
}

.booking-form input::placeholder,
.booking-form textarea::placeholder{
  color: rgba(255,255,255,.7);
}

.booking-form input:focus,
.booking-form select:focus,
.booking-form textarea:focus{
  border-color: rgba(255,255,255,.55);
  background: rgba(255,255,255,.16);
}

.booking-form select option{
  color:#232222;
}

.booking-submit{
  width: 100%;
  justify-content: center;
  margin-top: 14px;
}

.booking-hint{
  display:block;
  margin-top: 10px;
  color: rgba(255,255,255,.85);
  text-align:center;
}

.booking-alert{
  padding: 12px 14px;
  border-radius: 12px;
  margin-top: 12px;
  font-size: 14px;
}

.booking-alert-success{
  background: rgba(34,197,94,.18);
  border: 1px solid rgba(34,197,94,.35);
  color: #eafff2;
}

.booking-alert-error{
  background: rgba(239,68,68,.18);
  border: 1px solid rgba(239,68,68,.35);
  color: #ffecec;
}

@media (max-width: 480px){
  .booking-grid{ grid-template-columns: 1fr; }
}



</style>

<div class="photographer-portfolio">
    <!-- Hero Section -->
    <header class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="profile-avatar-container">
                    <div class="profile-avatar">
                        <img src="{{ $avatar }}" alt="{{ $photographer->full_name ?? 'Photographer' }}">
                    </div>
                </div>

                <div class="profile-info">
                    <h1>{{ $photographer->full_name ?? 'Photographer' }}</h1>
                    <p class="profile-subtitle">Professional Photographer & Visual Storyteller</p>

                    <div class="profile-meta">
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <div class="meta-text">
                                <span class="meta-value">{{ $exp }}</span>
                                <span class="meta-label">Years Experience</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-images"></i>
                            </div>
                            <div class="meta-text">
                                <span class="meta-value">{{ $photosCount }}</span>
                                <span class="meta-label">Portfolio Images</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="meta-text">
                                <span class="meta-value">{{ $city }}</span>
                                <span class="meta-label">Location</span>
                            </div>
                        </div>
                    </div>

                    <div class="expertise-tags">
                        @forelse($types as $t)
                            <span class="expertise-tag">{{ ucfirst(str_replace('-', ' ', $t)) }}</span>
                        @empty
                            <span class="expertise-tag">Photography</span>
                            <span class="expertise-tag">Visual Arts</span>
                            <span class="expertise-tag">Creative Direction</span>
                        @endforelse
                    </div>

                    <div class="hero-actions">
                        <a href="#booking" class="btn btn-primary">
                            <i class="bi bi-calendar-check"></i>
                            <span>Book a Session</span>
                        </a>
                        <a href="#portfolio" class="btn btn-secondary">
                            <i class="bi bi-images"></i>
                            <span>View Portfolio</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Left Column -->
        <div class="content-column">
            <!-- About Section -->
            <section class="content-section" id="about">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-person-circle"></i>
                        About Me
                    </h2>
                </div>
                <div class="about-content animate-on-scroll">
                    <div class="bio-text">
                        {{ $profile->bio ?? 'I am a passionate photographer with a keen eye for detail and a love for capturing life\'s precious moments. My approach combines technical expertise with artistic vision to create images that tell meaningful stories.' }}
                    </div>

                    @if($instagram || $website || $behance)
                    <div class="social-links-grid">
                        @php
    $instagramUrl = $profile->instagram_url ?? null;

    // تنظيف الرابط + استخراج اليوزر
    $igUsername = null;

    if ($instagramUrl) {
        $clean = preg_replace('~^https?://(www\.)?~', '', trim($instagramUrl));
        // مثال: instagram.com/username
        if (str_starts_with($clean, 'instagram.com/')) {
            $igUsername = trim(str_replace('instagram.com/', '', $clean), '/');
        } else {
            // لو المستخدم كتب username فقط
            $igUsername = trim($clean, '/');
            $instagramUrl = 'https://instagram.com/' . $igUsername;
        }
    }
@endphp

@if($instagramUrl)
    <a class="social-link-card" href="{{ $instagramUrl }}" target="_blank" rel="noopener">
        <div class="social-icon">
            <i class="bi bi-instagram"></i>
        </div>

        <div class="social-text">
            <div class="social-title">Instagram</div>
            <div class="social-handle">{{ $igUsername ? '@'.$igUsername : $instagramUrl }}</div>
        </div>

        <i class="bi bi-box-arrow-up-right social-arrow"></i>
    </a>
@endif


                        @if($website)
                        <a href="{{ $website }}" target="_blank" class="social-link-card">
                            <div class="social-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                            <div class="social-text">
                                <div class="social-platform">Website</div>
                                <div class="social-handle">Visit Portfolio</div>
                            </div>
                        </a>
                        @endif

                        @if($behance)
                        <a href="{{ $behance }}" target="_blank" class="social-link-card">
                            <div class="social-icon">
                                <i class="bi bi-behance"></i>
                            </div>
                            <div class="social-text">
                                <div class="social-platform">Behance</div>
                                <div class="social-handle">View Projects</div>
                            </div>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </section>

            <!-- Portfolio Section -->
            <section class="content-section" id="portfolio">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-images"></i>
                        Portfolio Showcase
                    </h2>
                    <span class="text-gradient" style="font-weight: 600;">{{ $photosCount }} Images</span>
                </div>

                @if($portfolio->isEmpty())
                <div class="empty-portfolio animate-on-scroll">
                    <div class="empty-icon">
                        <i class="bi bi-camera"></i>
                    </div>
                    <div class="empty-text">
                        <h3>Portfolio Coming Soon</h3>
                        <p>Beautiful moments are being captured and will be showcased here shortly.</p>
                    </div>
                </div>
                @else
                <div class="portfolio-grid">
                    @foreach($portfolio as $item)
                    <div class="portfolio-item animate-on-scroll" 
                         data-src="{{ asset('storage/' . $item->image_path) }}"
                         data-index="{{ $loop->index }}">
                        <img src="{{ asset('storage/' . $item->image_path) }}" 
                             alt="Portfolio Image {{ $loop->iteration }}"
                             loading="lazy">
                    </div>
                    @endforeach
                </div>
                @endif
            </section>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="sidebar-column">
            <!-- Contact Information -->
            <section class="sidebar-section" id="contact">
                <h3 class="sidebar-title">
                    <i class="bi bi-envelope"></i>
                    Contact Information
                </h3>
                <ul class="contact-list">
                    <li class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Location</div>
                            <div class="contact-value">{{ $city }}</div>
                        </div>
                    </li>
                    <li class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Email</div>
                            <div class="contact-value">{{ $photographer->email ?? 'contact@photographer.com' }}</div>
                        </div>
                    </li>
                    <li class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Availability</div>
                            <div class="contact-value">Available for Projects</div>
                        </div>
                    </li>
                </ul>
            </section>

            <!-- Pricing -->
            <section class="sidebar-section" id="pricing">
                <div class="pricing-card">
                    <div class="price-label">Starting From</div>
                    <div class="price-amount">${{ number_format($price) }}</div>
                    <div class="price-note">Custom packages available based on your needs</div>
                </div>
            </section>

            <!-- Booking CTA -->
          <section class="booking-cta" id="booking">
  <h3>Book a Session</h3>
  <p>Select date & time (60 minutes)</p>

  @guest
    <p style="margin-top:12px; opacity:.95;">Please login to book a session.</p>
    <a href="{{ route('login') }}" class="btn-cta" style="margin-top:12px;">
      <i class="bi bi-box-arrow-in-right"></i>
      <span>Login</span>
    </a>
  @else

    {{-- Success message --}}
    @if(session('success'))
      <div class="booking-alert booking-alert-success">
        {{ session('success') }}
      </div>
    @endif

    {{-- Error message --}}
    @if($errors->any())
      <div class="booking-alert booking-alert-error">
        <strong>Please fix:</strong>
        <ul style="margin:8px 0 0; padding-left:18px; text-align:left;">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

  <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
  @csrf

  <input type="hidden" name="provider" value="photographer">
  <input type="hidden" name="provider_id" value="{{ $photographer->id }}">

  <label style="display:block;margin:10px 0 6px;">Date</label>
  <input id="booking_date" type="date" name="booking_date"
         value="{{ old('booking_date') }}"
         min="{{ now()->toDateString() }}"
         required style="width:100%;padding:10px;border-radius:10px;border:1px solid #ddd;">

  <label style="display:block;margin:10px 0 6px;">Time</label>
  <select id="booking_time" name="booking_time" required
          style="width:100%;padding:10px;border-radius:10px;border:1px solid #ddd;">
    <option value="">Choose date first</option>
  </select>

  <label style="display:block;margin:10px 0 6px;">Location</label>
  <select name="location_type" required
          style="width:100%;padding:10px;border-radius:10px;border:1px solid #ddd;">
    <option value="client_place" {{ old('location_type')=='client_place'?'selected':'' }}>Client place</option>
    <option value="studio" {{ old('location_type')=='studio'?'selected':'' }}>Studio</option>
  </select>

  <label style="display:block;margin:10px 0 6px;">Notes (optional)</label>
  <textarea name="notes" rows="4"
            style="width:100%;padding:10px;border-radius:10px;border:1px solid #ddd;">{{ old('notes') }}</textarea>

  <button type="submit" style="margin-top:14px;width:100%;padding:12px;border-radius:999px;background:#fff;color:#6B5B40;font-weight:700;border:none;cursor:pointer;">
    Submit Booking
  </button>
</form>

  @endguest
</section>


        </div>
    </main>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" id="lightboxClose">&times;</button>
        <div class="lightbox-nav">
            <button class="lightbox-prev" id="lightboxPrev">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="lightbox-next" id="lightboxNext">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
        <div class="lightbox-content">
            <img class="lightbox-image" id="lightboxImage" src="" alt="Portfolio Image">
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lightbox functionality
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxClose = document.getElementById('lightboxClose');
    const lightboxPrev = document.getElementById('lightboxPrev');
    const lightboxNext = document.getElementById('lightboxNext');
    
    const portfolioItems = Array.from(document.querySelectorAll('.portfolio-item'));
    let currentIndex = 0;

    // Open lightbox with clicked image
    portfolioItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            currentIndex = index;
            updateLightbox();
            lightbox.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close lightbox
    lightboxClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    // Navigation
    lightboxPrev.addEventListener('click', (e) => {
        e.stopPropagation();
        currentIndex = (currentIndex - 1 + portfolioItems.length) % portfolioItems.length;
        updateLightbox();
    });

    lightboxNext.addEventListener('click', (e) => {
        e.stopPropagation();
        currentIndex = (currentIndex + 1) % portfolioItems.length;
        updateLightbox();
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('show')) return;
        
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') lightboxPrev.click();
        if (e.key === 'ArrowRight') lightboxNext.click();
    });

    function updateLightbox() {
        const src = portfolioItems[currentIndex].dataset.src;
        lightboxImage.src = src;
        lightboxImage.alt = `Portfolio Image ${currentIndex + 1}`;
    }

    function closeLightbox() {
        lightbox.classList.remove('show');
        document.body.style.overflow = '';
    }

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe all animate-on-scroll elements
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    function handleScroll() {
        if (window.scrollY > 60) {
            navbar.classList.add('nav-scrolled');
        } else {
            navbar.classList.remove('nav-scrolled');
        }
    }

    handleScroll(); // تشغيل عند التحميل
    window.addEventListener('scroll', handleScroll);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const dateInput = document.getElementById('booking_date');
  const timeSelect = document.getElementById('booking_time');
  const locationType = document.getElementById('location_type');
  const addressField = document.getElementById('addressField');

  if (!dateInput || !timeSelect) return;

  function toggleAddress(){
    if (!locationType || !addressField) return;
    addressField.style.display = (locationType.value === 'client_place') ? 'block' : 'none';
  }
  if (locationType) locationType.addEventListener('change', toggleAddress);
  toggleAddress();

  dateInput.addEventListener('change', async () => {
    const date = dateInput.value;
    if (!date) return;

    timeSelect.innerHTML = '<option value="">Loading...</option>';

    // ✅ عدّلي هذا حسب اسم الراوت عندك
    const endpoint = "{{ route('availability.check') }}"; 
    // إذا ما عندك availability.check استخدمي:
    // const endpoint = "{{ url('/availability') }}";

    const url = `${endpoint}?provider_type=photographer&provider_id={{ $photographer->id }}&date=${encodeURIComponent(date)}`;

    try{
      const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
      const data = await res.json();

      timeSelect.innerHTML = '<option value="">Select time</option>';

      if (!data.available || data.available.length === 0) {
        timeSelect.innerHTML = '<option value="">No available times</option>';
        return;
      }

      data.available.forEach(time => {
        const opt = document.createElement('option');
        opt.value = time;
        opt.textContent = time;
        timeSelect.appendChild(opt);
      });
    }catch(e){
      timeSelect.innerHTML = '<option value="">Error loading times</option>';
      console.error(e);
    }
  });
});
</script>


@endsection