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
          <h3 class="mb-1">Teachers</h3>
          <div class="text-muted small">
            View and manage teacher accounts
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
              <div class="fw-semibold">All Teachers</div>
              <div class="text-muted small">Showing {{ $teachers->count() }} teachers</div>
            </div>

            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Teacher</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>

                <tbody>
                  @forelse($teachers as $t)
                    <tr>
                      <td>
                        <div class="fw-semibold">{{ $t->name }}</div>
                      </td>
                      <td>{{ $t->email }}</td>
                      <td>{{ $t->phone }}</td>
                      <td class="text-muted small">{{ $t->created_at->format('Y-m-d') }}</td>
                      <td class="text-end">
                        <form method="POST"
                              action="{{ route('admin.teachers.destroy', $t->id) }}"
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
                      <td colspan="5" class="text-center text-muted py-4">
                        No teachers found.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="text-muted small mt-2">
              Deleting a teacher will remove the user account and all related data.
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
        text: 'Are you sure you want to delete this teacher?',
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
