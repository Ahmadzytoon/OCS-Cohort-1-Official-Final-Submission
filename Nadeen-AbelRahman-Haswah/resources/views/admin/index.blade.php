@extends('admin.layout.master')

@section('title', 'Dashboard')

@section('content')

    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-building"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category"> Companies</p>
                                    <h4 class="card-title">{{ number_format($companiesCount) }}</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Total Users</p>
                                    <h4 class="card-title">{{ number_format($usersCount) }}</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-info card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Active Users</p>
                                    <h4 class="card-title">{{ number_format($activeUsersCount) }}</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-success card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Knowledge </p>
                                    <h4 class="card-title">{{ number_format($knowledgeCount) }}</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <h4 class="card-title">Users</h4>
                            <div class="card-tools">
                                <a href="{{ route('admin.users.index') }}"><button class="btn  btn-primary ">
                                        View All
                                    </button></a>

                            </div>
                        </div>
                        {{-- <p class="card-category">
                            lastest users
                        </p> --}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table">
                                        <thead>
                                            <th>Profile Pic</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>role</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @forelse($latestUsers as $user)
                                                <tr>
                                                    <td>
                                                        <div class="avatar avatar-sm">
                                                            <img src="{{ $user->avatar }}" class="avatar-img rounded-circle"
                                                                alt="pic" />
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.users.show', $user->id) }}">
                                                            <button class="btn btn-success btn-round">View</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No users yet</td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="mapcontainer">
                                    <div id="world-map" class="w-100" style="height: 300px"></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Lastest Companies</div>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-list py-4">
                            <div class="item-list">
                                <div class="info-user text-info ms-2">
                                    <div>Company owner</div>
                                </div>
                                <div class="info-user text-info ms-5">
                                    <div>Company name</div>
                                </div>
                            </div>

                            @forelse($latestCompanies as $company)
                                <div class="item-list">
                                    <div class="avatar">
                                        <span class="avatar-title rounded-circle border border-white bg-primary">
                                            {{ strtoupper(substr($company->owner->name, 0, 1)) }}
                                        </span>
                                    </div>

                                    <div class="info-user ms-3">
                                        <div class="username">
                                            {{ optional($company->owner)->name ?? '—' }}
                                        </div>
                                    </div>

                                    <div class="info-user ms-3">
                                        <div>{{ $company->workspace_name }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-3">No companies yet</div>
                            @endforelse
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Departments</div>

                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Department Members</th>
                                        <th scope="col" class="text-end">Department Manager</th>
                                        <th scope="col" class="text-end">Department Title</th>
                                        <th scope="col" class="text-end">Totls members</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestDepartments as $dept)
                                        <tr>
                                            <th scope="row">
                                                <div class="avatar-group">
                                                    {{-- نعرض أول 4 موظفين --}}
                                                    @foreach ($dept->users->take(4) as $u)
                                                        <div class="avatar">
                                                            <span class="avatar-title rounded-circle border border-white">
                                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </th>

                                            <td class="text-end">{{ optional($dept->manager)->name ?? '—' }}</td>

                                            <td class="text-end">
                                                <span class="badge badge-success">{{ $dept->name }}</span>
                                            </td>

                                            <td class="text-end">{{ $dept->users_count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No departments yet</td>
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

@endsection
