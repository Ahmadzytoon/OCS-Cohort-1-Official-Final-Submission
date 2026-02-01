@extends('admin.layout.master')

@section('title', 'subscriptions')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Subscriptions</h3>
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
                    <a href="#">Subscriptions</a>
                </li>
            </ul>
        </div>
        <div class="table-responsive">
            <div class="mb-3 d-flex justify-content-end">
                <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2"
                        placeholder="Search by company, plan or status..." value="{{ $search ?? '' }}">
                    <button class="btn btn-primary">Search</button>
                </form>
            </div>

            <table id="subscriptions-table" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Plan</th>
                        <th>Users</th>
                        <th>Subscription Status</th>
                        <th>Started At</th>
                        <th>Ends At</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($subscriptions as $sub)
                        @php
                            $company = $sub->company;
                            $plan = $sub->plan;

                            $usedUsers = $company?->users?->count() ?? 0;
                            $maxUsers = $plan?->max_users ?? 0; // 0 = unlimited
                            $usersText = $maxUsers == 0 ? "{$usedUsers} / Unlimited" : "{$usedUsers} / {$maxUsers}";

                            $statusClass = match ($sub->status) {
                                'active' => 'bg-success',
                                'trial' => 'bg-info',
                                'expired' => 'bg-secondary',
                                'cancelled' => 'bg-danger',
                                'suspended' => 'bg-warning',
                                default => 'bg-secondary',
                            };
                        @endphp

                        <tr>
                            <td>{{ $company?->workspace_name ?? 'N/A' }}</td>

                            <td>
                                <span class="badge bg-primary">{{ $plan?->name ?? 'N/A' }}</span>
                            </td>

                            <td>{{ $usersText }}</td>

                            <td>
                                <span class="badge {{ $statusClass }}">{{ ucfirst($sub->status) }}</span>
                            </td>

                            <td>{{ $sub->starts_at?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $sub->ends_at?->format('d/m/Y') ?? '-' }}</td>

                            <td>
                                <div class="form-button-action">
                                    @if ($company)
                                        <a href="{{ route('admin.companies.show', $company->id) }}">
                                            <button type="button" class="btn btn-icon btn-success btn-round btn-sm"
                                                data-bs-toggle="tooltip" title="View Company">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </a>
                                    @endif

                                    {{-- لاحقًا: suspend/cancel --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No subscriptions found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
            {{-- {{ $subscriptions->links() }} --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $subscriptions->firstItem() }} to {{ $subscriptions->lastItem() }} of
                    {{ $subscriptions->total() }} entries
                </div>
                <nav aria-label="Page navigation">
                    {{ $subscriptions->links('pagination::bootstrap-5') }}
                </nav>
            </div>

        </div>

    </div>

@endsection
