<div class="container py-5 animate-fade-up">
    <!-- Header: Archival Style -->
    <div class="text-center mb-5 pb-5 border-bottom" style="border-color: rgba(0,0,0,0.03) !important;">
        <span class="text-muted extra-small text-uppercase ls-3 fw-bold mb-2 d-block opacity-75">Personal
            Selection</span>
        <h1 class="display-3 font-heading fw-bold">The Curated Archive</h1>
        <p class="fst-italic text-muted h5" style="font-family: 'Playfair Display', serif;">Your private collection of
            discovered elegance</p>
    </div>

    <div class="row g-4 px-2">
        @forelse($wishlistItems as $item)
            @if($item->product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="wishlist-item-card transition-premium h-100 position-relative group mb-4">
                        <!-- Product Visual -->
                        <div class="card card-premium overflow-hidden border-0 shadow-sm rounded-4 mb-3" style="height: 380px;">
                            <img src="{{ $item->product->image }}" class="w-100 h-100 object-fit-cover transition-premium"
                                style="transform: scale(1);" onmouseover="this.style.transform='scale(1.08)'"
                                onmouseout="this.style.transform='scale(1)'" alt="{{ $item->product->name }}">

                            <!-- Remove Trigger -->
                            <div class="position-absolute top-0 end-0 p-3 opacity-0 group-hover-visible transition-premium">
                                <button
                                    class="btn btn-white btn-sm rounded-circle shadow-lg d-flex align-items-center justify-content-center"
                                    style="width: 38px; height: 38px;" wire:click="removeFromWishlist({{ $item->id }})"
                                    title="Unarchive">
                                    <i class="fa-solid fa-xmark extra-small"></i>
                                </button>
                            </div>

                            <!-- Actions Overlay -->
                            <div
                                class="position-absolute bottom-0 w-100 p-3 opacity-0 group-hover-visible translate-y-10 group-hover-translate-y-0 transition-premium">
                                <a href="{{ route('shop.show', $item->product->id) }}"
                                    class="btn btn-dark w-100 rounded-pill py-3 text-uppercase ls-1 extra-small fw-bold shadow-xl">
                                    View Piece
                                </a>
                            </div>
                        </div>

                        <!-- Product Identity -->
                        <div class="text-center">
                            <span
                                class="text-muted extra-small text-uppercase ls-1 d-block mb-1">{{ $item->product->aesthetic }}
                                Collection</span>
                            <h6 class="mb-1 fw-bold font-heading text-dark">{{ $item->product->name }}</h6>
                            <p class="mb-0 fw-medium" style="color: #E87A90;">{{ number_format($item->product->price, 0) }} JOD
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-5 py-5 rounded-5 shadow-sm"
                    style="background: rgba(248, 245, 242, 0.4); border: 1px dashed rgba(0,0,0,0.05);">
                    <div class="mb-4">
                        <i class="fa-solid fa-gem fa-3x text-muted opacity-25"></i>
                    </div>
                    <h3 class="font-heading fw-bold mb-3">Your archive is awaiting its first discovery.</h3>
                    <p class="text-muted small mx-auto mb-5" style="max-width: 450px;">Explore our collections and curate
                        your personal universe with pieces that define your signature aura.</p>
                    <a href="{{ route('shop.index') }}"
                        class="btn btn-dark rounded-pill px-5 py-3 text-uppercase ls-2 fw-bold shadow-lg">Begin Curation</a>
                </div>
            </div>
        @endforelse
    </div>

    <style>
        .group:hover .group-hover-visible {
            opacity: 1 !important;
        }

        .group:hover .group-hover-translate-y-0 {
            transform: translateY(0) !important;
        }

        .translate-y-10 {
            transform: translateY(20px);
        }

        .wishlist-item-card {
            cursor: default;
        }

        .btn-white {
            background: #fff;
            color: #000;
            border: none;
        }

        .btn-white:hover {
            background: #E87A90;
            color: #fff;
        }

        .shadow-xl {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
    </style>
</div>