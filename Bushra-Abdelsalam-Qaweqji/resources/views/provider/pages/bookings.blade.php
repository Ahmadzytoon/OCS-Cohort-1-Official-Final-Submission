@extends('provider.layouts.app')
@section('title', 'Cleanova | Bookings')

@section('content')
    <div class="container-fluid">
        <div class="cc-page-head mb-3">
            <h2 class="fw-bold mb-1">Bookings</h2>
            <p class="text-muted mb-0">View requests and manage your schedule.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <livewire:provider.bookings-table />
    </div>
@endsection

