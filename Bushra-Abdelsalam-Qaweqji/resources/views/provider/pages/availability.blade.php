@extends('provider.layouts.app')
@section('title', 'Cleanova | Availability')

@section('content')
    <div class="container-fluid">
        <div class="cc-page-head mb-3">
            <h2 class="fw-bold mb-1">Availability</h2>
            <p class="text-muted mb-0">Set the times you're available for bookings.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-12 col-xl-6">
                <div class="card cc-shell-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Add Time Slot</h5>

                        <form method="POST" action="{{ route('provider.availability.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-semibold">Service</label>
                                    <select class="form-select" name="service_category_id">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_category_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold">Start Time</label>
                                    <input type="time" class="form-control" name="start_time"
                                        value="{{ old('start_time') }}">
                                    @error('start_time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold">End Time</label>
                                    <input type="time" class="form-control" name="end_time"
                                        value="{{ old('end_time') }}">
                                    @error('end_time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-primary w-100 cc-book-btn mt-3" type="submit">Add Slot</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card cc-shell-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Current Slots</h5>

                        @if ($slots->isEmpty())
                            <div class="text-muted">No slots yet.</div>
                        @else
                            <div class="d-flex flex-column gap-2">
                                @foreach ($slots as $slot)
                                    <div class="border rounded-3 p-2 d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-semibold">
                                                {{ $slot->category?->name ?? '-' }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('provider.availability.destroy', $slot) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit"
                                                @disabled($slot->is_booked)>
                                                {{ $slot->is_booked ? 'Booked' : 'Remove' }}
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="card cc-shell-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-2">Tips</h5>
                        <ul class="text-muted mb-0">
                            <li>Keep your schedule realistic to maintain a high response rate.</li>
                            <li>Set at least 3 - 5 time blocks for better booking chances.</li>
                            <li>You can update availability anytime.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
