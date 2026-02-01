   <footer id="footer" class="footer bg-body-secondary border-top py-4 mt-auto">
      <div class="container">
        <div class="row align-items-center gy-3">
          <!-- Copyright Left -->
          <div
            class="col-12 col-md-6 text-center text-md-start text-muted small"
          >
            ©2026 MentorRate. All rights reserved.
          </div>

          <!-- Social Icons Right -->
          <div class="col-12 col-md-6 text-center text-md-end">
            <a href="#" class="text-dark fs-5 me-3" aria-label="Facebook">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="#" class="text-dark fs-5 me-3" aria-label="Instagram">
              <i class="bi bi-instagram"></i>
            </a>
            <a href="#" class="text-dark fs-5 me-3" aria-label="Twitter">
              <i class="bi bi-twitter-x"></i>
            </a>
            <a href="#" class="text-dark fs-5" aria-label="LinkedIn">
              <i class="bi bi-linkedin"></i>
            </a>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scroll Top -->
    <a
      href="#"
      id="scroll-top"
      class="scroll-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

    <!-- Main JS File -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   @yield('js')