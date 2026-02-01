<div class="container py-4 py-md-5 animate-fade-up" 
     x-data="{ 
        mainImage: '{{ $product->image ?? ($product->images->count() > 0 ? $product->images->first()->url : 'https://via.placeholder.com/800x1200') }}',
        allImages: [],
        next() { 
            let idx = this.allImages.indexOf(this.mainImage);
            this.mainImage = this.allImages[(idx + 1) % this.allImages.length];
        },
        prev() {
            let idx = this.allImages.indexOf(this.mainImage);
            this.mainImage = this.allImages[(idx - 1 + this.allImages.length) % this.allImages.length];
        }
     }"
     x-init="
        allImages = [
            '{{ $product->image ?? 'https://via.placeholder.com/800x1200' }}',
            @foreach($product->images as $img)
                '{{ $img->url }}',
            @endforeach
        ].filter((v, i, a) => a.indexOf(v) === i);
     ">
    
    @php 
        // Ensure we handle both model instances and plain objects consistently
        $mainUrl = $product->image ?? ($product->images->first()?->url ?? 'https://via.placeholder.com/800x1200');
        
        $galleryImages = $product->images->map(fn($img) => (object)['url' => $img->url]);
        $primaryImg = (object)['url' => $mainUrl];
        
        $allImages = collect([$primaryImg])
            ->concat($galleryImages)
            ->unique('url')
            ->values();
        
        $sizeOrderMap = [
            'XXS' => 1, 'XS' => 2, 'S' => 3, 'M' => 4, 
            'L' => 5, 'XL' => 6, 'XXL' => 7, 'XXXL' => 8
        ];
        
        $availableSizes = ($product->sizes && count($product->sizes) > 0) ? $product->sizes : ['XS', 'S', 'M', 'L', 'XL'];
        
        usort($availableSizes, function($a, $b) use ($sizeOrderMap) {
            $rankA = $sizeOrderMap[strtoupper($a)] ?? 99;
            $rankB = $sizeOrderMap[strtoupper($b)] ?? 99;
            return $rankA <=> $rankB;
        });

        $availableColors = $product->colors ?? [];
    @endphp

    <style>
        .gallery-main-container { 
            width: 80%;
            margin: 0 auto;
            aspect-ratio: 4/5; /* Standardized ratio */
            background-color: #f8f8f8;
            border: 1px solid rgba(0,0,0,0.02);
            overflow: hidden;
            position: relative;
        }
        @media (max-width: 768px) {
            .gallery-main-container { aspect-ratio: 1/1; }
        }
        .main-display-img { 
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); 
        }
        .gallery-main-container:hover .main-display-img { transform: scale(1.05); }
        
        .thumbnail-scroll-container {
            max-height: 550px; /* Reduced to match global scale */
            overflow-y: auto;
            scrollbar-width: none;
        }
        .thumbnail-scroll-container::-webkit-scrollbar { display: none; }

        .transition-premium { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        
        .size-option-btn {
            min-width: 48px; height: 48px; border-radius: 50%; border: 1px solid #EDEDED;
            background: #fff; font-size: 0.75rem; font-weight: 800; transition: all 0.3s ease; color: #444;
            display: flex; align-items: center; justify-content: center;
        }
        .size-option-btn:hover:not(:disabled) { background-color: rgba(0, 0, 0, 0.05); transform: translateY(-2px); }
        .size-option-btn.active { background: #1a1a1a; color: #fff; border-color: #1a1a1a; box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        .size-option-btn:disabled { opacity: 0.3; cursor: not-allowed; text-decoration: line-through; }

        .color-option-btn { 
            width: 32px; height: 32px; border-radius: 50%; border: 3px solid #fff; 
            box-shadow: 0 0 0 1px #eee; transition: all 0.3s ease; 
        }
        .color-option-btn:hover:not(:disabled) { transform: scale(1.2); }
        .color-option-btn.active { box-shadow: 0 0 0 2px #E87A90; }
        .color-option-btn:disabled { opacity: 0.2; cursor: not-allowed; filter: grayscale(1); }

        .ls-3 { letter-spacing: 3px; }
        .ls-2 { letter-spacing: 2px; }

        @media (min-width: 992px) {
            .ps-lg-4 {
                position: sticky;
                top: 100px;
            }
        }

        .gallery-arrow {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            z-index: 10;
        }
        .gallery-arrow:hover {
            transform: scale(1.1);
            background: var(--color-ink-black);
            color: white;
        }
        .opacity-75 { opacity: 0.75; }
        .opacity-60 { opacity: 0.6; }
        .hover-opacity-100:hover { opacity: 1 !important; transform: scale(1.02); }
        .border-primary-blush { border-color: var(--color-primary-blush) !important; }
        
        .ratio-4x5 {
            --bs-aspect-ratio: 125%;
        }
    </style>
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-5 px-1">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}"
                    class="text-decoration-none text-muted extra-small text-uppercase ls-1">The Archive</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index', ['category' => $product->category_id]) }}" 
                    class="text-decoration-none text-muted extra-small text-uppercase ls-1">{{ $product->category->name ?? 'Collection' }}</a></li>
            <li class="breadcrumb-item active fw-bold extra-small text-uppercase ls-1"
                style="color: var(--color-primary-blush);" aria-current="page">
                {{ $product->name }}
            </li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Gallery Section -->
        <div class="col-lg-6">
            <div class="row g-3">
                @if($allImages->count() > 1)
                <div class="col-md-2 d-none d-md-block">
                    <div class="d-flex flex-column gap-3 thumbnail-scroll-container px-1" style="max-height: 600px;">
                        @foreach($allImages as $img)
                            <div class="ratio ratio-4x5 cursor-pointer rounded-4 overflow-hidden border-2 transition-premium shadow-sm"
                                 :class="mainImage === '{{ $img->url }}' ? 'border-primary-blush opacity-100' : 'border-transparent opacity-60 hover-opacity-100'"
                                 style="border-style: solid;"
                                 @click="mainImage = '{{ $img->url }}'">
                                <img src="{{ $img->url }}" class="object-fit-cover w-100 h-100" alt="Boutique View">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="{{ $allImages->count() > 1 ? 'col-md-10' : 'col-md-12' }}">
                    <div class="position-relative overflow-hidden rounded-5 bg-light shadow-sm gallery-main-container" style="border: 1px solid rgba(0,0,0,0.03);">
                        <img :src="mainImage" class="w-100 h-100 object-fit-cover main-display-img" 
                             x-transition:enter="transition ease-out duration-400" 
                             x-transition:enter-start="opacity-0 scale-95" 
                             x-transition:enter-end="opacity-100 scale-100" 
                             :key="mainImage"
                             alt="{{ $product->name }}">
                        
                        <!-- Gallery Arrows -->
                        <template x-if="allImages.length > 1">
                            <div style="pointer-events: none;" class="position-absolute top-50 start-0 end-0 translate-middle-y d-flex justify-content-between px-3">
                                <button @click.stop="prev()" class="gallery-arrow" style="pointer-events: auto;">
                                    <i class="fa-solid fa-chevron-left text-dark"></i>
                                </button>
                                <button @click.stop="next()" class="gallery-arrow" style="pointer-events: auto;">
                                    <i class="fa-solid fa-chevron-right text-dark"></i>
                                </button>
                            </div>
                        </template>

                        <div class="position-absolute top-0 start-0 p-4">
                            <span class="badge bg-white bg-opacity-95 text-dark text-uppercase ls-1 px-4 py-2 rounded-pill shadow-sm border-0 font-heading fw-bold" style="font-size: 0.65rem;">
                                 {{ $product->aesthetic }} Curator's Collection
                            </span>
                        </div>
                    </div>

                    @if($allImages->count() > 1)
                    <div class="d-md-none d-flex gap-3 mt-4 overflow-auto pb-2 scrollbar-hide">
                        @foreach($allImages as $img)
                            <div class="flex-shrink-0 cursor-pointer rounded-4 overflow-hidden shadow-sm border-2 transition-premium" 
                                 :class="mainImage === '{{ $img->url }}' ? 'border-primary-blush opacity-100' : 'border-transparent opacity-60'"
                                 style="width: 80px; aspect-ratio: 4/5; border-style: solid;"
                                 @click="mainImage = '{{ $img->url }}'">
                                <img src="{{ $img->url }}" class="w-100 h-100 object-fit-cover" alt="Boutique View">
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info & Buy Section -->
        <div class="col-lg-6">
            <div class="ps-lg-4 py-lg-2">
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="text-muted extra-small text-uppercase ls-2 fw-bold opacity-50">SKU: CP-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <span class="badge bg-dark rounded-pill px-3 py-1 text-uppercase ls-1 fw-bold" style="font-size: 0.6rem;">{{ $product->brand_name ?? 'Chic Elite' }} Archive</span>
                    </div>
                    <h1 class="font-heading fw-bold mb-3 display-5" style="letter-spacing: -1px;">{{ $product->name }}</h1>
                    <div class="d-flex align-items-center gap-4 mt-3">
                        @if($product->hasDiscount())
                            <div class="d-flex flex-column">
                                <span class="h2 mb-0 fw-bold font-heading text-dark">{{ number_format($product->discounted_price, 0) }} JOD</span>
                                <span class="text-muted text-decoration-line-through small opacity-50">{{ number_format($product->price, 0) }} JOD</span>
                            </div>
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 text-uppercase fw-bold" style="font-size: 0.6rem;">-{{ (float)$product->effective_discount }}% Priority Privilege</span>
                        @else
                            <span class="h2 mb-0 fw-bold font-heading text-dark">{{ number_format($product->price, 0) }} JOD</span>
                        @endif
                        
                        @if($this->getStockForVariant() <= 0)
                            <span class="badge bg-soft-blush text-primary rounded-pill px-3 py-1 text-uppercase fw-bold" style="font-size: 0.6rem;">Sold Out Combination</span>
                        @endif
                    </div>
                </div>

                <div class="mb-5">
                    <div class="p-4 rounded-4 bg-white border border-light shadow-sm mb-4">
                        <p class="text-muted mb-0 small" style="line-height: 1.8;">
                            {{ $product->description }}
                        </p>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($product->occasions ?? [] as $occ)
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2 text-uppercase ls-1 opacity-75" style="font-size: 0.6rem; border: 1px solid rgba(0,0,0,0.05);">{{ $occ }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="mb-5">
                    @if(count($availableColors) > 0)
                        <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="extra-small text-muted text-uppercase fw-bold ls-2">Curated Aesthetic</label>
                                <span class="extra-small text-dark fw-bold text-uppercase ls-1">{{ $selectedColor }}</span>
                            </div>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($availableColors as $color)
                                    <button wire:click="$set('selectedColor', '{{ $color }}')" 
                                            class="color-option-btn {{ $selectedColor === $color ? 'active' : '' }}"
                                            style="background-color: {{ $color }};" 
                                            {{ !$this->isColorAvailable($color) ? 'disabled' : '' }}
                                            title="{{ $color }} {{ !$this->isColorAvailable($color) ? '(Sold Out)' : '' }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-2">Dimensional Scale</label>
                            <a href="javascript:void(0)" class="extra-small text-muted text-decoration-none border-bottom border-muted text-uppercase ls-1 opacity-50">Size Reference</a>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($product->sizes as $size)
                                <button wire:click="$set('selectedSize', '{{ $size }}')" 
                                        class="size-option-btn {{ $selectedSize === $size ? 'active' : '' }}"
                                        {{ !$this->isSizeAvailable($size) ? 'disabled' : '' }}>
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-5">
                    @if($this->getStockForVariant() > 0)
                        <button wire:click="addToCart" 
                                class="btn btn-dark btn-lg py-4 flex-grow-1 rounded-pill text-uppercase ls-2 fw-bold shadow-lg transition-premium">
                             <i class="fa-solid fa-bag-shopping me-3"></i> Add to Bag
                        </button>
                    @else
                        <button disabled class="btn btn-light btn-lg py-4 flex-grow-1 rounded-pill text-uppercase ls-1 fw-bold text-muted border">
                            {{ $selectedSize ? 'Unavailable' : 'Complete Selection' }}
                        </button>
                    @endif
                    
                    <livewire:wishlist-button :productId="$product->id" 
                            class="btn border border-2 rounded-circle d-flex align-items-center justify-content-center shadow-none boutique-wish-btn"
                            style="width: 65px; height: 65px;" />
                </div>

                <div class="border-top pt-4">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3 mb-1">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                    <i class="fa-solid fa-truck-fast text-dark small opacity-75"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="extra-small text-uppercase ls-1 fw-bold">Amman Prime</span>
                                    <span class="text-muted extra-small opacity-75">Express Delivery</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3 mb-1">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                    <i class="fa-solid fa-gem text-dark small opacity-75"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="extra-small text-uppercase ls-1 fw-bold">Archive Verified</span>
                                    <span class="text-muted extra-small opacity-75">Genuine Luxury</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Section -->
    <div class="mt-5 pt-5 border-top" style="border-color: rgba(0,0,0,0.05) !important;">
        <livewire:product-reviews :productId="$product->id" />
    </div>

    <!-- Aesthetic recommendations -->
    @if($recommendations->count() > 0)
        <div class="mt-5 pt-5">
            <div class="text-center mb-5">
                <span class="text-muted extra-small text-uppercase ls-3 fw-bold mb-2 d-block opacity-50">Complete the Look</span>
                <h2 class="font-heading fw-bold h4">You Might Also Require</h2>
            </div>
            <div class="row g-4 px-2">
                @foreach($recommendations as $rec)
                    <div class="col-6 col-md-3">
                        <x-product-card :product="$rec" :badgeType="$rec->aesthetic" :badgeText="strtoupper($rec->aesthetic)" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <livewire:add-to-cart-suggestions />
</div>
