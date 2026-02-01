<div>
    @if($type === 'recent')
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button wire:click="setPersona(null)" 
                class="btn btn-sm rounded-pill px-3 py-1 extra-small text-uppercase ls-1 transition-premium {{ !$activePersona ? 'bg-dark text-white shadow' : 'bg-light text-muted border' }}">
                All
            </button>
            @foreach([
                'soft' => ['label' => 'Soft Femme', 'emoji' => '🌸'],
                'alt' => ['label' => 'Alt Girly', 'emoji' => '🖤'],
                'luxury' => ['label' => 'Luxury Clean', 'emoji' => '✨'],
                'mix' => ['label' => 'Modern Mix', 'emoji' => '🎭']
            ] as $key => $data)
                <button wire:click="setPersona('{{ $key }}')" 
                    class="btn btn-sm rounded-pill px-3 py-1 extra-small text-uppercase ls-1 transition-premium {{ $activePersona === $key ? 'bg-dark text-white shadow' : 'bg-light text-muted border' }}">
                    <span class="me-1">{{ $data['emoji'] }}</span> {{ $data['label'] }}
                </button>
            @endforeach
        </div>
    @endif

    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-6 col-md-3">
                <x-product-card :product="$product->toArray()" :badgeType="$product->aesthetic"
                    :badgeText="ucfirst($product->aesthetic)" />
            </div>
        @endforeach
        @if($products->isEmpty())
            <div class="col-12 text-center py-5 opacity-50">
                <p class="small text-muted italic">No pieces found in this category universe.</p>
            </div>
        @endif
    </div>
</div>