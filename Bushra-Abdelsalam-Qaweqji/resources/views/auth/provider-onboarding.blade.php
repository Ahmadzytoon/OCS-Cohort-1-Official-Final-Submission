<x-guest-layout>
    <div class="cc-auth-form">
        <div class="cc-auth-field">
            <div class="flex rounded-lg bg-gray-100 p-1 text-sm font-medium">
                <a href="{{ route('register.seeker') }}"
                    class="flex-1 rounded-md px-4 py-2 text-center text-gray-600 hover:text-gray-800">
                    Seeker
                </a>
                <a href="{{ route('register.provider.onboarding') }}"
                    class="flex-1 rounded-md bg-white px-4 py-2 text-center text-gray-900 shadow">
                    Provider
                </a>
            </div>
        </div>
        <div>
            <p class="cc-auth-subtitle">Step <span id="stepNum">1</span> of 3</p>
        </div>

        {{-- STEP 1 --}}
        <div id="step1">
            <form id="step1Form" class="cc-auth-form">
                @csrf

                <div class="cc-auth-field">
                    <x-input-label for="name" value="Full Name" />
                    <x-text-input id="name" class="cc-auth-input" type="text" name="name" required />
                    <div class="text-sm text-red-600 mt-1" data-err="name"></div>
                </div>

                <div class="cc-auth-field">
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="cc-auth-input" type="email" name="email" required />
                    <div class="text-sm text-red-600 mt-1" data-err="email"></div>
                </div>

                <div class="cc-auth-field">
                    <x-input-label for="phone" value="Phone (optional)" />
                    <x-text-input id="phone" class="cc-auth-input" type="text" name="phone" />
                    <div class="text-sm text-red-600 mt-1" data-err="phone"></div>
                </div>

                <div class="cc-auth-field">
                    <x-input-label for="zip_code" value="Zip Code" />
                    <x-text-input id="zip_code" class="cc-auth-input" type="text" name="zip_code" required />
                    <div class="text-sm text-red-600 mt-1" data-err="zip_code"></div>
                </div>

                <div class="cc-auth-field">
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" class="cc-auth-input" type="password" name="password" required />
                    <div class="text-sm text-red-600 mt-1" data-err="password"></div>
                </div>

                <div class="cc-auth-field">
                    <x-input-label for="password_confirmation" value="Confirm Password" />
                    <x-text-input id="password_confirmation" class="cc-auth-input" type="password"
                        name="password_confirmation" required />
                </div>

                <div class="cc-auth-row">
                    <a class="cc-auth-link" href="{{ route('login') }}">Already registered?</a>
                    <x-primary-button class="cc-auth-submit" type="submit">Next</x-primary-button>
                </div>
            </form>
        </div>

        {{-- STEP 2 --}}
        <div id="step2" style="display:none;">
            <form id="step2Form">
                @csrf

                <h3 class="text-lg font-semibold mb-2">Professional Details</h3>

                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1">Bio (optional)</label>
                    <textarea name="bio" class="block w-full border rounded p-2" rows="4"
                        placeholder="Tell customers about your experience..."></textarea>
                    <div class="text-sm text-red-600 mt-1" data-err2="bio"></div>
                </div>

                <div class="mt-4">
                    <h4 class="font-semibold mb-2">Services Offered</h4>
                    <p class="text-sm text-gray-600 mb-3">Select at least one service and set your hourly rate.</p>

                    @foreach ($categories as $cat)
                        <div class="border rounded p-3 mb-3">
                            <div class="flex items-center justify-between">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="service-toggle" data-cat="{{ $cat->id }}">
                                    <span class="font-medium">{{ $cat->name }}</span>
                                </label>

                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">Hourly Rate</span>
                                    <input type="number" step="0.01" min="0"
                                        class="border rounded p-1 w-32 rate-input" name="services[{{ $cat->id }}]"
                                        data-rate="{{ $cat->id }}" disabled placeholder="0.00">
                                </div>
                            </div>

                            @if ($cat->options->count())
                                <div class="mt-3 ps-4">
                                    <p class="text-sm text-gray-600 mb-2">Add-ons (optional)</p>

                                    @foreach ($cat->options as $opt)
                                        <div class="flex items-center justify-between mb-2">
                                            <label class="flex items-center gap-2">
                                                <input type="checkbox" class="option-toggle"
                                                    data-opt="{{ $opt->id }}" data-cat="{{ $cat->id }}"
                                                    disabled>
                                                <span class="text-sm">{{ $opt->name }}</span>
                                            </label>

                                            <input type="number" step="0.01" min="0"
                                                class="border rounded p-1 w-32 opt-price"
                                                name="option_prices[{{ $opt->id }}]"
                                                data-price="{{ $opt->id }}" disabled placeholder="0.00">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div class="text-sm text-red-600 mt-2" data-err2="services"></div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <button id="backBtn2" class="underline text-sm" type="button">Back</button>
                    <x-primary-button type="submit"
                        style="background-color: #0b1f3a; height: 40px">Next</x-primary-button>
                </div>
            </form>
        </div>

        {{-- STEP 3 --}}
        <div id="step3" style="display:none;">
            <form id="step3Form">
                @csrf

                <h3 class="text-lg font-semibold mb-2">Availability</h3>
                <p class="text-sm text-gray-600 mb-3">Add your available time slots.</p>

                <div id="slotsWrap"></div>

                <button type="button" id="addSlotBtn" class="underline text-sm">+ Add Slot</button>

                <div class="flex items-center justify-between mt-6">
                    <button id="backBtn3" class="underline text-sm" type="button">Back</button>
                    <x-primary-button type="submit"
                        style="background-color: #0b1f3a; height: 40px">Finish</x-primary-button>
                </div>

                <div class="text-sm text-red-600 mt-2" data-err3="slots"></div>
            </form>
        </div>
    </div>

    <script>
        // ===== Step Switch =====
        const stepNum = document.getElementById('stepNum');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const allCategories = @json($categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name]));

        // ===== Step 1 =====
        const step1Form = document.getElementById('step1Form');

        function clearErrors() {
            document.querySelectorAll('[data-err]').forEach(el => el.textContent = '');
        }

        function showErrors(errors) {
            Object.keys(errors).forEach(field => {
                const el = document.querySelector(`[data-err="${field}"]`);
                if (el) el.textContent = errors[field][0];
            });
        }

        step1Form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(step1Form);

            const res = await fetch("{{ route('register.provider.onboarding.step1') }}", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            });

            if (res.status === 422) {
                const data = await res.json();
                showErrors(data.errors || {});
                return;
            }

            if (!res.ok) {
                const txt = await res.text();
                alert("Server error:\n" + txt);
                return;
            }

            step1.style.display = "none";
            step2.style.display = "block";
            stepNum.textContent = "2";
        });

        // ===== Step 2 =====
        const step2Form = document.getElementById('step2Form');
        const backBtn2 = document.getElementById('backBtn2');
        let selectedCategories = [];

        function clearErrors2() {
            document.querySelectorAll('[data-err2]').forEach(el => el.textContent = '');
        }

        function showErrors2(errors) {
            Object.keys(errors).forEach(field => {
                if (field.startsWith('services')) {
                    const el = document.querySelector('[data-err2="services"]');
                    if (el) el.textContent = errors[field][0];
                    return;
                }
                const el = document.querySelector(`[data-err2="${field}"]`);
                if (el) el.textContent = errors[field][0];
            });
        }

        // enable/disable rate + options
        document.querySelectorAll('.service-toggle').forEach(cb => {
            cb.addEventListener('change', () => {
                const catId = cb.dataset.cat;

                const rate = document.querySelector(`[data-rate="${catId}"]`);
                if (rate) rate.disabled = !cb.checked;

                document.querySelectorAll(`.option-toggle[data-cat="${catId}"]`).forEach(optCb => {
                    optCb.disabled = !cb.checked;

                    if (!cb.checked) {
                        optCb.checked = false;
                        const priceInput = document.querySelector(
                            `[data-price="${optCb.dataset.opt}"]`);
                        if (priceInput) {
                            priceInput.value = '';
                            priceInput.disabled = true;
                        }
                    }
                });
            });
        });

        // enable/disable option price
        document.querySelectorAll('.option-toggle').forEach(cb => {
            cb.addEventListener('change', () => {
                const optId = cb.dataset.opt;
                const price = document.querySelector(`[data-price="${optId}"]`);
                if (!price) return;

                price.disabled = !cb.checked;
                if (!cb.checked) price.value = '';
            });
        });

        backBtn2.addEventListener('click', () => {
            step2.style.display = "none";
            step1.style.display = "block";
            stepNum.textContent = "1";
        });

        step2Form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors2();

            const formData = new FormData(step2Form);

            const res = await fetch("{{ route('register.provider.onboarding.step2') }}", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            });

            if (res.status === 422) {
                const data = await res.json();
                showErrors2(data.errors || {});
                return;
            }

            if (!res.ok) {
                const txt = await res.text();
                alert("Server error:\n" + txt);
                return;
            }

            const selectedIds = Array.from(document.querySelectorAll('.service-toggle:checked'))
                .map(cb => parseInt(cb.dataset.cat, 10))
                .filter(Boolean);
            selectedCategories = allCategories.filter(cat => selectedIds.includes(cat.id));

            step2.style.display = "none";
            step3.style.display = "block";
            stepNum.textContent = "3";
            slotsWrap.innerHTML = '';
            slotIndex = 0;
            addSlot();
        });

        // ===== Step 3 =====
        const step3Form = document.getElementById('step3Form');
        const slotsWrap = document.getElementById('slotsWrap');
        const addSlotBtn = document.getElementById('addSlotBtn');
        const backBtn3 = document.getElementById('backBtn3');

        let slotIndex = 0;

        function buildCategoryOptions() {
            if (!selectedCategories.length) {
                return '<option value="" disabled selected>Select a service</option>';
            }

            return [
                '<option value="" disabled selected>Select a service</option>',
                ...selectedCategories.map(cat => `<option value="${cat.id}">${cat.name}</option>`)
            ].join('');
        }

        function slotRowHTML(i) {
            return `
            <div class="border rounded p-3 mb-3">
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <label class="text-sm">Service</label>
                        <select name="slots[${i}][service_category_id]" class="border rounded p-2 w-full" required>
                            ${buildCategoryOptions()}
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm">Start Time</label>
                            <input
                                type="time"
                                name="slots[${i}][start_time]"
                                class="border rounded p-2 w-full"
                                required>
                        </div>
                        <div>
                            <label class="text-sm">End Time</label>
                            <input
                                type="time"
                                name="slots[${i}][end_time]"
                                class="border rounded p-2 w-full"
                                required>
                        </div>
                    </div>
                </div>
                <button type="button" class="underline text-sm remove-slot">Remove</button>
            </div>
        `;
        }

        function addSlot() {
            slotsWrap.insertAdjacentHTML('beforeend', slotRowHTML(slotIndex));
            slotIndex++;
        }

        addSlotBtn.addEventListener('click', () => addSlot());

        slotsWrap.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-slot')) {
                e.target.closest('.border').remove();
            }
        });

        // add first slot after step 2 completes

        backBtn3.addEventListener('click', () => {
            step3.style.display = "none";
            step2.style.display = "block";
            stepNum.textContent = "2";
        });

        step3Form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(step3Form);

            const res = await fetch("{{ route('register.provider.onboarding.complete') }}", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            });

            if (res.status === 422) {
                const data = await res.json();
                alert(Object.values(data.errors || {}).flat()[0] || data.message || 'Validation error');
                return;
            }

            if (!res.ok) {
                const txt = await res.text();
                alert("Server error:\n" + txt);
                return;
            }

            const data = await res.json();
            if (data.ok && data.redirect) {
                window.location.href = data.redirect;
            }
        });
    </script>
</x-guest-layout>
