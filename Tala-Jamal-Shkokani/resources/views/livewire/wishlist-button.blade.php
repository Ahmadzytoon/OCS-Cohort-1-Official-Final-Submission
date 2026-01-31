<button {{ $attributes->merge(['class' => 'btn-quick']) }} wire:click="toggleWishlist" title="{{ $isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
    @if($isWishlisted)
        <i class="fa-solid fa-heart text-danger"></i>
    @else
        <i class="fa-regular fa-heart"></i>
    @endif
</button>