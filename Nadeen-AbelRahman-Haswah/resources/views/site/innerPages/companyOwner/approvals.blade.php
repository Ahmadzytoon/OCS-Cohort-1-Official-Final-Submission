@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Approvals</a></li>
                <li class="breadcrumb-item active">Approvals</li>
            </ol>
        </nav>
    </div>

    <div class="content-body">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">
                    <i class="fas fa-check-circle text-success me-2"></i> Approvals
                </h4>
                <p class="text-muted">Review and approve pending knowledge cards</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-outline-secondary" onclick="bulkApprove()">
                    <i class="fas fa-check-double me-2"></i> Bulk Approve
                </button>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="approval-stat-card pending">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-details">
                        <h3>{{ $pendingCount }}</h3>
                        <p>Pending Approval</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="approval-stat-card approved">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <h3>{{ $approvedThisMonth }}</h3>

                        <p>Approved This Month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="approval-stat-card rejected">
                    <div class="stat-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-details">
                        <h3>{{ $rejectedThisMonth }}</h3>

                        <p>Rejected This Month</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Filters -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <select class="form-select" id="filterKnowledgeType">
                    <option value="">All Knowledge Types</option>
                    <option value="onboarding">Onboarding Knowledge</option>
                    <option value="mistakes">Mistakes & Lessons</option>
                    <option value="operational">Operational Knowledge</option>
                    <option value="critical">Critical & Strategic</option>
                </select>
            </div>

            @if (auth()->user()->role === 'company_owner')
                <div class="col-md-3">
                    <select class="form-select" id="filterDepartment">
                        <option value="">All Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-md-3">
                <input class="form-control" id="filterAuthor" placeholder="Search by author name">
            </div>

            <div class="col-md-3">
                <button class="btn btn-outline-secondary w-100" onclick="applyFilters()">
                    <i class="fas fa-filter me-2"></i> Apply Filters
                </button>
            </div>
        </div>


        <!-- Pending Approvals List -->
        <div class="content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Pending Knowledge Cards ({{ $entries->total() }})</h4>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                    <label class="form-check-label" for="selectAll">Select All</label>
                </div>
            </div>

            <div class="card-body p-0">
                @forelse($entries as $entry)
                    <div class="approval-item" id="entry-row-{{ $entry->id }}">
                        <div class="approval-select">
                            <input type="checkbox" class="form-check-input approval-checkbox" value="{{ $entry->id }}">
                        </div>

                        <div class="approval-content">
                            <div class="approval-header-row">
                                <div class="approval-title-section">
                                    <h5 class="approval-title">{{ $entry->title }}</h5>
                                    <div class="approval-badges">
                                        <span class="type-badge">
                                            <i class="fas fa-tag"></i> {{ $entry->type }}
                                        </span>
                                        <span class="dept-badge">
                                            <i class="fas fa-building"></i> {{ $entry->department?->name }}
                                        </span>
                                    </div>
                                </div>

                                <div class="approval-meta">
                                    <div class="meta-info">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($entry->author?->name ?? 'User') }}"
                                            alt="Author" class="author-avatar">
                                        <div>
                                            <div class="author-name">{{ $entry->author?->name }}</div>
                                            <div class="submitted-time">
                                                <i class="fas fa-clock"></i>
                                                {{ optional($entry->submitted_at)->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="approval-description">
                                <p>{{ \Illuminate\Support\Str::limit($entry->summary, 220) }}</p>
                            </div>

                            <div class="approval-actions-row">
                                <button class="btn btn-sm btn-outline-primary"
                                    onclick="viewCardDetails({{ $entry->id }})">
                                    <i class="fas fa-eye me-1"></i> View Full Details
                                </button>

                                <div class="action-buttons-group">
                                    <button class="btn btn-success" onclick="openApproveModal({{ $entry->id }})">
                                        <i class="fas fa-check me-1"></i> Approve
                                    </button>
                                    <button class="btn btn-danger" onclick="openRejectModal({{ $entry->id }})">
                                        <i class="fas fa-times me-1"></i> Reject
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No pending knowledge cards.</div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $entries->links() }}
            </div>

        </div>


    </div>

    <!-- Approve with Comment Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success bg-opacity-10">
                    <h5 class="modal-title text-success">
                        <i class="fas fa-check-circle me-2"></i> Approve Knowledge Card
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Approval Comment (Optional)</label>
                        <textarea class="form-control" id="approvalComment" rows="4" placeholder="Add any comments or suggestions..."></textarea>
                        <small class="text-muted">Your comment will be visible to the author</small>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="notifyAuthor" checked>
                        <label class="form-check-label" for="notifyAuthor">
                            Notify author via email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="confirmApproval()">
                        <i class="fas fa-check me-1"></i> Approve Card
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject with Comment Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger bg-opacity-10">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-times-circle me-2"></i> Reject Knowledge Card
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Additional Comments <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectionComment" rows="4"
                            placeholder="Explain why this card is being rejected..." required></textarea>
                        <small class="text-muted">Please provide clear feedback so the author can improve</small>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="notifyAuthorReject" checked>
                        <label class="form-check-label" for="notifyAuthorReject">
                            Notify author via email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmRejection()">
                        <i class="fas fa-times me-1"></i> Reject Card
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-eye me-2"></i> Knowledge Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailsModalBody">
                    <div class="text-center text-muted py-4">Loading...</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        let currentEntryId = null;

        function applyFilters() {
            const type = document.getElementById('filterKnowledgeType')?.value || '';
            const author = document.getElementById('filterAuthor')?.value || '';
            const deptEl = document.getElementById('filterDepartment');
            const department_id = deptEl ? deptEl.value : '';

            const params = new URLSearchParams();
            if (type) params.append('type', type);
            if (author) params.append('author', author);
            if (department_id) params.append('department_id', department_id);

            window.location.href = `{{ route('shared.approvals.index') }}?${params.toString()}`;
        }

        async function viewCardDetails(id) {
            const modalEl = document.getElementById('detailsModal');
            const bodyEl = document.getElementById('detailsModalBody');
            bodyEl.innerHTML = `<div class="text-center text-muted py-4">Loading...</div>`;

            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            try {
                const res = await fetch(`{{ url('/shared/approvals') }}/${id}/details`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await res.json();

                if (!data.ok) throw new Error('Failed');
                bodyEl.innerHTML = data.html;

            } catch (e) {
                bodyEl.innerHTML = `<div class="alert alert-danger">Failed to load details.</div>`;
            }
        }

        function openApproveModal(id) {
            currentEntryId = id;
            document.getElementById('approvalComment').value = '';
            new bootstrap.Modal(document.getElementById('approveModal')).show();
        }

        function openRejectModal(id) {
            currentEntryId = id;
            document.getElementById('rejectionComment').value = '';
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }

        async function confirmApproval() {
            const comment = document.getElementById('approvalComment').value.trim();

            try {
                const res = await fetch(`{{ url('/shared/approvals') }}/${currentEntryId}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': `{{ csrf_token() }}`,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        comment
                    })
                });
                const data = await res.json();

                if (!data.ok) throw new Error(data.message || 'Failed');

                bootstrap.Modal.getInstance(document.getElementById('approveModal')).hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Approved',
                    text: data.message
                });

                document.getElementById(`entry-row-${currentEntryId}`)?.remove();

            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: e.message || 'Something went wrong'
                });
            }
        }

        async function confirmRejection() {
            const comment = document.getElementById('rejectionComment').value.trim();
            if (!comment) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required',
                    text: 'Rejection comment is required.'
                });
                return;
            }

            try {
                const res = await fetch(`{{ url('/shared/approvals') }}/${currentEntryId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': `{{ csrf_token() }}`,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        comment
                    })
                });
                const data = await res.json();

                if (!data.ok) throw new Error(data.message || 'Failed');

                bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Rejected',
                    text: data.message
                });

                document.getElementById(`entry-row-${currentEntryId}`)?.remove();

            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: e.message || 'Something went wrong'
                });
            }
        }

        function toggleSelectAll() {
            const all = document.getElementById('selectAll').checked;
            document.querySelectorAll('.approval-checkbox').forEach(cb => cb.checked = all);
        }

        async function bulkApprove() {
            const ids = Array.from(document.querySelectorAll('.approval-checkbox:checked')).map(cb => parseInt(cb
                .value));
            if (!ids.length) {
                Swal.fire({
                    icon: 'info',
                    title: 'No selection',
                    text: 'Select at least one card.'
                });
                return;
            }

            const confirm = await Swal.fire({
                icon: 'question',
                title: 'Bulk Approve',
                text: `Approve ${ids.length} selected cards?`,
                showCancelButton: true,
                confirmButtonText: 'Approve'
            });

            if (!confirm.isConfirmed) return;

            try {
                const res = await fetch(`{{ route('shared.approvals.bulkApprove') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': `{{ csrf_token() }}`,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        ids
                    })
                });
                const data = await res.json();
                if (!data.ok) throw new Error(data.message || 'Failed');

                Swal.fire({
                    icon: 'success',
                    title: 'Done',
                    text: data.message
                });

                ids.forEach(id => document.getElementById(`entry-row-${id}`)?.remove());

            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: e.message || 'Something went wrong'
                });
            }
        }
    </script>
@endsection
