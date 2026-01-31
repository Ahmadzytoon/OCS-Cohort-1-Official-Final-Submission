@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="content-body">
        <!-- Department Header Card -->
        <div class="dept-header-card">
            <div class="dept-header-content">
                <div class="dept-icon-large">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <div class="dept-header-info flex-grow-1">
                    <h2>IT Department</h2>
                    <p>Welcome back, Ahmed! Here's what's happening in your department today.</p>
                </div>
            </div>
            <div class="dept-header-stats">
                <div class="header-stat-item">
                    <h4>12</h4>
                    <small>Team Members</small>
                </div>
                <div class="header-stat-item">
                    <h4>45</h4>
                    <small>Knowledge Cards</small>
                </div>
                <div class="header-stat-item">
                    <h4>8</h4>
                    <small>Pending Approvals</small>
                </div>
                <div class="header-stat-item">
                    <h4>78%</h4>
                    <small>Completion Rate</small>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="dept-stat-card members">
                    <div class="stat-header-dept">
                        <div class="stat-icon-dept">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +2
                        </span>
                    </div>
                    <div class="stat-value-dept">12</div>
                    <div class="stat-label-dept">Active Team Members</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dept-stat-card knowledge">
                    <div class="stat-header-dept">
                        <div class="stat-icon-dept">
                            <i class="fas fa-book"></i>
                        </div>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +5
                        </span>
                    </div>
                    <div class="stat-value-dept">45</div>
                    <div class="stat-label-dept">Knowledge Cards</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dept-stat-card approvals">
                    <div class="stat-header-dept">
                        <div class="stat-icon-dept">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="stat-change neutral">
                            <i class="fas fa-minus"></i> 0
                        </span>
                    </div>
                    <div class="stat-value-dept">8</div>
                    <div class="stat-label-dept">Pending Approvals</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dept-stat-card completion">
                    <div class="stat-header-dept">
                        <div class="stat-icon-dept">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +5%
                        </span>
                    </div>
                    <div class="stat-value-dept">78%</div>
                    <div class="stat-label-dept">Completion Rate</div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Team Members -->
                <div class="content-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-users text-primary me-2"></i>
                            Team Members
                        </h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#inviteEmployeeModal">
                            <i class="fas fa-user-plus me-1"></i> Add Member
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="team-member-item">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Ahmed&background=47b2e4&color=fff"
                                alt="Sarah Ahmed" class="member-avatar-dept">
                            <div class="member-info-dept">
                                <h6>Sarah Ahmed</h6>
                                <small><i class="fas fa-briefcase me-1"></i> Senior Developer</small>
                            </div>
                            <span class="member-status online">
                                <i class="fas fa-circle"></i> Online
                            </span>
                        </div>
                        <div class="team-member-item">
                            <img src="https://ui-avatars.com/api/?name=Mohammad+Ali&background=28a745&color=fff"
                                alt="Mohammad Ali" class="member-avatar-dept">
                            <div class="member-info-dept">
                                <h6>Mohammad Ali</h6>
                                <small><i class="fas fa-briefcase me-1"></i> Full Stack Developer</small>
                            </div>
                            <span class="member-status online">
                                <i class="fas fa-circle"></i> Online
                            </span>
                        </div>
                        <div class="team-member-item">
                            <img src="https://ui-avatars.com/api/?name=Layla+Hassan&background=ffc107&color=fff"
                                alt="Layla Hassan" class="member-avatar-dept">
                            <div class="member-info-dept">
                                <h6>Layla Hassan</h6>
                                <small><i class="fas fa-briefcase me-1"></i> UI/UX Designer</small>
                            </div>
                            <span class="member-status away">
                                <i class="fas fa-circle"></i> Away
                            </span>
                        </div>
                        <div class="team-member-item">
                            <img src="https://ui-avatars.com/api/?name=Omar+Khaled&background=dc3545&color=fff"
                                alt="Omar Khaled" class="member-avatar-dept">
                            <div class="member-info-dept">
                                <h6>Omar Khaled</h6>
                                <small><i class="fas fa-briefcase me-1"></i> DevOps Engineer</small>
                            </div>
                            <span class="member-status offline">
                                <i class="fas fa-circle"></i> Offline
                            </span>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-sm btn-link">View All Members (12)</a>
                        </div>
                    </div>
                </div>

                <!-- Knowledge Progress -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-bar text-success me-2"></i>
                            Knowledge Distribution
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="knowledge-progress-item">
                            <div class="progress-header-dept">
                                <span class="progress-label-dept">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>
                                    Onboarding Knowledge
                                </span>
                                <span class="progress-percentage-dept">15 / 20 (75%)</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="knowledge-progress-item">
                            <div class="progress-header-dept">
                                <span class="progress-label-dept">
                                    <i class="fas fa-cogs text-success me-2"></i>
                                    Operational Knowledge
                                </span>
                                <span class="progress-percentage-dept">18 / 20 (90%)</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 90%"></div>
                            </div>
                        </div>
                        <div class="knowledge-progress-item">
                            <div class="progress-header-dept">
                                <span class="progress-label-dept">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Mistakes & Lessons
                                </span>
                                <span class="progress-percentage-dept">6 / 15 (40%)</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"></div>
                            </div>
                        </div>
                        <div class="knowledge-progress-item">
                            <div class="progress-header-dept">
                                <span class="progress-label-dept">
                                    <i class="fas fa-star text-danger me-2"></i>
                                    Critical & Strategic
                                </span>
                                <span class="progress-percentage-dept">6 / 10 (60%)</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="content-card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-history text-info me-2"></i>
                            Recent Activity
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="activity-item">
                            <div class="activity-icon-dept added">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="activity-content-dept">
                                <p><strong>Sarah Ahmed</strong> added new knowledge card "Git Workflow Best Practices"</p>
                                <small><i class="fas fa-clock me-1"></i> 2 hours ago</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon-dept approved">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-content-dept">
                                <p><strong>You</strong> approved knowledge card "Docker Container Setup"</p>
                                <small><i class="fas fa-clock me-1"></i> 4 hours ago</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon-dept updated">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="activity-content-dept">
                                <p><strong>Mohammad Ali</strong> updated "API Documentation Standards"</p>
                                <small><i class="fas fa-clock me-1"></i> 6 hours ago</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon-dept added">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="activity-content-dept">
                                <p><strong>Layla Hassan</strong> added new team member "Noor Ibrahim"</p>
                                <small><i class="fas fa-clock me-1"></i> 1 day ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                {{-- <div class="content-card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            Quick Actions
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="#" class="quick-action-btn">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Add Knowledge</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="quick-action-btn">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Add Member</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="quick-action-btn">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>Add Event</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="quick-action-btn">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>View Reports</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- Pending Approvals -->
                <div class="content-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-clock text-warning me-2"></i>
                            Pending Approvals
                        </h4>
                        <span class="badge bg-warning">8</span>
                    </div>
                    <div class="card-body">
                        <div class="approval-item-dept">
                            <div class="approval-icon-dept onboarding">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="approval-content-dept">
                                <h6>New Developer Setup</h6>
                                <small><i class="fas fa-user me-1"></i> Sarah Ahmed</small>
                            </div>
                            <span class="approval-time">2h</span>
                        </div>
                        <div class="approval-item-dept">
                            <div class="approval-icon-dept operational">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="approval-content-dept">
                                <h6>CI/CD Pipeline Guide</h6>
                                <small><i class="fas fa-user me-1"></i> Mohammad Ali</small>
                            </div>
                            <span class="approval-time">5h</span>
                        </div>
                        <div class="approval-item-dept">
                            <div class="approval-icon-dept critical">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="approval-content-dept">
                                <h6>Security Protocol Update</h6>
                                <small><i class="fas fa-user me-1"></i> Omar Khaled</small>
                            </div>
                            <span class="approval-time">1d</span>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-sm btn-warning text-white">
                                <i class="fas fa-eye me-1"></i> View All Approvals
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Department Calendar -->
                <div class="content-card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            Upcoming Events
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="calendar-event-item">
                            <div class="event-date-box-dept">
                                <div class="event-month-dept">JAN</div>
                                <div class="event-day-dept">25</div>
                            </div>
                            <div class="event-content-dept">
                                <h6>Team Sprint Planning</h6>
                                <small><i class="fas fa-clock me-1"></i> 10:00 AM - 12:00 PM</small>
                                <div>
                                    <span class="event-type-badge-dept meeting">
                                        <i class="fas fa-users me-1"></i> Meeting
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="calendar-event-item">
                            <div class="event-date-box-dept">
                                <div class="event-month-dept">JAN</div>
                                <div class="event-day-dept">27</div>
                            </div>
                            <div class="event-content-dept">
                                <h6>React Advanced Workshop</h6>
                                <small><i class="fas fa-clock me-1"></i> 2:00 PM - 5:00 PM</small>
                                <div>
                                    <span class="event-type-badge-dept training">
                                        <i class="fas fa-chalkboard-teacher me-1"></i> Training
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="calendar-event-item">
                            <div class="event-date-box-dept">
                                <div class="event-month-dept">JAN</div>
                                <div class="event-day-dept">30</div>
                            </div>
                            <div class="event-content-dept">
                                <h6>Project Milestone Review</h6>
                                <small><i class="fas fa-clock me-1"></i> 11:00 AM</small>
                                <div>
                                    <span class="event-type-badge-dept deadline">
                                        <i class="fas fa-flag me-1"></i> Deadline
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-calendar me-1"></i> View Full Calendar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
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
                            <label class="form-label">Employee Email</label>
                            <input type="email" class="form-control" placeholder="employee@company.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position/Title</label>
                            <input type="text" class="form-control" placeholder="e.g., Senior Developer" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" required>
                                <option value="">Select Role</option>
                                <option value="employee">Team Member</option>
                                <option value="lead">Team Lead</option>
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            An invitation email will be sent to add this member to the IT Department.
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
