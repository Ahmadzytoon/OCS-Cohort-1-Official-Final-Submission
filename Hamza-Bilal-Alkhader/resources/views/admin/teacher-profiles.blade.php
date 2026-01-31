@extends('layouts.master')

@section('title','Admin Dashboard')

@section('content')
    <section class="py-4">
  <div class="container-fluid container-xl" data-aos="fade-up">
    <div class="row g-4">

      <!-- Sidebar -->
      @include('layouts.partials.side')

      <!-- Content -->
      <div class="col-12 col-lg-9">
        <div class="mb-3">
          <h3 class="mb-1">Teacher Profiles</h3>
          <div class="text-muted small">
            Admin controls approval manually
          </div>
        </div>

        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Teacher</th>
                    <th>Subject</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th>Paid</th>
                    <th class="text-end">Actions</th>
                  </tr>
                </thead>

               
                  <tbody>
@forelse($profiles as $p)
  <tr>
    <td>
      <div class="d-flex align-items-center gap-3">
        <img
          src="{{ $p->image_path ? asset('storage/'.$p->image_path) : asset('assets/img/teacher-placeholder.jpg') }}"
          style="width:48px;height:48px;object-fit:cover;border-radius:10px;"
          alt="Teacher"
        />
        <div>
          <div class="fw-semibold">{{ $p->display_name }}</div>
          <div class="text-muted small">{{ $p->phone }}</div>
        </div>
      </div>
    </td>

    <td>{{ $p->subject?->name }}</td>
    <td>{{ $p->branch?->name }}</td>

    <td>
      @if($p->status === 'pending')
        <span class="badge bg-warning text-dark">Pending</span>
      @elseif($p->status === 'approved')
        <span class="badge bg-success">Approved</span>
      @else
        <span class="badge bg-danger">Rejected</span>
      @endif
    </td>

    <td>
      @if($p->is_featured)
        <span class="badge bg-warning text-dark">Yes</span>
      @else
        <span class="badge bg-secondary">No</span>
      @endif
    </td>

    <td class="text-end">
      <div class="d-inline-flex gap-2">

        <a href="{{ route('admin.teacher-profiles.show', $p->id) }}"
           class="btn btn-sm btn-outline-success">
          View Details
        </a>

       {{--<form method="POST" action="{{ route('admin.teacher-profiles.approve', $p->id) }}">
          @csrf
          @method('PATCH')
          <button class="btn btn-sm btn-success" @disabled($p->status === 'approved')>
            Approve
          </button>
        </form>

        <form method="POST" action="{{ route('admin.teacher-profiles.reject', $p->id) }}">
          @csrf
          @method('PATCH')
          <button class="btn btn-sm btn-danger" @disabled($p->status === 'rejected')>
            Reject
          </button>
        </form>--}} 

        <form method="POST" action="{{ route('admin.teacher-profiles.toggleFeatured', $p->id) }}">
          @csrf
          @method('PATCH')
          <button class="btn btn-sm btn-outline-warning">
            {{ $p->is_featured ? 'Unpaid' : 'Paid' }}
          </button>
        </form>

      </div>
    </td>
  </tr>
@empty
  <tr>
    <td colspan="6" class="text-center text-muted py-4">
      No teacher profiles found.
    </td>
  </tr>
@endforelse
</tbody>

               
              </table>
            </div>

            <div class="text-muted small mt-2">
              Status is informational only. Paid indicates whether the teacher profile is featured.
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection