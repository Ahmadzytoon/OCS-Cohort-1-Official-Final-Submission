@extends('provider.layouts.app')
@section('title', 'Cleanova | Services')

@section('content')
    <div class="container-fluid">
        <div class="cc-page-head mb-3">
            <h2 class="fw-bold mb-1">Services</h2>
            <p class="text-muted mb-0">Choose what you offer and set your hourly price.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            @foreach ($categories as $category)
                @php
                    $svc = $providerServices[$category->id] ?? null;
                    $options = $optionsByCategory[$category->id] ?? collect();
                    $priceMap = $svc
                        ? $svc->optionPricings->keyBy('service_option_id')
                        : collect();
                @endphp
                <div class="col-12 col-xl-6">
                    <div class="card cc-shell-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $category->name }}</h5>
                                    <div class="text-muted small">Category code: {{ $category->code }}</div>
                                </div>
                                @if ($svc)
                                    <form method="POST" action="{{ route('provider.services.destroy', $svc) }}"
                                        onsubmit="return confirm('Delete this service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                @endif
                            </div>

                            <hr class="cc-hr">

                            @if ($svc)
                                <form method="POST" action="{{ route('provider.services.update', $svc) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold">Price per hour (JOD)</label>
                                            <input class="form-control" type="number" name="hourly_rate" min="1"
                                                value="{{ old('hourly_rate', $svc->hourly_rate) }}">
                                            @error('hourly_rate')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <button class="btn btn-primary cc-book-btn mt-3" type="submit">Update</button>
                                </form>

                                <hr class="cc-hr">

                                <form method="POST" action="{{ route('provider.services.options', $svc) }}">
                                    @csrf
                                    <h6 class="fw-semibold mb-2">Service Options</h6>

                                    @if ($options->isEmpty())
                                        <div class="text-muted">No options for this service.</div>
                                    @else
                                        <div class="d-flex flex-column gap-2">
                                            @foreach ($options as $opt)
                                                @php
                                                    $existing = $priceMap->get($opt->id);
                                                    $optIndex = $loop->index;
                                                @endphp
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="text-muted">{{ $opt->name }}</div>
                                                    @if ($opt->pricing_type === 'included')
                                                        <span class="badge bg-light text-muted">Included</span>
                                                        <input type="hidden" name="options[{{ $optIndex }}][service_option_id]" value="{{ $opt->id }}">
                                                        <input type="hidden" name="options[{{ $optIndex }}][price]" value="0">
                                                    @else
                                                        <div class="input-group" style="max-width: 160px;">
                                                            <span class="input-group-text bg-white">JOD</span>
                                                            <input class="form-control" type="number" min="0" step="0.5"
                                                                name="options[{{ $optIndex }}][price]"
                                                                value="{{ old('options.' . $optIndex . '.price', $existing?->price ?? 0) }}">
                                                            <input type="hidden" name="options[{{ $optIndex }}][service_option_id]" value="{{ $opt->id }}">
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="btn btn-outline-primary cc-btn-outline mt-3" type="submit">Save Options</button>
                                    @endif
                                </form>
                            @else
                                <form method="POST" action="{{ route('provider.services.store') }}">
                                    @csrf
                                    <input type="hidden" name="service_category_id" value="{{ $category->id }}">

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold">Price per hour (JOD)</label>
                                            <input class="form-control" type="number" name="hourly_rate" min="1"
                                                value="{{ old('hourly_rate') }}">
                                            @error('hourly_rate')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <button class="btn btn-primary cc-book-btn mt-3" type="submit">Add Service</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

