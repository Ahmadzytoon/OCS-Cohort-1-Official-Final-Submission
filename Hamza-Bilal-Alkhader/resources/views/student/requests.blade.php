@extends('layouts.master')

@section('title','My Requests')

@section('content')
<section class="py-4">
  <div class="container" data-aos="fade-up">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
      <div>
        <h3 class="mb-1">My Requests</h3>
        <p class="text-muted small mb-0">Track your lesson requests status</p>
      </div>

      <div class="text-muted small">
        Total: <strong>{{ $requests->total() }}</strong>
      </div>
    </div>


    <!-- Requests List -->
    <div class="row g-3">

      @forelse($requests as $req)
        @php
          $badgeClass = match($req->status) {
            'pending'   => 'bg-warning text-dark',
            'accepted'  => 'bg-info text-dark',
            'completed' => 'bg-success',
            'rejected'  => 'bg-danger',
            default     => 'bg-secondary',
          };

          $statusIcon = match($req->status) {
            'pending'   => 'bi-hourglass-split',
            'accepted'  => 'bi-hand-thumbs-up',
            'completed' => 'bi-check2-circle',
            'rejected'  => 'bi-x-circle',
            default     => 'bi-info-circle',
          };

          $img = $req->teacherProfile->image_path
              ? asset('storage/'.$req->teacherProfile->image_path)
              : asset('assets/img/teacher-placeholder.jpg');
        @endphp

        <div class="col-12">
          <div class="card shadow-sm border-0">
            <div class="card-body">

              <div class="d-flex flex-column flex-md-row justify-content-between gap-3">

                <!-- Left: Teacher -->
                <div class="d-flex gap-3 align-items-start">
                  <img
                    src="{{ $img }}"
                    alt="Teacher"
                    class="rounded"
                    style="width:64px;height:64px;object-fit:cover"
                  />

                  <div>
                    <h6 class="mb-1">
                      Tr. {{ $req->teacherProfile->display_name }}
                    </h6>

                    <div class="text-muted small mb-1">
                      {{ $req->teacherProfile->subject?->name ?? '—' }}
                      •
                      {{ $req->teacherProfile->branch?->name ?? '—' }}
                    </div>

                    <div class="text-muted small">
                      <i class="bi bi-calendar3 me-1"></i>
                      Requested on:
                      <strong>{{ $req->created_at->format('d M Y') }}</strong>
                      <span class="ms-1">({{ $req->created_at->diffForHumans() }})</span>
                    </div>
                  </div>
                </div>

                <!-- Right: Status + Action -->
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-sm-end gap-2">
                  <span class="badge {{ $badgeClass }} px-3 py-2">
                    <i class="bi {{ $statusIcon }} me-1"></i>
                    {{ ucfirst($req->status) }}
                  </span>

                  @if($req->teacherProfile->status !== 'approved')
                 <button type="button" class="btn btn-sm btn-secondary" disabled title="Teacher profile is not available right now">
                 Unavailable
                </button>

                 @else
               @if($req->status === 'completed' && !$req->review)
              <a href="{{ route('student.teacher-details', $req->teacherProfile->id) }}#add-review"
               class="btn btn-sm btn-outline-success">
              <i class="bi bi-star me-1"></i>
              Rate Teacher
             </a>

@elseif($req->status === 'completed' && $req->review)
  <button type="button" class="btn btn-sm btn-outline-secondary" disabled>
    <i class="bi bi-check2 me-1"></i>
    Rated
  </button>

@else
  <a href="{{ route('student.teacher-details', $req->teacherProfile->id) }}"
     class="btn btn-sm btn-outline-secondary">
    View Teacher
  </a>
@endif

@endif

                </div>

              </div>

            </div>
          </div>
        </div>

      @empty
        <div class="col-12">
          <div class="text-center text-muted py-5 border rounded bg-light">
            <i class="bi bi-inbox display-6 d-block mb-2"></i>
            You have no requests yet.
          </div>
        </div>
      @endforelse

    </div>

     <!-- Footer Note -->
    <div class="text-muted small mt-3">
      You can rate and comment on a teacher only after the request is marked as
      <strong>Completed</strong>.
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
  <div class="pagination-wrapper mt-4 d-flex justify-content-center">
    {{ $requests->links('pagination::bootstrap-5') }}
  </div>
@endif

  

  </div>
</section>
@endsection
