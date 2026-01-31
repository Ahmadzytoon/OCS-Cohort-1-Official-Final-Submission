@extends('admin.layout.master')

@section('title', 'All Departments')

@section('content')
    <div class="page-inner">
        <div class="page-header">
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
                    <a href="#">Departments</a>
                </li>
            </ul>
        </div>
        <div class="row">


            <div class="col-md-12">
                <div class="card">


                    <div class="card-header">
                        <form method="GET" action="{{ route('admin.departments.index') }}" class="mb-3">
                            <div class="input-group">

                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by department / manager / company..."
                                        value="{{ $search ?? request('search') }}">
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-primary w-30" type="submit"><i class="fas fa-search">
                                        </i></button>
                                </div>

                                <div class="col-md-1">
                                    <a class="btn btn-secondary w-30" href="{{ route('admin.departments.index') }}"><i
                                            class="fas fa-history"></i></a>
                                </div>
                            </div>
                        </form>
                        <div class="d-flex align-items-center  justify-content-between">
                            <h4 class="card-title">All Departmenets</h4>
                            <a href="{{ route('admin.departments.create') }}">
                                <button class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Add Department
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>

                                        <th>Title</th>
                                        <th>Department manager</th>
                                        <th>Employees count</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($departments as $department)
                                        <tr>
                                            <td>{{ $department->name }}</td>

                                            <td>{{ $department->manager?->name ?? 'N/A' }}</td>

                                            <td>{{ $department->users_count }}</td>

                                            <td>
                                                <div class="form-button-action">

                                                    <a href="{{ route('admin.departments.show', $department->id) }}">
                                                        <button type="button"
                                                            class="btn btn-primary btn-round btn-sm">View</button>
                                                    </a>

                                                    <a href="{{ route('admin.departments.edit', $department->id) }}">
                                                        {{-- {{ route('admin.departments.edit', $department->id) }} --}}
                                                        <button type="button"
                                                            class="btn btn-success btn-round btn-sm">Edit</button>
                                                    </a>

                                                    <form action="{{ route('admin.departments.destroy', $department->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger btn-round btn-sm btn-delete-dept">Delete</button>
                                                    </form>


                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No departments found</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of
                                    {{ $departments->total() }} entries
                                </div>
                                <nav aria-label="Page navigation">
                                    {{ $departments->links('pagination::bootstrap-5') }}
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.btn-delete-dept').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This department will be deleted!",
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


@endsection
