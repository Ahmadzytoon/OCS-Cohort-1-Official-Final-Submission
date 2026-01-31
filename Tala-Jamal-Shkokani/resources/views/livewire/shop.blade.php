<div class="container pt-4 pb-5 animate-fade-up">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/"
                    class="text-decoration-none text-muted extra-small text-uppercase ls-1">Home</a></li>
            <li class="breadcrumb-item extra-small text-uppercase ls-1 text-muted" aria-current="page">The Collection
            </li>
            @if($aesthetic)
                <li class="breadcrumb-item active fw-bold extra-small text-uppercase ls-1"
                    style="color: var(--color-primary-blush);" aria-current="page">
                    {{ $aesthetic }}
                </li>
            @endif
        </ol>
    </nav>

    <div class="text-center mb-5">
        <h1 class="display-3 font-heading fw-bold mb-3">{{ $title }}</h1>
        <p class="text-muted text-uppercase ls-2 small">Curated excellence for your unique persona</p>
        <div class="d-inline-flex align-items-center gap-2 mt-3">
            <span
                class="badge bg-primary-subtle text-primary border-0 rounded-pill px-4 py-2 text-uppercase extra-small ls-1 fw-bold">{{ $products->count() }}
                Exclusive Pieces</span>
        </div>
    </div>

    <div class="row g-5">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card card-premium p-4 border shadow-none">
                <div class="mb-5">
                    <div class="position-relative">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                            placeholder="Discover...">
                        <i
                            class="fa fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-muted opacity-50"></i>
                    </div>
                </div>

                <h6 class="text-uppercase extra-small ls-2 fw-bold mb-4 opacity-75">Aesthetic Universe</h6>
                <div class="d-flex flex-column gap-2 mb-5">
                    <button wire:click="setAesthetic(null)"
                        class="btn btn-sm text-start px-4 py-3 rounded-pill transition-premium {{ !$aesthetic ? 'bg-dark text-white shadow-lg' : 'bg-light text-dark hover-bg-light-dark' }}">
                        All Collections
                    </button>
                    @foreach(['soft' => '🌸 Soft Femme', 'alt' => '🖤 Alt Girly', 'luxury' => '✨ Luxury Clean', 'mix' => '🎭 Modern Mix'] as $key => $label)
                        <button wire:click="setAesthetic('{{ $key }}')"
                            class="btn btn-sm text-start px-4 py-3 rounded-pill transition-premium {{ $aesthetic == $key ? 'bg-dark text-white shadow-lg' : 'bg-light text-dark hover-bg-light-dark' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <h6 class="text-uppercase extra-small ls-2 fw-bold mb-4 opacity-75">Curated Collections</h6>
                <div class="d-flex flex-column gap-2 mb-5">
                    @foreach($categories as $category)
                        <button wire:click="$set('categoryId', {{ $categoryId == $category->id ? 'null' : $category->id }})"
                            class="btn btn-sm text-start px-4 py-3 rounded-pill transition-premium {{ $categoryId == $category->id ? 'bg-dark text-white shadow-lg' : 'bg-light text-dark hover-bg-light-dark' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <h6 class="text-uppercase extra-small ls-2 fw-bold mb-4 opacity-75">Investment Range</h6>
                <div class="d-flex flex-column gap-2 mb-5">
                    @foreach(['accessible' => 'Daily Luxury', 'aspirational' => 'Aspirational', 'luxury' => 'Investment'] as $tier => $label)
                        <button wire:click="setPriceTier('{{ $tier }}')"
                            class="btn btn-sm text-start px-4 py-3 rounded-pill transition-premium {{ $price_tier == $tier ? 'bg-dark text-white shadow-lg' : 'bg-light text-dark hover-bg-light-dark' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                    @if($price_tier)
                        <button wire:click="setPriceTier(null)"
                            class="btn btn-link btn-sm text-muted text-decoration-none mt-2 extra-small text-uppercase ls-1">Clear
                            Range</button>
                    @endif
                </div>

                <h6 class="text-uppercase extra-small ls-2 fw-bold mb-4 opacity-75">Palette Selection</h6>
                <div class="d-flex flex-wrap gap-2">
                    @php
                        $filterColors = ['#000000', '#F5F5DC', '#FFFFFF', '#808080', '#A52A2A', '#000080', '#2E8B57', '#C0C0C0', '#FFD700'];
                    @endphp
                    @foreach($filterColors as $c)
                        <button wire:click="setColor('{{ $c == $color ? null : $c }}')"
                            class="rounded-circle border d-flex align-items-center justify-content-center transition-premium"
                            style="width: 32px; height: 32px; background-color: {{ $c }}; border-color: {{ $c == '#FFFFFF' ? '#eee' : 'transparent' }} !important; {{ $color == $c ? 'transform: scale(1.15); box-shadow: 0 0 0 3px var(--color-primary-blush) !important;' : '' }}"
                            title="{{ $c }}">
                        </button>
                    @endforeach
                    @if($color)
                        <button wire:click="setColor(null)"
                            class="btn btn-sm btn-link text-muted text-decoration-none w-100 mt-2 extra-small text-uppercase ls-1">Clear
                            Palette</button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9 text-start">
            <div class="d-flex justify-content-between align-items-center mb-5 px-3">
                <div class="extra-small text-muted text-uppercase ls-1 fw-bold">
                    Displaying {{ $products->count() }} curated selections
                </div>
                <div>
                    <select wire:model.live="sort"
                        class="form-select form-select-sm border-0 bg-transparent fw-bold text-dark cursor-pointer shadow-none text-uppercase extra-small ls-1"
                        style="width: auto;">
                        <option value="latest">Latest Arrivals</option>
                        <option value="price_asc">Price: Ascending</option>
                        <option value="price_desc">Price: Descending</option>
                    </select>
                </div>
            </div>

            <div class="row g-4 px-2">
                @forelse ($products as $product)
                    <div class="col-6 col-lg-3" wire:key="product-{{ $product->id }}">
                        <x-product-card :product="$product" :badgeType="$product->aesthetic"
                            :badgeText="strtoupper($product->aesthetic)" />
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-4">
                            <i class="fa-solid fa-magnifying-glass fa-3x text-muted opacity-25"></i>
                        </div>
                        <h4 class="font-heading fw-bold">The collection is silent.</h4>
                        <p class="text-muted small">No pieces match your current parameters in our archives.</p>
                        <button wire:click="$set('search', '')"
                            class="btn btn-premium px-5 py-3 mt-4 text-uppercase ls-1">Clear Search</button>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Recommendations Sidebar (Appears after add to cart) -->
    <livewire:add-to-cart-suggestions />

    <style>
        .hover-bg-light-dark:hover {
            background-color: #eee !important;
            transform: translateY(-2px);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "•";
            color: #ccc;
        }
    </style>
</div>