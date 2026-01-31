<footer id="footer" class="footer">

    <!-- Newsletter -->
    <div class="footer-newsletter">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-6">
                    <h4>Join Our Newsletter</h4>
                    <p>Subscribe to receive the latest updates about our knowledge management platform!</p>
                    <form action="forms/newsletter.php" method="post" class="php-email-form">
                        <div class="newsletter-form">
                            <input type="email" name="email" placeholder="Your Email">
                            <input type="submit" value="Subscribe">
                        </div>
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Top -->
    <div class="container footer-top">
        <div class="row gy-4">

            <!-- About / Contact -->
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="#home" class="d-flex align-items-center">
                    <span class="sitename">Arsha</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>A108 Adam Street</p>
                    <p>New York, NY 535022</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                    <p><strong>Email:</strong> <span>info@example.com</span></p>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Navigation</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('site.index') }}">Home</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('site.solution') }}">Solution</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('site.knowledgeModel') }}">Knowledge
                            Model</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a ref="{{ route('site.about') }}">About</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('site.faq') }}">FAQs</a></li>
                </ul>
            </div>

            <!-- Services / Features -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Features</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Knowledge Storage</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Access Control</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">AI Summaries</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Collaboration</a></li>
                </ul>
            </div>

            <!-- Social Links -->
            <div class="col-lg-4 col-md-12">
                <h4>Follow Us</h4>
                <p>Stay connected with us on social media for updates and tips on knowledge management!</p>
                <div class="social-links d-flex">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!-- Copyright -->
    <div class="container copyright text-center mt-4 ">
        <p>© <span>Copyright</span>
            <strong class="px-1 sitename">Arsha</strong>
            <span>All Rights Reserved</span>
        </p>

    </div>

</footer>


<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>

<script>
    // Toggle Other Industry Input
    function toggleOtherIndustry(select) {
        const otherContainer = document.getElementById('other-industry-container');
        const otherInput = document.getElementById('other-industry');

        if (select.value === 'other') {
            // Show the input field with animation
            otherContainer.style.display = 'block';
            otherInput.required = true;
            otherInput.focus();

            // Animation
            setTimeout(() => {
                otherContainer.style.opacity = '1';
                otherContainer.style.transform = 'translateY(0)';
            }, 10);
        } else {
            // Hide the input field
            otherContainer.style.display = 'none';
            otherInput.required = false;
            otherInput.value = ''; // Clear the value
        }
    }

    // Form Validation Before Submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const industrySelect = document.getElementById('industry');
        const otherIndustryInput = document.getElementById('other-industry');

        // If "Other" is selected, validate the custom input
        if (industrySelect.value === 'other') {
            if (!otherIndustryInput.value.trim()) {
                e.preventDefault();
                alert('Please specify your industry');
                otherIndustryInput.removeClass('')
                otherIndustryInput.focus();

                return false;
            }
        }
    });
</script>
<!-- Vendor JS Files -->
<script src="{{ asset('site/landingPage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('site/landingPage/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('site/landingPage/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('site/landingPage/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('site/landingPage/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('site/landingPage/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
<script src="{{ asset('site/landingPage/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('site/landingPage/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Main JS File -->
<script src="{{ asset('site/landingPage/assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
            confirmButtonText: 'OK'
        });
    </script>
@endif
@yield('js')
