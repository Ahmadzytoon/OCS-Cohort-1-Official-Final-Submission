@extends('layouts.main.master')

@section('title', 'About')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endsection

@section('content')

  <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>About Us</h1>
                <p>At CaptureHub, we're passionate about connecting people with perfect photography experiences. Our platform bridges the gap between clients seeking memorable moments and talented photographers ready to capture them.</p>
            </div>
        </div>
    </section>

    <!-- Who We Are Section -->
    <section class="who-we-are">
        <div class="container">
            <div class="who-we-are-content">
                <h2 class="section-title">Who We Are</h2>
                <p>CaptureHub was founded in 2023 by a team of photography enthusiasts and technology experts who recognized a common challenge: finding the right photographer for special moments shouldn't be difficult.</p>
                <p>We noticed that clients often struggled to discover photographers whose style matched their vision, while talented photographers faced challenges reaching their ideal clients. Studios with beautiful spaces remained underutilized, and the booking process was often fragmented across multiple platforms.</p>
                <p>Our solution is a unified marketplace that brings clarity, convenience, and trust to photography bookings. We've built a platform where quality, simplicity, and human connection come first.</p>
            </div>
            <div class="who-we-are-image">
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="Photographer capturing a moment">
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision">
        <div class="container">
            <h2 class="section-title">Our Mission & Vision</h2>
            <div class="mission-vision-cards">
                <div class="mission-card">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To simplify the photography booking process by creating a trusted platform where clients can easily find and book the perfect photographer or studio for their needs, while empowering photographers and studios to grow their businesses and showcase their talent.</p>
                    <p>We're committed to fostering meaningful connections and ensuring every photography experience is exceptional, from discovery to delivery.</p>
                </div>
                
                <div class="vision-card">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>To become the world's most trusted photography marketplace, where anyone can easily capture life's most important moments with confidence. We envision a future where finding the perfect photography service is as simple as a few clicks, and where photographers and studios thrive doing what they love.</p>
                    <p>We aim to transform how people think about and access professional photography services globally.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us">
        <div class="container">
            <h2 class="section-title">Why Choose Our Platform</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Easy Booking</h3>
                    <p>Simple, intuitive booking process with clear pricing and availability. Request sessions in minutes with our streamlined system.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3>Trusted Professionals</h3>
                    <p>All photographers and studios are vetted for quality. Read genuine reviews from previous clients before making your choice.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <h3>Portfolio-Based Selection</h3>
                    <p>Browse extensive portfolios to find a style that matches your vision. Filter by photography type, location, and budget.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure & Reliable</h3>
                    <p>Your bookings and data are protected with industry-leading security. We're here to support you throughout the process.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3>Studio & Photographer Variety</h3>
                    <p>Choose from freelance photographers or professional studio spaces. Options for every type of photoshoot and budget.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Dedicated Support</h3>
                    <p>Our team is here to help with any questions or concerns. Get assistance with bookings, recommendations, or technical issues.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- For Whom Section -->
    <section class="for-whom">
        <div class="container">
            <h2 class="section-title">For Whom Is This Platform</h2>
            <div class="audience-cards">
                <div class="audience-card">
                    <div class="audience-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3>For Clients</h3>
                    <p>Whether you're planning a wedding, family portrait, graduation, or professional headshots, find the perfect photographer or studio for your special moment. Browse portfolios, compare options, and book with confidence.</p>
                </div>
                
                <div class="audience-card">
                    <div class="audience-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h3>For Photographers</h3>
                    <p>Showcase your talent, manage bookings, and grow your photography business. Reach new clients, manage your availability, and focus on what you love — capturing beautiful moments.</p>
                </div>
                
                <div class="audience-card">
                    <div class="audience-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>For Studios</h3>
                    <p>Maximize your studio's visibility and bookings. Manage multiple photographers, display your spaces, and streamline scheduling. Fill unused time slots and grow your studio business.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Capture Your Moments?</h2>
                <p>Join thousands of clients, photographers, and studios who trust CaptureHub for their photography needs. Start your journey today.</p>
                <div class="cta-buttons">
                    <a href="browse.html" class="btn btn-primary">Find a Photographer</a>
                    <a href="join-photographer.html" class="btn btn-outline">Join as a Photographer</a>
                </div>
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

