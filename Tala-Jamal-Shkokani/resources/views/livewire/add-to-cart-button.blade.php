<div>
    @if($isSoldOut)
        <button {{ $attributes->merge(['class' => 'btn btn-secondary rounded-pill d-flex align-items-center justify-content-center disabled']) }} style="z-index: 10; min-width: 140px; opacity: 0.6; cursor: not-allowed;"
            disabled>
            <span class="small fw-bold text-uppercase ls-1">Sold Out</span>
        </button>
    @else
        <button
            @click="$wire.addToCart(typeof selectedSize !== 'undefined' ? selectedSize : null, typeof selectedColor !== 'undefined' ? selectedColor : null)"
            {{ $attributes->merge(['class' => 'btn btn-dark rounded-pill d-flex align-items-center justify-content-center']) }}
            style="z-index: 10; min-width: 140px; position: relative;"
            wire:loading.attr="disabled"
            wire:offline.attr="disabled">
            <span wire:loading.remove wire:target="addToCart">
                <i class="fa-solid fa-cart-plus me-2"></i> Add to Cart
            </span>
            <span wire:loading wire:target="addToCart">
                <i class="fa-solid fa-spinner fa-spin me-2"></i> Adding...
            </span>
        </button>
        <div wire:offline class="text-danger small text-center mt-1">
            Check connection
        </div>
    @endif
</div>