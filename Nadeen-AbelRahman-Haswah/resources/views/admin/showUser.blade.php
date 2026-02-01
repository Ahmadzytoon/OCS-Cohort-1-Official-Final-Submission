@extends('admin.layout.master')

@section('title', 'user')

@section('content')
    <div class="page-inner">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Details</h4>
                </div>

                <div class="card-body">
                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-pills-icons justify-content-center"
                        id="pills-tab-with-icon" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="pills-user-tab" data-bs-toggle="pill" href="#pills-user"
                                role="tab" aria-controls="pills-user" aria-selected="true">
                                <i class="fas fa-user"></i>
                                User Information
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="pills-company-tab" data-bs-toggle="pill" href="#pills-company"
                                role="tab" aria-controls="pills-company" aria-selected="false">
                                <i class="fas fa-building"></i>
                                Company & Department
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="pills-knowledge-tab" data-bs-toggle="pill" href="#pills-knowledge"
                                role="tab" aria-controls="pills-knowledge" aria-selected="false">
                                <i class="far fa-envelope"></i>
                                Knowledge Cards
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="pills-with-icon-tabContent">

                        {{-- Tab 1: User Information --}}
                        <div class="tab-pane fade show active" id="pills-user" role="tabpanel"
                            aria-labelledby="pills-user-tab">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="{{ $user->avatar }}" class="rounded-circle mb-3" width="120"
                                        alt="avatar">
                                    <h4 class="mb-0">{{ $user->name }}</h4>
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-stats card-round">
                                                <div class="card-body">
                                                    <p class="card-category">Role</p>
                                                    <h4 class="card-title">{{ $user->role }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card card-stats card-round">
                                                <div class="card-body">
                                                    <p class="card-category">Status</p>
                                                    <h4 class="card-title">
                                                        <span
                                                            class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $user->status }}
                                                        </span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card card-stats card-round">
                                                <div class="card-body">
                                                    <p class="card-category">Phone</p>
                                                    <h4 class="card-title">{{ $user->phone ?? 'N/A' }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card card-stats card-round">
                                                <div class="card-body">
                                                    <p class="card-category">Position</p>
                                                    <h4 class="card-title">{{ $user->position ?? 'N/A' }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card card-stats card-round">
                                                <div class="card-body">
                                                    <p class="card-category">Joined At</p>
                                                    <h4 class="card-title">{{ $user->joined_at?->format('d/m/Y') ?? 'N/A' }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card card-stats card-round">
                                                <div class="card-body">
                                                    <p class="card-category">Last Login</p>
                                                    <h4 class="card-title">
                                                        {{ $user->last_login_at?->format('d/m/Y H:i') ?? 'N/A' }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-round">
                                    Back
                                </a>
                            </div>
                        </div>

                        {{-- Tab 2: Company & Department --}}
                        <div class="tab-pane fade" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <p class="card-category">Company</p>
                                            <h4 class="card-title">{{ $user->company?->workspace_name ?? 'N/A' }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <p class="card-category">Department</p>
                                            <h4 class="card-title">{{ $user->department?->name ?? 'N/A' }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-2">
                                    @if ($user->company)
                                        <a href="{{ route('admin.companies.show', $user->company->id) }}"
                                            class="btn btn-info btn-round">
                                            View Company
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Tab 3: Knowledge Cards (Placeholder for now) --}}
                        <div class="tab-pane fade" id="pills-knowledge" role="tabpanel"
                            aria-labelledby="pills-knowledge-tab">
                            @if ($knowledgeItems->isEmpty())
                                <p class="text-muted mb-0">
                                    Knowledge cards will appear here after creating Knowledge Items tables & CRUD.
                                </p>
                            @else
                                {{-- لاحقًا: table/cards --}}
                            @endif
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