@section('script')
<script>
document.addEventListener("DOMContentLoaded", () => {

  /* =========================
     Mobile Navigation Toggle
  ========================== */
  const navToggle = document.getElementById('navToggle');
  const navMenu   = document.getElementById('navMenu');

  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function () {
      navMenu.classList.toggle('active');

      // Toggle between hamburger and close icon
      const icon = this.querySelector('i');
      if (icon) {
        if (icon.classList.contains('fa-bars')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-times');
        } else {
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      }
    });
  }

  // Close mobile menu when clicking a link
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      if (navMenu) navMenu.classList.remove('active');

      const toggleIcon = document.querySelector('#navToggle i');
      if (toggleIcon) {
        toggleIcon.classList.remove('fa-times');
        toggleIcon.classList.add('fa-bars');
      }
    });
  });

  /* =========================
     Footer animations + Back to top
  ========================== */
  const footerColumns = document.querySelectorAll('.footer-column');
  const backToTopBtn  = document.getElementById('backToTop');

  function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.9 &&
      rect.bottom >= 0
    );
  }

  function checkColumnVisibility() {
    footerColumns.forEach(column => {
      if (isElementInViewport(column)) {
        column.classList.add('visible');
      }
    });

    if (backToTopBtn) {
      if (window.scrollY > 500) backToTopBtn.classList.add('visible');
      else backToTopBtn.classList.remove('visible');
    }
  }

  // stagger animation
  footerColumns.forEach((column, index) => {
    column.style.transitionDelay = `${index * 0.1}s`;
  });

  checkColumnVisibility();
  window.addEventListener('scroll', checkColumnVisibility);

  if (backToTopBtn) {
    backToTopBtn.addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* =========================
     Newsletter subscription
  ========================== */
  const newsletterBtn   = document.querySelector('.newsletter-btn');
  const newsletterInput = document.querySelector('.newsletter-input');

  if (newsletterBtn && newsletterInput) {
    newsletterBtn.addEventListener('click', function () {
      const email = newsletterInput.value.trim();

      if (!email) {
        newsletterInput.focus();
        newsletterInput.style.borderColor = '#f87171';
        return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        newsletterInput.style.borderColor = '#f87171';
        return;
      }

      newsletterBtn.innerHTML = '<span>Subscribing...</span><i class="bi bi-hourglass-split"></i>';
      newsletterBtn.disabled = true;

      setTimeout(() => {
        newsletterBtn.innerHTML = '<span>Subscribed!</span><i class="bi bi-check-circle"></i>';
        newsletterBtn.style.backgroundColor = '#4ade80';
        newsletterInput.value = '';

        setTimeout(() => {
          newsletterBtn.innerHTML = '<span>Subscribe</span><i class="bi bi-envelope-arrow-up"></i>';
          newsletterBtn.style.backgroundColor = '';
          newsletterBtn.disabled = false;
        }, 2000);
      }, 1500);
    });

    newsletterInput.addEventListener('focus', function () {
      this.style.borderColor = '';
    });
  }

  /* =========================
     Footer links / social / legal
  ========================== */
  document.querySelectorAll('.footer-link').forEach(link => {
    link.addEventListener('mouseenter', function () {
      const icon = this.querySelector('i');
      if (icon) icon.style.transitionDelay = '0s';
    });

    link.addEventListener('mouseleave', function () {
      const icon = this.querySelector('i');
      if (icon) icon.style.transitionDelay = '0.1s';
    });

    link.addEventListener('click', function () {
      const span = this.querySelector('span');
      if (span) console.log(`Footer link clicked: ${span.textContent}`);
    });
  });

  document.querySelectorAll('.social-link').forEach(link => {
    link.addEventListener('click', function () {
      console.log(`Social link clicked: ${this.getAttribute('aria-label')}`);
    });
  });

  document.querySelectorAll('.legal-link').forEach(link => {
    link.addEventListener('click', function () {
      console.log(`Legal page clicked: ${this.textContent}`);
    });
  });

  const footerLogo = document.querySelector('.footer-logo');
  if (footerLogo) {
    footerLogo.addEventListener('click', function () {
      console.log('Footer logo clicked - navigating to homepage');
    });
  }

  /* =========================
     Navbar scroll effect
  ========================== */
  const navbar = document.querySelector(".navbar");
  if (navbar) {
    const updateNavbar = () => {
      navbar.classList.toggle("scrolled", window.scrollY > 50);
    };
    updateNavbar();
    window.addEventListener("scroll", updateNavbar);
  }

});
</script>
@endsection
