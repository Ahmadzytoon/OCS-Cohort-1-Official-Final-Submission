<div>
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h4 class="mb-0 font-heading">The Treasury</h4>
        <button class="btn btn-premium btn-sm py-2 px-4" wire:click="openModal()">+ Add New Instrument</button>
    </div>

    <div class="row g-4">
        @forelse($payments as $payment)
            <div class="col-md-6">
                <div class="card card-premium p-4 h-100 animate-fade-up">
                    <div class="d-flex align-items-center gap-4 mb-4">
                        <div class="bg-light p-3 rounded-circle text-dark shadow-sm">
                            @if(str_contains(strtolower($payment->provider), 'visa'))
                                <i class="fa-brands fa-cc-visa fs-3"></i>
                            @elseif(str_contains(strtolower($payment->provider), 'master'))
                                <i class="fa-brands fa-cc-mastercard fs-3"></i>
                            @else
                                <i class="fa-solid fa-credit-card fs-3"></i>
                            @endif
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold font-heading">•••• {{ $payment->last_four }}</h6>
                            <small class="text-muted d-block text-uppercase ls-1 extra-small">{{ $payment->provider }} • Exp
                                {{ $payment->expiry }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-auto">
                        @if($payment->is_default)
                            <span
                                class="badge bg-primary-subtle text-primary border-0 extra-small px-3 text-uppercase ls-1">Primary</span>
                        @endif
                        <button
                            class="btn btn-link text-danger p-0 text-decoration-none ms-auto extra-small text-uppercase fw-bold ls-1"
                            wire:click="remove({{ $payment->id }})">Remove Account</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 bg-light rounded-5 border-dashed">
                    <i class="fa-solid fa-vault fs-1 mb-3 opacity-25"></i>
                    <p class="text-muted mb-0">No payment instruments archived.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-5 shadow-lg overflow-hidden">
                <div class="p-4 border-bottom bg-light">
                    <h5 class="mb-0 fw-bold font-heading">Archive Payment Instrument</h5>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Card
                                    Provider</label>
                                <input type="text" wire:model.live.debounce.500ms="provider"
                                    class="form-control @error('provider') is-invalid @enderror"
                                    placeholder="e.g. Visa, Mastercard">
                                @error('provider') <span class="text-danger extra-small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Ending
                                    Digits (Last 4)</label>
                                <input type="text" wire:model.live.debounce.500ms="last_four"
                                    class="form-control @error('last_four') is-invalid @enderror" placeholder="4242">
                                @error('last_four') <span class="text-danger extra-small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label
                                    class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2 ms-3">Expiry</label>
                                <input type="text" wire:model.live.debounce.500ms="expiry"
                                    class="form-control @error('expiry') is-invalid @enderror" placeholder="MM/YY">
                                @error('expiry') <span class="text-danger extra-small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-check ms-3">
                                    <input class="form-check-input shadow-none" type="checkbox" wire:model="is_default"
                                        id="defPay" style="cursor: pointer;">
                                    <label class="form-check-label extra-small text-muted text-uppercase ls-1"
                                        for="defPay" style="cursor: pointer;">
                                        Prioritize as primary instrument
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-top text-end bg-light">
                        <button type="button" class="btn btn-premium-outline py-2 px-4 me-2"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-premium py-2 px-4">Secure Archive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            Livewire.on('open-payment-modal', () => modal.show());
            Livewire.on('close-payment-modal', () => modal.hide());
        });
    </script>
</div>