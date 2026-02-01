@extends('admin.layout.master')

@section('title', 'Companies')


@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">DataTables.Net</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Home</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Users</a>
                </li>
            </ul>
        </div>
        <div class="row">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form method="GET" action="{{ route('admin.companies.index') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="q" class="form-control"
                                        placeholder="Search company..." value="{{ request('q') }}">
                                </div>

                                <div class="col-md-1">
                                    <button class="btn btn-primary w-30" type="submit"><i class="fas fa-search">
                                        </i></button>
                                </div>

                                <div class="col-md-1">
                                    <a class="btn btn-secondary w-30" href="{{ route('admin.companies.index') }}"><i
                                            class="fas fa-history"></i></a>
                                </div>
                            </div>
                        </form>

                        <div class="d-flex align-items-center  justify-content-between">
                            <h4 class="card-title">All Companies</h4>

                            <a href="{{ route('admin.addCompany') }}">
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#addRowModal">
                                    <i class="fa fa-plus"></i>
                                    Add Company
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">



                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Owner</th>
                                        <th Name>Number of employees</th>
                                        <th>Date Created</th>
                                        <th>Status (Active / Suspended)</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if ($companies->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">No companies found</td>
                                        </tr>
                                    @endif
                                    @foreach ($companies as $company)
                                        @php
                                            $owner = $company->users->where('role', 'company_owner')->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $company->company_name ?? $company->workspace_name }}</td>

                                            <td>{{ $owner->name ?? 'N/A' }}</td>

                                            <td>{{ $company->users->count() }}</td>

                                            <td>{{ $company->created_at->format('d/m/Y') }}</td>

                                            <td>
                                                <span class="badge {{ $company->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $company->is_active ? 'Active' : 'Suspended' }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="form-button-action">
                                                    <a href=" {{ route('admin.companies.show', $company->id) }}">
                                                        <button type="button"
                                                            class="btn btn-success btn-round btn-sm">View</button>
                                                    </a>

                                                    <a href="{{ route('admin.companies.edit', $company->id) }}">

                                                        <button type="button"
                                                            class="btn btn-info btn-round btn-sm">Edit</button>
                                                    </a>

                                                    <form action="{{ route('admin.companies.destroy', $company->id) }}"
                                                        method="POST" style="display:inline;" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger btn-round btn-sm btn-delete">Delete</button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }} of
                                    {{ $companies->total() }} entries
                                </div>
                                <nav aria-label="Page navigation">
                                    {{ $companies->links('pagination::bootstrap-5') }}
                                </nav>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('js')
    <!-- Datatables -->
    <script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('admin/assets/js/kaiadmin.min.js') }}"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('admin/assets/js/setting-demo2.js') }}"></script>


@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('form[data-delete-form]').forEach((form) => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'This company will be deleted!',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Done',
                text: @json(session('success')),
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This company will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection
