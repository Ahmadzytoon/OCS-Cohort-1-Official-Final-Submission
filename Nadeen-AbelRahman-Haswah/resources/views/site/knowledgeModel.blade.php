@extends('site.layout.mater')

@section('content')
    <!-- Knowledge Model Section -->
    <section id="knowledge-model" class="work-process section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Knowledge Model</h2>
            <p>
                Not all knowledge is the same. Our system captures four critical types that
                companies usually lose over time.
            </p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-5">

                <!-- Type 1: Onboarding Knowledge -->
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="steps-item">
                        <div class="steps-image">
                            <img src="{{ asset('site/landingPage/assets/img/steps/steps-1.webp') }}"
                                alt="Onboarding Knowledge" class="img-fluid" loading="lazy">
                        </div>
                        <div class="steps-content">
                            <div class="steps-number">01</div>
                            <h3>Onboarding Knowledge</h3>
                            <p>
                                Knowledge gained during the first days and weeks of joining a company —
                                things that are never written in official documents.
                            </p>
                            <div class="steps-features">
                                <div class="feature-item">
                                    <i class="bi bi-lightbulb"></i>
                                    <span>Why it matters: Reduces onboarding time</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-code-slash"></i>
                                    <span>Example: How the codebase is actually structured</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-graph-up"></i>
                                    <span>Impact: Faster productivity for new hires</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type 2: Mistakes & Lessons Learned -->
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="steps-item">
                        <div class="steps-image">
                            <img src="{{ asset('site/landingPage/assets/img/steps/steps-2.webp') }}"
                                alt="Mistakes Knowledge" class="img-fluid" loading="lazy">
                        </div>
                        <div class="steps-content">
                            <div class="steps-number">02</div>
                            <h3>Mistakes & Lessons Learned</h3>
                            <p>
                                Real mistakes made during projects and the lessons learned from them —
                                knowledge that prevents repeating costly errors.
                            </p>
                            <div class="steps-features">
                                <div class="feature-item">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <span>Why it matters: Prevents repeated failures</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-bug"></i>
                                    <span>Example: Deployment failure due to missing env config</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-shield-check"></i>
                                    <span>Impact: More stable systems & decisions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type 3: Operational Knowledge -->
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="steps-item">
                        <div class="steps-image">
                            <img src="{{ asset('site/landingPage/assets/img/steps/steps-3.webp') }}"
                                alt="Operational Knowledge" class="img-fluid" loading="lazy">
                        </div>
                        <div class="steps-content">
                            <div class="steps-number">03</div>
                            <h3>Operational Knowledge</h3>
                            <p>
                                Day-to-day processes and workflows that keep the company running smoothly.
                            </p>
                            <div class="steps-features">
                                <div class="feature-item">
                                    <i class="bi bi-gear"></i>
                                    <span>Why it matters: Ensures consistency</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-diagram-3"></i>
                                    <span>Example: How to release a new feature step-by-step</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-clock-history"></i>
                                    <span>Impact: Less dependency on individuals</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type 4: Critical / Strategic Knowledge -->
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="500">
                    <div class="steps-item">
                        <div class="steps-image">
                            <img src="{{ asset('site/landingPage/assets/img/steps/step-4.png') }}" alt="Strategic Knowledge"
                                class="img-fluid" loading="lazy">
                        </div>
                        <div class="steps-content">
                            <div class="steps-number">04</div>
                            <h3>Critical & Strategic Knowledge</h3>
                            <p>
                                High-level decisions, architectural choices, and strategic insights that
                                shape the future of the company.
                            </p>
                            <div class="steps-features">
                                <div class="feature-item">
                                    <i class="bi bi-compass"></i>
                                    <span>Why it matters: Preserves decision context</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-server"></i>
                                    <span>Example: Why a specific framework was chosen</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-award"></i>
                                    <span>Impact: Smarter long-term decisions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>
    <!-- /Knowledge Model Section -->


    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section dark-background">

        <img src="{{ asset('site/landingPage/assets/img/bg/bg-8.webp') }}" alt="">

        <div class="container">

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-9 text-center text-xl-start">
                    <h3>From Understanding Knowledge to Using It</h3>
                    <p>
                        Knowledge isn’t powerful until it’s applied.
                        This model helps you recognize different types of knowledge, understand why they matter,
                        and see how they create real impact in real contexts.
                    </p>
                    <div class="col-xl-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="{{route('site.loging.login')}}">Get Started</a>
                    </div>
                </div>

            </div>

    </section><!-- /Call To Action Section -->
@endsection
