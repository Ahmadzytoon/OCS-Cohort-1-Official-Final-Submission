@extends('layouts.master')

@section('title','Teachers')

@section('css')
<style>
  /* ---- Page polish ---- */
  .page-header-badge{
    border-radius: 999px;
  }

  /* ---- Search bar ---- */
  .search-wrap{
    border-radius: 18px;
  }
  .search-input{
    border-radius: 14px;
    padding-left: 42px;
  }
  .search-icon{
    position:absolute;
    left:14px;
    top:50%;
    transform: translateY(-50%);
    opacity:.6;
  }

  /* ---- Filter pills ---- */
  .filter-label{
    letter-spacing:.2px;
  }
  .filter-scroll{
    overflow-x:auto;
    -webkit-overflow-scrolling: touch;
    padding-bottom: 4px;
  }
  .filter-scroll::-webkit-scrollbar{ height:6px; }
  .filter-scroll::-webkit-scrollbar-thumb{ background:#e9ecef; border-radius: 999px; }

  .pill{
    border-radius: 999px !important;
    padding: .45rem .85rem;
    white-space: nowrap;
  }

  /* ---- Teacher cards ---- */
  .teacher-card{
    border-radius: 18px;
    overflow:hidden;
    transition: transform .15s ease, box-shadow .15s ease;
  }
  .teacher-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 .9rem 2.2rem rgba(0,0,0,.08);
  }
  .teacher-img{
    height: 220px;
    object-fit: cover;
  }
  .teacher-overlay{
    background: linear-gradient(180deg, rgba(0,0,0,0) 10%, rgba(0,0,0,.35) 100%);
  }
  .teacher-name{
    line-height:1.15;
  }
  .rating-badge{
    border-radius: 12px;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(6px);
  }

 
</style>
@endsection

@section('content')

