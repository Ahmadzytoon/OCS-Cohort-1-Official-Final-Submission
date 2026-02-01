<div class="container py-5 animate-fade-in" style="min-height: 80vh;">
    <div class="text-center mb-5">
        <h1 class="display-5 font-heading fw-bold mb-2" style="font-family: 'Playfair Display', serif;">Secured Checkout
        </h1>
        <p class="text-muted text-uppercase ls-1 small">Finalize your luxury experience</p>
    </div>

    <div class="row g-5">
        <!-- Main Checkout Column -->
        <div class="col-lg-8">
            @if($isMockMode)
                <div
                    class="alert alert-warning rounded-4 border-0 shadow-sm mb-5 animate-fade-in d-flex align-items-center gap-3">
                    <i class="fa-solid fa-flask-vial fs-4"></i>
                    <div>
                        <h6 class="mb-1 fw-bold">Demo Mode Active</h6>
                        <p class="small mb-0 opacity-75">Stripe keys are not configured. Card payments will be simulated for
                            testing purposes.</p>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="confirmOrder">

                <!-- 1. Contact Info -->
                <div class="checkout-section mb-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="step-number me-3">1</div>
                        <h4 class="mb-0 fw-bold">Contact Information</h4>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label small text-uppercase fw-bold ls-1">First Name</label>
                            <input type="text"
                                class="form-control rounded-pill px-3 @error('firstName') is-invalid @enderror"
                                wire:model.live.debounce.500ms="firstName" placeholder="Tala">
                            @error('firstName') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small text-uppercase fw-bold ls-1">Last Name</label>
                            <input type="text"
                                class="form-control rounded-pill px-3 @error('lastName') is-invalid @enderror"
                                wire:model.live.debounce.500ms="lastName" placeholder="Shkokani">
                            @error('lastName') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-uppercase fw-bold ls-1">Email Address</label>
                            <input type="email"
                                class="form-control rounded-pill px-3 @error('email') is-invalid @enderror"
                                wire:model.live.debounce.500ms="email" placeholder="tala@example.com">
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- 2. Shipping Address -->
                <div class="checkout-section mb-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="step-number me-3">2</div>
                        <h4 class="mb-0 fw-bold">Shipping Destination</h4>
                    </div>

                    @if(count($savedAddresses) > 0)
                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold ls-1 mb-3 d-block">Saved Addresses</label>
                            <div class="row g-3">
                                @foreach($savedAddresses as $addr)
                                    <div class="col-md-6">
                                        <div class="address-card {{ $selectedAddressId == $addr->id ? 'active' : '' }}"
                                            wire:click="selectAddress({{ $addr->id }})">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span
                                                    class="badge {{ $addr->type == 'home' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }} rounded-pill text-uppercase"
                                                    style="font-size: 0.6rem;">{{ $addr->type }}</span>
                                                @if($addr->is_default)
                                                    <i class="fa-solid fa-circle-check text-dark"></i>
                                                @endif
                                            </div>
                                            <p class="mb-1 fw-bold">{{ $addr->area }}</p>
                                            <p class="mb-1 small text-muted">{{ $addr->street_address }}</p>
                                            <p class="mb-0 small text-muted">{{ $addr->phone }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-6">
                                    <div class="address-card d-flex flex-column align-items-center justify-content-center border-dashed {{ $selectedAddressId === 'new' ? 'active' : '' }}"
                                        wire:click="selectAddress('new')">
                                        <i class="fa-solid fa-plus mb-2"></i>
                                        <span class="small fw-bold text-uppercase ls-1">Add New Address</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($selectedAddressId === 'new')
                        <div class="new-address-form animate-fade-in">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase fw-bold ls-1">Area / Neighborhood</label>
                                    <select class="form-select rounded-pill px-3 @error('area') is-invalid @enderror"
                                        wire:model.live.debounce.500ms="area">
                                        <option value="">Select Neighborhood...</option>
                                        <option>Dabouq</option>
                                        <option>Abdoun</option>
                                        <option>Al-Rabieh</option>
                                        <option>Sweifieh</option>
                                        <option>Khalda</option>
                                        <option>Jabal Amman</option>
                                    </select>
                                    @error('area') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase fw-bold ls-1">Phone Number</label>
                                    <input type="text"
                                        class="form-control rounded-pill px-3 @error('phone') is-invalid @enderror"
                                        wire:model.live.debounce.500ms="phone" placeholder="079 XXXXXXX">
                                    @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label small text-uppercase fw-bold ls-1">Street Address</label>
                                    <input type="text"
                                        class="form-control rounded-pill px-3 @error('streetAddress') is-invalid @enderror"
                                        wire:model.live.debounce.500ms="streetAddress"
                                        placeholder="Building name, street...">
                                    @error('streetAddress') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase fw-bold ls-1">Building No.</label>
                                    <input type="text" class="form-control rounded-pill px-3"
                                        wire:model.live.debounce.500ms="buildingNo">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase fw-bold ls-1">Apartment No.</label>
                                    <input type="text" class="form-control rounded-pill px-3"
                                        wire:model.live.debounce.500ms="apartmentNo">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- 3. Payment Method -->
                <div class="checkout-section mb-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="step-number me-3">3</div>
                        <h4 class="mb-0 fw-bold">Payment Method</h4>
                    </div>

                    <div class="payment-options d-flex gap-3 mb-4">
                        <button type="button"
                            class="btn flex-grow-1 py-3 border rounded-4 d-flex flex-column align-items-center {{ $paymentMethod === 'card' ? 'border-dark bg-light' : '' }}"
                            wire:click="$set('paymentMethod', 'card')">
                            <i class="fa-regular fa-credit-card mb-2 fs-4"></i>
                            <span class="small fw-bold text-uppercase ls-1">Card Payment</span>
                        </button>
                        <button type="button"
                            class="btn flex-grow-1 py-3 border rounded-4 d-flex flex-column align-items-center {{ $paymentMethod === 'cod' ? 'border-dark bg-light' : '' }}"
                            wire:click="$set('paymentMethod', 'cod')">
                            <i class="fa-solid fa-hand-holding-dollar mb-2 fs-4"></i>
                            <span class="small fw-bold text-uppercase ls-1">Cash On Delivery</span>
                        </button>
                    </div>

                    @if($paymentMethod === 'card')
                        <div class="card-details-section animate-fade-in">
                            @if(count($savedPaymentMethods) > 0)
                                <div class="mb-4">
                                    <label class="form-label small text-uppercase fw-bold ls-1 mb-3 d-block">Saved Cards</label>
                                    <div class="row g-3">
                                        @foreach($savedPaymentMethods as $pay)
                                            <div class="col-md-6">
                                                <div class="payment-card {{ $selectedPaymentMethodId == $pay->id ? 'active' : '' }}"
                                                    wire:click="selectPaymentMethod({{ $pay->id }})">
                                                    <div class="d-flex justify-content-between mb-3">
                                                        <i class="fa-brands fa-cc-{{ strtolower($pay->provider) }} fs-3"></i>
                                                        @if($pay->is_default)
                                                            <i class="fa-solid fa-circle-check text-dark"></i>
                                                        @endif
                                                    </div>
                                                    <p class="mb-1 fw-bold">•••• •••• •••• {{ $pay->last_four }}</p>
                                                    <p class="mb-0 extra-small text-muted text-uppercase">Exp: {{ $pay->expiry }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-md-6">
                                            <div class="payment-card d-flex flex-column align-items-center justify-content-center border-dashed {{ $selectedPaymentMethodId === 'new' ? 'active' : '' }}"
                                                wire:click="$set('selectedPaymentMethodId', 'new')">
                                                <i class="fa-solid fa-plus mb-2"></i>
                                                <span class="small fw-bold text-uppercase ls-1">New Card</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($selectedPaymentMethodId === 'new')
                                <div class="new-card-form p-4 bg-light rounded-4">
                                    @if($isMockMode)
                                        <div class="text-center py-3">
                                            <i class="fa-solid fa-credit-card mb-3 fs-2 opacity-25"></i>
                                            <h6 class="fw-bold mb-1">Simulated Card Entry</h6>
                                            <p class="small text-muted mb-0">Proceeding with "Complete Purchase" will simulate a successful card authorization.</p>
                                        </div>
                                    @else
                                        <div wire:ignore>
                                            <!-- Stripe Payment Element -->
                                            <div id="payment-element"></div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                    @else
                        <div class="p-4 bg-light rounded-4 text-center animate-fade-in">
                            <i class="fa-solid fa-truck-fast mb-3 fs-3 opacity-50"></i>
                            <p class="mb-0">You'll pay <strong>{{ number_format($total, 0) }} JOD</strong> in cash when your
                                order arrives.</p>
                        </div>
                    @endif
                </div>

                <hr class="my-5">

                <button class="w-100 btn btn-dark btn-lg py-4 rounded-pill text-uppercase ls-2 fw-bold shadow-lg"
                    type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Complete Purchase • {{ number_format($total, 0) }} JOD</span>
                    <span wire:loading><i class="fa-solid fa-spinner fa-spin me-2"></i> processing...</span>
                </button>
            </form>

            @push('scripts')
                <script src="https://js.stripe.com/v3/"></script>
                <script>
                    document.addEventListener('livewire:initialized', () => {
                        let stripe = null;
                        let elements = null;

                        const initStripe = async (clientSecret) => {
                            if (!clientSecret) return;

                            if (!stripe) {
                                stripe = Stripe('{{ config('services.stripe.key') }}');
                            }

                            const appearance = { theme: 'stripe' };
                            elements = stripe.elements({ appearance, clientSecret });
                            const paymentElement = elements.create('payment');
                            paymentElement.mount('#payment-element');
                        };

                        // Initialize if client secret is present on load
                        @if($clientSecret)
                            initStripe('{{ $clientSecret }}');
                        @endif

                        // Listen for component updates calling for init
                        Livewire.on('stripe-init', (data) => {
                            const secret = data.clientSecret || data[0].clientSecret;
                            initStripe(secret);
                        });

                        // Handle the specific event emitted by Checkout.php `placeOrder` method:
                        Livewire.on('stripe-init', async (data) => {
                            const secret = data.clientSecret || data[0].clientSecret;
                            const orderId = data.orderId || data[0].orderId;

                            if (!elements) {
                                await initStripe(secret);
                            }

                            const { error } = await stripe.confirmPayment({
                                elements,
                                confirmParams: {
                                    return_url: '{{ route('stripe.success') }}' + '?order_id=' + orderId,
                                },
                            });

                            if (error) {
                                Livewire.dispatch('swal:error', { title: 'Payment Failed', text: error.message });
                            }
                        });
                    });
                </script>
            @endpush
        </div>

        <!-- Sidebar Summary -->
        <div class="col-lg-4">
            <div class="summary-sidebar sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-dark text-white p-4 border-0">
                        <h5 class="mb-0 font-heading text-uppercase ls-1" style="color: white;">Your Order</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-4">
                            @foreach($cart as $item)
                                <li class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <img src="{{ $item['image'] }}" class="rounded-3"
                                                style="width: 50px; height: 65px; object-fit: cover;">
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
                                                style="font-size: 0.6rem;">
                                                {{ $item['quantity'] }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 extra-small fw-bold text-uppercase">{{ $item['name'] }}</h6>
                                            <div class="d-flex gap-2">
                                                @if(isset($item['size']) && $item['size'])
                                                    <small class="text-muted extra-small">SIZE: {{ $item['size'] }}</small>
                                                @endif
                                                @if(isset($item['color']) && $item['color'])
                                                    <div class="d-flex align-items-center gap-1">
                                                        <small class="text-muted extra-small">COLOR:</small>
                                                        <div class="rounded-circle border"
                                                            style="width: 10px; height: 10px; background-color: {{ $item['color'] }};"
                                                            title="{{ $item['color'] }}"></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-bold">{{ number_format($item['price'] * $item['quantity'], 0) }}
                                        JOD</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="border-top pt-3 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Subtotal</span>
                                <span class="fw-bold">{{ number_format($total, 0) }} JOD</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Shipping</span>
                                <span class="text-success small fw-bold">Complimentary</span>
                            </div>
                        </div>

                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">Total</h5>
                                <h4 class="mb-0 fw-bold">{{ number_format($total, 0) }} JOD</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-4 text-center">
                    <p class="text-muted extra-small">
                        <i class="fa-solid fa-shield-halved me-2"></i> Guaranteed safe and secure checkout. <br> Powered
                        by Amman Luxury Fintech.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .step-number {
            width: 32px;
            height: 32px;
            background: var(--color-ink-black);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .address-card,
        .payment-card {
            border: 2px solid #eee;
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            background: white;
            height: 100%;
        }

        .address-card:hover,
        .payment-card:hover {
            border-color: #ddd;
            transform: translateY(-2px);
        }

        .address-card.active,
        .payment-card.active {
            border-color: var(--color-ink-black);
            background: #f8f9fa;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .border-dashed {
            border-style: dashed !important;
        }

        .extra-small {
            font-size: 0.75rem;
        }

        .ls-2 {
            letter-spacing: 2px;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
            border-color: #999;
        }
    </style>
</div>