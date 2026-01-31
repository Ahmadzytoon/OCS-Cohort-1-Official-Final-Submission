@extends('seeker.layouts.app')

@section('title', 'Cleaner Details')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="{{ route('seeker.providers-list') }}" class="cc-back-link text-decoration-none">
                &larr; Back to cleaners
            </a>
        </div>

        <div class="card cc-card mb-4">
            <div class="card-body">
                <div
                    class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center justify-content-between">
                    @php
                        $profileImage = $provider->profile_image;
                        $defaultImage = asset('seeker/img/images.jpg');
                        $profileImageSrc = $defaultImage;
                        if ($profileImage) {
                            $profilePath = str_contains($profileImage, '/')
                                ? $profileImage
                                : 'provider-avatars/' . $profileImage;
                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($profilePath)) {
                                $profileImageSrc = asset('storage/' . $profilePath);
                            }
                        }
                    @endphp
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ $profileImageSrc }}" class="rounded-circle"
                            style="width:72px;height:72px;object-fit:cover;" alt="Cleaner">
                        <div>
                            <h3 class="mb-1">
                                {{ $provider->user->name ?? 'Cleaner' }}
                            </h3>
                            <div class="text-muted small d-flex flex-wrap gap-3">
                                <span>
                                    <strong>Rating:</strong>
                                    {{ isset($provider->avg_rating) ? number_format((float) $provider->avg_rating, 2) : '-' }}
                                    <span class="ms-1">({{ $provider->rating_count ?? 0 }})</span>
                                </span>

                                <span>
                                    <strong>ZIP:</strong>
                                    {{ $provider->zip_code ?? '-' }}
                                </span>

                                <span>
                                    <strong>Provider ID:</strong>
                                    {{ $provider->user_id ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if (!empty($provider->bio))
                    <hr>
                    <p class="mb-0">{{ $provider->bio }}</p>
                @endif
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card cc-card">
                    <div class="card-body">
                        <h5 class="mb-3">Services & Hourly Rate</h5>

                        @php $services = $provider->services ?? collect(); @endphp

                        @if ($services->isEmpty())
                            <div class="alert alert-warning mb-0">
                                This cleaner hasn't added services yet.
                            </div>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach ($services as $service)
                                    <div class="border rounded-3 p-3">
                                        <div class="d-flex align-items-start justify-content-between gap-3">
                                            <div>
                                                <div class="fw-semibold">
                                                    {{ $service->category->name ?? ($service->category->code ?? 'Service') }}
                                                </div>
                                                <div class="text-muted small">
                                                    Category code: {{ $service->category->code ?? '-' }}
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <div class="fw-semibold">
                                                    {{ number_format((float) ($service->hourly_rate ?? 0), 2) }} JD
                                                </div>
                                                <div class="text-muted small">per hour</div>
                                            </div>
                                        </div>

                                        @php $optionPricings = $service->optionPricings ?? collect(); @endphp
                                        @if ($optionPricings->isNotEmpty())
                                            <hr class="my-3">
                                            <div class="small fw-semibold mb-2">Extra options</div>

                                            <div class="d-flex flex-column gap-2">
                                                @foreach ($optionPricings as $op)
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="text-muted">
                                                            {{ $op->serviceOption->name ?? 'Option' }}
                                                        </div>
                                                        <div class="fw-semibold">
                                                            {{ number_format((float) ($op->price ?? 0), 2) }} JOD
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card cc-card">
                    <div class="card-body">
                        <h5 class="mb-3">Available Time Slots</h5>

                        @php
                            $serviceCategoryLabels = $services
                                ->mapWithKeys(function ($service) {
                                    $category = $service->category;
                                    $label = $category?->name ?? $category?->code ?? 'Service';

                                    return [(int) $service->service_category_id => $label];
                                })
                                ->filter()
                                ->all();
                            $slots = ($provider->availabilitySlots ?? collect())
                                ->unique(function ($s) {
                                    return ($s->service_category_id ?? 'na') . '|' . $s->start_time . '-' . $s->end_time;
                                })
                                ->values();
                            $groupedSlots = $slots->groupBy(function ($s) {
                                return $s->service_category_id ?? 'na';
                            });
                        @endphp

                        @if ($slots->isEmpty())
                            <div class="alert alert-info mb-0">
                                No available slots right now.
                            </div>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach ($groupedSlots as $categoryId => $categorySlots)
                                    <div>
                                        <div class="fw-semibold mb-2">
                                            {{ $serviceCategoryLabels[(int) $categoryId] ?? 'General' }}
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            @foreach ($categorySlots as $slot)
                                                <div class="border rounded-3 p-2 d-flex align-items-center justify-content-between">
                                                    <div class="fw-semibold">
                                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                                    </div>
                                                    <span class="badge bg-success-subtle text-success border">Available</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <a href="{{ route('seeker.bookings.create', $provider->user_id) }}"
                                class="btn btn-primary w-100 mt-3">
                                Book Now
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-12">
                <div class="card cc-card">
                    <div class="card-body">
                        <h5 class="mb-3">Reviews</h5>

                        @if (($reviews ?? collect())->isEmpty())
                            <div class="text-muted">No reviews.</div>
                        @else
                            <div class="d-flex flex-column gap-2">
                                @foreach ($reviews as $review)
                                    <div class="border rounded-3 p-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div class="fw-semibold">
                                                {{ $review->booking?->customer?->name ?? 'Customer' }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $review->created_at?->format('Y-m-d') ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="text-muted">{{ $review->comment }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
