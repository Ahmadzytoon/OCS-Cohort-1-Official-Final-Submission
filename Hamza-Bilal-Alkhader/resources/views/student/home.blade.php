@extends('layouts.master')

@section('title', 'Mentory - Find Your Perfect Teacher')

@section('css')
<style>
  .feature-card{
    transition: all .25s ease;
  }
  .feature-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0,0,0,.10) !important;
    border-color: rgba(95,207,128,.35) !important;
  }
  .feature-icon{
    width: 56px;
    height: 56px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: rgba(95,207,128,.12);
    color: #5fcf80;
  }
  
.carousel-indicators [data-bs-target] {
    background-color: #5fcf80; 
    opacity: 0.4;
}

.carousel-indicators .active {
    opacity: 1;
}


</style>
@endsection

@section('content')
    
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background py-5">
        <img src="{{ asset('assets/img/hero.png') }}" alt="" data-aos="fade-in" />

        <div class="container">
            <div class="hero-content py-5">
                <h2 data-aos="fade-up" data-aos-delay="100">
                    Learn Smarter,<br />Choose the Right Teacher
                </h2>
                <p data-aos="fade-up" data-aos-delay="200">
                    Find verified teachers, send requests, and rate with confidence
                </p>
                <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('pages.teachers') }}" class="btn-get-started">Browse Teachers</a>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hero Section -->

       <!-- Featured Teachers -->
<section id="featured-teachers" class="section py-5">
  <div class="container">
    <div class="section-header text-center mb-5">
      <h2>Top Rated Teachers</h2>
      <p class="text-muted">Highest rated Teachers based on real student reviews</p>
    </div>

    @php
      // 3 cards per slide
      $chunks = $topTeachers->chunk(3);
    @endphp

    @if($topTeachers->isEmpty())
      <div class="text-center text-muted py-5 border rounded bg-light">
        <i class="bi bi-star display-6 d-block mb-2"></i>
        No teachers available yet.
      </div>
    @else

      <div id="featuredTeachersCarousel" class="carousel slide" data-bs-ride="carousel">

        {{-- Indicators--}}
        @if($chunks->count() > 1)
          <div class="carousel-indicators" style="bottom:-45px; ">
            @foreach($chunks as $i => $c)
              <button type="button"
                      data-bs-target="#featuredTeachersCarousel"
                      data-bs-slide-to="{{ $i }}"
                      class="{{ $i === 0 ? 'active' : '' }}"
                      aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                      aria-label="Slide {{ $i+1 }}"></button>
            @endforeach
          </div>
        @endif

        <div class="carousel-inner">
          @foreach($chunks as $index => $group)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
              <div class="row g-4">

                @foreach($group as $t)
                  <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                      <img
                        src="{{ $t->image_path
                              ? asset('storage/'.$t->image_path)
                              : asset('assets/img/teacher-placeholder.jpg') }}"
                        class="card-img-top"
                        style="height:220px;object-fit:cover"
                        alt="Teacher"
                      >

                      <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <h5 class="mb-0 fw-bold">Tr. {{ $t->display_name }}</h5>

                          <span class="badge" style="background-color:#5fcf80; color:white;">
                            Top Rated
                          </span>
                        </div>

                        <div class="text-muted small mb-3">
                          {{ $t->subject?->name ?? '—' }} - {{ $t->branch?->name ?? '—' }}
                        </div>

                        <div class="d-flex align-items-center mb-4">
                          <div class="text-warning me-2">
                            <i class="bi bi-star-fill"></i>
                          </div>

                          <span class="text-muted ms-1">
                            {{ number_format($t->reviews_avg_rating ?? 0, 1) }}
                            ({{ $t->reviews_count }} )
                          </span>
                        </div>

                        <a href="{{ route('student.teacher-details', $t->id) }}"
                           class="btn w-100"
                           style="background-color:#5fcf80; color:white;">
                          View Details
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach

              </div>
            </div>
          @endforeach
        </div>

        @if($chunks->count() > 1)
          <!-- Controls -->
          <button class="carousel-control-prev" type="button" data-bs-target="#featuredTeachersCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" style="background-color:#5fcf80; border-radius:50%;"></span>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#featuredTeachersCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" style="background-color:#5fcf80; border-radius:50%;"></span>
          </button>
        @endif

      </div>

      <div class="text-center mt-5">
        <a href="{{ route('pages.teachers') }}"
           class="btn"
           style="color:#5fcf80; border-color:#5fcf80; padding:10px 40px;">
          View All Teachers
        </a>
      </div>

    @endif
  </div>
</section>
<!-- /Featured Teachers -->

