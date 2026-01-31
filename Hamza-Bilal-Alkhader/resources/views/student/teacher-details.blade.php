@extends('layouts.master')

@section('title','Teacher Details')

@section('content')
<section class="py-4">
  
  <div class="container" data-aos="fade-up">
    <div class="row g-4">

      <!-- Left: Teacher Info -->
      <div class="col-12 col-lg-8">
              @if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger">
    {{ session('error') }}
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="d-flex flex-column flex-md-row gap-3">

              <!-- Photo -->
              <img
                src="{{ $teacher->image_path
                      ? asset('storage/'.$teacher->image_path)
                      : asset('assets/img/teacher-placeholder.jpg') }}"
                alt="Teacher"
                class="rounded"
                style="width:170px;height:170px;object-fit:cover"
              />

              <!-- Info -->
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h3 class="mb-1">{{ $teacher->display_name }}</h3>
                  </div>

                  <!-- Rating -->
                  <div class="text-end">
                    <div class="fw-semibold">
                      <i class="bi bi-star-fill text-warning"></i>
                      @if(!is_null($teacher->reviews_avg_rating))
                        {{ number_format($teacher->reviews_avg_rating, 1) }}
                      @else
                        0.0
                      @endif
                    </div>
                    <div class="text-muted small">
                      ({{ $teacher->reviews_count }} reviews)
                    </div>
                  </div>
                </div>

                <hr class="my-3" />

                <!-- Quick Details -->
                <div class="row g-2 small">
                  <div class="col-12 col-md-6">
                    <div class="p-2 bg-light rounded">
                      <i class="bi bi-briefcase me-1"></i>
                      <strong>Experience:</strong>
                      {{ $teacher->experience_years }} years
                    </div>
                  </div>

                  <div class="col-12 col-md-6">
                    <div class="p-2 bg-light rounded">
                      <i class="bi bi-book me-1"></i>
                      <strong>Subject:</strong>
                      {{ $teacher->subject?->name }}
                    </div>
                  </div>

                  <div class="col-12 col-md-6">
                    <div class="p-2 bg-light rounded">
                      <i class="bi bi-diagram-3 me-1"></i>
                      <strong>Branch:</strong>
                      {{ $teacher->branch?->name }}
                    </div>
                  </div>

                  <div class="col-12 col-md-6">
                    <div class="p-2 bg-light rounded">
                      <i class="bi bi-telephone me-1"></i>
                      <strong>Phone:</strong>
                      {{ $teacher->phone }}
                    </div>
                  </div>
                </div>

                <hr class="my-3" />

                <!-- Bio -->
                <h6 class="mb-2">About</h6>
                <p class="text-muted "     style=" max-height:160px; overflow-y:auto; overflow-wrap:anywhere; 
                word-break:break-word;  padding-right:6px; ">
                  {{ $teacher->bio ?? 'No bio yet.' }}
                </p>

              </div>
            </div>
          </div>
        </div>

    
        <!-- Reviews Section -->
        <div class="card shadow-sm border-0 mt-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0">Reviews</h5>
              <span class="text-muted small">
                Latest comments from students
              </span>
            </div>

            @if($reviews->isEmpty())
              <div class="text-muted">No reviews yet.</div>
            @else
              @foreach($reviews as $r)
              
                 @php
                $reportedByMe = auth()->check() && in_array($r->id, $reportedReviewIds->toArray());
              @endphp


                    <div class="border rounded p-3 mb-3 bg-light">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-2">

      <!-- Left: Avatar + Name -->
      <div class="d-flex align-items-center gap-2">
        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
             style="width:36px;height:36px;font-size:14px;">
          {{ strtoupper(substr($r->serviceRequest?->student?->name ?? 'S', 0, 1)) }}
        </div>

        <div>
          <div class="fw-semibold small">
            {{ $r->serviceRequest?->student?->name ?? 'Student' }}
          </div>
          <div class="text-muted small">
            {{ $r->created_at->diffForHumans() }}
          </div>
        </div>
      </div>

      <!-- Right: Rating -->
      <div class="text-end small">
        <i class="bi bi-star-fill text-warning"></i>
        <strong>{{ number_format($r->rating, 1) }}</strong>
      </div>

    </div>

    <!-- Comment -->
    @if($r->comment)
      <div class="bg-white rounded p-2 small text-muted">
        {{ $r->comment }}
      </div>
    @endif
    
 <div class="d-flex justify-content-end gap-2 mt-2">

  {{-- Report (any logged-in user) --}}
  @auth
    <form method="POST" action="{{ route('reviews.report', $r->id) }}">
      @csrf
      <button type="submit"
              class="btn btn-sm {{ $reportedByMe ? 'btn-secondary' : 'btn-outline-warning' }}"
              @disabled($reportedByMe)>
        <i class="bi bi-flag"></i>
        {{ $reportedByMe ? 'Reported' : 'Report' }}
      </button>
    </form>
  @endauth

  {{-- Delete (only owner) --}}
  @if(auth()->check() && auth()->user()->role === 'student' && $r->serviceRequest?->student_id === auth()->id())
    <form method="POST" action="{{ route('student.reviews.destroy', $r->id) }}">
      @csrf
      @method('DELETE')
      <button type="button" class="btn btn-sm btn-outline-danger js-delete-review">
        <i class="bi bi-trash"></i>
      </button>
    </form>
  @endif

