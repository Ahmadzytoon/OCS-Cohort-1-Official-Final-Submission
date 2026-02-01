@extends('admin.layout.master')

@section('title', 'Studio Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/approval.css') }}">
@endsection

@section('content')
<div class="container-fluid main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Studio Details</h1>
            <p class="text-muted mb-0">{{ $studio->studio_name ?? '-' }} • {{ $user->email }}</p>
        </div>

        <div class="page-actions d-flex gap-2">
            <a href="{{ route('admin.studios', ['tab' => $user->status]) }}" class="btn btn-outline-secondary">Back</a>

            @if($user->status !== 'approved')
                <form method="POST" action="{{ route('admin.studios.approve', $user->id) }}">
                    @csrf
                    <button class="btn btn-success"><i class="fas fa-check"></i> Approve</button>
                </form>
            @endif

            @if($user->status !== 'rejected')
                <form method="POST" action="{{ route('admin.studios.reject', $user->id) }}">
                    @csrf
                    <button class="btn btn-danger"><i class="fas fa-times"></i> Reject</button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
    $services = is_array($studio->services)
        ? implode(', ', $studio->services)
        : ($studio->services ?? '-');

    $equipment = is_array($studio->equipment_tags)
        ? implode(', ', $studio->equipment_tags)
        : ($studio->equipment_tags ?? '-');

    // ✅ working_hours: nested array -> format it nicely
    $hours = '-';
    if (is_array($studio->working_hours)) {
        $parts = [];
        foreach ($studio->working_hours as $day => $info) {
            if (is_array($info)) {
                if (!empty($info['closed'])) {
                    $parts[] = ucfirst($day) . ': Closed';
                } else {
                    $open = $info['open'] ?? '';
                    $close = $info['close'] ?? '';
                    $parts[] = ucfirst($day) . ': ' . ($open && $close ? "$open - $close" : '—');
                }
            }
        }
        $hours = $parts ? implode(' | ', $parts) : '-';
    } elseif (!empty($studio->working_hours)) {
        $hours = $studio->working_hours;
    }
@endphp


    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card p-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('/img/Userprofile.png') }}" class="rounded-circle" style="width:70px;height:70px;" alt="">
                    <div>
                        <h5 class="mb-1">{{ $studio->studio_name ?? '-' }}</h5>
                        <div class="text-muted small">{{ $user->email }}</div>

                        <div class="mt-2">
                            <span class="badge bg-secondary">Studio</span>
                            <span class="badge {{ $user->status=='approved' ? 'bg-success' : ($user->status=='pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="small text-muted mb-1">Owner: <strong class="text-dark">{{ $user->full_name }}</strong></div>
                <div class="small text-muted mb-1">Phone: <strong class="text-dark">{{ $studio->phone_number ?? '-' }}</strong></div>
                <div class="small text-muted mb-1">Working Hours: <strong class="text-dark">{{ $hours }}</strong></div>
                <div class="small text-muted mb-1">Address: <strong class="text-dark">{{ $studio->address ?? '-' }}</strong></div>
                <div class="small text-muted mb-1">
                    Location:
                    <strong class="text-dark">{{ $studio->location_lat ?? '-' }}</strong> ,
                    <strong class="text-dark">{{ $studio->location_lng ?? '-' }}</strong>
                </div>
                <div class="small text-muted mb-1">Team Size: <strong class="text-dark">{{ $studio->team_size ?? '-' }}</strong></div>
                <div class="small text-muted mb-1">Services: <strong class="text-dark">{{ $services }}</strong></div>
                <div class="small text-muted mb-1">Equipment: <strong class="text-dark">{{ $equipment }}</strong></div>

                @if(!empty($studio->description))
                    <div class="mt-3">
                        <div class="small text-muted mb-1">Description</div>
                        <div class="text-dark">{{ $studio->description }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card p-3">
                <h5 class="mb-3">Studio Portfolio</h5>

                @if($portfolio->count())
                    <div class="row g-2">
                        @foreach($portfolio as $item)
                            <div class="col-6 col-md-4">
                                <img src="{{ asset('storage/' . $item->image_path) }}"
                                     class="w-100 rounded"
                                     style="height:140px;object-fit:cover;"
                                     alt="Portfolio">
                                <div class="small text-muted mt-1">
                                    {{ optional($item->uploaded_at)->diffForHumans() ?? '' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-muted">No portfolio uploaded.</div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
