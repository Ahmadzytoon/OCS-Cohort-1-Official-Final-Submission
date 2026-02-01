@extends('admin.layout.master')

@section('title', 'Users Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
<div class="container-fluid main-content">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success m-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger m-3">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger m-3">
            <strong>Fix these issues:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Users Management</h1>
            <p class="text-muted mb-0">Manage all users, photographers, and studios in the platform</p>
        </div>
        <div class="page-actions">
            <button class="btn-add-user" id="openAddUserModal" type="button">
                <i class="fas fa-plus"></i> Add New User
            </button>
            <a href="#" class="btn btn-outline-secondary">
                <i class="fas fa-download"></i> Export
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon total-users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalUsers ?? 0) }}</h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon active-users">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($approvedUsers ?? 0) }}</h3>
                <p>Approved Users</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon pending-users">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($pendingUsers ?? 0) }}</h3>
                <p>Pending Users</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blocked-users">
                <i class="fas fa-ban"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($rejectedUsers ?? 0) }}</h3>
                <p>Rejected Users</p>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="main-card">
        <!-- Card Header with Filters (UI فقط حالياً) -->
        <div class="card-header">
            <h3 class="card-title">All Users</h3>
            <div class="card-tools">
    <form class="filters" method="GET" action="{{ route('admin.users') }}">
        <div class="filter-group">
            <i class="fas fa-search"></i>
            <input type="text" name="q" class="filter-input"
                   value="{{ request('q') }}"
                   placeholder="Search by name or email...">
        </div>

        <select class="filter-select" name="role" onchange="this.form.submit()">
            <option value="all" @selected(request('role','all')=='all')>All Roles</option>
            <option value="customer" @selected(request('role')=='customer')>Customer</option>
            <option value="photographer" @selected(request('role')=='photographer')>Photographer</option>
            <option value="studio" @selected(request('role')=='studio')>Studio</option>
        </select>

        <select class="filter-select" name="status" onchange="this.form.submit()">
            <option value="all" @selected(request('status','all')=='all')>All Statuses</option>
            <option value="approved" @selected(request('status')=='approved')>Approved</option>
            <option value="pending" @selected(request('status')=='pending')>Pending</option>
            <option value="rejected" @selected(request('status')=='rejected')>Rejected</option>
        </select>

        <select class="filter-select" name="sort" onchange="this.form.submit()">
            <option value="newest"  @selected(request('sort','newest')=='newest')>Sort by: Newest</option>
            <option value="oldest"  @selected(request('sort')=='oldest')>Sort by: Oldest</option>
            <option value="name_az" @selected(request('sort')=='name_az')>Sort by: Name A-Z</option>
            <option value="name_za" @selected(request('sort')=='name_za')>Sort by: Name Z-A</option>
        </select>

        {{-- زر اختياري --}}
        <noscript><button class="btn btn-sm btn-light border">Apply</button></noscript>
    </form>
</div>

        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="users-table">
                <thead>
                <tr>
                    <th style="width: 40px;">
                        <input type="checkbox" class="form-check-input" id="selectAll">
                    </th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Join Date</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse($users as $u)
                    @php
                        // اربط status مع CSS classes الموجودة عندك
                        $statusClass = match($u->status) {
                            'approved' => 'status-active',
                            'pending'  => 'status-pending',
                            'rejected' => 'status-blocked',
                            default    => 'status-pending',
                        };
                    @endphp

                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input row-check">
                        </td>

                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <img src="{{ asset('/img/Userprofile.png') }}" class="rounded-circle table-user-img me-2" alt="User">
                                </div>
                                <div class="user-details">
                                    <h6>{{ $u->full_name }}</h6>
                                    <p>{{ ucfirst($u->account_type) }}</p>
                                </div>
                            </div>
                        </td>

                        <td>{{ $u->email }}</td>
                        <td>{{ ucfirst($u->account_type) }}</td>

                        <td>
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($u->status) }}</span>
                        </td>

                        <td>{{ optional($u->created_at)->format('M d, Y') }}</td>

                        <td>
                            <div class="action-buttons">
                               
                                {{-- ✅ Delete حقيقي --}}
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $u->id) }}"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete"
                                            onclick="return confirm('Delete this user?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
            </div>

            <div class="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<!-- ADD USER MODAL -->
<div class="modal-overlay" id="addUserModal">
    <div class="add-user-modal">
        <div class="modal-header">
            <h2 class="modal-title">
                <i class="fas fa-user-plus"></i>
                Add New User
            </h2>
            <button class="modal-close" id="closeAddUserModal" type="button">&times;</button>
        </div>

        <div class="modal-body">
            <form id="addUserForm" method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h3>

                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label for="fullName">Full Name <span class="required">*</span></label>
                            <input type="text" id="fullName" name="full_name" class="form-control"
                                   placeholder="Enter full name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="userEmail">Email Address <span class="required">*</span></label>
                            <input type="email" id="userEmail" name="email" class="form-control"
                                   placeholder="user@example.com" required>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-key"></i>
                        Account Information
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password <span class="required">*</span></label>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Create a strong password" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="userRole">User Role <span class="required">*</span></label>
                            <select id="userRole" name="account_type" class="form-control select" required>
                                <option value="customer">Customer</option>
                                <option value="photographer">Photographer</option>
                                <option value="studio">Studio</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="userStatus">Account Status <span class="required">*</span></label>
                            <select id="userStatus" name="status" class="form-control select" required>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-modal btn-modal-secondary" id="cancelAddUserBtn">
                        Cancel
                    </button>
                    <button type="submit" class="btn-modal btn-modal-primary">
                        <i class="fas fa-save"></i>
                        Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Sidebar Toggle Script (safe)
    document.getElementById('sidebarToggle')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('wrapper')?.classList.toggle('toggled');
    });

    // Select All Checkbox
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.users-table tbody .row-check');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });
    }

    // MODAL FUNCTIONALITY
    const addUserModal = document.getElementById('addUserModal');
    const openModalBtn = document.getElementById('openAddUserModal');
    const closeModalBtn = document.getElementById('closeAddUserModal');
    const cancelModalBtn = document.getElementById('cancelAddUserBtn');

    function openModal() {
        addUserModal?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        addUserModal?.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    openModalBtn?.addEventListener('click', openModal);
    closeModalBtn?.addEventListener('click', closeModal);
    cancelModalBtn?.addEventListener('click', closeModal);

    // Close modal when clicking outside
    addUserModal?.addEventListener('click', function (e) {
        if (e.target === addUserModal) closeModal();
    });

    // Front-end search filter (اختياري - UI)
    const searchInput = document.querySelector('.filter-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.users-table tbody tr');

            rows.forEach(row => {
                const nameEl = row.querySelector('.user-details h6');
                const emailEl = row.querySelector('td:nth-child(3)');

                const name = nameEl ? nameEl.textContent.toLowerCase() : '';
                const email = emailEl ? emailEl.textContent.toLowerCase() : '';

                row.style.display = (name.includes(searchTerm) || email.includes(searchTerm)) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection
