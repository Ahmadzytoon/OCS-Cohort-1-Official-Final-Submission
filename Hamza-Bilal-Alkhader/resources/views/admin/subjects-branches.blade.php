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
          <h3 class="mb-1">Subjects & Branches</h3>
          <div class="text-muted small">
            Manage available subjects and branches
          </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
          <div class="alert alert-success small">{{ session('success') }}</div>
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

        <div class="row g-4">

          <!-- Add Subject -->
          <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h5 class="mb-3">Add Subject</h5>

                <form method="POST" action="{{ route('admin.subjects.store') }}">
                  @csrf

                  <div class="mb-3">
                    <label class="form-label">Subject Name</label>
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      placeholder="e.g. Math"
                      value="{{ old('name') }}"
                    />
                  </div>

                  <div class="d-grid">
                    <button class="btn text-white" style="background-color:#5fcf80">
                      Add Subject
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>

          <!-- Add Branch -->
          <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h5 class="mb-3">Add Branch</h5>

                <form method="POST" action="{{ route('admin.branches.store') }}">
                  @csrf

                  <div class="mb-3">
                    <label class="form-label">Branch Name</label>
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      placeholder="e.g. Scientific"
                      value="{{ old('name') }}"
                    />
                  </div>

                  <div class="d-grid">
                    <button class="btn text-white" style="background-color:#5fcf80">
                      Add Branch
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>

          <!-- Subjects Table -->
          <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h5 class="mb-3">Subjects</h5>

                <div class="table-responsive">
                  <table class="table align-middle">
                    <thead class="table-light">
                      <tr>
                        <th>Name</th>
                        <th class="text-end">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @forelse($subjects as $s)
                        <tr>
                          <td>{{ $s->name }}</td>
                          <td class="text-end text-muted small">—</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="2" class="text-center text-muted py-4">
                            No subjects found.
                          </td>
                        </tr>
                      @endforelse
                    </tbody>

                  </table>
                </div>

              </div>
            </div>
          </div>

          <!-- Branches Table -->
          <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h5 class="mb-3">Branches</h5>

                <div class="table-responsive">
                  <table class="table align-middle">
                    <thead class="table-light">
                      <tr>
                        <th>Name</th>
                        <th class="text-end">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @forelse($branches as $b)
                        <tr>
                          <td>{{ $b->name }}</td>
                          <td class="text-end text-muted small">—</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="2" class="text-center text-muted py-4">
                            No branches found.
                          </td>
                        </tr>
                      @endforelse
                    </tbody>

                  </table>
                </div>

              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