</div>

    
  </div>
              @endforeach
            @endif

          </div>
        </div>

        <!-- Add Review -->
<div class="card shadow-sm border-0 mt-4" id="add-review">
  <div class="card-body">
    <h5 class="mb-3">Add Your Review</h5>

    @if($reviewableRequest)
      <form method="POST" action="{{ route('student.reviews.store', $reviewableRequest->id) }}">
        @csrf

        <div class="mb-3">
          <label class="form-label fw-semibold">Your Rating</label>
          <div class="d-flex gap-2 flex-wrap">
            @for($i = 5; $i >= 1; $i--)
              <input
                type="radio"
                class="btn-check"
                name="rating"
                value="{{ $i }}"
                id="rate{{ $i }}"
                required
              />
              <label class="btn btn-outline-warning" for="rate{{ $i }}">
                {{ $i }} ★
              </label>
            @endfor
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Your Comment</label>
          <textarea
            class="form-control"
            name="comment"
            rows="4"
            placeholder="Share your experience with this teacher..."
          ></textarea>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn text-white" style="background-color:#5fcf80">
            Submit Review
          </button>
        </div>

        <div class="text-muted small mt-2">
          You can submit only one review per completed request.
        </div>
      </form>
    @else
      <div class="alert alert-warning  small mb-0">
        You can leave a review only after the teacher marks your request as <strong>Completed</strong>,
        and only if you haven’t reviewed that request yet.
      </div>
    @endif

  </div>
</div>

      </div>

      <!-- Right: Actions -->
      <div class="col-12 col-lg-4">
        <div class="card shadow-sm border-0 position-sticky" style="top:110px">
          
          <div class="card-body">
            <h5 class="mb-2">Request Service</h5>
            <p class="text-muted small">
              Click below to send a request. After completion, you can rate and comment once.
            </p>

            <div class="d-grid mb-2">
  @guest
    <a href="{{ route('login') }}" class="btn text-white" style="background-color:#5fcf80">
      Request Lesson
    </a>
  @else
    @if(auth()->user()->role === 'student')
      <form method="POST" action="{{ route('student.requests.store', $teacher->id) }}">
        @csrf
        <button type="submit" class="btn text-white w-100" style="background-color:#5fcf80">
          Request Lesson
        </button>
      </form>
    @else
      <button type="button" class="btn btn-secondary w-100 "  disabled>
        Request Lesson
      </button>
    @endif
  @endguest
</div>


            <div class="d-grid mb-3">
         @if(auth()->check() && auth()->user()->role !== 'student')
  {{-- Admin / Teacher --}}
  <button type="button" class="btn btn-outline-danger w-100" disabled>
    <i class="bi bi-heart me-1"></i>
    Add to Favorite
  </button>
@else
  {{-- Guest OR Student --}}
  <form method="POST" action="{{ route('student.favorites.toggle', $teacher->id) }}">
    @csrf
    <button type="submit"
      class="btn w-100 {{ $isFavorited ? 'btn-danger' : 'btn-outline-danger' }}">
      <i class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i>
      {{ $isFavorited ? 'Remove from Favorite' : 'Add to Favorite' }}
    </button>
  </form>
@endif

            </div>

            <hr />

            <div class="small text-muted">
              <div class="d-flex justify-content-between mb-2">
                <span>Subject</span>
                <strong>{{ $teacher->subject?->name }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Branch</span>
                <strong>{{ $teacher->branch?->name }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Rating</span>
                <strong>
                  {{ number_format($teacher->reviews_avg_rating ?? 0, 1) }}
                </strong>
              </div>
              <div class="d-flex justify-content-between">
                <span>Reviews</span>
                <strong>{{ $teacher->reviews_count }}</strong>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection


@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.js-delete-review').forEach(button => {
    button.addEventListener('click', function (e) {
      const form = this.closest('form');

      Swal.fire({
        title: 'Delete review?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
});
</script>

@endsection