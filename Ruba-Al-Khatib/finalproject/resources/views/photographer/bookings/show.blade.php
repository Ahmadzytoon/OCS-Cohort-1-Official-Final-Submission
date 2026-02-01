@extends('photographer.layout')

@section('title', 'Booking Details')

@section('styles')
<style>
    /* Minimal extra styles for details page */
    .page-header {
        padding: 2rem 0 1.5rem;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 2rem;
    }
    .header-content{
        display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap;
    }
    .back-link{ display:inline-flex; gap:.5rem; align-items:center; color:#64748b; padding:.75rem 0; }
    .back-link:hover{ color: var(--primary-accent); }

    .two-col{
        display:grid;
        grid-template-columns: 1fr 420px;
        gap: 1.5rem;
        align-items:start;
    }
    @media (max-width: 1024px){
        .two-col{ grid-template-columns: 1fr; }
        .sticky{ position: static !important; }
    }

    .card{
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius:1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }
    .card-header{
        display:flex; align-items:center; gap:.75rem;
        border-bottom:1px solid #e5e7eb;
        padding-bottom:.75rem; margin-bottom:1rem;
    }
    .icon-box{
        width:40px; height:40px; border-radius:.75rem;
        background: rgba(166,124,82,.1);
        display:flex; align-items:center; justify-content:center;
        color: var(--primary-accent);
    }

    .info-item{ display:flex; gap:1rem; padding:.75rem 0; border-bottom:1px solid #f3f4f6; }
    .info-item:last-child{ border-bottom:none; }
    .info-label{ width:160px; font-weight:700; color:#232222; }
    .info-value{ flex:1; color:#64748b; }

    .status-badge{
        display:inline-flex; align-items:center;
        padding: .35rem .8rem;
        border-radius: 999px;
        font-weight:700; font-size:.9rem;
        border:1px solid transparent;
    }
    .status-pending{ background:rgba(251,191,36,.12); color:#d97706; border-color:rgba(251,191,36,.25);}
    .status-approved{ background:rgba(74,222,128,.12); color:#059669; border-color:rgba(74,222,128,.25);}
    .status-rejected{ background:rgba(248,113,113,.12); color:#dc2626; border-color:rgba(248,113,113,.25);}
    .status-completed{ background:rgba(100,116,139,.12); color:#475569; border-color:rgba(100,116,139,.25);}

    .actions{
        display:flex; flex-direction:column; gap:.75rem;
    }
    .sticky{ position: sticky; top: 1.25rem; }
    .btn-lg{ padding: 1rem 1.25rem; font-size: 1rem; width: 100%; justify-content:center; }
</style>
@endsection

@section('content')

<header class="page-header">
    <div class="container">
        <a href="{{ route('photographer.bookings.index', ['status' => request('status','pending')]) }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Bookings</span>
        </a>

        <div class="header-content">
            <div>
                <h1 style="margin:0;">Booking #{{ $booking->id }}</h1>
                <p style="margin:.25rem 0 0;">Session Type ID: {{ $booking->session_type_id }}</p>

                <div style="margin-top:.75rem;">
                    <span class="status-badge status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            <div style="display:flex; gap:.75rem; align-items:center;">
                <button class="btn btn-outline" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="container">
        <div class="two-col">

            {{-- LEFT --}}
            <div>
                {{-- Customer --}}
                <div class="card">
                    <div class="card-header">
                        <div class="icon-box"><i class="fas fa-user"></i></div>
                        <h3 style="margin:0;">Customer Information</h3>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Name</div>
                        <div class="info-value"><strong style="color:#232222;">{{ $booking->customer->full_name ?? '-' }}</strong></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $booking->customer->email ?? '-' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $booking->customer->phone ?? '-' }}</div>
                    </div>
                </div>

                {{-- Session Details --}}
                <div class="card">
                    <div class="card-header">
                        <div class="icon-box"><i class="fas fa-calendar-alt"></i></div>
                        <h3 style="margin:0;">Session Details</h3>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Date</div>
                        <div class="info-value">
                            {{ optional($booking->booking_date)->format('D, M d, Y') ?? ($booking->booking_date ?? '-') }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Time</div>
                        <div class="info-value">{{ $booking->booking_time ?? '-' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Session Type</div>
                        <div class="info-value">Session #{{ $booking->session_type_id }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Location Type</div>
                        <div class="info-value">{{ $booking->location_type ?? '-' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $booking->location_address ?? '-' }}</div>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="card">
                    <div class="card-header">
                        <div class="icon-box"><i class="fas fa-sticky-note"></i></div>
                        <h3 style="margin:0;">Customer Notes</h3>
                    </div>

                    @if(!empty($booking->notes))
                        <div style="background:#f3f4f6; padding:1rem; border-radius:.75rem; color:#475569; line-height:1.8;">
                            {!! nl2br(e($booking->notes)) !!}
                        </div>
                    @else
                        <p style="margin:0;">No notes.</p>
                    @endif
                </div>
            </div>

            {{-- RIGHT --}}
            <div>
                <div class="card sticky">
                    <div class="card-header">
                        <div class="icon-box"><i class="fas fa-cogs"></i></div>
                        <h3 style="margin:0;">Actions</h3>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Price</div>
                        <div class="info-value">
                            <strong style="font-size:1.25rem; color:#232222;">
                                ${{ $booking->price ?? '0' }}
                            </strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>

                    <div style="margin-top:1rem;" class="actions">
                        @if($booking->status === 'pending')
                            <form method="POST" action="{{ route('photographer.bookings.approve', $booking) }}">
                                @csrf
                                <button class="btn btn-success btn-lg" type="submit">
                                    <i class="fas fa-check-circle"></i> Approve
                                </button>
                            </form>

                            <form method="POST" action="{{ route('photographer.bookings.reject', $booking) }}"
                                  onsubmit="return confirm('Reject this booking?');">
                                @csrf
                                <button class="btn btn-error btn-lg" type="submit">
                                    <i class="fas fa-times-circle"></i> Reject
                                </button>
                            </form>
                        @endif

                        {{-- Optional: Mark completed --}}
                        @if($booking->status === 'approved')
                            <form method="POST" action="{{ route('photographer.bookings.complete', $booking) }}"
                                  onsubmit="return confirm('Mark this booking as completed?');">
                                @csrf
                                <button class="btn btn-primary btn-lg" type="submit">
                                    <i class="fas fa-check-double"></i> Mark as Completed
                                </button>
                            </form>
                        @endif
                    </div>

                    <div style="margin-top:1.25rem; border-top:1px solid #e5e7eb; padding-top:1rem; color:#64748b;">
                        <div style="display:flex; justify-content:space-between; gap:1rem;">
                            <div>Created:</div>
                            <div>{{ optional($booking->created_at)->format('M d, Y') ?? '-' }}</div>
                        </div>
                        <div style="display:flex; justify-content:space-between; gap:1rem; margin-top:.5rem;">
                            <div>Updated:</div>
                            <div>{{ optional($booking->updated_at)->format('M d, Y') ?? '-' }}</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>

@endsection
