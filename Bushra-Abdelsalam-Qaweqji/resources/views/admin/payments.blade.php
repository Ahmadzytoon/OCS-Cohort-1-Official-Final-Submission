@extends('admin.layout.master')

@section('title', 'Payments & Transactions')

@section('css')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="h3 mb-2 text-gray-800">Payments & Transactions</h1>
    <p class="mb-4">Transactions monitoring page.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transactions Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Provider</th>
                            <th>Booking Ref</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>View</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Provider</th>
                            <th>Booking Ref</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>View</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        @forelse ($payments as $payment)
                            @php
                                $paymentBadge = match ($payment->payment_status) {
                                    'paid' => 'success',
                                    'failed' => 'danger',
                                    default => 'warning',
                                };
                                $amount = $payment->booking?->total_cost ?? 0;
                            @endphp
                            <tr>
                                <td>#TX-{{ $payment->id }}</td>
                                <td>{{ $payment->booking?->customer?->name ?? 'N/A' }}</td>
                                <td>{{ $payment->booking?->provider?->name ?? 'N/A' }}</td>
                                <td>#BK-{{ $payment->booking_id }}</td>
                                <td>${{ number_format($amount, 2) }}</td>
                                <td><span class="text-muted">N/A</span></td>
                                <td><span class="badge badge-{{ $paymentBadge }}">{{ ucfirst($payment->payment_status) }}</span></td>
                                <td>{{ $payment->created_at?->format('Y-m-d') }}</td>
                                <td><span class="text-muted">—</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No payments found.</td>
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
