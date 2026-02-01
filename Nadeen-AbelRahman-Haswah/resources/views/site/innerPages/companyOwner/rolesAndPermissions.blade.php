@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Users & Roles</a></li>
                <li class="breadcrumb-item active"> Roles & Permissions</li>
            </ol>
        </nav>
    </div>
    <div class="content-body">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="mb-2">Roles & Permissions</h4>
            <p class="text-muted">Manage user roles and their permissions across the system</p>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <i class="fas fa-plus me-2"></i> Create Custom Role
            </button>
        </div>
    </div>

    <!-- Default Roles -->
    <div class="row g-4 mb-4">
        <!-- Company Admin Role -->
        <div class="col-lg-4">
            <div class="role-card role-admin-card">
                <div class="role-header">
                    <div class="role-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="role-title">
                        <h5>Company Admin</h5>
                        <span class="role-count">2 users</span>
                    </div>
                    <span class="badge bg-primary">Default</span>
                </div>
                <p class="role-description">
                    Full access to all features and settings. Can manage users, billing, and company settings.
                </p>
                <div class="role-permissions">
                    <h6>Key Permissions:</h6>
                    <ul class="permissions-list">
                        <li><i class="fas fa-check text-success"></i> Manage all departments</li>
                        <li><i class="fas fa-check text-success"></i> Approve/reject knowledge cards</li>
                        <li><i class="fas fa-check text-success"></i> Manage users & roles</li>
                        <li><i class="fas fa-check text-success"></i> Access billing & subscription</li>
                        <li><i class="fas fa-check text-success"></i> View analytics</li>
                    </ul>
                </div>
                <button class="btn btn-outline-primary btn-sm w-100 mt-3" onclick="viewRoleDetails('admin')">
                    <i class="fas fa-eye me-1"></i> View All Permissions
                </button>
            </div>
        </div>

        <!-- Department Manager Role -->
        <div class="col-lg-4">
            <div class="role-card role-manager-card">
                <div class="role-header">
                    <div class="role-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="role-title">
                        <h5>Department Manager</h5>
                        <span class="role-count">8 users</span>
                    </div>
                    <span class="badge bg-warning">Default</span>
                </div>
                <p class="role-description">
                    Manage specific department, approve cards, and oversee team members within assigned department.
                </p>
                <div class="role-permissions">
                    <h6>Key Permissions:</h6>
                    <ul class="permissions-list">
                        <li><i class="fas fa-check text-success"></i> Manage own department</li>
                        <li><i class="fas fa-check text-success"></i> Approve department cards</li>
                        <li><i class="fas fa-check text-success"></i> View team analytics</li>
                        <li><i class="fas fa-times text-danger"></i> Manage billing</li>
                        <li><i class="fas fa-times text-danger"></i> Delete users</li>
                    </ul>
                </div>
                <button class="btn btn-outline-primary btn-sm w-100 mt-3" onclick="viewRoleDetails('manager')">
                    <i class="fas fa-eye me-1"></i> View All Permissions
                </button>
            </div>
        </div>

        <!-- Employee Role -->

        <div class="col-lg-4">
        <div class="role-card role-employee-card">
            <div class="role-header">
                <div class="role-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="role-title">
                    <h5>Employee</h5>
                    <span class="role-count">117 users</span>
                </div>
                <span class="badge bg-secondary">Default</span>
            </div>
            <p class="role-description">
                Basic access to create and view knowledge cards, participate in company activities and events.
            </p>
            <div class="role-permissions">
                <h6>Key Permissions:</h6>
                <ul class="permissions-list">
                    <li><i class="fas fa-check text-success"></i> Create knowledge cards</li>
                    <li><i class="fas fa-check text-success"></i> View approved cards</li>
                    <li><i class="fas fa-check text-success"></i> Access calendar</li>
                    <li><i class="fas fa-times text-danger"></i> Approve cards</li>
                    <li><i class="fas fa-times text-danger"></i> Manage users</li>
                </ul>
            </div>
            <button class="btn btn-outline-primary btn-sm w-100 mt-3" onclick="viewRoleDetails('employee')">
                <i class="fas fa-eye me-1"></i> View All Permissions
            </button>
        </div>
    </div>
