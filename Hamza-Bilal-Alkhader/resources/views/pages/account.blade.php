@extends('layouts.master')

@section('title','Account Setting')

@section('content')
<section class="py-5">
  <div class="container" data-aos="fade-up">

    @php
      $u = auth()->user();
      $role = $u->role ?? 'user';
      $createdAt = optional($u->created_at)->format('d M Y');
    @endphp

    {{-- Alerts --}}
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
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

    <!-- Header -->
    <div class="text-center mb-4">
      <h3 class="mb-1">My Account</h3>
      <p class="text-muted mb-0">
        Manage your personal information and security settings
      </p>

      <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
        <span class="badge bg-light text-dark border px-3 py-2">
          <i class="bi bi-person-badge me-1"></i>
          Role: {{ ucfirst($role) }}
        </span>

        <span class="badge bg-light text-dark border px-3 py-2">
          <i class="bi bi-calendar3 me-1"></i>
          Joined: {{ $createdAt ?? '—' }}
        </span>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-12 col-lg-7">

        <!-- Profile Summary Card -->
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center"
                   style="width:56px;height:56px;">
                <i class="bi bi-person fs-3 text-muted"></i>
              </div>

              <div class="flex-grow-1">
                <div class="fw-semibold fs-5 mb-0">
                  {{ $u->name ?? '—' }}
                </div>
                <div class="text-muted small">
                  <i class="bi bi-envelope me-1"></i>
                  {{ $u->email ?? '—' }}
                </div>
              </div>

              <div class="text-end">
                <span class="badge bg-light text-dark border px-3 py-2">
                  {{ ucfirst($role) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Profile Info (UPDATE) -->
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="mb-0">
                <i class="bi bi-person-lines-fill me-2 text-muted"></i>
                Profile Information
              </h5>
              <span class="text-muted small">Basic details</span>
            </div>

            <form method="POST" action="{{ route('account.update') }}">
              @csrf
              @method('PATCH')

              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">Full Name</label>
                  <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $u->name) }}"
                    required
                  />
                </div>

                <div class="col-12">
                  <label class="form-label">Email</label>
                  <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $u->email) }}"
                    required
                  />
                </div>

                <div class="col-12">
                  <label class="form-label">Phone Number</label>
                  <input
                    type="text"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone', $u->phone) }}"
                    placeholder="07XXXXXXXX"
                    required
                  />
                 
                </div>
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn text-white" style="background-color:#5fcf80">
                  <i class="bi bi-check2-circle me-1"></i>
                  Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Change Password (UPDATE) -->
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="mb-0">
                <i class="bi bi-shield-lock me-2 text-muted"></i>
                Change Password
              </h5>
              <span class="text-muted small">Security</span>
            </div>

            <form method="POST" action="{{ route('account.password.update') }}">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input name="current_password" type="password" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">New Password</label>
                <input name="password" type="password" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input name="password_confirmation" type="password" class="form-control" required />
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-outline-success">
                  <i class="bi bi-arrow-repeat me-1"></i>
                  Update Password
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Delete Account (DELETE) -->
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between gap-3">
              <div>
                <h5 class="text-danger mb-1">
                  <i class="bi bi-exclamation-triangle me-2"></i>
                  Danger Zone
                </h5>
                <p class="text-muted small mb-2">
                  Deleting your account is permanent and cannot be undone.
                </p>

                <div class="small text-muted">
                  To confirm, enter your current password.
                </div>
              </div>
            </div>

            <form method="POST" action="{{ route('account.destroy') }}" class="mt-3 js-delete-account-form">
              @csrf
              @method('DELETE')

              <div class="row g-2 align-items-end">
                <div class="col-12 col-md-8">
                  <label class="form-label">Current Password</label>
                  <input name="current_password" type="password" class="form-control" required />
                </div>

                <div class="col-12 col-md-4 d-grid">
                  <button type="button" class="btn btn-danger js-delete-account-btn">
                    <i class="bi bi-trash me-1"></i>
                    Delete My Account
                  </button>
                </div>
              </div>
            </form>

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
  const btn = document.querySelector('.js-delete-account-btn');
  const form = document.querySelector('.js-delete-account-form');

  if (!btn || !form) return;

  btn.addEventListener('click', function () {
    Swal.fire({
      title: 'Delete your account?',
      text: 'This action cannot be undone.',
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
