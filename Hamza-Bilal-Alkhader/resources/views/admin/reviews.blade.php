@extends('layouts.master')

@section('title','Admin Dashboard')

@section('content')
<section class="py-4">
  <div class="container-fluid container-xl" data-aos="fade-up">
    <div class="row g-4">

      @include('layouts.partials.side')

      <div class="col-12 col-lg-9">
        <div class="mb-3">
          <h3 class="mb-1">Reviews</h3>
          <div class="text-muted small">View and manage teacher reviews</div>
        </div>

        @if (session('success'))
          <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger small">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="fw-semibold">All Reviews</div>
              <div class="text-muted small">Showing {{ $reviews->count() }} reviews</div>
            </div>

            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Student</th>
                    <th>Teacher</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Created</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>

                <tbody>
                  @forelse($reviews as $r)
                    @php
                      $studentName = $r->serviceRequest?->student?->name ?? '—';
                      $teacherName = $r->serviceRequest?->teacherProfile?->display_name ?? '—';
                    @endphp

                    <tr>
                      <td>{{ $studentName }}</td>
                      <td>{{ $teacherName }}</td>

                      <td>
                        <i class="bi bi-star-fill text-warning"></i>
                        {{ $r->rating }}
                      </td>

                      <td style="max-width: 320px">
                        <div class="small" style="white-space: nowrap; overflow-x: auto">
                          {{ $r->comment ?: 'No comment.' }}
                        </div>
                      </td>

                      <td class="text-muted small">{{ $r->created_at->format('Y-m-d') }}</td>

                      <td class="text-end">
                        <form method="POST"
                              action="{{ route('admin.reviews.destroy', $r->id) }}"
                              class="delete-form d-inline">
                          @csrf
                          @method('DELETE')

                          <button type="button" class="btn btn-sm btn-outline-danger btn-delete">
                            Delete
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center text-muted py-4">
                        No reviews found.
                      </td>
                    </tr>
                  @endforelse
                </tbody>

              </table>
            </div>

            <div class="text-muted small mt-2">
              Deleting a review will remove it permanently from the system.
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
  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', () => {
      const form = button.closest('.delete-form');

      Swal.fire({
        title: 'Confirm action',
        text: 'Are you sure you want to delete this review?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
</script>
@endsection
