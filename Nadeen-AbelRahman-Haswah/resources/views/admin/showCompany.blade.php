@extends('admin.layout.master')

@section('title', 'company')

@section('content')
    <div class="page-inner">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Nav Pills With Icon (Horizontal Tabs)</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center"
                        id="pills-tab-with-icon" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab-icon" data-bs-toggle="pill"
                                href="#pills-home-icon" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                                <i class="icon-home"></i>
                                Company Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab-icon" data-bs-toggle="pill" href="#pills-profile-icon"
                                role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                                <i class="fas fa-user-tie"></i>
                                Manager
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab-icon" data-bs-toggle="pill" href="#pills-contact-icon"
                                role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                                <i class="fas fa-users"></i>
                                Employees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab-icon" data-bs-toggle="pill"
                                href="#pills-Knowledge-icon" role="tab" aria-controls="pills-contact-icon"
                                aria-selected="false">
                                <i class="far fa-envelope"></i>
                                Knowledge items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab-icon" data-bs-toggle="pill" href="#pills-News-icon"
                                role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                                <i class="fas fa-globe"></i>
                                News
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                        <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel"
                            aria-labelledby="pills-home-tab-icon">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="numbers">
                                                <p class="card-category">Workspace Name</p>
                                                <h4 class="card-title">{{ $company->workspace_name }}</h4>
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
                                                        class="badge {{ $company->is_active ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $company->is_active ? 'Active' : 'Suspended' }}
                                                    </span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="numbers">
                                                <p class="card-category">Company Size</p>
                                                <h4 class="card-title">{{ $company->company_size ?? 'N/A' }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="numbers">
                                                <p class="card-category">Industry</p>
                                                <h4 class="card-title">
                                                    {{ $company->industry ?? 'N/A' }}
                                                    @if ($company->industry === 'other' && $company->other_industry)
                                                        <small class="text-muted">({{ $company->other_industry }})</small>
                                                    @endif
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="numbers">
                                                <p class="card-category">Created At</p>
                                                <h4 class="card-title">{{ $company->created_at?->format('d/m/Y') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="numbers">
                                                <p class="card-category">Employees Count</p>
                                                <h4 class="card-title">{{ $company->users->count() }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('admin.companies.edit', $company->id) }}"
                                    class="btn btn-info btn-round">
                                    Edit Company
                                </a>
                                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary btn-round">
                                    Back
                                </a>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel"
                            aria-labelledby="pills-profile-tab-icon">

                            <div class="col-md-12">
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
                                            <div class="name">{{ $owner?->name ?? 'No Owner Found' }}</div>
                                            <div class="job">Company Owner</div>
                                            <div class="desc">{{ $owner?->email ?? '' }}</div>

                                            <div class="view-profile">
                                                <a href="{{ route('admin.companies.edit', $company->id) }}"
                                                    class="btn btn-secondary w-100">
                                                    Edit Company / Owner
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="row user-stats text-center">
                                            <div class="col">
                                                <div class="number">
                                                    {{ $company->users->where('role', 'department_manager')->count() }}
                                                </div>
                                                <div class="title">Managers</div>
                                            </div>
                                            <div class="col">
                                                <div class="number">
                                                    {{ $company->users->where('role', 'employee')->count() }}</div>
                                                <div class="title">Employees</div>
                                            </div>
                                            <div class="col">
                                                <div class="number">{{ $company->users->count() }}</div>
                                                <div class="title">Total Users</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="pills-contact-icon" role="tabpanel"
                            aria-labelledby="pills-contact-tab-icon">

                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>profile pic</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($employees as $emp)
                                            <tr>
                                                <td>
                                                    <div class="avatar">
                                                        <img src="{{ $emp->avatar }}" alt="..."
                                                            class="avatar-img rounded-circle" />
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
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button"
                                                            class="btn btn-success btn-round btn-sm">View</button>
                                                        <button type="button"
                                                            class="btn btn-danger btn-round btn-sm">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No employees found for this
                                                    company.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-Knowledge-icon" role="tabpanel"
                            aria-labelledby="pills-contact-tab-icon">
                            <p class="text-muted">This section will be connected after creating Knowledge Items tables &
                                CRUD.</p>



                        </div>
                        <div class="tab-pane fade" id="pills-News-icon" role="tabpanel"
                            aria-labelledby="pills-contact-tab-icon">


                            <p class="text-muted">This section will be connected after creating Knowledge Items tables &
                                CRUD.</p>

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

    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});

            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-select"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append(
                                        '<option value="' + d + '">' + d + "</option>"
                                    );
                                });
                        });
                },
            });

            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function() {
                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        });
    </script>

@endsection
