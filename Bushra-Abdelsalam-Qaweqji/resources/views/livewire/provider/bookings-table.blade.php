<div class="card cc-shell-card">
    <div class="card-body p-4">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted small">Filter:</span>
                <select class="form-select form-select-sm cc-select-sm" wire:model.live="status" style="width: 170px;">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="accepted">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="rejected">Canceled</option>
                </select>
            </div>
            <div class="text-muted small" wire:loading>
                Loading...
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="cc-table-head">
                    <tr>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Time</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="fw-semibold">{{ $booking->customer?->name ?? '-' }}</td>
                            <td class="text-muted">
                                {{ $booking->category?->name ?? ($booking->category?->code ?? '-') }}</td>
                            <td class="text-muted">
                                {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') : '-' }}
                                -
                                {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') : '-' }}
                            </td>
                            <td class="text-muted">{{ $booking->service_address }}</td>
                            <td>
                                <span class="badge cc-badge {{ $statusClass[$booking->status] ?? 'cc-badge-pending' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('provider.bookings.show', $booking) }}"
                                    class="btn btn-sm cc-btn-primary-sm cc-view-details-btn">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted p-4">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
