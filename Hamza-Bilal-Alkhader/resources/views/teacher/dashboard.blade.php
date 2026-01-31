@extends('layouts.master')

@section('title','Teacher Dashboard')

@section('content')
     <section class="py-4">
        <div class="container" data-aos="fade-up">
          <!-- Header -->
          <div
            class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4"
          >
            <div>
              <h3 class="mb-1">Teacher Panel</h3>
              <div class="text-muted small">
                Manage your profile and student service requests
              </div>
            </div>

             
          </div>

          @if (session('success'))
  <div class="alert alert-success small">
    {{ session('success') }}
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger small">
    {{ session('error') }}
  </div>
@endif

@if ($errors->any())
  <div class="alert alert-danger small">
    <ul class="mb-0">
      @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif


    {{-- Info Message --}}
@if(!$profile)
  <div class="alert alert-info small">
    You haven’t created your teacher profile yet.  
    Please fill in your information and submit your profile for admin review.
  </div>

@elseif($profile->status === 'pending')
  <div class="alert alert-warning small">
    Your profile is under review. Students will not see your profile until admin approval.
  </div>

@elseif($profile->status === 'rejected')
  <div class="alert alert-danger small">
    Your profile was rejected. Please update your information and submit again.
  </div>

@elseif($profile->status === 'approved')
  <div class="alert alert-success small">
    Your profile is approved and visible to students.
  </div>
@endif


          <div class="row g-4">
            <!-- Teacher Profile -->
            <div class="col-12 col-lg-5">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5 class="mb-3">Teacher Profile</h5>

                    <form method="POST" action="{{ route('teacher.profile.save') }}" enctype="multipart/form-data">
  @csrf

  <div class="mb-3 text-center">
    <img
      src="{{ $profile && $profile->image_path ? asset('storage/'.$profile->image_path) : asset('assets/img/teacher-placeholder.jpg') }}"
      alt="Teacher Image"
      class="rounded-circle mb-2"
      style="width: 120px; height: 120px; object-fit: cover"
    />
    <label class="form-label d-block">Profile Image</label>
    <input type="file" name="image" class="form-control" />
  </div>

  <div class="mb-3">
    <label class="form-label">Display Name</label>
    <input type="text" name="display_name" class="form-control"
      value="{{ old('display_name', $profile->display_name ?? '') }}">
  </div>

  <div class="mb-3">
    <label class="form-label">Subject</label>
    <select name="subject_id" class="form-select">
      <option disabled {{ !$profile ? 'selected' : '' }}>Select subject</option>
      @foreach($subjects as $s)
        <option value="{{ $s->id }}"
          @selected(old('subject_id', $profile->subject_id ?? null) == $s->id)>
          {{ $s->name }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Branch</label>
    <select name="branch_id" class="form-select">
      <option disabled {{ !$profile ? 'selected' : '' }}>Select branch</option>
      @foreach($branches as $b)
        <option value="{{ $b->id }}"
          @selected(old('branch_id', $profile->branch_id ?? null) == $b->id)>
          {{ $b->name }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Experience (Years)</label>
    <input type="number" name="experience_years" class="form-control"
      value="{{ old('experience_years', $profile->experience_years ?? 0) }}">
  </div>

  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control"
      value="{{ old('phone', $profile->phone ?? '') }}">
  </div>

  <div class="mb-3">
    <label class="form-label">About</label>
    <textarea name="bio" class="form-control" rows="4">{{ old('bio', $profile->bio ?? '') }}</textarea>
  </div>

  <div class="d-grid">
    <button type="submit" class="btn text-white" style="background-color:#5fcf80">
      {{ $profile ? 'Update Profile' : 'Send For Approval' }}
    </button>
  </div>
</form>

@if($profile && in_array($profile->status, ['pending', 'rejected']))
<form method="POST" action="{{ route('teacher.profile.delete') }}" class="mt-2">
  @csrf
  @method('DELETE')
  <button type="submit" class="btn btn-outline-danger w-100">
    Delete / Withdraw Profile
  </button>
</form>
@endif


                </div>
              </div>
            </div>

            <!-- Requests Table -->
            <div class="col-12 col-lg-7">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <div
                    class="d-flex justify-content-between align-items-center mb-3"
                  >
                    <h5 class="mb-0">Student Service Requests</h5>
                    <span class="text-muted small">
                      Accept / Cancel / Complete
                    </span>
                  </div>

                  <div class="table-responsive">
                    <table class="table align-middle">
                      <thead class="table-light">
                        <tr>
                          <th>Student</th>
                          <th>Phone</th>
                          <th>Status</th>
                          <th class="text-end">Actions</th>
                        </tr>
                      </thead>
           <tbody>
  @forelse($requests as $req)
    @php
      $badgeClass = match($req->status) {
        'pending'   => 'bg-warning text-dark',
        'accepted'  => 'bg-info text-dark',
        'completed' => 'bg-success',
        'rejected'  => 'bg-danger',
        default     => 'bg-secondary',
      };
    @endphp

    <tr>
      <td>
        <div class="fw-semibold">{{ $req->student?->name ?? 'Student' }}</div>
        
        <div class="text-muted small">
          <i class="bi bi-calendar3 me-1"></i>
          {{ $req->created_at->format('d M Y') }}
        </div>
      </td>

      <td class="text-muted">{{ $req->student?->phone ?? '—' }}</td>

      <td>
        <span class="badge {{ $badgeClass }}">
          {{ ucfirst($req->status) }}
        </span>
      </td>

      <td class="text-end">
        <div class="d-inline-flex gap-2">

          {{-- Accept: فقط لو Pending --}}
          @if($req->status === 'pending')
            <form method="POST" action="{{ route('teacher.requests.accept', $req->id) }}">
              @csrf
              @method('PATCH')
              <button class="btn btn-sm text-white" style="background-color:#5fcf80">
                Accept
              </button>
            </form>
          @endif

          {{-- Reject: لو Pending أو Accepted --}}
          @if(in_array($req->status, ['pending', 'accepted']))
            <form method="POST" action="{{ route('teacher.requests.reject', $req->id) }}">
              @csrf
              @method('PATCH')
              <button class="btn btn-sm btn-outline-danger">
                Reject
              </button>
            </form>
          @endif

          {{-- Complete: فقط لو Accepted --}}
          @if($req->status === 'accepted')
            <form method="POST" action="{{ route('teacher.requests.complete', $req->id) }}">
              @csrf
              @method('PATCH')
              <button class="btn btn-sm btn-outline-success">
                Complete
              </button>
            </form>
          @endif

          {{-- Completed/Rejected --}}
          @if(in_array($req->status, ['completed','rejected']))
            <button class="btn btn-sm btn-secondary" disabled>Done</button>
          @endif

        </div>
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="4" class="text-center text-muted py-4">
        No requests yet.
      </td>
    </tr>
  @endforelse
</tbody>

                    </table>
                  </div>

                  <div class="text-muted small">
                    Tip: Mark the request as <strong>Completed</strong> after
                    finishing the service so the student can rate you.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection