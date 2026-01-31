@extends('admin.layout.master')

@section('title', 'Service Providers')

@section('css')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="h3 mb-2 text-gray-800">Service Providers</h1>
    <p class="mb-4">Monitor and manage service providers accounts.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Providers Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>Provider Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Services Offered</th>
                            <th>Hourly Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Provider Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Services Offered</th>
                            <th>Hourly Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        @forelse ($providers as $provider)
                            @php
                                $isActive = $provider->status === \App\Models\User::STATUS_ACTIVE;
                                $services = $provider->providerProfile?->services ?? collect();
                                $categoryCodes = $services->map(fn ($service) => $service->category?->code)->filter()->unique()->values();
                                $rates = $services->pluck('hourly_rate')->filter()->values();
                                $minRate = $rates->min();
                                $maxRate = $rates->max();
                            @endphp
                            <tr>
                                <td>{{ $provider->name }}</td>
                                <td>{{ $provider->email }}</td>
                                <td>{{ $provider->phone ?? 'N/A' }}</td>
                                <td>
                                    @if ($categoryCodes->isNotEmpty())
                                        @foreach ($categoryCodes as $code)
                                            <span class="badge badge-primary">{{ $code }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($rates->isNotEmpty())
                                        ${{ number_format($minRate, 2) }}
                                        @if ($minRate !== $maxRate)
                                            - ${{ number_format($maxRate, 2) }}
                                        @endif
                                        / hr
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $isActive ? 'success' : 'secondary' }}">
                                        {{ $isActive ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.users.status', $provider) }}" class="d-inline">
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
                                <td colspan="7" class="text-center text-muted">No providers found.</td>
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
