@extends('admin.layout.master')

@section('title', 'Studio Approvals')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/approval.css') }}">
@endsection

@section('content')
<div class="container-fluid main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Studio Approvals</h1>
            <p class="text-muted mb-0">Review and approve studio applications</p>
        </div>
        <div class="page-actions">
            <a href="#" class="btn-primary-custom">
                <i class="fas fa-download"></i> Export Report
            </a>
        </div>
    </div>

    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-building"></i></div>
            <div class="stat-info">
                <h3>{{ number_format($totalApplications ?? 0) }}</h3>
                <p>Total Applications</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon approved"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <h3>{{ number_format($approvedCount ?? 0) }}</h3>
                <p>Approved Studios</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon pending"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <h3>{{ number_format($pendingCount ?? 0) }}</h3>
                <p>Pending Approvals</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon rejected"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <h3>{{ number_format($rejectedCount ?? 0) }}</h3>
                <p>Rejected Applications</p>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="card-header">
            <h3 class="card-title">Studio Applications</h3>

            <div class="card-tools">
                <form class="filters" method="GET" action="{{ route('admin.studios') }}">
                    <input type="hidden" name="tab" value="{{ $tab ?? 'pending' }}">

                    <div class="filter-group">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" class="filter-input"
                               placeholder="Search by name or email..."
                               value="{{ $q ?? '' }}">
                    </div>

                    <select class="filter-select" name="sort" onchange="this.form.submit()">
                        <option value="newest" @selected(($sort ?? 'newest') === 'newest')>Sort by: Newest First</option>
                        <option value="oldest" @selected(($sort ?? '') === 'oldest')>Sort by: Oldest First</option>
                        <option value="name_az" @selected(($sort ?? '') === 'name_az')>Sort by: Name A-Z</option>
                    </select>

                    <button class="btn btn-sm btn-light border" type="submit">Apply</button>
                </form>
            </div>
        </div>

        <div class="approval-tabs">
            <a class="tab-btn {{ ($tab ?? 'pending') === 'pending' ? 'active' : '' }}"
               href="{{ route('admin.studios', ['tab'=>'pending','q'=>$q,'sort'=>$sort]) }}">
                Pending <span class="tab-count">{{ number_format($pendingCount ?? 0) }}</span>
            </a>

            <a class="tab-btn {{ ($tab ?? '') === 'approved' ? 'active' : '' }}"
               href="{{ route('admin.studios', ['tab'=>'approved','q'=>$q,'sort'=>$sort]) }}">
                Approved <span class="tab-count">{{ number_format($approvedCount ?? 0) }}</span>
            </a>

            <a class="tab-btn {{ ($tab ?? '') === 'rejected' ? 'active' : '' }}"
               href="{{ route('admin.studios', ['tab'=>'rejected','q'=>$q,'sort'=>$sort]) }}">
                Rejected <span class="tab-count">{{ number_format($rejectedCount ?? 0) }}</span>
            </a>
        </div>

        <div class="table-container">
            <table class="approvals-table">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                        <th>Studio</th>
                        <th>Owner</th>
                        <th>Address</th>
                        <th>Application Date</th>
                        <th>Status</th>
                        <th style="min-width: 140px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($applications as $app)
                        @php
                            $status = $app->status ?? 'pending';
                            $badgeClass = $status === 'approved'
                                ? 'status-approved'
                                : ($status === 'rejected' ? 'status-rejected' : 'status-pending');

                            $studio = $app->studioProfile ?? null;
                        @endphp

                        <tr>
                            <td><input type="checkbox" class="form-check-input row-check"></td>

                            <td>
                                <div class="photographer-info">
                                    <img src="{{ asset('/img/Userprofile.png') }}" class="photographer-avatar" alt="">
                                    <div class="photographer-details">
                                        <h6>{{ $studio?->studio_name ?? '—' }}</h6>
                                        <p>{{ $app->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $app->full_name }}</td>

                            <td>{{ $studio?->address ?? '—' }}</td>

                            <td>{{ optional($app->created_at)->format('M d, Y') }}</td>

                            <td>
                                <span class="status-badge {{ $badgeClass }}">
                                    {{ $status === 'pending' ? 'Pending Review' : ucfirst($status) }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a class="btn-action view" href="{{ route('admin.studios.show', $app->id) }}">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">No studios found for this tab.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }}
                of {{ $applications->total() ?? 0 }} entries
            </div>
            <div>{{ $applications->links() }}</div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script>
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
