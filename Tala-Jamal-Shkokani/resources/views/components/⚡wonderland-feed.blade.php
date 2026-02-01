<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Product;

new class extends Component {
    use WithPagination;

    public $userAesthetic;
    public $mood = 'explore';
    public $priceTier = 'all';
    public $showComplementary = false;
    public $currentComplementarySet = [];

    public function mount()
    {
        $this->userAesthetic = auth()->check()
            ? auth()->user()->primary_aesthetic
            : session('user_aesthetic', 'mix');

        if (!$this->userAesthetic) {
            $this->userAesthetic = 'mix';
        }
    }

    public function setMood($mood)
    {
        $this->mood = $mood;
        if ($mood == 'indulge')
            $this->priceTier = 'luxury';
        elseif ($mood == 'treat')
            $this->priceTier = 'treat';
        else
            $this->priceTier = 'all';
        $this->resetPage();
    }

    public function showComplementaryItems($productId)
    {
        $product = Product::find($productId);

        $this->currentComplementarySet = [
            'main' => $product,
            'complements' => Product::where('id', '!=', $productId)
                ->where('aesthetic', $product->aesthetic)
                ->inRandomOrder()
                ->limit(3)
                ->get()
        ];

        $this->showComplementary = true;
    }

    public function getFeedProducts()
    {
        return Product::query()
            ->when($this->userAesthetic != 'all', function ($query) {
                $query->where('aesthetic', $this->userAesthetic);
            })
            ->when($this->priceTier != 'all', function ($query) {
                $query->where('price_tier', $this->priceTier);
            })
            ->orderBy('discover_score', 'desc')
            ->paginate(12);
    }

    public function with()
    {
        return [
            'products' => $this->getFeedProducts(),
            'moods' => [
                'explore' => ['emoji' => '🔍', 'text' => 'Just Exploring'],
                'indulge' => ['emoji' => '💎', 'text' => 'Feeling Indulgent'],
                'discover' => ['emoji' => '🎯', 'text' => 'Looking to Discover'],
                'treat' => ['emoji' => '🎁', 'text' => 'Want to Treat Myself']
            ]
        ];
    }
};
?>

<div class="wonderland-feed-container">
    <!-- Mood Filter -->
    <div class="row mb-5 justify-content-center">
        <div class="col-md-10">
            <div class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($moods as $key => $m)
                    <button wire:click="setMood('{{ $key }}')"
                        class="btn {{ $mood == $key ? 'btn-primary-custom' : 'btn-light border shadow-sm' }} py-3 px-4 rounded-4 transition-all">
                        <span class="me-2">{{ $m['emoji'] }}</span>
                        <span class="small fw-bold text-uppercase" style="letter-spacing: 1px;">{{ $m['text'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row g-4" wire:loading.class="opacity-50">
        @foreach($products as $product)
            <div class="col-6 col-lg-3 animate-fade-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                <div class="card card-custom product-card h-100">
                    <div class="position-relative overflow-hidden" style="padding-top: 135%;">
                        <a href="{{ route('shop.show', $product->id) }}" class="d-block w-100 h-100">
                            <img src="{{ $product->image }}"
                                class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-all"
                                alt="{{ $product->name }}">
                        </a>

                        <!-- Aesthetic Badge -->
                        <div class="aesthetic-badge aesthetic-{{ $product->aesthetic }}">
                            {{ Product::getAestheticName($product->aesthetic) }}
                        </div>

                        <!-- Quick Actions -->
                        <div class="quick-actions">
                            <button class="btn-quick" title="Wishlist">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <button class="btn-quick" title="Add to Cart">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button class="btn-quick" wire:click="showComplementaryItems({{ $product->id }})"
                                title="Complete the Look">
                                <i class="fa-solid fa-wand-sparkles"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <small class="text-muted text-uppercase fw-bold"
                            style="font-size: 0.65rem; letter-spacing: 0.5px;">{{ $product->brand_name }}</small>
                        <h6 class="card-title mt-1 mb-2 text-truncate">
                            <a href="{{ route('shop.show', $product->id) }}"
                                class="text-dark text-decoration-none hover-gold transition-all">
                                {{ $product->name }}
                            </a>
                        </h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-5">{{ number_format($product->price, 0) }} JOD</span>
                        </div>
                        <div class="engagement-stats mt-2 d-flex gap-3 text-muted" style="font-size: 0.7rem;">
                            <span><i class="fa-regular fa-eye"></i> {{ $product->view_count }}</span>
                            <span><i class="fa-regular fa-heart"></i> {{ $product->wishlist_count }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>

    <!-- Complementary Items Modal -->
    @if($showComplementary)
        <div class="modal fade show d-block" style="background: rgba(30,30,30,0.8); backdrop-filter: blur(10px);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0" style="border-radius: 30px;">
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn-close" wire:click="$set('showComplementary', false)"></button>
                    </div>
                    <div class="modal-body p-4 p-md-5">
                        <div class="text-center mb-5">
                            <h2 class="display-6" style="font-family: 'Playfair Display', serif;">Complete the Look</h2>
                            <p class="text-muted">Hand-picked pieces to complement your selection.</p>
                        </div>

                        <div class="row g-4 align-items-center">
                            <!-- Main Item -->
                            <div class="col-md-4">
                                <div class="text-center">
                                    <a href="{{ route('shop.show', $currentComplementarySet['main']['id']) }}"
                                        class="d-block">
                                        <img src="{{ $currentComplementarySet['main']['image'] }}"
                                            class="img-fluid rounded-4 shadow-sm mb-3 hover-lift transition-all">
                                    </a>
                                    <h6 class="mb-0">
                                        <a href="{{ route('shop.show', $currentComplementarySet['main']['id']) }}"
                                            class="text-dark text-decoration-none">
                                            {{ $currentComplementarySet['main']['name'] ?? 'Main Item' }}
                                        </a>
                                    </h6>
                                    <span
                                        class="fw-bold">{{ number_format($currentComplementarySet['main']['price'] ?? 0, 2) }}
                                        JOD</span>
                                </div>
                            </div>

                            <div class="col-md-1 text-center">
                                <i class="fa-solid fa-plus fs-3 opacity-25"></i>
                            </div>

                            <!-- Complementary Items -->
                            <div class="col-md-7">
                                <div class="row g-3">
                                    @foreach($currentComplementarySet['complements'] as $comp)
                                        <div class="col-4">
                                            <div class="text-center">
                                                <a href="{{ route('shop.show', $comp->id) }}" class="d-block">
                                                    <img src="{{ $comp->image }}"
                                                        class="img-fluid rounded-3 shadow-sm mb-2 hover-lift transition-all">
                                                </a>
                                                <small class="d-block text-truncate">
                                                    <a href="{{ route('shop.show', $comp->id) }}"
                                                        class="text-dark text-decoration-none">
                                                        {{ $comp->name }}
                                                    </a>
                                                </small>
                                                <small class="fw-bold">{{ number_format($comp->price, 2) }} JOD</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button class="btn btn-primary-custom px-5 py-3 rounded-pill">Add Entire Look to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>