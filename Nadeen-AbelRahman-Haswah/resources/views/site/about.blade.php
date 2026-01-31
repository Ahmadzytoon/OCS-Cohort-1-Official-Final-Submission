@extends('site.layout.mater')

@section('content')
    <!-- About Section -->
    <section id="about" class="about section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Vision</h2>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                    <p>
                        We envision a world where knowledge is not just collected, but clearly understood,
                        intentionally structured, and meaningfully applied.
                    <ul>
                        <li>
                            <i class="bi bi-check2-circle"></i>
                            <span>Transform abstract knowledge into clear, usable understanding</span>
                        </li>
                        <li>
                            <i class="bi bi-check2-circle"></i>
                            <span>Bridge the gap between knowing and doing</span>
                        </li>
                        <li>
                            <i class="bi bi-check2-circle"></i>
                            <span>Make knowledge visible, contextual, and impactful</span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <p> Knowledge today is everywhere, yet clarity is rare.
                        Our vision is to redefine how people interact with knowledge —
                        not as static information, but as a living system that evolves,
                        guides decisions, and creates real-world impact. </p>
                    <a href="#mission" class="read-more">
                        <span>Read More</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

            </div>

        </div>

    </section><!-- /About Section -->

    {{-- mission --}}
    <section id="mission" class="mission section">

        <div class="container" data-aos="fade-up">

            <div class="row align-items-center gy-4">

                <!-- Image -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <img src="{{ asset('site/landingPage/assets/img/Business mission-pana.png') }}"
                        class="img-fluid mission-img" alt="Mission Illustration">
                </div>

                <!-- Content -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <h3>Our Mission</h3>
                    <p class="mission-text">
                        Our mission is to help individuals and teams understand the nature of the knowledge
                        they work with, recognize its value, and apply it effectively.
                    </p>

                    <p class="mission-text">
                        By structuring knowledge into clear models and meaningful contexts,
                        this platform exists to turn learning into insight,
                        and insight into action.
                    </p>
                </div>

            </div>

        </div>

    </section>
@endsection
