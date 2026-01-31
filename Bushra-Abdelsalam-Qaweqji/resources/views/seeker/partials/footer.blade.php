<footer class="footer-dark">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="d-flex align-items-center gap-2 fw-bold text-white mb-2">
                    <span class="brand-mark brand-mark-sm">C</span>
                    <span>Cleanova</span>
                </div>
                <p class="text-white-50 mb-3">
                    Connecting you with trusted cleaning professionals in your area. Your clean home is just a click
                    away.
                </p>
                <div class="d-flex gap-2">
                    <a class="btn btn-sm btn-outline-light" href="#">f</a>
                    <a class="btn btn-sm btn-outline-light" href="#">t</a>
                    <a class="btn btn-sm btn-outline-light" href="#">in</a>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <h6 class="text-white fw-bold mb-3">Services</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ url('/providers?service=home') }}">Housekeeping</a></li>
                    <li><a href="{{ url('/providers?service=car') }}">Car Washing</a></li>
                    <li><a href="{{ route('providers.index') }}">Find a Cleaner</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h6 class="text-white fw-bold mb-3">Company</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Become a Provider</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h6 class="text-white fw-bold mb-3">Contact Us</h6>
                <ul class="list-unstyled text-white-50 mb-0">
                    <li class="mb-2">✉ hello@Cleanova.com</li>
                    <li class="mb-2">☎ 1-800-CLEAN-NOW</li>
                    <li>📍 Nationwide Service</li>
                </ul>
            </div>
        </div>

        <div class="text-center text-white-50 small mt-4 pt-4 border-top border-light border-opacity-10">
            © 2024 Cleanova. All rights reserved.
        </div>
    </div>
</footer>

