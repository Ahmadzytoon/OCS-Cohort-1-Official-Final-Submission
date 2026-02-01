<a class="text-dark opacity-50 hover-opacity-100 transition-premium d-flex align-items-center justify-content-center p-0 position-relative"
    data-bs-toggle="offcanvas" href="#cartSidebar" role="button" title="Bag">
    <i class="fa-solid fa-bag-shopping fs-5"></i>
    @if($count > 0)
        <span
            class="cart-badge position-absolute top-0 start-100 translate-middle-x badge rounded-pill bg-dark text-white fw-bold"
            style="font-size: 0.6rem; padding: 0.25rem 0.4rem; margin-top: -5px; margin-left: 2px;">
            {{ $count }}
        </span>
    @endif
</a>