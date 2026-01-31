@props(['product', 'badgeType' => 'soft', 'badgeText' => ''])

<div {{ $attributes->merge(['class' => 'product-card h-100 position-relative group']) }}>

    <!-- Image Wrapper -->
    <div class="img-shadow-overlay overflow-hidden position-relative rounded-4 bg-light" style="aspect-ratio: 3/4;">
        <a href="{{ route('shop.show', $product['id']) }}" class="d-block w-100 h-100 position-relative">
            <!-- Primary Image -->
            <img src="{{ $product['image'] ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop' }}"
                alt="{{ $product['name'] }}"
                class="w-100 h-100 object-fit-cover transition-premium product-img-primary {{ ($product['stock'] ?? 1) <= 0 ? 'grayscale opacity-75' : '' }}">

            <!-- Secondary Hover Image -->
            @php
                $secondaryImage = null;
                if (is_object($product) && $product->images->count() > 1) {
                    $secondaryImage = $product->images->skip(1)->first()?->url;
                } elseif (isset($product['images']) && count($product['images']) > 1) {
                    $secondaryImage = $product['images'][1]['url'] ?? null;
                }
            @endphp

            @if($secondaryImage)
                <img src="{{ $secondaryImage }}" alt="{{ $product['name'] }} - Detail"
                    class="w-100 h-100 object-fit-cover transition-premium position-absolute top-0 start-0 product-img-secondary opacity-0">
            @endif
        </a>

        <!-- Badges -->
        <div
            class="position-absolute top-0 start-0 p-3 w-100 d-flex justify-content-between align-items-start pointer-events-none">
            @if($badgeText)
                <span class="aesthetic-badge aesthetic-{{ $badgeType }} shadow-sm">
                    {{ $badgeText }}
                </span>
            @endif

            @if(($product['stock'] ?? 1) <= 0)
                <span class="badge bg-white text-dark shadow-sm text-uppercase ls-1 fw-bold border"
                    style="font-size: 0.6rem;">Sold Out</span>
            @elseif(is_object($product) && $product->hasDiscount())
                <span class="badge bg-danger shadow-sm text-uppercase ls-1 fw-bold border-0"
                    style="font-size: 0.6rem;">-{{ (float) $product->effective_discount }}%</span>
            @endif
        </div>

        <!-- Quick Actions (Hover) -->
        <div class="quick-actions opacity-0 group-hover-opacity-100 transition-premium mb-3">
            <a href="{{ route('shop.show', $product['id']) }}" class="btn-quick text-decoration-none" title="View">
                <i class="fa-regular fa-eye"></i>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="pt-4 pb-2 text-center px-2">
        <h3 class="h6 font-heading fw-bold mb-1 text-dark text-truncate">
            <a href="{{ route('shop.show', $product['id']) }}" class="text-dark text-decoration-none">
                {{ $product['name'] }}
            </a>
        </h3>

        <div class="d-flex flex-column align-items-center mb-3">
            @if(is_object($product) && $product->hasDiscount())
                <div class="d-flex align-items-center gap-2">
                    <span class="small fw-bold text-dark" style="color: var(--color-ink-black) !important;">
                        {{ number_format($product->discounted_price, 0) }} JOD
                    </span>
                    <span class="extra-small text-muted text-decoration-line-through">
                        {{ number_format($product->price, 0) }} JOD
                    </span>
                </div>
            @elseif(isset($product['discount_percentage']) && $product['discount_percentage'] > 0)
                {{-- Handle array case if needed or just fallback --}}
                <p class="small text-muted mb-0" style="color: var(--color-warm-gold) !important; font-weight: 500;">
                    {{ number_format($product['price'], 2) }} JOD
                </p>
            @else
                <p class="small text-muted mb-0" style="color: var(--color-warm-gold) !important; font-weight: 500;">
                    {{ number_format($product['price'] ?? 0, 2) }} JOD
                </p>
            @endif
        </div>

        <!-- Add to Bag & Wishlist -->
        <div class="d-flex gap-2 align-items-center">
            @if(($product['stock'] ?? 1) > 0)
                <button @click="Livewire.dispatch('quick-add-to-cart', { productId: {{ $product['id'] }} })"
                    class="btn btn-primary-custom flex-grow-1 rounded-pill py-2 small text-uppercase fw-bold ls-1 shadow-sm transition-premium hover-translate-up"
                    style="font-size: 0.65rem; padding: 8px 16px !important;">
                    Add to Bag
                </button>
            @else
                <button disabled
                    class="btn btn-outline-secondary flex-grow-1 rounded-pill py-2 extra-small text-uppercase fw-bold ls-1 border-0 bg-light text-muted">
                    Unavailable
                </button>
            @endif

            <livewire:wishlist-button :productId="$product['id']" :wire:key="'wishlist-btn-'.$product['id']"
                class="btn rounded-circle d-flex align-items-center justify-content-center transition-premium wishlist-card-btn"
                style="width: 38px; height: 38px; border: 1px solid #EDEDED;" />
        </div>
    </div>
</div>