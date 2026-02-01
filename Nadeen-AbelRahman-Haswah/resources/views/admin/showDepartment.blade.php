@extends('admin.layout.master')

@section('title', 'show Department')

@section('content')
    <div class="page-inner">

        {{-- SweetAlert Success --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif

        {{-- Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    {{-- Header --}}
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">{{ $department->name }}</h4>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary btn-round btn-sm">
                                Back
                            </a>

                            <button type="button" class="btn btn-primary btn-round btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addEmployeesModal">
                                + Add Employees
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- Tabs --}}
                        <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">
                                    Description
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">
                                    Manager
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact"
                                    role="tab" aria-controls="pills-contact" aria-selected="false">
                                    Employees ({{ $department->users->count() }})
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Contents --}}
                        <div class="tab-content mt-3" id="pills-tabContent">

                            {{-- Description Tab --}}
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-stats card-round">
                                            <div class="card-body">
                                                <div class="numbers">
                                                    <p class="card-category">Company</p>
                                                    <h4 class="card-title">
                                                        {{ $department->company?->workspace_name ?? 'N/A' }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card card-stats card-round">
                                            <div class="card-body">
                                                <div class="numbers">
                                                    <p class="card-category">Status</p>
                                                    <h4 class="card-title">
                                                        <span
                                                            class="badge {{ $department->is_active ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $department->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card card-stats card-round">
                                            <div class="card-body">
                                                <div class="numbers">
                                                    <p class="card-category">Description</p>
                                                    <h4 class="card-title" style="font-size: 16px;">
                                                        {{ $department->description ?? 'No description provided.' }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Manager Tab --}}
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">

                                @if ($department->manager)
                                    <div class="card card-profile">
                                        <div class="card-header"
                                            style="background-image: url('{{ asset('admin/assets/img/blogpost.jpg') }}')">
                                            <div class="profile-picture">
                                                <div class="avatar avatar-xl">
                                                    <img src="{{ asset('admin/assets/img/profile.jpg') }}" alt="..."
                                                        class="avatar-img rounded-circle" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="user-profile text-center">
                                                <div class="name">{{ $department->manager->name }}</div>
                                                <div class="job">{{ $department->manager->role }}</div>
                                                <div class="desc">{{ $department->manager->email }}</div>

                                                <div class="view-profile mt-3">
                                                    <a href="{{ route('admin.users.show', $department->manager->id) }}"
                                                        class="btn btn-secondary w-100">
                                                        View Manager Profile
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <div class="row user-stats text-center">
                                                <div class="col">
                                                    <div class="number">{{ $department->users->count() }}</div>
                                                    <div class="title">Employees</div>
                                                </div>
                                                <div class="col">
                                                    <div class="number">{{ $department->created_at?->format('d/m/Y') }}
                                                    </div>
                                                    <div class="title">Created</div>
                                                </div>
                                                <div class="col">
                                                    <div class="number">
                                                        {{ $department->company?->workspace_name ?? 'N/A' }}</div>
                                                    <div class="title">Company</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-info mb-0">
                                        No manager assigned to this department yet.
                                    </div>
                                @endif

                            </div>

                            {{-- Employees Tab --}}
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Employees List</h5>

                                    {{-- <button type="button" class="btn btn-primary btn-round btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#addEmployeesModal">
                                        + Add Employees
                                    </button> --}}
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Avatar</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($department->users as $emp)
                                                <tr>
                                                    <td>
                                                        <div class="avatar">
                                                            <img src="{{ asset('admin/assets/img/profile.jpg') }}"
                                                                class="avatar-img rounded-circle" alt="...">
                                                        </div>
                                                    </td>
                                                    <td>{{ $emp->name }}</td>
                                                    <td>{{ $emp->role }}</td>
                                                    <td>{{ $emp->email }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $emp->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $emp->status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No employees in this department
                                                        yet.</td>
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

    {{-- Add Employees Modal --}}
    <div class="modal fade" id="addEmployeesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Add Employees to {{ $department->name }}
                        <small class="text-muted">({{ $department->company?->workspace_name ?? 'N/A' }})</small>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.departments.employees.store', $department->id) }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Select Employees (same company only)</label>

                            <select name="employee_ids[]" class="form-control" multiple size="10" required>
                                @foreach ($availableUsers as $u)
                                    <option value="{{ $u->id }}">
                                        {{ $u->name }} - {{ $u->email }}
                                    </option>
                                @endforeach
                            </select>

                            <small class="text-muted">Hold Ctrl (Windows) / Cmd (Mac) to select multiple.</small>
                        </div>

                        @if ($availableUsers->isEmpty())
                            <div class="alert alert-warning mt-3 mb-0">
                                No available employees found for this company (users without department).
                            </div>
                        @endif

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Employees</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection
