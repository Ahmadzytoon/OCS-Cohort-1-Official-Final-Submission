@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Users & Roles</a></li>
                <li class="breadcrumb-item active">Access Requests</li>
            </ol>
        </nav>
    </div>

    <div class="content-body">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">Access Requests</h4>
                <p class="text-muted">Review and manage pending access requests from users</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-history me-2"></i> View History
                </button>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $pendingCount }}</h4>
                        <p>Pending Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $approvedThisMonth }}</h4>
                        <p>Approved This Month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-mini-card">
                    <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stats-info">
                        <h4>{{ $rejectedThisMonth }}</h4>
                        <p>Rejected This Month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="content-card">
            <div class="card-header">
                <h4>Pending Access Requests</h4>
            </div>
            <div class="card-body">
                @forelse($pendingRequests as $req)
                    <div class="access-request-item">
                        <div class="request-user">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($req->name) }}" class="request-avatar">
                            <div class="request-info">
                                <h6>{{ $req->name }}</h6>
                                <p class="text-muted mb-1">{{ $req->email }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i> Requested {{ $req->created_at }}
                                </small>
                            </div>
                        </div>

                        <div class="request-details">
                            <div class="detail-item">
                                <span class="detail-label">Company</span>
                                <span class="detail-value">{{ $req->company?->workspace_name }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Department</span>
                                <span class="detail-value">{{ $req->department?->name ?? '—' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Requested Role</span>
                                <span class="detail-value">{{ $req->requested_role }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Message</span>
                                <span class="detail-value">{{ $req->message ?? '—' }}</span>
                            </div>
                        </div>

                        <div class="request-actions">
                            {{-- بدون JS: نستخدم data-bs-target للـ modal الخاص بكل طلب --}}
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#approveModal-{{ $req->id }}">
                                <i class="fas fa-check me-1"></i> Approve
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#rejectModal-{{ $req->id }}">
                                <i class="fas fa-times me-1"></i> Reject
                            </button>
                        </div>
                    </div>

                    {{-- Approve Modal (لكل Request) --}}
                    <div class="modal fade" id="approveModal-{{ $req->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-success bg-opacity-10">
                                    <h5 class="modal-title text-success">
                                        <i class="fas fa-check-circle me-2"></i> Approve Access Request
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="POST" action="{{ route('shared.accessRequests.approve', $req->id) }}">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label">Assign Department</label>
                                            <select class="form-select" name="department_id">
                                                <option value="">(Keep requested)</option>
                                                @foreach ($departments as $dep)
                                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Assign Role</label>
                                            <select class="form-select" name="approved_role" required>
                                                <option value="department_manager">Department Manager</option>
                                                <option value="employee" selected>Employee</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Position</label>
                                            <input type="text" name="position" class="form-control"
                                                placeholder="Position">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Welcome Message (Optional)</label>
                                            <textarea class="form-control" name="welcome_message" rows="3" placeholder="Welcome to the team!"></textarea>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check me-1"></i> Approve & Send Invite
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    {{-- Reject Modal (لكل Request) --}}
                    <div class="modal fade" id="rejectModal-{{ $req->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger bg-opacity-10">
                                    <h5 class="modal-title text-danger">
                                        <i class="fas fa-times-circle me-2"></i> Reject Access Request
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="POST"
                                    action="{{ route('shared.accessRequests.reject', $req->id) }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Reason for Rejection</label>
                                            <select class="form-select mb-3" name="rejection_reason" required>
                                                <option value="">Select reason</option>
                                                <option value="not_hiring">Not currently hiring</option>
                                                <option value="no_position">No available positions</option>
                                                <option value="qualifications">Doesn't meet qualifications</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Additional Message (Optional)</label>
                                            <textarea class="form-control" name="rejection_message" rows="3" placeholder="Thank you for your interest..."></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times me-1"></i> Reject Request
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                @empty
                    <p class="text-muted text-center">No pending requests.</p>
                @endforelse

                {{-- Pagination (بدون JS) --}}
                <div class="mt-3">
                    {{ $pendingRequests->links() }}
                </div>

            </div>

        </div>
    </div>

@endsection
