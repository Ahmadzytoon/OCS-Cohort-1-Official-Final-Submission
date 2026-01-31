<div class="card cc-shell-card">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
            <div class="d-flex flex-column flex-sm-row gap-2 align-items-start align-items-sm-center w-100">
                <div class="d-flex gap-2 align-items-center">
                    <span class="text-muted small">Filter:</span>
                    <select class="form-select form-select-sm cc-select-sm" wire:model="status" style="width: 170px;">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="rejected">Cancelled</option>
                    </select>
                </div>
                <div class="flex-grow-1">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        placeholder="Search by provider name..."
                        wire:model.debounce.300ms="search">
                </div>
            </div>
            <div class="text-muted small" wire:loading>
                Loading...
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="cc-table-head">
                    <tr>
                        <th>Provider</th>
                        <th>Service</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        @php
                            $paid = $booking->payment && $booking->payment->payment_status === 'paid';
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $booking->provider?->name ?? '-' }}</td>
                            <td class="text-muted">{{ $booking->category?->name ?? $booking->category?->code ?? '-' }}</td>
                            <td class="text-muted">
                                {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') : '-' }}
                                -
                                {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') : '-' }}
                            </td>
                            <td>{{ $statusMap[$booking->status] ?? ucfirst($booking->status) }}</td>
                            <td class="text-end">
                                <a href="{{ route('seeker.bookings.show', $booking) }}"
                                    class="btn btn-sm btn-primary cc-btn-primary">
                                    View
                                </a>
                                @if ($booking->status === 'accepted' && !$paid)
                                    <a href="{{ route('seeker.bookings.pay.form', $booking) }}"
                                        class="btn btn-sm btn-success">
                                        Pay
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted p-4">
                                You have no bookings yet.
                            </td>
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
