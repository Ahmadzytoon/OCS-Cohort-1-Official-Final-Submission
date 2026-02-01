@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Calendar</a></li>
                <li class="breadcrumb-item active">Departments Calendars</li>
            </ol>
        </nav>
    </div>

    <div class="content-body">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">
                    <i class="fas fa-calendar-week text-info me-2"></i> Department Calendars
                </h4>
                <p class="text-muted">View all department-specific events and schedules</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="alert alert-info mb-0 py-2 px-3">
                    <i class="fas fa-info-circle me-2"></i> Read-only view
                </div>
            </div>
        </div>

        <!-- Department Selector -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <select class="form-select" id="departmentSelector" onchange="switchDepartment()">
                    <option value="all">All Departments</option>
                    <option value="it" selected>IT Department</option>
                    <option value="hr">HR Department</option>
                    <option value="sales">Sales Department</option>
                    <option value="marketing">Marketing Department</option>
                    <option value="finance">Finance Department</option>
                </select>
            </div>
            <div class="col-md-8 text-end">
                <button class="btn btn-outline-secondary me-2" onclick="navigateDepCalendar('prev')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn btn-outline-secondary me-2" onclick="navigateDepCalendar('today')">Today</button>
                <button class="btn btn-outline-secondary" onclick="navigateDepCalendar('next')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Department Info -->
        <div class="content-card mb-4">
            <div class="card-body">
                <div class="dept-calendar-header">
                    <div class="dept-icon-calendar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="dept-calendar-info">
                        <h4>IT Department Calendar</h4>
                        <p class="mb-0 text-muted">Manager: Ahmad Khaled | 23 Members</p>
                    </div>
                    <div class="dept-calendar-stats">
                        <div class="stat-item-calendar">
                            <h5>12</h5>
                            <small>Events This Month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Month View -->
        <div class="content-card mb-4">
            <div class="card-body text-center">
                <h3 id="deptCurrentMonth">January 2025</h3>
            </div>
        </div>

        <!-- Department Calendar Grid -->
        <div class="content-card">
            <div class="card-body p-0">
                <div class="calendar-container">
                    <!-- Calendar Weekdays Header -->
                    <div class="calendar-weekdays">
                        <div class="weekday">Sunday</div>
                        <div class="weekday">Monday</div>
                        <div class="weekday">Tuesday</div>
                        <div class="weekday">Wednesday</div>
                        <div class="weekday">Thursday</div>
                        <div class="weekday">Friday</div>
                        <div class="weekday">Saturday</div>
                    </div>

                    <!-- Calendar Days Grid -->
                    <div class="calendar-days">
                        <!-- Days from previous month -->
                        <div class="calendar-day inactive">
                            <div class="day-number">29</div>
                        </div>
                        <div class="calendar-day inactive">
                            <div class="day-number">30</div>
                        </div>
                        <div class="calendar-day inactive">
                            <div class="day-number">31</div>
                        </div>

                        <!-- Current month days -->
                        <div class="calendar-day">
                            <div class="day-number">1</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">2</div>
                            <div class="day-events">
                                <div class="event-item event-dept" onclick="viewDeptEvent(1)">
                                    <i class="fas fa-code"></i> Sprint Planning
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">3</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">4</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">5</div>
                            <div class="day-events">
                                <div class="event-item event-dept" onclick="viewDeptEvent(2)">
                                    <i class="fas fa-users"></i> Team Standup
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">6</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">7</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">8</div>
                            <div class="day-events">
                                <div class="event-item event-dept" onclick="viewDeptEvent(3)">
                                    <i class="fas fa-laptop"></i> Code Review Session
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">9</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">10</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">11</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">12</div>
                            <div class="day-events">
                                <div class="event-item event-dept" onclick="viewDeptEvent(4)">
                                    <i class="fas fa-flag"></i> Release Deadline
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">13</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">14</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">15</div>
                            <div class="day-events">
                                <div class="event-item event-dept" onclick="viewDeptEvent(5)">
                                    <i class="fas fa-chart-bar"></i> Sprint Review
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">16</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">17</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">18</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">19</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">20</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">21</div>
                        </div>
                        <div class="calendar-day today">
                            <div class="day-number">22</div>
                            <div class="today-badge">Today</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">23</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">24</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">25</div>
                            <div class="day-events">
                                <div class="event-item event-dept" onclick="viewDeptEvent(6)">
                                    <i class="fas fa-tools"></i> System Maintenance
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">26</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">27</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">28</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">29</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">30</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">31</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Events List -->
        <div class="content-card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>IT Department Events</h4>
                <span class="badge bg-info">Read-only</span>
            </div>
            <div class="card-body">
                <div class="dept-events-list">
                    <div class="dept-event-item">
                        <div class="event-date-box dept-event-date">
                            <div class="event-month">JAN</div>
                            <div class="event-day">02</div>
                        </div>
                        <div class="event-details">
                            <h6>Sprint Planning Meeting</h6>
                            <p class="mb-1"><i class="fas fa-clock text-primary"></i> 9:00 AM - 11:00 AM</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt text-danger"></i> IT Conference Room</p>
                        </div>
                        <div class="event-type-label">
                            <span class="badge bg-primary">Team Meeting</span>
                        </div>
                    </div>

                    <div class="dept-event-item">
                        <div class="event-date-box dept-event-date">
                            <div class="event-month">JAN</div>
                            <div class="event-day">08</div>
                        </div>
                        <div class="event-details">
                            <h6>Code Review Session</h6>
                            <p class="mb-1"><i class="fas fa-clock text-primary"></i> 2:00 PM - 4:00 PM</p>
                            <p class="mb-0"><i class="fas fa-video text-success"></i> Online via Teams</p>
                        </div>
                        <div class="event-type-label">
                            <span class="badge bg-success">Development</span>
                        </div>
                    </div>

                    <div class="dept-event-item">
                        <div class="event-date-box dept-event-date">
                            <div class="event-month">JAN</div>
                            <div class="event-day">12</div>
                        </div>
                        <div class="event-details">
                            <h6>Version 2.0 Release Deadline</h6>
                            <p class="mb-1"><i class="fas fa-clock text-primary"></i> All Day</p>
                            <p class="mb-0"><i class="fas fa-exclamation-triangle text-warning"></i> Critical Deadline
                            </p>
                        </div>
                        <div class="event-type-label">
                            <span class="badge bg-danger">Deadline</span>
                        </div>
                    </div>
                    <div class="dept-event-item">
                        <div class="event-date-box dept-event-date">
                            <div class="event-month">JAN</div>
                            <div class="event-day">25</div>
                        </div>
                        <div class="event-details">
                            <h6>System Maintenance Window</h6>
                            <p class="mb-1"><i class="fas fa-clock text-primary"></i> 11:00 PM - 3:00 AM</p>
                            <p class="mb-0"><i class="fas fa-server text-info"></i> Production Servers</p>
                        </div>
                        <div class="event-type-label">
                            <span class="badge bg-warning">Maintenance</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Departments Overview -->
        <div class="content-card mt-4">
            <div class="card-header">
                <h4>All Departments Summary</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="dept-summary-card">
                            <div class="dept-summary-icon"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <div class="dept-summary-info">
                                <h6>IT Department</h6>
                                <p class="mb-0">12 events this month</p>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewDepartmentCalendar('it')">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dept-summary-card">
                            <div class="dept-summary-icon"
                                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="dept-summary-info">
                                <h6>HR Department</h6>
                                <p class="mb-0">8 events this month</p>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewDepartmentCalendar('hr')">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dept-summary-card">
                            <div class="dept-summary-icon"
                                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="dept-summary-info">
                                <h6>Sales Department</h6>
                                <p class="mb-0">15 events this month</p>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewDepartmentCalendar('sales')">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dept-summary-card">
                            <div class="dept-summary-icon"
                                style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="dept-summary-info">
                                <h6>Marketing Department</h6>
                                <p class="mb-0">10 events this month</p>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewDepartmentCalendar('marketing')">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dept-summary-card">
                            <div class="dept-summary-icon"
                                style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="dept-summary-info">
                                <h6>Finance Department</h6>
                                <p class="mb-0">6 events this month</p>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewDepartmentCalendar('finance')">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dept-summary-card">
                            <div class="dept-summary-icon"
                                style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="dept-summary-info">
                                <h6>Operations</h6>
                                <p class="mb-0">9 events this month</p>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewDepartmentCalendar('operations')">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- View Department Event Modal -->
    <div class="modal fade" id="viewDeptEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Department Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-lock me-2"></i> This is a department-specific event. Only the department manager
                        can edit it.
                    </div>
                    <div class="event-detail-view">
                        <h4>Sprint Planning Meeting</h4>
                        <div class="detail-item">
                            <i class="fas fa-building text-primary"></i>
                            <span>IT Department</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar text-primary"></i>
                            <span>January 02, 2025</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock text-success"></i>
                            <span>9:00 AM - 11:00 AM</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <span>IT Conference Room</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-user text-warning"></i>
                            <span>Created by: Ahmad Khaled</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
