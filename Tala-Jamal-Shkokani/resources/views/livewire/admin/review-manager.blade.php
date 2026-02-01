<div class="animate-fade-in">
    <!-- Header & Statistics -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Aesthetic Testimonials</h1>
                <p class="text-muted small mb-0">Moderate and curate the community's impressions of your luxury pieces.</p>
            </div>
            <div class="d-flex gap-2">
                <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1">Total</div>
                    <div class="h5 mb-0 fw-bold">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 text-warning">Pending</div>
                    <div class="h5 mb-0 fw-bold text-warning">{{ $stats['pending'] }}</div>
                </div>
                <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 text-primary">Avg Rating</div>
                    <div class="h5 mb-0 fw-bold text-primary">{{ $stats['average'] }} <i class="fa fa-star fa-xs"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <div class="position-relative">
                            <input type="text" class="form-control border-0 bg-light rounded-3 ps-5 shadow-sm"
                                placeholder="Search comments, clients..." wire:model.live.debounce.300ms="search">
                            <i
                                class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="statusFilter"
                            class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="ratingFilter"
                            class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="">All Ratings</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="dateFilter" class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="all">Any Date</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button wire:click="resetFilters" class="btn btn-light rounded-3 px-3 shadow-sm border-0">
                            <i class="fa fa-undo-alt me-2 text-muted"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        @if(count($selectedRows) > 0)
            <div class="d-flex align-items-center gap-3 animate-fade-in bg-white p-2 rounded-pill shadow border px-4 mb-4">
                <span class="small fw-bold text-primary">{{ count($selectedRows) }} selected</span>
                <div class="vr"></div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-dark border-0 rounded-pill dropdown-toggle"
                        data-bs-toggle="dropdown">
                        Moderation Actions
                    </button>
                    <ul class="dropdown-menu shadow border-0 rounded-4">
                        <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="bulkApprove">Approve
                                Selected</a></li>
                        <li>
                            <hr class="dropdown-divider opacity-50">
                        </li>
                        <li><a class="dropdown-item small py-2 text-danger" href="#" wire:click.prevent="bulkDelete">Remove
                                Permanently</a></li>
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <!-- Testimonials Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="bg-light bg-opacity-50 align-top">
                            <th class="ps-4 py-3 border-0" style="width: 40px;">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none cursor-pointer" type="checkbox"
                                        wire:model.live="selectAll">
                                </div>
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 cursor-pointer"
                                wire:click="sortBy('user_id')">
                                Client @if($sortField === 'user_id') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Piece</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Impression</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center cursor-pointer"
                                wire:click="sortBy('rating')">
                                Star Rating @if($sortField === 'rating') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center cursor-pointer"
                                wire:click="sortBy('is_approved')">
                                Status @if($sortField === 'is_approved') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="pe-4 py-3 border-0 text-end text-uppercase extra-small text-muted fw-bold ls-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($reviews as $review)
                            <tr wire:key="review-row-{{ $review->id }}" class="border-top hover-shadow transition-all"
                                style="border-color: rgba(0,0,0,0.02) !important;">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input shadow-none cursor-pointer" type="checkbox"
                                            value="{{ $review->id }}" wire:model.live="selectedRows">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft-blush rounded-circle d-flex align-items-center justify-content-center me-3 text-dark fw-bold"
                                            style="width: 36px; height: 36px; font-size: 0.8rem; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                            {{ substr($review->user->name ?? 'G', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small mb-0">{{ $review->user->name ?? 'Guest' }}</div>
                                            <div class="extra-small text-muted">{{ $review->created_at->format('M d') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-bold text-dark text-truncate" style="max-width: 140px;">
                                        {{ $review->product->name ?? 'Deleted Item' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-muted text-truncate fst-italic" style="max-width: 280px;">
                                        "{{ $review->comment }}"</div>
                                </td>
                                <td class="text-center">
                                    <div class="text-warning extra-small">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= $review->rating ? '-solid' : '-regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge rounded-pill px-3 py-1 border-0 extra-small fw-bold
                                                    {{ $review->is_approved ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                        {{ $review->is_approved ? 'APPROVED' : 'PENDING' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4" x-data="confirmAction">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button wire:click="toggleApproval({{ $review->id }})"
                                            class="btn btn-sm btn-light rounded-pill px-3 py-1 extra-small fw-bold border shadow-sm hover-lift" title="{{ $review->is_approved ? 'Demote' : 'Approve' }}">
                                            <i class="fa {{ $review->is_approved ? 'fa-arrow-down' : 'fa-check' }}"></i>
                                        </button>
                                        <button wire:click="viewDetails({{ $review->id }})"
                                            class="btn btn-sm btn-light rounded-pill px-3 py-1 extra-small border shadow-sm hover-lift" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button
                                            @click="confirm('deleteReview', {{ $review->id }}, 'Remove Impression?', 'This review will be permanently deleted.')"
                                            class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 extra-small border-0 hover-lift" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa fa-comment-slash fa-3x mb-3 opacity-25 text-primary"></i>
                                    <p class="mb-0 fw-bold">No member impressions match your filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reviews->count() > 0)
            <div class="card-footer bg-white py-4 border-0 d-flex justify-content-center">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>

    <!-- Review Details Sidebar -->
    @if($showReviewSidebar && $selectedReview)
        <div class="position-fixed inset-0 bg-dark bg-opacity-50 blur-bg" style="z-index: 1060;"
            wire:click="$set('showReviewSidebar', false)"></div>
        <div class="bg-white position-fixed top-0 end-0 h-100 shadow-lg animate-slide-in"
            style="width: 450px; z-index: 1070; border-left: 1px solid rgba(0,0,0,0.05);">
            <div class="h-100 d-flex flex-column">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                    <h5 class="mb-0 fw-bold" style="font-family: 'Playfair Display';">Impression Details</h5>
                    <button class="btn-close" wire:click="$set('showReviewSidebar', false)"></button>
                </div>

                <div class="flex-grow-1 overflow-auto p-4">
                    <div class="mb-4 text-center">
                        <div class="bg-soft-blush rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 70px; height: 70px; font-size: 1.5rem; border: 3px solid white; shadow: 0 5px 15px rgba(0,0,0,0.03);">
                            {{ substr($selectedReview->user->name ?? 'G', 0, 1) }}
                        </div>
                        <h6 class="fw-bold mb-0">{{ $selectedReview->user->name ?? 'Guest' }}</h6>
                        <p class="extra-small text-muted">{{ $selectedReview->created_at->format('M d, Y @ H:i') }}</p>
                    </div>

                    <div class="card border-0 bg-light rounded-4 mb-4">
                        <div class="card-body p-4 text-center">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-3 d-block">Client's
                                Rating</label>
                            <div class="h3 mb-3 text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $selectedReview->rating ? '-solid' : '-regular' }} fa-star"></i>
                                @endfor
                            </div>
                            <blockquote class="blockquote small italic text-dark mb-0">
                                "{{ $selectedReview->comment }}"
                            </blockquote>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-3 d-block">Referenced
                            Piece</label>
                        <div class="d-flex align-items-center gap-3 p-3 bg-white border rounded-4 shadow-sm">
                            <div class="bg-light rounded-3 p-1" style="width: 60px; height: 80px;">
                                <img src="{{ $selectedReview->product->image ?? 'https://via.placeholder.com/60' }}"
                                    class="rounded-2 object-fit-cover w-100 h-100">
                            </div>
                            <div>
                                <h6 class="small mb-1 fw-bold">{{ $selectedReview->product->name ?? 'Deleted Piece' }}</h6>
                                <p class="extra-small text-muted mb-0">Original Investment: JOD
                                    {{ number_format($selectedReview->product->price ?? 0, 0) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="alert {{ $selectedReview->is_approved ? 'alert-success' : 'alert-warning' }} border-0 rounded-4 p-3 d-flex align-items-center gap-3 mb-4">
                        <i class="fa {{ $selectedReview->is_approved ? 'fa-check-circle' : 'fa-info-circle' }}"></i>
                        <div class="small fw-bold">Status:
                            {{ $selectedReview->is_approved ? 'Visible on Main Gallery' : 'Waiting for Moderation' }}
                        </div>
                    </div>
                </div>

                <div class="p-4 border-top grid gap-2" x-data="confirmAction">
                    <button wire:click="toggleApproval({{ $selectedReview->id }})"
                        class="btn {{ $selectedReview->is_approved ? 'btn-outline-warning' : 'btn-success text-white' }} w-100 rounded-pill py-3 fw-bold mb-2">
                        {{ $selectedReview->is_approved ? 'Demote Review' : 'Approve Impression' }}
                    </button>
                    <button
                        @click="confirm('deleteReview', {{ $selectedReview->id }}, 'Remove Permanently?', 'This action cannot be undone.')"
                        class="btn btn-link text-danger w-100 extra-small text-decoration-none">
                        Remove Impression Permanently
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .extra-small {
            font-size: 0.65rem;
        }

        .ls-1 {
            letter-spacing: 1.5px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .bg-soft-blush {
            background: rgba(246, 166, 178, 0.15);
        }

        .bg-success-subtle {
            background: rgba(25, 135, 84, 0.1);
            color: #198754 !important;
        }

        .bg-danger-subtle {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545 !important;
        }

        .bg-info-subtle {
            background: rgba(13, 202, 240, 0.1);
            color: #0dcaf0 !important;
        }

        .bg-warning-subtle {
            background: rgba(255, 193, 7, 0.1);
            color: #f59e0b !important;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .form-check-input:checked {
            background-color: #F6A6B2;
            border-color: #F6A6B2;
        }

        .blur-bg {
            backdrop-filter: blur(5px);
        }

        .text-primary {
            color: #F6A6B2 !important;
        }

        .btn-primary {
            background-color: #F6A6B2;
            border-color: #F6A6B2;
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
            transform: translateY(-2px);
            background-color: #fff !important;
            z-index: 10;
            position: relative;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .hover-lift {
            transition: all 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
        }
    </style>
</div>