@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Department Team</li>
            </ol>
        </nav>
    </div>



    <div class="content-body">
        <!-- Team Header -->
        <div class="team-header-banner">
            <div class="team-header-content-main">
                <div class="team-header-left">
                    <div class="team-dept-icon-large">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="team-header-info">
                        <h2>IT Department Team</h2>
                        <p>Manage your team members, roles, and permissions</p>
                    </div>
                </div>
                <div>
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#inviteEmployeeModal">
                        <i class="fas fa-user-plus me-2"></i> Invite Team Member
                    </button>
                </div>
            </div>
            <div class="team-stats-row">
                <div class="team-stat-box">
                    <h4>12</h4>
                    <small>Total Members</small>
                </div>
                <div class="team-stat-box">
                    <h4>10</h4>
                    <small>Active Members</small>
                </div>
                <div class="team-stat-box">
                    <h4>1</h4>
                    <small>Department Manager</small>
                </div>
                <div class="team-stat-box">
                    <h4>2</h4>
                    <small>Team Leads</small>
                </div>
            </div>
        </div>

        <!-- Filters Bar -->
        <div class="team-filters-bar d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="team-search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" placeholder="Search team members...">
            </div>
            <div class="d-flex gap-2">
                <select class="form-select" style="width: auto;">
                    <option value="">All Roles</option>
                    <option value="manager">Department Manager</option>
                    <option value="lead">Team Lead</option>
                    <option value="member">Team Member</option>
                </select>
                <select class="form-select" style="width: auto;">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Team Members Grid -->
        <div class="row g-4">
            <!-- Member Card 1 - Manager -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="team-member-card">
                    <div class="member-card-header">
                        <img src="https://ui-avatars.com/api/?name=Ahmed+Khaled&background=47b2e4&color=fff&size=200"
                            alt="Ahmed Khaled" class="member-avatar-large">
                        <div class="member-name-title">
                            <h5>Ahmed Khaled</h5>
                        </div>
                        <p class="member-position-title">IT Department Manager</p>
                        <span class="member-role-badge-card manager">
                            <i class="fas fa-crown me-1"></i> Manager
                        </span>
                        <span class="member-status-badge active-status">
                            <i class="fas fa-circle"></i> Active
                        </span>
                    </div>
                    <div class="member-card-body">
                        <div class="member-info-row">
                            <i class="fas fa-envelope"></i>
                            <span>ahmed.khaled@company.com</span>
                        </div>
                        <div class="member-info-row">
                            <i class="fas fa-phone"></i>
                            <span>+962 79 123 4567</span>
                        </div>
                        <div class="member-info-row">
                            <i class="fas fa-calendar"></i>
                            <span>Joined Jan 2023</span>
                        </div>
                        <div class="member-info-row">
                            <i class="fas fa-book"></i>
                            <span>8 Knowledge Cards</span>
                        </div>
                    </div>
                    <div class="member-card-footer">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#memberDetailModal">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                            data-bs-target="#changeRoleModal">
                            <i class="fas fa-user-tag"></i> Role
                        </button>
                    </div>
                </div>
            </div>

            <!-- Member Card 8 -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="team-member-card">
                    <div class="member-card-header">
                        <img src="https://ui-avatars.com/api/?name=Khalid+Mahmoud&background=20c997&color=fff&size=200"
                            alt="Khalid Mahmoud" class="member-avatar-large">
                        <div class="member-name-title">
                            <h5>Khalid Mahmoud</h5>
                        </div>
                        <p class="member-position-title">QA Engineer</p>
                        <span class="member-role-badge-card member">
                            <i class="fas fa-user me-1"></i> Team Member
                        </span>
                        <span class="member-status-badge active-status">
                            <i class="fas fa-circle"></i> Active
                        </span>
                    </div>
                    <div class="member-card-body">
                        <div class="member-info-row">
                            <i class="fas fa-envelope"></i>
                            <span>khalid.mahmoud@company.com</span>
                        </div>
                        <div class="member-info-row">
                            <i class="fas fa-phone"></i>
                            <span>+962 79 890 1234</span>
                        </div>
                        <div class="member-info-row">
                            <i class="fas fa-calendar"></i>
                            <span>Joined Oct 2023</span>
                        </div>
                        <div class="member-info-row">
                            <i class="fas fa-book"></i>
                            <span>14 Knowledge Cards</span>
                        </div>
                    </div>
                    <div class="member-card-footer">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#memberDetailModal">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                            data-bs-target="#changeRoleModal">
                            <i class="fas fa-user-tag"></i> Role
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <p class="text-muted mb-0">Showing 8 of 12 members</p>
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Invite Employee Modal -->
    <div class="modal fade" id="inviteEmployeeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i> Invite New Team Member
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="inviteEmployeeForm">
                        <div class="mb-3">
                            <label class="form-label">Employee Email *</label>
                            <input type="email" class="form-control" placeholder="employee@company.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position/Title *</label>
                            <input type="text" class="form-control" placeholder="e.g., Senior Developer" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" placeholder="+962 79 123 4567">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role in Department *</label>
                            <select class="form-select" required>
                                <option value="">Select Role</option>
                                <option value="lead">Team Lead</option>
                                <option value="member">Team Member</option>
                            </select>
                        </div>
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            An invitation email will be sent to add this member to the <strong>IT Department</strong>.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Send Invitation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Role Modal -->
    <div class="modal fade" id="changeRoleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-tag me-2"></i> Change Member Role
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Sarah+Ahmed&background=6f42c1&color=fff&size=80"
                            alt="Sarah Ahmed" class="rounded-circle mb-2"
                            style="width: 80px; height: 80px; border: 3px solid var(--accent-color);">
                        <h6 class="mb-1">Sarah Ahmed</h6>
                        <p class="text-muted small mb-0">Senior Developer</p>
                        <span class="badge bg-secondary mt-2">Current: Team Lead</span>
                    </div>

                    <h6 class="mb-3">Select New Role:</h6>

                    <!-- Manager Role Option -->
                    <div class="role-option-card" onclick="selectRole(this)">
                        <div class="role-option-header">
                            <div class="role-option-icon manager-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div class="role-option-title">
                                <h6>Department Manager</h6>
                            </div>
                        </div>
                        <p class="role-option-desc">
                            Full control over department operations, team management, and all knowledge cards. Can
                            approve/reject submissions and manage all department settings.
                        </p>
                    </div>

                    <!-- Team Lead Role Option -->
                    <div class="role-option-card selected" onclick="selectRole(this)">
                        <div class="role-option-header">
                            <div class="role-option-icon lead-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="role-option-title">
                                <h6>Team Lead</h6>
                            </div>
                        </div>
                        <p class="role-option-desc">
                            Can review and suggest changes to knowledge cards, mentor team members, and assist in department
                            coordination. Limited approval permissions.
                        </p>
                    </div>

                    <!-- Team Member Role Option -->
                    <div class="role-option-card" onclick="selectRole(this)">
                        <div class="role-option-header">
                            <div class="role-option-icon member-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="role-option-title">
                                <h6>Team Member</h6>
                            </div>
                        </div>
                        <p class="role-option-desc">
                            Can create and submit knowledge cards, view department resources, and collaborate with team.
                            Requires approval for submissions.
                        </p>
                    </div>

                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Changing the role will immediately update the member's permissions and access level.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-sync-alt me-1"></i> Update Role
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Detail Modal -->
    <div class="modal fade" id="memberDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-id-card me-2"></i> Member Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Sarah+Ahmed&background=6f42c1&color=fff&size=240"
                            alt="Sarah Ahmed" class="member-detail-avatar">
                        <h4 class="mb-1">Sarah Ahmed</h4>
                        <p class="text-muted mb-2">Senior Developer</p>
                        <span class="member-role-badge-card lead me-2">
                            <i class="fas fa-star me-1"></i> Team Lead
                        </span>
                        <span class="member-status-badge active-status">
                            <i class="fas fa-circle"></i> Active
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="member-detail-section">
                                <h6>
                                    <i class="fas fa-user-circle text-primary"></i>
                                    Personal Information
                                </h6>
                                <div class="member-detail-row">
                                    <span class="detail-label-col">Email:</span>
                                    <span class="detail-value-col">sarah.ahmed@company.com</span>
                                </div>
                                <div class="member-detail-row">
                                    <span class="detail-label-col">Phone:</span>
                                    <span class="detail-value-col">+962 79 234 5678</span>
                                </div>
                                <div class="member-detail-row">
                                    <span class="detail-label-col">Department:</span>
                                    <span class="detail-value-col">IT Department</span>
                                </div>
                                <div class="member-detail-row">
                                    <span class="detail-label-col">Join Date:</span>
                                    <span class="detail-value-col">March 15, 2023</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="member-detail-section">
                                <h6>
                                    <i class="fas fa-chart-line text-success"></i>
                                    Performance Stats
                                </h6>
                                <div class="member-detail-row">
                                    <span class="detail-label-col">Knowledge Cards:</span>
                                    <span class="detail-value-col">
                                        <strong class="text-primary">22</strong> Created
                                    </span>
                                </div>
                                <div class="member-detail-row">
                                    <span class="detail-label-col">Approvals:</span>
                                    <span class="detail-value-col">
                                        <strong class="text-success">18</strong> Approved
                                    </span>
                                </div>
                                <div class="member-detail-row">
                                    <span class="detail-label-col">Contributions:</span>
                                    <span class="detail-value-col">
                                        <strong class="text-info">45</strong> Reviews
                                    </span>
                                </div>
                                <div class="member-detail-row">
                                    <span class="detail-label-col">Last Activity:</span>
                                    <span class="detail-value-col">2 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="member-detail-section">
                        <h6>
                            <i class="fas fa-tasks text-warning"></i>
                            Recent Activities
                        </h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-plus-circle text-success me-3"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">Added new knowledge card "Git Workflow Best Practices"</p>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-primary me-3"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">Reviewed knowledge card "API Documentation"</p>
                                        <small class="text-muted">5 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-edit text-warning me-3"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">Updated "React Best Practices" knowledge card</p>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#changeRoleModal">
                        <i class="fas fa-user-tag me-1"></i> Change Role
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-envelope me-1"></i> Send Message
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Role selection function
        function selectRole(element) {
            // Remove selected class from all cards
            document.querySelectorAll('.role-option-card').forEach(card => {
                card.classList.remove('selected');
            });
            // Add selected class to clicked card
            element.classList.add('selected');
        }

        // Search functionality
        document.querySelector('.team-search-box input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.team-member-card').forEach(card => {
                const name = card.querySelector('.member-name-title h5').textContent.toLowerCase();
                const position = card.querySelector('.member-position-title').textContent.toLowerCase();
                const email = card.querySelector('.member-info-row span').textContent.toLowerCase();

                if (name.includes(searchTerm) || position.includes(searchTerm) || email.includes(
                        searchTerm)) {
                    card.closest('.col-xl-3').style.display = '';
                } else {
                    card.closest('.col-xl-3').style.display = 'none';
                }
            });
        });
    </script>
@endsection
