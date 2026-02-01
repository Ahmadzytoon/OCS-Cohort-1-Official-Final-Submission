@extends('admin.layout.master')

@section('title', 'Photographer Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/approval.css') }}">
@endsection

@section('content')
<div class="container-fluid main-content">

    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h1 class="page-title">Photographer Details</h1>
            <p class="text-muted mb-0">{{ $user->full_name }} • {{ $user->email }}</p>
        </div>

        <div class="page-actions d-flex gap-2">
            <a href="{{ route('admin.photographers', ['tab' => $user->status]) }}" class="btn btn-outline-secondary">
                Back
            </a>

            {{-- Approve / Reject من هون --}}
            @if(($user->status ?? 'pending') !== 'approved')
            <form method="POST" action="{{ route('admin.photographers.approve', $user->id) }}">
                @csrf
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-check"></i> Approve
                </button>
            </form>
            @endif

            @if(($user->status ?? 'pending') !== 'rejected')
            <form method="POST" action="{{ route('admin.photographers.reject', $user->id) }}">
                @csrf
                <button class="btn btn-danger" type="submit">
                    <i class="fas fa-times"></i> Reject
                </button>
            </form>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Left: Profile -->
        <div class="col-lg-4 mb-4">
            <div class="card p-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('/img/Userprofile.png') }}" class="rounded-circle" style="width:70px;height:70px;" alt="">
                    <div>
                        <h5 class="mb-1">{{ $user->full_name }}</h5>
                        <div class="text-muted small">{{ $user->email }}</div>

                        <div class="mt-2">
                            <span class="badge bg-secondary">Photographer</span>
                            @php
                            $st = $user->status ?? 'pending';
                            $badge = $st === 'approved' ? 'bg-success' : ($st === 'pending' ? 'bg-warning text-dark' : 'bg-danger');
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($st) }}</span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="small text-muted mb-1">
                    City: <strong class="text-dark">{{ $photographer->city ?? '-' }}</strong>
                </div>
                <div class="small text-muted mb-1">
                    Experience: <strong class="text-dark">{{ $photographer->years_of_experience ?? 0 }} years</strong>
                </div>
                <div class="small text-muted mb-1">
                    Starting Price: <strong class="text-dark">{{ $photographer->starting_price ?? '-' }}</strong>
                </div>
                <div class="small text-muted mb-1">
                    @php
                    $typesText = is_array($photographer->photography_types)
                    ? implode(', ', $photographer->photography_types)
                    : ($photographer->photography_types ?? '-');
                    @endphp

                    Types: <strong class="text-dark">{{ $typesText ?: '-' }}</strong>

                </div>

                @if(!empty($photographer->bio))
                <div class="mt-3">
                    <div class="small text-muted mb-1">Bio</div>
                    <div class="text-dark">{{ $photographer->bio }}</div>
                </div>
                @endif

                <div class="mt-3 d-flex gap-2 flex-wrap">
                    @if(!empty($photographer->instagram_url))
                    <a class="btn btn-sm btn-outline-secondary" target="_blank" href="{{ $photographer->instagram_url }}">Instagram</a>
                    @endif
                    @if(!empty($photographer->website_url))
                    <a class="btn btn-sm btn-outline-secondary" target="_blank" href="{{ $photographer->website_url }}">Website</a>
                    @endif
                    @if(!empty($photographer->behance_url))
                    <a class="btn btn-sm btn-outline-secondary" target="_blank" href="{{ $photographer->behance_url }}">Behance</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Portfolio -->
        <div class="col-lg-8 mb-4">
            <div class="card p-3">
                <h5 class="mb-3">Portfolio</h5>

                @if($portfolio->count())
                <div class="row g-2">
                    @foreach($portfolio as $item)
                    <div class="col-6 col-md-4">
                        <img
                            src="{{ asset('storage/' . $item->image_path) }}"
                            class="w-100 rounded"
                            style="height:160px;object-fit:cover;"
                            alt="Portfolio">
                        <div class="small text-muted mt-1">
                            {{ $item->uploaded_at ? \Carbon\Carbon::parse($item->uploaded_at)->diffForHumans() : '' }}
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

@section('script')
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('wrapper')?.classList.toggle('toggled');
    });
</script>
@endsection