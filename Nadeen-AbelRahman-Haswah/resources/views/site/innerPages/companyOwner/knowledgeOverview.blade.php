@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Knowledge Center</a></li>
                <li class="breadcrumb-item active">Knowledge Overview</li>
            </ol>
        </nav>
    </div>

    <div class="content-body">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">Knowledge Center Overview</h4>
                <p class="text-muted">Complete overview of your company's knowledge base</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createKnowledgeModal">
                    <i class="fas fa-plus me-2"></i> Create Knowledge Card
                </button>
            </div>
        </div>

        <!-- Knowledge Statistics -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="knowledge-stat-card onboarding-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>89</h3>
                    </div>
                    <div class="stat-footer">
                        <span>Onboarding Knowledge</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary">26%</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="knowledge-stat-card mistakes-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3>67</h3>
                    </div>
                    <div class="stat-footer">
                        <span>Mistakes & Lessons</span>
                        <span class="badge bg-warning bg-opacity-10 text-warning">20%</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="knowledge-stat-card operational-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>124</h3>
                    </div>
                    <div class="stat-footer">
                        <span>Operational Knowledge</span>
                        <span class="badge bg-success bg-opacity-10 text-success">36%</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="knowledge-stat-card critical-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>62</h3>
                    </div>
                    <div class="stat-footer">
                        <span>Critical & Strategic</span>
                        <span class="badge bg-danger bg-opacity-10 text-danger">18%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Analytics -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="card-header">
                        <h4>Knowledge Cards by Department</h4>
                    </div>
                    <div class="card-body">
                        <div class="department-knowledge-list">
                            <div class="dept-knowledge-item">
                                <div class="dept-info">
                                    <div class="dept-icon-small"
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="fas fa-laptop-code"></i>
                                    </div>
                                    <div>
                                        <h6>IT Department</h6>
                                        <small class="text-muted">87 cards</small>
                                    </div>
                                </div>
                                <div class="dept-progress-container">
                                    <div class="progress" style="height: 10px; flex: 1;">
                                        <div class="progress-bar bg-primary" style="width: 25%"></div>
                                    </div>
                                    <span class="progress-percentage">25%</span>
                                </div>
                            </div>
                            <div class="dept-knowledge-item">
                                <div class="dept-info">
                                    <div class="dept-icon-small"
                                        style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <h6>Sales Department</h6>
                                        <small class="text-muted">63 cards</small>
                                    </div>
                                </div>
                                <div class="dept-progress-container">
                                    <div class="progress" style="height: 10px; flex: 1;">
                                        <div class="progress-bar bg-info" style="width: 18%"></div>
                                    </div>
                                    <span class="progress-percentage">18%</span>
                                </div>
                            </div>
                            <div class="dept-knowledge-item">
                                <div class="dept-info">
                                    <div class="dept-icon-small"
                                        style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                        <i class="fas fa-bullhorn"></i>
                                    </div>
                                    <div>
                                        <h6>Marketing Department</h6>
                                        <small class="text-muted">52 cards</small>
                                    </div>
                                </div>
                                <div class="dept-progress-container">
                                    <div class="progress" style="height: 10px; flex: 1;">
                                        <div class="progress-bar bg-warning" style="width: 15%"></div>
                                    </div>
                                    <span class="progress-percentage">15%</span>
                                </div>
                            </div>
                            <div class="dept-knowledge-item">
                                <div class="dept-info">
                                    <div class="dept-icon-small"
                                        style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <div>
                                        <h6>HR Department</h6>
                                        <small class="text-muted">45 cards</small>
                                    </div>
                                </div>
                                <div class="dept-progress-container">
                                    <div class="progress" style="height: 10px; flex: 1;">
                                        <div class="progress-bar bg-success" style="width: 13%"></div>
                                    </div>
                                    <span class="progress-percentage">13%</span>
                                </div>
                            </div>
                            <div class="dept-knowledge-item">
                                <div class="dept-info">
                                    <div class="dept-icon-small"
                                        style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div>
                                        <h6>Finance Department</h6>
                                        <small class="text-muted">38 cards</small>
                                    </div>
                                </div>
                                <div class="dept-progress-container">
                                    <div class="progress" style="height: 10px; flex: 1;">
                                        <div class="progress-bar bg-primary" style="width: 11%"></div>
                                    </div>
                                    <span class="progress-percentage">11%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card">
                    <div class="card-header">
                        <h4>Most Active Departments</h4>
                    </div>
                    <div class="card-body">
                        <div class="active-dept-list">
                            <div class="active-dept-item">
                                <div class="rank-badge rank-1">1</div>
                                <div class="dept-details">
                                    <h6>IT Department</h6>
                                    <small class="text-muted">23 cards this month</small>
                                </div>
                                <i class="fas fa-trophy text-warning"></i>
                            </div>
                            <div class="active-dept-item">
                                <div class="rank-badge rank-2">2</div>
                                <div class="dept-details">
                                    <h6>Sales Department</h6>
                                    <small class="text-muted">18 cards this month</small>
                                </div>
                            </div>
                            <div class="active-dept-item">
                                <div class="rank-badge rank-3">3</div>
                                <div class="dept-details">
                                    <h6>Marketing Department</h6>
                                    <small class="text-muted">15 cards this month</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recently Added Cards -->
        <div class="content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Recently Added Knowledge Cards</h4>
                <a href="#" class="text-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover knowledge-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Department</th>
                                <th>Created By</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="card-title-cell">
                                        <i class="fas fa-file-alt text-primary me-2"></i>
                                        <strong>New Employee Onboarding Process</strong>
                                    </div>
                                </td>
                                <td><span class="type-badge type-onboarding text-center">Onboarding</span></td>
                                <td>HR Department</td>
                                <td>Sarah Ahmed</td>
                                <td>2 hours ago</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="card-title-cell">
                                        <i class="fas fa-file-alt text-warning me-2"></i>
                                        <strong>Customer Data Migration Error</strong>
                                    </div>
                                </td>
                                <td><span class="type-badge type-mistakes">Mistakes</span></td>
                                <td>IT Department</td>
                                <td>Ahmad Khaled</td>
                                <td>5 hours ago</td>
                                <td><span class="status-badge status-active">Approved</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="card-title-cell">
                                        <i class="fas fa-file-alt text-success me-2"></i>
                                        <strong>Weekly Sales Report Template</strong>
                                    </div>
                                </td>
                                <td><span class="type-badge type-operational">Operational</span></td>
                                <td>Sales Department</td>
                                <td>Mohammed Ali</td>
                                <td>1 day ago</td>
                                <td><span class="status-badge status-active">Approved</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="card-title-cell">
                                        <i class="fas fa-file-alt text-danger me-2"></i>
                                        <strong>Q4 Strategic Decision Framework</strong>
                                    </div>
                                </td>
                                <td><span class="type-badge type-critical">Critical</span></td>
                                <td>Management</td>
                                <td>Ahmad Khaled</td>
                                <td>2 days ago</td>
                                <td><span class="status-badge status-active">Approved</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
