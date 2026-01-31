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
        <!-- Statistics Overview -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>127</h3>
                        <p>Total Employees</p>
                        <small class="text-success"><i class="fas fa-arrow-up"></i> 12% from last month</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="stat-content">
                        <h3>8</h3>
                        <p>Departments</p>
                        <small class="text-muted">Active departments</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-content">
                        <h3>342</h3>
                        <p>Knowledge Cards</p>
                        <small class="text-success"><i class="fas fa-arrow-up"></i> 23 new this week</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>15</h3>
                        <p>Pending Approvals</p>
                        <small class="text-warning"><i class="fas fa-exclamation-circle"></i> Needs attention</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Knowledge Cards Breakdown -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Knowledge Cards by Type</h4>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="knowledge-type-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="type-badge bg-primary"></div>
                                            <span class="fw-semibold">Onboarding Knowledge</span>
                                        </div>
                                        <span class="text-muted">89</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 26%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="knowledge-type-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="type-badge bg-warning"></div>
                                            <span class="fw-semibold">Mistakes & Lessons</span>
                                        </div>
                                        <span class="text-muted">67</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 20%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="knowledge-type-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="type-badge bg-success"></div>
                                            <span class="fw-semibold">Operational Knowledge</span>
                                        </div>
                                        <span class="text-muted">124</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 36%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="knowledge-type-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="type-badge bg-danger"></div>
                                            <span class="fw-semibold">Critical & Strategic</span>
                                        </div>
                                        <span class="text-muted">62</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 18%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card">
                    <div class="card-header">
                        <h4>Pending Approvals</h4>
                    </div>
                    <div class="card-body">
                        <div class="approval-list">
                            <div class="approval-item">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="approval-icon bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">New Knowledge Card</h6>
                                        <p class="text-muted small mb-1">HR Department</p>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="approval-item">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="approval-icon bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Access Request</h6>
                                        <p class="text-muted small mb-1">John Doe - Marketing</p>
                                        <small class="text-muted">5 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="approval-item">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="approval-icon bg-warning bg-opacity-10 text-warning">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Card Update</h6>
                                        <p class="text-muted small mb-1">IT Department</p>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm w-100 mt-3">View All Approvals</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events & Latest News -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Upcoming Events</h4>
                        <a href="#" class="text-primary small">View Calendar</a>
                    </div>
                    <div class="card-body">
                        <div class="event-list">
                            <div class="event-item">
                                <div class="event-date">
                                    <div class="event-day">24</div>
                                    <div class="event-month">Jan</div>
                                </div>
                                <div class="event-content">
                                    <h6>Team Building Workshop</h6>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-clock me-1"></i> 10:00 AM - 2:00 PM
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-map-marker-alt me-1"></i> Conference Room A
                                    </p>
                                </div>
                            </div>
                            <div class="event-item">
                                <div class="event-date">
                                    <div class="event-day">28</div>
                                    <div class="event-month">Jan</div>
                                </div>
                                <div class="event-content">
                                    <h6>Monthly All-Hands Meeting</h6>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-clock me-1"></i> 3:00 PM - 4:30 PM
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-video me-1"></i> Online via Zoom
                                    </p>
                                </div>
                            </div>
                            <div class="event-item">
                                <div class="event-date">
                                    <div class="event-day">02</div>
                                    <div class="event-month">Feb</div>
                                </div>
                                <div class="event-content">
                                    <h6>New Employee Orientation</h6>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-clock me-1"></i> 9:00 AM - 12:00 PM
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-map-marker-alt me-1"></i> Training Room
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Latest Company News</h4>
                        <a href="#" class="text-primary small">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="news-list">
                            <div class="news-item">
                                <div class="news-icon">
                                    <i class="fas fa-trophy text-warning"></i>
                                </div>
                                <div class="news-content">
                                    <h6>Q4 Results Exceeded Expectations</h6>
                                    <p class="text-muted small mb-0">We're proud to announce that our Q4 performance has
                                        surpassed all targets...</p>
                                    <small class="text-muted">Posted 2 days ago</small>
                                </div>
                            </div>
                            <div class="news-item">
                                <div class="news-icon">
                                    <i class="fas fa-rocket text-primary"></i>
                                </div>
                                <div class="news-content">
                                    <h6>New Product Launch Next Month</h6>
                                    <p class="text-muted small mb-0">Get ready for our biggest product launch of the year
                                        coming in February...</p>
                                    <small class="text-muted">Posted 4 days ago</small>
                                </div>
                            </div>
                            <div class="news-item">
                                <div class="news-icon">
                                    <i class="fas fa-users text-success"></i>
                                </div>
                                <div class="news-content">
                                    <h6>Welcome Our New Team Members</h6>
                                    <p class="text-muted small mb-0">Please join us in welcoming 5 new talented individuals
                                        to our growing team...</p>
                                    <small class="text-muted">Posted 1 week ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
