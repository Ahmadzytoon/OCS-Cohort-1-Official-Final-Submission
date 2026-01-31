<div x-data="{ open: @entangle('show') }" x-cloak>
    <!-- Sidebar Panel -->
    <div class="bg-white shadow-lg"
        style="position: fixed; top: 0; right: 0; height: 100vh; width: 400px; z-index: 1050; transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);"
        :style="open ? 'transform: translateX(0); visibility: visible;' : 'transform: translateX(100%); visibility: hidden;'">

        <div class="h-100 d-flex flex-column">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-uppercase ls-1 mb-1">Successfully Added</h5>
                    <p class="small text-muted mb-0">Your selection has been curated into the cart.</p>
                </div>
                <button type="button" class="btn-close" @click="open = false"></button>
            </div>

            <div class="flex-grow-1 overflow-auto p-4">
                <div class="d-flex gap-3 mb-5">
                    <a href="{{ route('cart') }}"
                        class="btn btn-dark flex-grow-1 rounded-pill py-3 fw-bold text-uppercase ls-1">View Cart</a>
                    <button @click="open = false"
                        class="btn btn-outline-dark flex-grow-1 rounded-pill py-3 fw-bold text-uppercase ls-1">Continue</button>
                </div>

                <div class="suggestions-section">
                    <h6 class="text-uppercase small ls-2 fw-bold mb-4 opacity-50">Complete the Aesthetic</h6>
                    <div class="row g-3">
                        @foreach($suggestions as $suggestion)
                            <div class="col-12">
                                <div class="d-flex gap-3 align-items-center p-2 rounded-4 hover-bg-light transition-all">
                                    <a href="{{ route('shop.show', $suggestion->id) }}" class="flex-shrink-0"
                                        style="width: 80px; height: 100px;">
                                        <img src="{{ $suggestion->image }}"
                                            class="w-100 h-100 object-fit-cover rounded-3 shadow-sm">
                                    </a>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">{{ $suggestion->name }}</h6>
                                        <p class="small text-muted mb-2">{{ number_format($suggestion->price, 0) }} JOD</p>
                                        <button wire:click="addToCart({{ $suggestion->id }})"
                                            class="btn btn-sm btn-dark rounded-pill px-3 py-1 extra-small fw-bold text-uppercase ls-1 d-inline-flex align-items-center gap-2">
                                            <i class="fa-solid fa-plus" style="font-size: 0.6rem;"></i>
                                            <span>Add</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .hover-bg-light:hover {
            background: #f8f9fa;
        }

        .extra-small {
            font-size: 0.7rem;
        }

        .ls-2 {
            letter-spacing: 2px;
        }
    </style>
</div>