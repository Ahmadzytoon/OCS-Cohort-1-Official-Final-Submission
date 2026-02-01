<div>
    <a href="javascript:void(0);" wire:click="toggleWishlist" class="wishlist-toggle {{ $isWishlisted ? 'text-danger' : '' }}" title="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}">
        <i wire:loading.remove wire:target="toggleWishlist" class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart"></i>
        <i wire:loading wire:target="toggleWishlist" class="fas fa-spinner fa-spin"></i>
    </a>
</div>
