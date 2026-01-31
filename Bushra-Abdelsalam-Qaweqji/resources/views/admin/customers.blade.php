@extends('admin.layout.master')

@section('title', 'Customers')

@section('css')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="h3 mb-2 text-gray-800">Customers</h1>
    <p class="mb-4">Manage and monitor all registered customers.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customers Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        @forelse ($customers as $customer)
                            @php
                                $isActive = $customer->status === \App\Models\User::STATUS_ACTIVE;
                            @endphp
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $isActive ? 'success' : 'secondary' }}">
                                        {{ $isActive ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $customer->created_at?->format('Y-m-d') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.users.status', $customer) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $isActive ? \App\Models\User::STATUS_DEACTIVATED : \App\Models\User::STATUS_ACTIVE }}">
                                        <button class="btn btn-sm btn-{{ $isActive ? 'danger' : 'success' }}">
                                            {{ $isActive ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No customers found.</td>
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
