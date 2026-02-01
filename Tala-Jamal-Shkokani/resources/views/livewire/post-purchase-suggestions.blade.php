<div class="mt-5 pt-5 border-top">
    <div class="text-center mb-5">
        <h3 class="font-heading fw-bold" style="font-family: 'Playfair Display', serif;">Complete Your Look ✨</h3>
        <p class="text-muted small text-uppercase ls-1">Others who bought these luxury pieces also added:</p>
    </div>

    @if(count($suggestions) > 0)
        <div class="row g-4 justify-content-center">
            @foreach($suggestions as $product)
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 product-card-hover">
                        <a href="{{ route('shop.show', $product->id) }}" class="text-decoration-none">
                            <div class="position-relative" style="padding-top: 130%;">
                                <img src="{{ $product->image }}"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                    alt="{{ $product->name }}">
                            </div>
                            <div class="card-body p-3 text-center">
                                <h6 class="mb-1 text-dark text-uppercase fw-bold text-truncate" style="font-size: 0.75rem;">
                                    {{ $product->name }}</h6>
                                <p class="mb-0 text-muted extra-small">{{ number_format($product->price, 0) }} JOD</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <style>
        .product-card-hover {
            transition: all 0.3s ease;
        }

        .product-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        .extra-small {
            font-size: 0.7rem;
        }
    </style>
</div>