</div>

<!-- Custom Roles (Enterprise Feature) -->
<div class="content-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Custom Roles</h4>
        <span class="badge bg-info">Enterprise Feature</span>
    </div>
    <div class="card-body">
        <div class="enterprise-feature-notice">
            <div class="feature-icon">
                <i class="fas fa-lock"></i>
            </div>
            <div class="feature-content">
                <h5>Create Custom Roles with Enterprise Plan</h5>
                <p>Unlock the ability to create custom roles with specific permissions tailored to your organization's needs.</p>
                <ul class="feature-benefits">
                    <li><i class="fas fa-check text-success"></i> Unlimited custom roles</li>
                    <li><i class="fas fa-check text-success"></i> Granular permission control</li>
                    <li><i class="fas fa-check text-success"></i> Role-based workflows</li>
                    <li><i class="fas fa-check text-success"></i> Advanced access control</li>
                </ul>
                <button class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-up me-2"></i> Upgrade to Enterprise
                </button>
            </div>
        </div>

        <!-- Sample Custom Roles (for Enterprise users) -->
        <div class="custom-roles-list mt-4" style="display: none;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Users</th>
                            <th>Permissions</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-shield-alt text-primary"></i>
                                    <strong>Content Moderator</strong>
                                </div>
                            </td>
                            <td>3 users</td>
                            <td>
                                <span class="badge bg-light text-dark">5 permissions</span>
                            </td>
                            <td>Dec 15, 2024</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">Edit</button>
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Permissions Matrix -->
<div class="content-card mt-4">
    <div class="card-header">
        <h4>Permissions Matrix</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table permissions-matrix-table">
                <thead>
                    <tr>
                        <th width="300">Permission</th>
                        <th class="text-center">Company Admin</th>
                        <th class="text-center">Dept. Manager</th>
                        <th class="text-center">Employee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="table-section-header">
                            <i class="fas fa-book me-2"></i> Knowledge Cards
                        </td>
                    </tr>
                    <tr>
                        <td>Create Knowledge Cards</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                    </tr>
                    <tr>
                        <td>Approve/Reject Cards</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                    </tr>
                    <tr>
                        <td>Delete Any Card</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-minus-circle text-warning"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="table-section-header">
                            <i class="fas fa-users me-2"></i> User Management
                        </td>
                    </tr>
                    <tr>
                        <td>Invite Users</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                    </tr>
                    <tr>
                        <td>Manage Roles & Permissions</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                    </tr>
                    <tr>
                        <td>Suspend/Delete Users</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="table-section-header">
                            <i class="fas fa-cog me-2"></i> Settings & Billing
                        </td>
                    </tr>
                    <tr>
                        <td>Manage Company Profile</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                    </tr>
                    <tr>
                        <td>Manage Subscription & Billing</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                    </tr>
                    <tr>
                        <td>View Analytics</td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check-circle text-success"></i></td>
                        <td class="text-center"><i class="fas fa-times-circle text-danger"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <small class="text-muted">
                <i class="fas fa-check-circle text-success"></i> = Full Access &nbsp;&nbsp;
                <i class="fas fa-minus-circle text-warning"></i> = Limited Access &nbsp;&nbsp;
                <i class="fas fa-times-circle text-danger"></i> = No Access
            </small>
        </div>
    </div>
</div>

</div>
<!-- Create Custom Role Modal (Enterprise) -->
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-shield-alt me-2"></i> Create Custom Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-lock me-2"></i>
                    This feature is only available for Enterprise plan users.
                    <a href="#" class="alert-link">Upgrade now</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection
