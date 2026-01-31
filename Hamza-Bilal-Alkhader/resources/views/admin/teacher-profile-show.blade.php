@extends('layouts.master')

@section('title','Admin Dashboard')

@section('content')
<section class="py-4">
  <div class="container-fluid container-xl" data-aos="fade-up">
    <div class="row g-4">

      {{-- Sidebar --}}
      @include('layouts.partials.side')

      {{-- Content --}}
      <div class="col-12 col-lg-9">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h3 class="mb-1">Teacher Profile</h3>
            <div class="text-muted small">Review teacher information before approval</div>
          </div>

          <a href="{{ route('admin.teacher-profiles') }}"
             class="btn btn-sm btn-outline-secondary">
            ← Back
          </a>
        </div>

        {{-- Messages --}}
        @if (session('success'))
          <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger small">{{ session('error') }}</div>
        @endif

        {{-- Profile Card --}}
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <div class="d-flex flex-column flex-md-row gap-4">

              {{-- Image --}}
              <img
                src="{{ $profile->image_path ? asset('storage/'.$profile->image_path) : asset('assets/img/teacher-placeholder.jpg') }}"
                alt="Teacher"
                style="width:160px;height:160px;object-fit:cover;border-radius:12px"
              />

              {{-- Info --}}
              <div class="flex-grow-1">
                <h4 class="mb-1">{{ $profile->display_name }}</h4>

                <div class="text-muted mb-2">
                  {{ $profile->subject?->name }} • {{ $profile->branch?->name }}
                </div>

                <div class="row g-2 small mb-3">
                  <div class="col-md-6">
                    <strong>Phone:</strong> {{ $profile->phone }}
                  </div>

                  <div class="col-md-6">
                    <strong>Experience:</strong> {{ $profile->experience_years }} years
                  </div>

                  <div class="col-md-6">
                    <strong>Status:</strong>
                    @if($profile->status === 'pending')
                      <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($profile->status === 'approved')
                      <span class="badge bg-success">Approved</span>
                    @else
                      <span class="badge bg-danger">Rejected</span>
                    @endif
                  </div>

                  <div class="col-md-6">
                    <strong>Paid:</strong>
                    @if($profile->is_featured)
                      <span class="badge bg-warning text-dark">Yes</span>
                    @else
                      <span class="badge bg-secondary">No</span>
                    @endif
                  </div>
                </div>

                <hr>

                <h6>About</h6>
              <div
  class="text-muted small"
  style="
    max-height: 120px;
    overflow-y: auto;
    padding-right: 6px;

    white-space: normal;
    overflow-wrap: anywhere;
    word-break: break-word;
  "
>
  {{ $profile->bio ?: 'No bio provided.' }}
</div>
              </div>
            </div>
          </div>
        </div>

        {{-- Actions --}}
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="mb-3">Actions</h5>

            <div class="d-inline-flex gap-2 flex-wrap">

              {{-- Approve --}}
              <form method="POST"
                    action="{{ route('admin.teacher-profiles.approve', $profile->id) }}">
                @csrf
                @method('PATCH')
                <button
                  class="btn btn-sm btn-success {{ $profile->status === 'approved' ? 'opacity-50' : '' }}"
                  {{ $profile->status === 'approved' ? 'disabled style=pointer-events:none' : '' }}>
                  Approve
                </button>
              </form>

              {{-- Reject --}}
              <form method="POST"
                    action="{{ route('admin.teacher-profiles.reject', $profile->id) }}">
                @csrf
                @method('PATCH')
                <button
                  class="btn btn-sm btn-danger {{ $profile->status === 'rejected' ? 'opacity-50' : '' }}"
                  {{ $profile->status === 'rejected' ? 'disabled style=pointer-events:none' : '' }}>
                  Reject
                </button>
              </form>

              {{-- Paid --}}
              <form method="POST"
                    action="{{ route('admin.teacher-profiles.toggleFeatured', $profile->id) }}">
                @csrf
                @method('PATCH')
                <button class="btn btn-sm btn-outline-warning">
                  {{ $profile->is_featured ? 'Unpaid' : 'Paid' }}
                </button>
              </form>

            </div>

            <div class="text-muted small mt-3">
              Approval controls visibility for students. Paid status controls priority in teachers list.
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