<section class="py-4">
  <div class="container" data-aos="fade-up">

    <!-- Header -->
    <div class="text-center mb-4">
      <h3 class="mb-1">Find Teachers</h3>
      <p class="text-muted mb-0">Search and filter teachers by name, subject, and branch</p>

      <div class="mt-3 d-flex justify-content-center flex-wrap gap-2">
        <span class="badge bg-light text-dark border px-3 py-2 page-header-badge">
          <i class="bi bi-people me-1"></i>
          Showing <strong>{{ $teachers->total() }}</strong> teachers
        </span>

        @if(request()->filled('q') || request()->filled('subject_id') || request()->filled('branch_id'))
          <span class="badge bg-light text-dark border px-3 py-2 page-header-badge">
            <i class="bi bi-funnel me-1"></i>
            Filters applied
          </span>
        @endif
      </div>
    </div>

    <!-- Search -->
    <div class="card shadow-sm border-0 mb-3 search-wrap">
      <div class="card-body">
        <form class="row g-2 align-items-center" method="GET" action="{{ route('pages.teachers') }}">

          @if(request('subject_id'))
            <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
          @endif

          @if(request('branch_id'))
            <input type="hidden" name="branch_id" value="{{ request('branch_id') }}">
          @endif

          <div class="col-12 col-md-9 position-relative">
            <i class="bi bi-search search-icon"></i>
            <input
              type="text"
              name="q"
              value="{{ request('q') }}"
              class="form-control search-input"
              placeholder="Search teacher by name..."
            />
          </div>

          <div class="col-12 col-md-3 d-grid">
            <button type="submit" class="btn text-white" style="background-color:#5fcf80; border-radius:14px;">
              <i class="bi bi-search me-1"></i>
              Search
            </button>
          </div>
        </form>

        <!-- Clear filter -->
        @if(request()->filled('q') || request()->filled('subject_id') || request()->filled('branch_id'))
          <div class="mt-3">
            <a href="{{ route('pages.teachers') }}" class="btn btn-sm btn-light border pill">
              <i class="bi bi-x-circle me-1"></i>
              Clear filters
            </a>
          </div>
        @endif

      </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-body">

        <!-- Subject Filters -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
          <div class="text-muted small fw-semibold filter-label">
            <i class="bi bi-book me-1"></i> Filter by Subject
          </div>
        </div>

        <div class="filter-scroll">
          <div class="d-flex flex-wrap gap-2 mb-3">

            {{-- All Subjects --}}
            <a
              href="{{ route('pages.teachers', array_filter([
                'q' => request('q'),
                'branch_id' => request('branch_id'),
              ])) }}"
              class="btn btn-sm pill {{ request('subject_id') ? 'btn-outline-success' : 'text-white' }}"
              style="{{ request('subject_id') ? '' : 'background-color:#5fcf80' }}"
            >
              All
            </a>

            {{-- Subjects --}}
            @foreach($subjects as $s)
              <a
                href="{{ route('pages.teachers', array_filter([
                  'q' => request('q'),
                  'subject_id' => $s->id,
                  'branch_id' => request('branch_id'),
                ])) }}"
                class="btn btn-sm pill {{ (string)request('subject_id') === (string)$s->id ? 'text-white' : 'btn-outline-success' }}"
                style="{{ (string)request('subject_id') === (string)$s->id ? 'background-color:#5fcf80' : '' }}"
              >
                {{ $s->name }}
              </a>
            @endforeach

          </div>
        </div>

        <!-- Branch Filters -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
          <div class="text-muted small fw-semibold filter-label">
            <i class="bi bi-diagram-3 me-1"></i> Filter by Branch
          </div>
        </div>

        <div class="filter-scroll">
          <div class="d-flex flex-wrap gap-2">

            {{-- All Branches --}}
            <a
              href="{{ route('pages.teachers', array_filter([
                'q' => request('q'),
                'subject_id' => request('subject_id'),
              ])) }}"
              class="btn btn-sm pill btn-outline-secondary {{ request('branch_id') ? '' : 'active' }}"
            >
              All
            </a>

            {{-- Branches --}}
            @foreach($branches as $b)
              <a
                href="{{ route('pages.teachers', array_filter([
                  'q' => request('q'),
                  'subject_id' => request('subject_id'),
                  'branch_id' => $b->id,
                ])) }}"
                class="btn btn-sm pill btn-outline-secondary {{ (string)request('branch_id') === (string)$b->id ? 'active' : '' }}"
              >
                {{ $b->name }}
              </a>
            @endforeach

          </div>
        </div>

      </div>
    </div>

    <!-- Teacher Cards -->
    <div class="row g-4">
      @forelse($teachers as $t)
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card h-100 shadow-sm border-0 teacher-card">

            <div class="position-relative">
              <img
                src="{{ $t->image_path
                      ? asset('storage/'.$t->image_path)
                      : asset('assets/img/teacher-placeholder.jpg') }}"
                class="w-100 teacher-img"
                alt="Teacher photo"
              />

              <div class="position-absolute top-0 start-0 w-100 h-100 teacher-overlay"></div>

              <!-- Rating badge on image -->
              <div class="position-absolute top-0 end-0 m-3 px-3 py-2 rating-badge border">
                <div class="small fw-semibold">
                  <i class="bi bi-star-fill text-warning me-1"></i>
                  {{ number_format($t->reviews_avg_rating ?? 0, 1) }}
                </div>
                <div class="text-muted small">
                  ({{ $t->reviews_count }}) reviews
                </div>
              </div>
            </div>

            <div class="card-body d-flex flex-column">
              <div class="mb-2">
                <h5 class="card-title teacher-name mb-1">Tr. {{ $t->display_name }}</h5>
                <div class="text-muted small">
                  <i class="bi bi-book me-1"></i>{{ $t->subject?->name ?? '—' }}
                  <span class="mx-1">•</span>
                  <i class="bi bi-diagram-3 me-1"></i>{{ $t->branch?->name ?? '—' }}
                </div>
              </div>

              <div class="mt-auto d-flex gap-2">
                <a
                  href="{{ route('student.teacher-details', $t->id) }}"
                  class="btn btn-outline-success flex-grow-1"
                  style="border-radius: 12px;"
                >
                  <i class="bi bi-eye me-1"></i>
                  View Details
                </a>

                
              </div>
            </div>

          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="text-center text-muted py-5 border rounded bg-light">
            <i class="bi bi-search display-6 d-block mb-2"></i>
            No teachers found.
          </div>
        </div>
      @endforelse
    </div>

    @if($teachers->hasPages())
      <div class="pagination-wrapper mt-4 d-flex justify-content-center">
        {{ $teachers->links('pagination::bootstrap-5') }}
      </div>
    @endif

  </div>
</section>

@endsection