{{-- Demo Advertisement (Google Ads Style Placeholder) --}}
<div class="my-5">
  <div class="ad-card d-flex align-items-center gap-3">

    <img
      src="{{ asset('assets/img/ad-demo.jpg') }}"
      alt="Advertisement"
      class="ad-image"
    >

    <div class="ad-content">
      <span class="ad-badge">Ad</span>

      <h6 class="ad-title">
        Boost Your Grades with Private Tutors
      </h6>

      <p class="ad-text">
        Find experienced teachers for Tawjihi subjects.
        Learn smarter and achieve better results.
      </p>

      <a href="#" class="ad-link">
        Visit Website
      </a>
    </div>

  </div>
</div>

    <!-- About Us -->
    <section id="about" class="section py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>About Mentory</h2>
                <p class="text-muted">Trusted ratings, real learning</p>
            </div>

            <div class="row gy-4 align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('assets/img/about.jpg') }}" class="img-fluid rounded" alt="" />
                </div>

                <div class="col-lg-6">
                    <p class="mb-4">
                        Mentory helps students find the right teacher with verified reviews.
                        Reviews are allowed only after a completed request.
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-check-circle me-2" style="color: #5fcf80;"></i>
                            <span>Only <strong>approved</strong> teacher profiles appear to students.</span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle me-2" style="color: #5fcf80;"></i>
                            <span>Requests ensure ratings come from real interactions.</span>
                        </li>
                        <li class="mb-4">
                            <i class="bi bi-check-circle me-2" style="color: #5fcf80;"></i>
                            <span>Filter by subject and branch, then sort by rating.</span>
                        </li>
                    </ul>
                    <a href="{{ route('pages.teachers') }}" class="text-decoration-none fw-bold" style="color: #5fcf80;">
                        Browse Teachers <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- /About Us -->

    <!-- Why Choose Us -->
    <section id="why-us" class="section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Why Choose Us</h2>
                <p class="text-muted">We focus on simplicity and trust</p>
            </div>

            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="h-100 p-4">
                        <h3 class="mb-4">Why Mentory?</h3>
                        <p class="mb-4">
                            No fake reviews — ratings are linked to real requests.
                            Students discover the best teachers faster.
                        </p>
                        <a href="{{ route('pages.teachers') }}" class="text-decoration-none fw-bold" style="color: #5fcf80;">
                            Explore Now <i class="bi bi-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center p-4 h-100">
                                <i class="bi bi-shield-check display-6 mb-3" style="color: #5fcf80;"></i>
                                <h4 class="mb-3">Approved Profiles</h4>
                                <p class="text-muted">Teachers appear only after admin approval to keep quality high.</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center p-4 h-100">
                                <i class="bi bi-funnel display-6 mb-3" style="color: #5fcf80;"></i>
                                <h4 class="mb-3">Smart Filtering</h4>
                                <p class="text-muted">Filter by subject and branch, then quickly find your match.</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center p-4 h-100">
                                <i class="bi bi-star-fill display-6 mb-3" style="color: #5fcf80;"></i>
                                <h4 class="mb-3">Trusted Ratings</h4>
                                <p class="text-muted">Reviews are tied to completed requests — real experience only.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Why Choose Us -->

    <!-- Features -->
    <section id="features" class="section py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Our Features</h2>
                <p class="text-muted">Everything you need to find the right teacher, with confidence</p>
            </div>

            <div class="row gy-4">

                {{-- Feature Card --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-search fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Search Teachers</h5>
                            <p class="text-muted small mb-0">Find teachers quickly by name.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-funnel fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Filter by Subject</h5>
                            <p class="text-muted small mb-0">Pick the subject you need.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-diagram-3 fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Filter by Branch</h5>
                            <p class="text-muted small mb-0">Select the academic branch that fits your level</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-send-check fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Send a Request</h5>
                            <p class="text-muted small mb-0">Contact teachers easily and start learning.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-star-fill fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Verified Ratings</h5>
                            <p class="text-muted small mb-0">Reviews are allowed only after a completed request</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-person-badge fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Detailed Profiles</h5>
                            <p class="text-muted small mb-0">View teacher bio, subjects, and real ratings.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- /Features -->

  <!-- CTA Section -->
<section class="section py-5" style="background-color: #5fcf80;">
    <div class="container">
        <div class="text-center py-4">
            <h3 class="text-white mb-3">
                Need Help or Have a Question?
            </h3>
            <p class="text-white mb-4">
                Contact us directly on WhatsApp and we’ll be happy to assist you.
            </p>
            <a href="https://wa.me/962795717995"
               target="_blank"
               class="btn btn-light px-4">
                <i class="bi bi-whatsapp me-2"></i>
                Chat on WhatsApp
            </a>
        </div>
    </div>
</section>
<!-- /CTA Section -->


@endsection

