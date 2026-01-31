@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    @php 
        /** @var \App\Models\User $user */ 
        $user = Auth::user(); 
        
        $recentIds = session()->get('recently_viewed', []);
        $recentDiscoveries = \App\Models\Product::with('images')->whereIn('id', $recentIds)->get();
        // Preserve order
        $recentDiscoveries = $recentDiscoveries->sortBy(function($model) use ($recentIds) {
            return array_search($model->id, $recentIds);
        });
    @endphp
    <div class="container py-5 animate-fade-up">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card card-premium p-4 shadow-lg border-0 dashboard-sidebar" 
                     style="background: linear-gradient(180deg, #ffffff 0%, #fdfbfc 100%); position: sticky; top: 120px; z-index: 10; transition: all 0.3s ease; height: fit-content;">
                    <div class="d-flex align-items-center mb-4 px-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--color-primary-blush) 0%, #ff85a1 100%); color: white;">
                            <i class="fa-solid fa-user-tie fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 font-heading fw-bold">{{ $user->name }}</h5>
                            <span class="badge bg-primary-subtle text-primary border-0 extra-small text-uppercase ls-1">Elite Member</span>
                        </div>
                    </div>

                    @if($recentDiscoveries->count() > 0)
                        <div class="mb-4 px-2 p-3 rounded-4" style="background: rgba(246, 166, 178, 0.05); border: 1px solid rgba(246, 166, 178, 0.1);">
                            <p class="text-uppercase text-muted fw-bold ls-1 mb-2" style="font-size: 0.6rem; color: var(--color-primary-blush) !important;">Recently Viewed</p>
                            <div class="d-flex gap-2 pb-1" style="overflow-x: auto; scrollbar-width: none;">
                                @foreach($recentDiscoveries as $product)
                                    <a href="{{ route('shop.show', $product->id) }}" class="flex-shrink-0">
                                        <div class="rounded-circle border-2 border-white overflow-hidden shadow-sm" style="width: 45px; height: 45px;">
                                            <img src="{{ $product->images->first()?->url ?? asset('images/placeholder.jpg') }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-100 h-100 object-fit-cover transition-transform duration-300 hover-scale"
                                                 style="transform: scale(1.15);">
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="nav flex-column nav-pills gap-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link border-0 text-start px-4 py-3 active d-flex align-items-center rounded-pill transition-premium" 
                                id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button" role="tab">
                            <i class="fa-solid fa-box-open me-3 text-primary"></i> Experiences
                        </button>
                        <button class="nav-link border-0 text-start px-4 py-3 d-flex align-items-center rounded-pill transition-premium" 
                                id="v-pills-wishlist-tab" data-bs-toggle="pill" data-bs-target="#wishlist" type="button" role="tab">
                            <i class="fa-solid fa-gem me-3 text-danger"></i> Curations
                        </button>
                        <button class="nav-link border-0 text-start px-4 py-3 d-flex align-items-center rounded-pill transition-premium" 
                                id="v-pills-addresses-tab" data-bs-toggle="pill" data-bs-target="#addresses" type="button" role="tab">
                            <i class="fa-solid fa-map-pin me-3 text-success"></i> Destinations
                        </button>
                        <button class="nav-link border-0 text-start px-4 py-3 d-flex align-items-center rounded-pill transition-premium" 
                                id="v-pills-payments-tab" data-bs-toggle="pill" data-bs-target="#payments" type="button" role="tab">
                            <i class="fa-solid fa-wallet me-3 text-warning"></i> Treasury
                        </button>
                        <button class="nav-link border-0 text-start px-4 py-3 d-flex align-items-center rounded-pill transition-premium" 
                                id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab">
                            <i class="fa-solid fa-wand-magic-sparkles me-3 text-info"></i> Style Identity
                        </button>

                        <div class="border-top my-3"></div>

                        @if($user->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link border-0 text-start px-4 py-3 d-flex align-items-center rounded-pill text-primary">
                                <i class="fa-solid fa-shield-halved me-3"></i> curator@admin
                            </a>
                        @endif

                        <a href="{{ route('logout') }}"
                            class="nav-link border-0 text-start px-4 py-3 d-flex align-items-center rounded-pill text-danger"
                            onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();">
                            <i class="fa-solid fa-power-off me-3"></i> Departure
                        </a>
                        <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="p-4 rounded-5 mb-4 animate-fade-up d-flex justify-content-between align-items-center shadow-sm" style="background: linear-gradient(90deg, #FAF7F4 0%, #F5E6E8 100%); border-left: 5px solid var(--color-primary-blush);">
                    <div>
                        <h4 class="font-heading fw-bold mb-1">Welcome back, {{ explode(' ', $user->name)[0] }}</h4>
                        <p class="text-muted small mb-0 font-monospace">Authorized Session • Level 3 Access</p>
                    </div>
                    <div class="d-none d-md-block text-end">
                        <span class="badge bg-white text-dark border extra-small text-uppercase ls-1 px-3 py-2 rounded-pill">Status: Operational</span>
                    </div>
                </div>

                <div class="tab-content">
                    <!-- Orders Tab -->
                    <div class="tab-pane fade show active" id="orders">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Recent Orders</h4>
                            <a href="{{ route('account.orders') }}" class="small text-dark text-decoration-underline">View
                                Full Archive</a>
                        </div>

                        <livewire:user.recent-orders />
                    </div>

                    <!-- Wishlist Tab -->
                    <div class="tab-pane fade" id="wishlist">
                        <livewire:user.wishlist />
                    </div>

                    <!-- Addresses Tab -->
                    <div class="tab-pane fade" id="addresses">
                        <livewire:user.addresses />
                    </div>

                    <!-- Payments Tab -->
                    <div class="tab-pane fade" id="payments">
                        <livewire:user.payments />
                    </div>

                    <!-- Style Profile Tab -->
                    <div class="tab-pane fade" id="profile">
                        <livewire:user.profile-settings />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection