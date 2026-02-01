@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Departments</a></li>
                <li class="breadcrumb-item active">departments</li>
            </ol>
        </nav>
    </div>
    <div class="content-body">
        <!-- Page Header with Actions -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">Departments</h4>
                <p class="text-muted">Manage your company's organizational structure</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDepartmentModal">
                    <i class="fas fa-plus me-2"></i> Create Department
                </button>
            </div>
        </div>

        <!-- Department Statistics -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $totalDepartments }}</h4>
                        <p>Total Departments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $totalMembers }}</h4>
                        <p>Total Members</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $knowledgeCardsCount }}</h4>
                        <p>Knowledge Cards</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $departmentManagersCount }}</h4>
                        <p>Department Managers</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments Grid -->
        <div class="row g-4 mb-4">
            @forelse($departments as $dept)
                <div class="col-lg-6 col-xl-4">
                    <div class="department-card">
                        <div class="department-header">
                            <div class="department-icon"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas {{ $dept->icon ?? 'fa-briefcase' }}"></i>
                            </div>

                            <div class="department-actions dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#editDepartmentModal" data-id="{{ $dept->id }}"
                                            data-name="{{ $dept->name }}" data-description="{{ $dept->description }}"
                                            data-manager_id="{{ $dept->manager_id }}">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </button>

                                    </li>

                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#viewDetailsModal"
                                            onclick="openDepartmentDetails({{ $dept->id }})">
                                            <i class="fas fa-eye me-2"></i> View Details
                                        </button>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            onclick="prepareDelete('{{ route('companyOwner.departments.destroy', $dept->id) }}')">
                                            <i class="fas fa-trash me-2"></i> Delete
                                        </button>

                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="department-body">
                            <h5 class="department-name">{{ $dept->name }}</h5>

                            <div class="department-manager">
                                @if ($dept->manager)
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($dept->manager->name) }}&size=40"
                                        class="manager-avatar" alt="Manager">
                                    <div>
                                        <div class="manager-label">Manager</div>
                                        <div class="manager-name">{{ $dept->manager->name }}</div>
                                    </div>
                                @else
                                    <div class="manager-avatar-placeholder"><i class="fas fa-user"></i></div>
                                    <div>
                                        <div class="manager-label">Manager</div>
                                        <div class="manager-name text-muted">Not Assigned</div>
                                    </div>
                                @endif
                            </div>

                            <div class="department-stats">
                                <div class="stat-item">
                                    <i class="fas fa-users text-primary"></i>
                                    <span>{{ $dept->users_count }} Members</span>
                                </div>
                            </div>
                        </div>

                        <div class="department-footer">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#viewMembersModal" onclick="openDepartmentMembers({{ $dept->id }})">
                                <i class="fas fa-users me-1"></i> View Members
                            </button>


                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#viewDetailsModal" onclick="openDepartmentDetails({{ $dept->id }})">
                                <i class="fas fa-eye me-1"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No departments yet.</div>
                </div>
            @endforelse
        </div>


        <!-- Department Comparison Table -->
        <div class="content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Department Comparison</h4>
             
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover comparison-table">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Manager</th>
                                <th>Members</th>
                                <th>Knowledge Cards</th>
                                <th>Completion Rate</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $dept)
                                @php
                                    $members = $dept->users_count ?? 0;
                                    $cards = $dept->knowledge_count ?? 0;

                                    $rate = (int) round(($cards / $maxCards) * 100);

                                    $statusText = $dept->manager ? 'Active' : 'Needs Manager';
                                    $statusClass = $dept->manager ? 'status-active' : 'status-pending';

                                    $barClass =
                                        $rate >= 80 ? 'bg-success' : ($rate >= 60 ? 'bg-primary' : 'bg-warning');
                                @endphp

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="table-icon"
                                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <i class="fas {{ $dept->icon ?? 'fa-briefcase' }}"></i>
                                            </div>
                                            <strong>{{ $dept->name }}</strong>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($dept->manager)
                                            {{ $dept->manager->name }}
                                        @else
                                            <span class="text-muted">Not Assigned</span>
                                        @endif
                                    </td>

                                    <td><span class="badge bg-primary">{{ $members }}</span></td>

                                    <td><span class="badge bg-warning text-dark">{{ $cards }}</span></td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 8px; width: 80px;">
                                                <div class="progress-bar {{ $barClass }}"
                                                    style="width: {{ $rate }}%"></div>
                                            </div>
                                            <span class="small">{{ $rate }}%</span>
                                        </div>
                                    </td>

                                    <td><span class="status-badge {{ $statusClass }}">{{ $statusText }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No departments yet.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Department Modal -->
    <div class="modal fade" id="createDepartmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i> Create New Department
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('companyOwner.departments.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Department Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>



                        <div class="mb-3">
                            <label class="form-label">Assign Manager (Optional)</label>
                            <select name="manager_id" class="form-select">
                                <option value="">Select Manager</option>
                                @foreach ($managers as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description (Optional)</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Create Department
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- Edit Department Modal -->
    <div class="modal fade" id="editDepartmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i> Edit Department
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editDepartmentForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Department Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Department Icon</label>
                            <input type="text" name="icon" id="edit_icon" class="form-control">
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label">Assign Manager</label>
                            <select name="manager_id" id="edit_manager" class="form-select">
                                <option value="">Select Manager</option>
                                @foreach ($managers as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- View Department Members Modal -->
    <div class="modal fade" id="viewMembersModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-users me-2"></i>
                        <span id="membersModalTitle">Department Members</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="membersLoading" class="text-center py-4 d-none">
                        <div class="spinner-border" role="status"></div>
                        <div class="mt-2">Loading...</div>
                    </div>

                    <div id="membersEmpty" class="alert alert-info d-none">
                        No members in this department.
                    </div>

                    <div class="members-list" id="membersList"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    {{-- زر Add Member خليته موجود (لاحقًا بنربطه) --}}
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i> Add Member
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- View Details Modal --}}
    <div class="modal fade" id="viewDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-eye me-2"></i> Department Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Name</label>
                            <div class="fw-bold" id="detail_name">—</div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">Created At</label>
                            <div class="fw-bold" id="detail_created">—</div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">Manager</label>
                            <div class="fw-bold" id="detail_manager">—</div>
                            <div class="text-muted small" id="detail_manager_email"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">Members</label>
                            <div class="fw-bold" id="detail_members">—</div>
                        </div>

                        <div class="col-12">
                            <label class="text-muted small">Description</label>
                            <div id="detail_description" class="mt-1">—</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- delete --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-triangle-exclamation me-2"></i>Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete this department?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form id="deleteDeptForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function prepareDelete(actionUrl) {
            document.getElementById('deleteDeptForm').action = actionUrl;
        }
    </script>
@endsection
@if (session('deleted'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Deleted',
                text: @json(session('deleted')),
                timer: 1800,
                showConfirmButton: false
            });
        });
    </script>
@endif

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editDepartmentModal');

            editModal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;

                const id = btn.getAttribute('data-id');
                const name = btn.getAttribute('data-name');
                const icon = btn.getAttribute('data-icon');
                const description = btn.getAttribute('data-description');
                const managerId = btn.getAttribute('data-manager_id');

                document.getElementById('edit_name').value = name ?? '';
                document.getElementById('edit_icon').value = icon ?? '';
                document.getElementById('edit_description').value = description ?? '';

                const managerSelect = document.getElementById('edit_manager');
                managerSelect.value = managerId ? managerId : '';

                const form = document.getElementById('editDepartmentForm');
                form.action = `{{ url('company-owner/departments') }}/${id}`;
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editDepartmentModal');

            editModal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget; // زر Edit اللي انضغط

                const id = btn.getAttribute('data-id');
                const name = btn.getAttribute('data-name');
                const description = btn.getAttribute('data-description');
                const managerId = btn.getAttribute('data-manager_id');

                // تعبئة الحقول
                document.getElementById('edit_name').value = name ?? '';
                document.getElementById('edit_description').value = description ?? '';

                const managerSelect = document.getElementById('edit_manager');
                managerSelect.value = managerId ? managerId : '';

                // ✅ أهم سطر: ضبط action الصحيح
                const form = document.getElementById('editDepartmentForm');
                form.action = `{{ url('company-owner/departments') }}/${id}`;
            });
        });
    </script>
    <script>
        async function openDepartmentMembers(deptId) {
            const title = document.getElementById('membersModalTitle');
            const list = document.getElementById('membersList');
            const loading = document.getElementById('membersLoading');
            const empty = document.getElementById('membersEmpty');

            // reset
            list.innerHTML = '';
            empty.classList.add('d-none');
            loading.classList.remove('d-none');
            title.textContent = 'Department Members';

            try {
                const res = await fetch(`{{ url('company-owner/departments') }}/${deptId}/members`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                if (!res.ok) throw new Error('Request failed');

                const data = await res.json();

                title.textContent = `${data.department.name} Members`;

                if (!data.members || data.members.length === 0) {
                    empty.classList.remove('d-none');
                    return;
                }

                data.members.forEach(m => {
                    const roleLabel =
                        m.role === 'company_owner' ? 'Company Owner' :
                        m.role === 'department_manager' ? 'Department Manager' :
                        'Employee';

                    const roleClass =
                        m.role === 'company_owner' ? 'role-admin' :
                        m.role === 'department_manager' ? 'role-manager' :
                        'role-employee';

                    list.insertAdjacentHTML('beforeend', `
                <div class="member-item">
                    <img src="${m.avatar}" alt="Member" class="member-avatar-modal">
                    <div class="member-details">
                        <h6>${m.name}</h6>
                        <p class="text-muted mb-0">${m.email}</p>
                        </div>
                        <span class="role-badge ${roleClass} mt-1">${roleLabel}</span>
                </div>
            `);
                });

            } catch (e) {
                empty.textContent = 'Failed to load members.';
                empty.classList.remove('d-none');
            } finally {
                loading.classList.add('d-none');
            }
        }
    </script>
@endsection
