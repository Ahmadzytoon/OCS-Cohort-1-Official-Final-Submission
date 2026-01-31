@extends('admin.layout.master')

@section('title', 'Bookings')

@section('css')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="h3 mb-2 text-gray-800">Bookings</h1>
    <p class="mb-4">Bookings monitoring page.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bookings Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service Provider</th>
                            <th>Service Type</th>
                            <th>Booking Date & Time</th>
                            <th>Booking Status</th>
                            <th>Payment Status</th>
                            <th>View</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Customer</th>
                            <th>Service Provider</th>
                            <th>Service Type</th>
                            <th>Booking Date & Time</th>
                            <th>Booking Status</th>
                            <th>Payment Status</th>
                            <th>View</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        @forelse ($bookings as $booking)
                            @php
                                $paymentStatus = $booking->payment?->payment_status ?? 'unpaid';
                                $bookingBadge = match ($booking->status) {
                                    'completed' => 'success',
                                    'accepted' => 'info',
                                    'rejected' => 'danger',
                                    default => 'warning',
                                };
                                $paymentBadge = match ($paymentStatus) {
                                    'paid' => 'success',
                                    'failed' => 'danger',
                                    'pending' => 'warning',
                                    default => 'secondary',
                                };
                            @endphp
                            <tr>
                                <td>{{ $booking->customer?->name ?? 'N/A' }}</td>
                                <td>{{ $booking->provider?->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($booking->category)
                                        <span class="badge badge-primary">{{ $booking->category->code }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $booking->slot?->start_time ?? $booking->created_at?->format('Y-m-d H:i') }}</td>
                                <td><span class="badge badge-{{ $bookingBadge }}">{{ ucfirst($booking->status) }}</span></td>
                                <td><span class="badge badge-{{ $paymentBadge }}">{{ ucfirst($paymentStatus) }}</span></td>
                                <td><span class="text-muted">—</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
@endsection
