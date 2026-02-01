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
        <!-- Header -->
        <div class="mb-3">
          <h3 class="mb-1">Students</h3>
          <div class="text-muted small">
            View and manage registered students
          </div>
        </div>

        @if (session('success'))
          <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger small">{{ session('error') }}</div>
        @endif

        <!-- Table -->
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="fw-semibold">All Students</div>
              <div class="text-muted small">
                Showing {{ $students->count() }} students
              </div>
            </div>

            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>

                <tbody>
                  @forelse($students as $s)
                    <tr>
                      <td>
                        <div class="fw-semibold">{{ $s->name }}</div>
                      </td>
                      <td>{{ $s->email }}</td>
                      <td>{{ $s->phone }}</td>
                      <td class="text-muted small">
                        {{ $s->created_at->format('Y-m-d') }}
                      </td>
                      <td class="text-end">
                        <form method="POST"
                              action="{{ route('admin.students.destroy', $s->id) }}"
                              class="delete-form d-inline">
                          @csrf
                          @method('DELETE')

                          <button type="button"
                                  class="btn btn-sm btn-outline-danger btn-delete">
                            Delete
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center text-muted py-4">
                        No students found.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="text-muted small mt-2">
              Deleting a student will remove the account permanently.
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
        text: 'Are you sure you want to delete this student?',
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
