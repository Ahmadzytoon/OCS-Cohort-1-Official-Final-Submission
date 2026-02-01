@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/footer.css') }}">
@endpush

<footer class="footer-section footer-bg section-padding pb-0" style="background-color: #fcf6f5;">
    <div class="container">
        <div class="footer-widgets-wrapper">
            <div class="row g-4">
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="single-footer-widget">
                        <div class="widget-head">
                            <h4 class="text-dark">About Us</h4>
                        </div>
                        <div class="footer-content">
                            <p class="mb-4">
                                Your premier destination for books of all genres. We believe in the power of reading to transform lives and expand horizons.
                            </p>
                            <div class="social-icon d-flex align-items-center gap-3">
                                <a href="https://www.facebook.com/" class="text-dark"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://x.com/" class="text-dark"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.youtube.com/" class="text-dark"><i class="fab fa-youtube"></i></a>
                                <a href="https://www.linkedin.com/" class="text-dark"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                    <div class="single-footer-widget">
                        <div class="widget-head">
                            <h4 class="text-dark">Quick Links</h4>
                        </div>
                        <ul class="list-area">
                            <li><a href="{{ route('user.home') }}" class="text-muted"><i class="fa-solid fa-chevron-right me-2"></i>Home</a></li>
                            <li><a href="{{ route('user.shop') }}" class="text-muted"><i class="fa-solid fa-chevron-right me-2"></i>Shop</a></li>
                            <li><a href="{{ route('user.about') }}" class="text-muted"><i class="fa-solid fa-chevron-right me-2"></i>About Us</a></li>
                            <li><a href="{{ route('user.contact') }}" class="text-muted"><i class="fa-solid fa-chevron-right me-2"></i>Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                    <div class="single-footer-widget">
                        <div class="widget-head">
                            <h4 class="text-dark">Categories</h4>
                        </div>
                        <ul class="list-area">
                            @foreach(\App\Models\Category::where('name', '!=', 'Education & Learning')->take(4)->get() as $cat)
                                <li><a href="{{ route('user.shop', ['category' => $cat->id]) }}" class="text-muted"><i class="fa-solid fa-chevron-right me-2"></i>{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                    <div class="single-footer-widget">
                        <div class="widget-head">
                            <h4 class="text-dark">Contact Information</h4>
                        </div>
                        <div class="footer-content">
                            <ul class="contact-info">
                                <li class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-location-dot me-3 text-pink"></i>
                                    <span class="text-muted">123 Bookstore St, Knowledge City</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-phone me-3 text-pink"></i>
                                    <a href="tel:+1234567890" class="text-muted">+1 234 567 890</a>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fa-solid fa-envelope me-3 text-pink"></i>
                                    <a href="mailto:info@readify.com" class="text-muted">info@readify.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom mt-5 py-4 border-top">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <p class="mb-0 text-muted">&copy; {{ date('Y') }} Readify. All rights reserved.</p>
                <div class="payment-methods d-flex gap-3">
                    <img src="{{ asset('assets/user/images/visa-logo.png') }}" alt="Visa" style="height: 20px; opacity: 0.8;">
                    <img src="{{ asset('assets/user/images/mastercard.png') }}" alt="Mastercard" style="height: 20px; opacity: 0.8;">
                    <img src="{{ asset('assets/user/images/PayPal.png') }}" alt="PayPal" style="height: 20px; opacity: 0.8;">
                    <img src="{{ asset('assets/user/images/GooglePay.png') }}" alt="Google Pay" style="height: 20px; opacity: 0.8;">
                </div>
            </div>
        </div>
    </div>
</footer>