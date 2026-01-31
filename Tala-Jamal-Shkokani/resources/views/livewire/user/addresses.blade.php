<div>
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h4 class="mb-0 font-heading">Delivery Destinations</h4>
        <button class="btn btn-premium btn-sm py-2 px-4" wire:click="openModal()">+ Add New</button>
    </div>

    <div class="row g-4">
        @forelse($addresses as $address)
            <div class="col-md-6">
                <div class="card card-premium p-4 position-relative h-100 animate-fade-up">
                    @if($address->is_default)
                        <span
                            class="badge position-absolute top-0 end-0 m-4 bg-primary-subtle text-primary border-0 text-uppercase extra-small ls-1">Default</span>
                    @endif
                    <h6 class="mb-2 text-capitalize font-heading">{{ $address->type }}</h6>
                    <p class="text-muted small mb-4">
                        {{ $address->area }}, {{ $address->street_address }}<br>
                        @if($address->building_no) Bldg {{ $address->building_no }}@endif
                        @if($address->apartment_no), Apt {{ $address->apartment_no }}@endif
                        <br>Amman, Jordan
                    </p>
                    <div class="d-flex gap-3 mt-auto">
                        <button
                            class="btn btn-link text-dark p-0 text-decoration-none extra-small text-uppercase fw-bold ls-1"
                            wire:click="openModal({{ $address->id }})">Edit Location</button>
                        <button
                            class="btn btn-link text-danger p-0 text-decoration-none extra-small text-uppercase fw-bold ls-1"
                            wire:click="delete({{ $address->id }})">Remove</button>
                        @if(!$address->is_default)
                            <button
                                class="btn btn-link text-muted p-0 text-decoration-none ms-auto extra-small text-uppercase fw-bold ls-1"
                                wire:click="setAsDefault({{ $address->id }})">Set Primary</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 bg-light rounded-5 border-dashed">
                    <i class="fa-solid fa-map-location-dot fs-1 mb-3 opacity-25"></i>
                    <p class="text-muted mb-0">No destinations saved in your registry.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="addressModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-5 shadow-lg overflow-hidden">
                <div class="p-4 border-bottom bg-light">
                    <h5 class="mb-0 fw-bold font-heading">{{ $address_id ? 'Refine Destination' : 'New Destination' }}
                    </h5>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Label
                                    Identifier</label>
                                <input type="text" wire:model.live.debounce.500ms="type"
                                    class="form-control @error('type') is-invalid @enderror"
                                    placeholder="e.g. Penthouse, Office">
                                @error('type') <span class="text-danger extra-small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label
                                    class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Neighborhood</label>
                                <select wire:model.live.debounce.500ms="area"
                                    class="form-select @error('area') is-invalid @enderror">
                                    <option value="">Select Region</option>
                                    <option value="Abdoun">Abdoun</option>
                                    <option value="Dabouq">Dabouq</option>
                                    <option value="Sweifieh">Sweifieh</option>
                                    <option value="Al-Rabieh">Al-Rabieh</option>
                                    <option value="Um Uthaina">Um Uthaina</option>
                                </select>
                                @error('area') <span class="text-danger extra-small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Contact
                                    Signal</label>
                                <input type="text" wire:model.live.debounce.500ms="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="079 XXX XXXX">
                                @error('phone') <span class="text-danger extra-small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Pathway /
                                    Address</label>
                                <input type="text" wire:model.live.debounce.500ms="street_address"
                                    class="form-control @error('street_address') is-invalid @enderror"
                                    placeholder="Building name, Floor, Street...">
                                @error('street_address') <span
                                class="text-danger extra-small ms-3">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Bldg
                                    No.</label>
                                <input type="text" wire:model.live.debounce.500ms="building_no"
                                    class="form-control @error('building_no') is-invalid @enderror">
                            </div>
                            <div class="col-md-6">
                                <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Apt
                                    No.</label>
                                <input type="text" wire:model.live.debounce.500ms="apartment_no"
                                    class="form-control @error('apartment_no') is-invalid @enderror">
                            </div>
                            <div class="col-12">
                                <div class="form-check ms-3">
                                    <input class="form-check-input shadow-none" type="checkbox" wire:model="is_default"
                                        id="defaultCheck" style="cursor: pointer;">
                                    <label class="form-check-label extra-small text-muted text-uppercase ls-1"
                                        for="defaultCheck" style="cursor: pointer;">
                                        Prioritize as primary destination
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-top text-end bg-light">
                        <button type="button" class="btn btn-premium-outline py-2 px-4 me-2"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-premium py-2 px-4">Save Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const modal = new bootstrap.Modal(document.getElementById('addressModal'));
            Livewire.on('open-address-modal', () => {
                modal.show();
            });
            Livewire.on('close-address-modal', () => {
                modal.hide();
            });
        });
    </script>
</div>