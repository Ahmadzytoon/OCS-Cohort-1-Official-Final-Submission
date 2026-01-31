@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Users & Roles</a></li>
                <li class="breadcrumb-item active">Employees</li>
            </ol>
        </nav>
    </div>

    <div class="content-body">
        <!-- Page Header with Actions -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <form method="GET" action="{{ route('shared.employee.index') }}"
                        class="d-flex align-items-center gap-3">
                        <div class="search-box flex-grow-1">
                            <i class="fas fa-search"></i>
                            <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control"
                                placeholder="Search employees by name, email, or department...">
                        </div>

                        {{-- نخلي الفلاتر تحفظ قيمها --}}
                        <input type="hidden" name="department_id" value="{{ $departmentId ?? '' }}">
                        <input type="hidden" name="role" value="{{ $role ?? '' }}">
                        <input type="hidden" name="status" value="{{ $status ?? '' }}">

                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>

                </div>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inviteEmployeeModal">
                    <i class="fas fa-user-plus me-2"></i> add Employee
                </button>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('shared.employee.index') }}" class="row g-3 mb-4">
            <input type="hidden" name="q" value="{{ $q ?? '' }}">

            <div class="col-md-3">
                <select class="form-select" name="department_id">
                    <option value="">All Departments</option>
                    @foreach ($departments as $dep)
                        <option value="{{ $dep->id }}" @selected(($departmentId ?? '') == $dep->id)>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select class="form-select" name="role">
                    <option value="">All Roles</option>
                    <option value="department_manager" @selected(($role ?? '') == 'department_manager')>Department Manager</option>
                    <option value="employee" @selected(($role ?? '') == 'employee')>Employee</option>
                </select>
            </div>

            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" @selected(($status ?? '') == 'active')>Active</option>
                    <option value="inactive" @selected(($status ?? '') == 'inactive')>Inactive</option>
                    <option value="pending" @selected(($status ?? '') == 'pending')>Pending</option>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">
                    Apply
                </button>

                <a class="btn btn-outline-secondary w-100" href="{{ route('shared.employee.index') }}">
                    <i class="fas fa-redo me-2"></i> Reset
                </a>
            </div>
        </form>


        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $stats['total'] }}</h4>
                        <p>Total Employees</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $stats['active'] }}</h4>
                        <p>Active</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $stats['pending'] }}</h4>
                        <p>Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $stats['inactive'] }}</h4>
                        <p>Suspended</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employees Table -->
        <div class="content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Employees List</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover employees-table">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input">
                                </th>
                                <th>Employee</th>
                                <th>Role</th>
                                <th>Position</th>
                                <th>Department</th>
                                <th>Join Date</th>
                                <th>Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>

                                    <td>
                                        <div class="employee-info">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                                                alt="Employee" class="employee-avatar">
                                            <div>
                                                <div class="employee-name">{{ $user->name }}</div>
                                                <div class="employee-email">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $roleClass = match ($user->role) {
                                                'department_manager' => 'role-manager',
                                                default => 'role-employee',
                                            };

                                            $roleText = match ($user->role) {
                                                'department_manager' => 'Department Manager',
                                                'employee' => 'Employee',
                                                default => $user->role,
                                            };
                                        @endphp
                                        <span class="role-badge {{ $roleClass }}">{{ $roleText }}</span>
                                    </td>

                                    {{-- ✅ Position --}}
                                    <td>{{ $user->position ?? '-' }}</td>

                                    <td>{{ $user->department?->name ?? '—' }}</td>

                                    <td>
                                        {{ $user->joined_at ? \Carbon\Carbon::parse($user->joined_at)->format('M d, Y') : '—' }}
                                    </td>

                                    <td>
                                        @php
                                            $statusClass = match ($user->status) {
                                                'active' => 'status-active',
                                                'pending' => 'status-pending',
                                                'inactive' => 'status-suspended',
                                                default => 'status-pending',
                                            };
                                        @endphp
                                        <span
                                            class="status-badge {{ $statusClass }}">{{ ucfirst($user->status) }}</span>
                                    </td>

                                    {{-- ✅ Actions: شيلنا edit نهائيًا (حسب طلبك) --}}
                                    <td>
                                        <div class="action-buttons">
                                            {{-- إذا بدك فقط عرض بدون تعديل/تعطيل: خليها فاضية أو احذفي العمود كامل --}}
                                            <span class="text-muted">—</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        No employees found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    <div class="table-footer">
                        <div class="showing-info">
                            Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                            employees
                        </div>

                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Invite Employee Modal -->
    <div class="modal fade" id="inviteEmployeeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i> add New Employee
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="inviteEmployeeForm" method="POST" action="{{ route('shared.employee.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Employee Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="employee@company.com" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="John Doe" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                placeholder="079...">
                            @error('phone')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" name="position" class="form-control" value="{{ old('position') }}"
                                placeholder="Full Stack Developer">
                            @error('position')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department_id">
                                <option value="">Select Department</option>
                                @foreach ($departments as $dep)
                                    <option value="{{ $dep->id }}" @selected(old('department_id') == $dep->id)>
                                        {{ $dep->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="">Select Role</option>
                                <option value="department_manager" @selected(old('role') == 'department_manager')>Department Manager</option>
                                <option value="employee" @selected(old('role') == 'employee')>Employee</option>
                            </select>
                            @error('role')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active" @selected(old('status', 'active') == 'active')>Active</option>
                                <option value="pending" @selected(old('status') == 'pending')>Pending</option>
                                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        {{-- ملاحظة: انتِ حالياً “بتنشئي user مباشرة”، مش نظام invitation بالبريد --}}
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Employee account will be created directly.
                        </div>

                        <div class="modal-footer px-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Add Employee
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Done',
                text: @json(session('success')),
                timer: 1800,
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            // افتحي المودال تلقائيًا لو في validation errors
            const modal = new bootstrap.Modal(document.getElementById('inviteEmployeeModal'));
            modal.show();

            Swal.fire({
                icon: 'error',
                title: 'Validation error',
                text: 'Please check the form fields.'
            });
        </script>
    @endif
@endsection
