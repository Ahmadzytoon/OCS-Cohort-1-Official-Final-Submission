@extends('site.layout.mater')

@section('content')
    <!-- Problem Section -->
    <section id="why-us" class="section why-us light-background">

        <div class="container-fluid">

            <div class="row gy-4">

                <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

                    <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                        <h3>
                            <span>The Real Problem</span><br>
                            <strong>Knowledge Exists — But It’s Constantly Being Lost</strong>
                        </h3>
                        <p>
                            Most organizations don’t suffer from lack of knowledge.
                            They suffer from poor knowledge retention, weak documentation,
                            and over-dependence on individuals.
                        </p>
                    </div>

                    <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">

                        <!-- Problem 1 -->
                        <div class="faq-item faq-active">
                            <h3>
                                <span>01</span>
                                Knowledge lives in people, not in the system
                            </h3>
                            <div class="faq-content">
                                <p>
                                    Critical information exists only in employees’ minds.
                                    When someone leaves, their experience leaves with them —
                                    with no structured way to transfer or preserve it.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <!-- Problem 2 -->
                        <div class="faq-item">
                            <h3>
                                <span>02</span>
                                Documentation is incomplete, outdated, or ignored
                            </h3>
                            <div class="faq-content">
                                <p>
                                    Files are scattered across tools, chats, and folders.
                                    There is no single source of truth,
                                    and most documentation quickly becomes irrelevant.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <!-- Problem 3 -->
                        <div class="faq-item">
                            <h3>
                                <span>03</span>
                                Mistakes are repeated instead of being learned from
                            </h3>
                            <div class="faq-content">
                                <p>
                                    Teams repeat the same errors because past failures,
                                    lessons learned, and decisions are never captured
                                    in a reusable and searchable way.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                    </div>

                </div>

                <div class="col-lg-5 order-1 order-lg-2 why-us-img">
                    <img src="{{ asset('site/landingPage/assets/img/why-us.png') }}" class="img-fluid"
                        alt="Knowledge loss illustration" data-aos="zoom-in" data-aos-delay="100">
                </div>

            </div>

        </div>

    </section>
    <!-- /Problem Section -->

    <!-- How Our System Solves It -->
    <section id="solution" class="testimonials section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>How Our System Solves It</h2>
            <p>
                A structured, scalable, and intelligent approach to capturing
                and preserving organizational knowledge.
            </p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 4500
          },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          }
        }
      </script>

                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item text-center">
                            <div class="icon mb-3">
                                <i class="bi bi-diagram-3 fs-1"></i>
                            </div>
                            <h3>Structured Knowledge Types</h3>
                            <p>
                                Knowledge is stored in four clear types:
                                <strong>Processes, Decisions, Lessons Learned, and Best Practices</strong>
                                — ensuring clarity, consistency, and reuse.
                            </p>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item text-center">
                            <div class="icon mb-3">
                                <i class="bi bi-building fs-1"></i>
                            </div>
                            <h3>Department-Based Organization</h3>
                            <p>
                                Knowledge is linked to departments and teams,
                                making information relevant, discoverable,
                                and aligned with real organizational structure.
                            </p>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item text-center">
                            <div class="icon mb-3">
                                <i class="bi bi-shield-lock fs-1"></i>
                            </div>
                            <h3>Controlled Access & Permissions</h3>
                            <p>
                                Visibility and permissions ensure the right people
                                see the right knowledge — protecting sensitive
                                information while enabling collaboration.
                            </p>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item text-center">
                            <div class="icon mb-3">
                                <i class="bi bi-clock-history fs-1"></i>
                            </div>
                            <h3>Versioning & History Tracking</h3>
                            <p>
                                Every update is tracked.
                                Nothing is lost, overwritten, or forgotten —
                                knowledge evolves transparently over time.
                            </p>
                        </div>
                    </div>

                    <!-- Slide 5 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item text-center">
                            <div class="icon mb-3">
                                <i class="bi bi-search fs-1"></i>
                            </div>
                            <h3>Searchable & Intelligent Retrieval</h3>
                            <p>
                                Employees find answers instantly using search,
                                tags, and AI-powered summaries — reducing
                                repeated questions and wasted time.
                            </p>
                        </div>
                    </div>

                </div>

                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section>
    <!-- /How Our System Solves It -->


    <!-- Impact & Benefits Section -->
    <section id="impact" class="skills section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row">

                <!-- Illustration -->
                <div class="col-lg-6 d-flex align-items-center">
                    <img src="{{ asset('site/landingPage/assets/img/illustration/illustration-10.webp') }}"
                        class="img-fluid" alt="Knowledge Impact Illustration">
                </div>

                <!-- Content -->
                <div class="col-lg-6 pt-4 pt-lg-0 content">

                    <h3>The Real Impact on Your Organization</h3>
                    <p class="fst-italic">
                        When knowledge is captured, structured, and accessible,
                        organizations move faster, make better decisions,
                        and stop repeating the same mistakes.
                    </p>

                    <div class="skills-content skills-animation">

                        <!-- Impact 1 -->
                        <div class="progress">
                            <span class="skill">
                                <span>Reduced Knowledge Loss</span>
                                <i class="val">85%</i>
                            </span>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <!-- Impact 2 -->
                        <div class="progress">
                            <span class="skill">
                                <span>Faster Employee Onboarding</span>
                                <i class="val">75%</i>
                            </span>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <!-- Impact 3 -->
                        <div class="progress">
                            <span class="skill">
                                <span>Improved Decision-Making Quality</span>
                                <i class="val">80%</i>
                            </span>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <!-- Impact 4 -->
                        <div class="progress">
                            <span class="skill">
                                <span>Operational Efficiency</span>
                                <i class="val">70%</i>
                            </span>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </section>
    <!-- /Impact & Benefits Section -->



    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>How It Works</h2>
            <p>A simple flow designed to capture, organize, and grow your company knowledge.</p>
        </div>

        <div class="container">

            <div class="row gy-4">

                <!-- Step 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="how-step">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h4>Capture Knowledge</h4>
                        <p>
                            Employees document onboarding experiences, lessons learned, and daily operations.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="how-step">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                        <h4>Organize & Structure</h4>
                        <p>
                            Knowledge is categorized by department and type for clarity and consistency.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="how-step">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4>Access & Learn</h4>
                        <p>
                            Employees quickly find trusted information when they need it most.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="how-step">
                        <div class="step-number">4</div>
                        <div class="step-icon">
                            <i class="bi bi-cpu"></i>
                        </div>
                        <h4>Improve with AI</h4>
                        <p>
                            AI summarizes, connects insights, and highlights gaps for smarter decisions.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </section>
    <!-- /How It Works Section -->
@endsection
