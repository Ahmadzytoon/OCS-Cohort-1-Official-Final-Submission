@extends('seeker.layouts.app')
@section('title', 'Cleanova | Book Service')

@section('content')
    <section class="cc-section pt-4">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('seeker.provider-details', $provider->user_id) }}" class="cc-back-link">
                    &larr; Back to provider
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4 align-items-start">
                <div class="col-12 col-lg-8">
                    <form method="POST" action="{{ route('seeker.bookings.store', $provider->user_id) }}">
                        @csrf

                        <div class="card cc-shell-card mb-4">
                            <div class="card-body p-3 p-md-4">
                                <h5 class="fw-bold mb-3">Booking Details</h5>

                                <div class="d-flex gap-3 align-items-start">
                                    @php
                                        $profileImage = $provider->profile_image ?? null;
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
                                    <img src="{{ $profileImageSrc }}" class="cc-mini-img" alt="Provider">

                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between gap-2">
                                            <div>
                                                <div class="fw-bold">{{ $provider->user->name ?? 'Cleaner' }}</div>
                                                <div class="text-muted small">Verified provider</div>
                                            </div>
                                        </div>

                                        <div class="row g-2 mt-2">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label small fw-semibold">Service</label>
                                                <select name="service_category_id" id="ccService" class="form-select">
                                                    <option value="">Select a service</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->service_category_id }}"
                                                            data-rate="{{ (float) $service->hourly_rate }}"
                                                            @selected(old('service_category_id') == $service->service_category_id)>
                                                            {{ $service->category->name ?? $service->category->code }}
                                                            ({{ number_format((float) $service->hourly_rate, 2) }} JOD/hr)
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('service_category_id')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        {{-- Slots --}}
                                        <div class="mt-3" id="ccSlotsWrap" style="display:none;">
                                            <div class="form-label small fw-semibold">Available Time Slots</div>
                                            <div class="vstack gap-2">
                                                @php
                                                    $slotIndex = 0;
                                                    $slotsByCategory = ($slots ?? collect())->groupBy(
                                                        'service_category_id',
                                                    );
                                                @endphp

                                                @foreach ($slotsByCategory as $categoryId => $catSlots)
                                                    @php
                                                        $uniqueSlots = $catSlots
                                                            ->unique(function ($s) {
                                                                return $s->start_time . '-' . $s->end_time;
                                                            })
                                                            ->values();
                                                    @endphp

                                                    @foreach ($uniqueSlots as $slot)
                                                        @php
                                                            $start = \Carbon\Carbon::parse($slot->start_time);
                                                            $end = \Carbon\Carbon::parse($slot->end_time);
                                                            $groupId = 'slot-group-' . $slot->id;
                                                        @endphp

                                                        @if ($end->greaterThan($start))
                                                            <div class="border rounded-3 p-2"
                                                                data-service="{{ (string) $categoryId }}"
                                                                style="display:none;">
                                                                <button type="button" class="btn btn-link p-0 fw-semibold"
                                                                    data-toggle="{{ $groupId }}">
                                                                    {{ $start->format('H:i') }} -
                                                                    {{ $end->format('H:i') }}
                                                                </button>

                                                                <div id="{{ $groupId }}" class="mt-2"
                                                                    style="display:none;">
                                                                    <div class="vstack gap-2">
                                                                        @while ($start->lessThan($end))
                                                                            @php
                                                                                $next = (clone $start)->addHour();
                                                                                if ($next->greaterThan($end)) {
                                                                                    break;
                                                                                }
                                                                                $slotIndex++;
                                                                                $value =
                                                                                    $slot->id .
                                                                                    '|' .
                                                                                    $start->format('Y-m-d H:i:s') .
                                                                                    '|' .
                                                                                    $next->format('Y-m-d H:i:s');
                                                                            @endphp
                                                                            <label
                                                                                class="d-flex align-items-center gap-2 mb-0">
                                                                            <input type="checkbox"
                                                                                name="availability_segments[]"
                                                                                value="{{ $value }}"
                                                                                data-hours="1"
                                                                                @checked(collect(old('availability_segments', []))->contains($value))>
                                                                                <span>{{ $start->format('H:i') }} -
                                                                                    {{ $next->format('H:i') }}</span>
                                                                            </label>
                                                                            @php $start = $next; @endphp
                                                                        @endwhile
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endforeach

                                                @if ($slotIndex === 0)
                                                    <div class="text-muted small">No available slots.</div>
                                                @endif
                                            </div>
                                            @error('availability_segments')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- ? Options grouped per service --}}
                                        <div class="mt-3" id="ccOptionsWrap" style="display:none;">
                                            <div class="form-label small fw-semibold">Service Options</div>

                                            @foreach ($services as $service)
                                                <div class="vstack gap-2 cc-options-group"
                                                    data-option-group="{{ (string) $service->service_category_id }}"
                                                    style="display:none;">
                                                    @forelse($service->optionPricings as $pricing)
                                                        @php $opt = $pricing->serviceOption; @endphp
                                                        @if ($opt)
                                                            <label class="d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="options[]"
                                                                    value="{{ $opt->id }}"
                                                                    data-price="{{ (float) $pricing->price }}">
                                                                <span>{{ $opt->name }}</span>
                                                                <span class="text-muted small">+
                                                                    {{ number_format((float) $pricing->price, 2) }} JOD
                                                                </span>
                                                            </label>
                                                        @endif
                                                    @empty
                                                        <div class="text-muted small">No options for this service.</div>
                                                    @endforelse
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="card cc-shell-card mb-4">
                            <div class="card-body p-3 p-md-4">
                                <h5 class="fw-bold mb-3">Service address</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-semibold">Full Address</label>
                                        <input class="form-control" name="service_address"
                                            value="{{ old('service_address') }}" placeholder="e.g., 12 King Abdullah St.">
                                        @error('service_address')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label small fw-semibold">Zip</label>
                                        <input class="form-control" name="zip_code" value="{{ old('zip_code') }}"
                                            placeholder="11181">
                                        @error('zip_code')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="card cc-shell-card">
                            <div class="card-body p-3 p-md-4">
                                <h5 class="fw-bold mb-3">Notes for the cleaner</h5>
                                <textarea class="form-control" name="customer_note" rows="4"
                                    placeholder="Any special instructions? (pets, parking, focus areas...)">{{ old('customer_note') }}</textarea>
                                @error('customer_note')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary cc-book-btn" type="submit">
                                        Confirm Booking
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Summary --}}
                <div class="col-12 col-lg-4 position-sticky" style="top: 90px; align-self: flex-start;">
                    <div class="card cc-shell-card cc-booking-card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Order Summary</h5>

                            <div class="cc-summary-row">
                                <span>Subtotal</span>
                                <strong><span id="ccSubtotal">0.00</span> JOD</strong>
                            </div>

                            <div class="text-muted small mt-2">
                                Subtotal updates when you choose service, slot, and options.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        (function() {
            var serviceSelect = document.getElementById('ccService');
            var subtotalEl = document.getElementById('ccSubtotal');
            var slotsWrap = document.getElementById('ccSlotsWrap');
            var optionsWrap = document.getElementById('ccOptionsWrap');

            function getRate() {
                var opt = serviceSelect.options[serviceSelect.selectedIndex];
                if (!opt || !opt.dataset.rate) return 0;
                return parseFloat(opt.dataset.rate) || 0;
            }

            function getOptionsTotal() {
                var total = 0;
                document.querySelectorAll('.cc-options-group input[type="checkbox"]').forEach(function(cb) {
                    if (cb.checked) total += parseFloat(cb.dataset.price || '0');
                });
                return total;
            }

    function getSelectedHours() {
        var total = 0;
        document.querySelectorAll('input[name="availability_segments[]"]:checked').forEach(function(cb) {
            total += parseFloat(cb.dataset.hours || '0') || 0;
        });
        return total;
    }

            function updateSubtotal() {
                var rate = getRate();
                var hours = getSelectedHours();
                var optionsTotal = getOptionsTotal();
                var subtotal = rate * hours + optionsTotal;
                subtotalEl.textContent = subtotal.toFixed(2);
            }

            function toggleSlots() {
                slotsWrap.style.display = serviceSelect.value ? 'block' : 'none';
            }

            function toggleOptions() {
                optionsWrap.style.display = serviceSelect.value ? 'block' : 'none';
            }

            function filterSlotsByService() {
                var selected = String(serviceSelect.value || '').trim();

                document.querySelectorAll('[data-service]').forEach(function(group) {
                    var cat = String(group.getAttribute('data-service') || '').trim();
                    var show = selected && cat === selected;
            group.style.display = show ? 'block' : 'none';
            if (!show) {
                group.querySelectorAll('input[name="availability_segments[]"]').forEach(function(cb) {
                    cb.checked = false;
                });
            }
        });
    }

            function filterOptionsByService() {
                var selected = String(serviceSelect.value || '').trim();

                document.querySelectorAll('.cc-options-group').forEach(function(group) {
                    var cat = String(group.getAttribute('data-option-group') || '').trim();
                    var show = selected && (cat === selected);

                    group.style.display = show ? 'block' : 'none';

                    if (!show) {
                        group.querySelectorAll('input[type="checkbox"]').forEach(function(cb) {
                            cb.checked = false;
                        });
                    }
                });

                updateSubtotal();
            }

            function toggleGroup(id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.style.display = el.style.display === 'none' ? 'block' : 'none';
            }

            document.querySelectorAll('[data-toggle]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    toggleGroup(btn.getAttribute('data-toggle'));
                });
            });

    document.querySelectorAll('input[name="availability_segments[]"]').forEach(function(cb) {
        cb.addEventListener('change', updateSubtotal);
    });

            document.querySelectorAll('input[type="checkbox"][name="options[]"]').forEach(function(cb) {
                cb.addEventListener('change', updateSubtotal);
            });

            serviceSelect.addEventListener('change', function() {
                toggleSlots();
                toggleOptions();
                filterSlotsByService();
                filterOptionsByService();
                updateSubtotal();
            });

            toggleSlots();
            toggleOptions();
            filterSlotsByService();
            filterOptionsByService();
            updateSubtotal();
        })();
    </script>
@endsection
