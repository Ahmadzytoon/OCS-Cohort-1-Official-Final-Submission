@extends('site.layout.mater')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                    <h1>Protect Your Company Knowledge</h1>
                    <p>A smart platform to capture experiences, prevent repeated mistakes, and preserve critical knowledge —
                        all in one place.</p>
                    <div class="d-flex">
                        <a href="{{ route('site.loging.choose') }}" class="btn-get-started">Get Started</a>
                        <a href="" class="glightbox btn-watch-video d-flex align-items-center"><i
                                class="bi bi-play-circle"></i><span>Watch Video</span></a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="{{ asset('site/landingPage/assets/img/hero-img.png') }}" class="img-fluid animated"
                        alt="">
                </div>
            </div>
        </div>

    </section>
    <!-- /Hero Section -->


    <!--  Hidden Problems Section -->
    <section id="services" class="services section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>The Hidden Problems Inside Every Company</h2>
            <p>Problems that silently slow teams down, waste time, and cause knowledge to disappear</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-activity icon"></i></div>
                        <h4><a href="" class="stretched-link">Knowledge Walks Out the Door</a></h4>
                        <p>When employees leave, critical knowledge leaves with them — undocumented and unrecoverable.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                        <h4><a href="" class="stretched-link">New Employees Start From Zero</a></h4>
                        <p>Onboarding depends on asking people instead of learning from real experiences.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                        <h4><a href="" class="stretched-link">The Same Mistakes Happen Again</a></h4>
                        <p>Lessons are learned once — then forgotten, repeated, and paid for again.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                        <h4><a href="" class="stretched-link">Critical Knowledge Is Invisible</a></h4>
                        <p>Key decisions, turning points, and operational know-how live only in people’s minds.</p>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>

    </section>
    <!-- / Hidden Problems Section -->


    <!-- Before vs After Section -->
    <section id="about" class="about section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>From Chaos to Clarity</h2>
            <p>See how unmanaged knowledge turns into structured organizational power.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <!-- BEFORE -->
                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="mb-3">Before</h4>
                    <p>
                        Knowledge exists, but it is scattered, undocumented, and locked inside people’s minds.
                    </p>
                    <ul>
                        <li>
                            <i class="bi bi-x-circle text-danger"></i>
                            <span>Employees leave and take critical knowledge with them</span>
                        </li>
                        <li>
                            <i class="bi bi-x-circle text-danger"></i>
                            <span>New hires struggle to understand how things really work</span>
                        </li>
                        <li>
                            <i class="bi bi-x-circle text-danger"></i>
                            <span>The same mistakes are repeated across teams</span>
                        </li>
                    </ul>
                </div>

                <!-- AFTER -->
                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="mb-3">After</h4>
                    <p>
                        Knowledge is captured, structured, and accessible — becoming a shared company asset.
                    </p>
                    <ul>
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Critical knowledge stays inside the company</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>New employees learn from real experiences, not guesses</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Mistakes turn into lessons that everyone can learn from</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </section>
    <!-- /Before vs After Section -->
@endsection
