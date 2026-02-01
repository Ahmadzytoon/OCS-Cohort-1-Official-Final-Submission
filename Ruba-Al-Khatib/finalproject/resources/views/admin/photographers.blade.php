@extends('admin.layout.master')

@section('title', 'Photographer Approvals')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/approval.css') }}">
@endsection

@section('content')
<div class="container-fluid main-content">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Photographer Approvals</h1>
            <p class="text-muted mb-0">Review and approve photographer applications</p>
        </div>
        <div class="page-actions">
            <a href="#" class="btn-primary-custom">
                <i class="fas fa-download"></i> Export Report
            </a>
        </div>
    </div>

    <!-- Stats Cards (Real counts) -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalApplications ?? 0) }}</h3>
                <p>Total Applications</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon approved">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($approvedCount ?? 0) }}</h3>
                <p>Approved Photographers</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($pendingCount ?? 0) }}</h3>
                <p>Pending Approvals</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon rejected">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($rejectedCount ?? 0) }}</h3>
                <p>Rejected Applications</p>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">

        <!-- Card Header with Filters (Server side) -->
        <div class="card-header">
            <h3 class="card-title">Photographer Applications</h3>

            <div class="card-tools">
                <form class="filters" method="GET" action="{{ route('admin.photographers') }}">
                    <input type="hidden" name="tab" value="{{ $tab ?? 'pending' }}">

                    <div class="filter-group">
                        <i class="fas fa-search"></i>
                        <input
                            type="text"
                            name="q"
                            class="filter-input"
                            placeholder="Search by name or email..."
                            value="{{ $q ?? '' }}">
                    </div>

                    <select class="filter-select" name="sort" onchange="this.form.submit()">
                        <option value="newest" @selected(($sort ?? 'newest' )==='newest' )>Sort by: Newest First</option>
                        <option value="oldest" @selected(($sort ?? '' )==='oldest' )>Sort by: Oldest First</option>
                        <option value="name_az" @selected(($sort ?? '' )==='name_az' )>Sort by: Name A-Z</option>
                    </select>

                    <button class="btn btn-sm btn-light border" type="submit">Apply</button>
                </form>
            </div>
        </div>

        <!-- Tabs (server side) -->
        <div class="approval-tabs">
            <a class="tab-btn {{ ($tab ?? 'pending') === 'pending' ? 'active' : '' }}"
                href="{{ route('admin.photographers', ['tab'=>'pending','q'=>$q,'sort'=>$sort]) }}">
                Pending <span class="tab-count">{{ number_format($pendingCount ?? 0) }}</span>
            </a>

            <a class="tab-btn {{ ($tab ?? '') === 'approved' ? 'active' : '' }}"
                href="{{ route('admin.photographers', ['tab'=>'approved','q'=>$q,'sort'=>$sort]) }}">
                Approved <span class="tab-count">{{ number_format($approvedCount ?? 0) }}</span>
            </a>

            <a class="tab-btn {{ ($tab ?? '') === 'rejected' ? 'active' : '' }}"
                href="{{ route('admin.photographers', ['tab'=>'rejected','q'=>$q,'sort'=>$sort]) }}">
                Rejected <span class="tab-count">{{ number_format($rejectedCount ?? 0) }}</span>
            </a>
        </div>

        <!-- Table -->
        <div class="table-container" id="pending-tab">
            <table class="approvals-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" class="form-check-input" id="selectAllPending">
                        </th>
                        <th>Photographer</th>
                        <th>Experience</th>
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

                    // جلب بيانات المصور (من جدول photographers) إذا كانت محملة eager، وإلا بنعرض "-"
                    $profile = $app->photographerProfile ?? null;

                    $types = $profile?->photography_types;

                    // ✅ لو Array (cast) نحوله لنص
                    $typesText = is_array($types)
                    ? implode(', ', $types)
                    : ($types ?: '—');
                    $years = $profile?->years_of_experience;
                    @endphp

                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input pending-checkbox" value="{{ $app->id }}">
                        </td>

                        <td>
                            <div class="photographer-info">
                                <img src="{{ asset('/img/Userprofile.png') }}" alt="Photographer" class="photographer-avatar">
                                <div class="photographer-details">
                                    <h6>{{ $app->full_name }}</h6>
                                    <p>{{ $app->email }}</p>
                                    <p>{{ $typesText }}</p>

                                </div>
                            </div>
                        </td>

                        <td>{{ is_null($years) ? '—' : ($years . ' years') }}</td>

                        <td>{{ optional($app->created_at)->format('M d, Y') }}</td>

                        <td>
                            <span class="status-badge {{ $badgeClass }}">
                                {{ $status === 'pending' ? 'Pending Review' : ucfirst($status) }}
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                {{-- ✅ View فقط: يودّي على صفحة ثانية --}}
                                <a class="btn-action view" href="{{ route('admin.photographers.show', $app->id) }}">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No photographers found for this tab.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }}
                of {{ $applications->total() ?? 0 }} entries
            </div>

            <div>
                {{ $applications->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script>
    // Sidebar Toggle Script (safe)
    document.getElementById('sidebarToggle')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('wrapper')?.classList.toggle('toggled');
    });

    // Select All
    const selectAll = document.getElementById('selectAllPending');
    const boxes = document.querySelectorAll('.pending-checkbox');

    selectAll?.addEventListener('change', function() {
        boxes.forEach(cb => cb.checked = selectAll.checked);
    });
</script>
@endsection