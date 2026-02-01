@extends('layouts.app')

@section('content')
    <!-- Hero Section: The Aspirational Aura -->
    <section class="position-relative vh-100 w-100 d-flex align-items-center justify-content-center overflow-hidden bg-white">
        
        <!-- Background Image (Luxury Lifestyle) -->
        <div class="position-absolute top-0 start-0 w-100 h-100 effect-zoom-slow">
            <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=75&w=1600&auto=format&fit=crop" 
                 alt="Luxury Lifestyle" 
                 class="w-100 h-100 object-fit-cover"
                 style="opacity: 1;">
        </div>
        
        <!-- Subtle Overlay for Readability -->
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(180deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0.1) 100%);"></div>

        <!-- Content -->
        <div class="container position-relative z-2 text-center px-4 mt-5">
            
            <h1 class="display-1 fw-bold mb-4 animate-fade-up font-heading" 
                style="font-size: clamp(3.5rem, 8vw, 6.5rem); line-height: 1; color: #1E1E1E; letter-spacing: -2px;">
                Unlock Your<br>
                <span class="fst-italic pe-2" style="color: #E87A90; font-family: 'Playfair Display', serif;">Signature Aura</span>
            </h1>

      
            <div class="d-flex flex-column flex-sm-row gap-4 justify-content-center align-items-center animate-fade-up mt-5" style="animation-delay: 0.2s;">
                <a href="{{ route('sparkle.quiz') }}" 
                   class="btn btn-dark btn-lg px-5 py-3 rounded-pill fs-6 fw-bold shadow-lg hover-scale text-uppercase ls-2 d-flex align-items-center gap-2"
                   style="background-color: #1E1E1E; border: none; min-width: 260px; justify-content: center;">
                   <span>DISCOVER YOUR AURA</span>
                   <i class="fa-solid fa-wand-magic-sparkles text-warning ms-1"></i>
                </a>
                
                <a href="{{ route('shop.index') }}" 
                   class="btn btn-outline-dark btn-lg px-5 py-3 rounded-pill fs-6 fw-bold text-uppercase ls-2 hover-bg-dark hover-text-white"
                   style="border: 1px solid #1E1E1E; min-width: 260px;">
                    SHOP THE DREAM
                </a>
            </div>
        </div>
        
        <!-- Scroll Prompt -->
         <div class="position-absolute bottom-0 start-50 translate-middle-x mb-5 animate-bounce opacity-50">
            <i class="fa-solid fa-chevron-down text-dark fs-4"></i>
        </div>
    </section>

    <style>
        .effect-zoom-slow img {
            animation: slowZoom 40s infinite alternate;
        }
        
        .backdrop-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        @keyframes slowZoom {
            from { transform: scale(1); }
            to { transform: scale(1.15); }
        }

        .btn.btn-outline-light.transition-all {
            color: #f8f9fa; /* Bootstrap's light color */
            transition: all 0.3s ease;
        }

        .btn.btn-outline-light.transition-all:hover {
            color: #f8f9fa !important; /* Force same font color */
            background-color: rgba(255, 255, 255, 0.15) !important; /* Darker background */
            border-color: #f8f9fa !important;
            transform: scale(1.05); /* Keep your hover-scale effect */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important; /* Enhanced shadow on hover */
        }
    </style>

    <!-- Curated Experience: Personas -->
    <section class="py-5" style="background-color: var(--color-cloud);">
        <div class="container py-5">
            <div class="text-center mb-5 animate-fade-up">
                 <h2 class="display-4 font-heading fw-bold mb-3">Your Aesthetic Journey</h2>
                 <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">Discover pieces matched to your style DNA via our exclusive curator algorithms.</p>
            </div>

            <div class="row g-4">
                @foreach([
                    'soft' => ['label' => 'Soft Femme', 'emoji' => '🌸', 'sub' => 'Dabouq Elegance', 'bg' => '#FFF0F3'],
                    'alt' => ['label' => 'Alt Girly', 'emoji' => '🖤', 'sub' => 'Abdoun Chic', 'bg' => '#F8F9FA'],
                    'luxury' => ['label' => 'Luxury Clean', 'emoji' => '✨', 'sub' => 'Al-Rabieh Minimalism', 'bg' => '#FDFAED'],
                    'mix' => ['label' => 'Modern Mix', 'emoji' => '🎭', 'sub' => 'Swafeih Cosmopolitan', 'bg' => '#F0F9FF']
                ] as $key => $data)
                <div class="col-lg-3 col-md-6 animate-fade-up">
                    <a href="{{ route('personalized.feed', ['aesthetic' => $key]) }}" class="text-decoration-none d-block h-100">
                        <div class="product-card h-100 bg-white rounded-4 shadow-sm p-4 text-center hover-translate-up transition-premium">
                            <div class="rounded-3 overflow-hidden mb-4 bg-light position-relative" style="height: 200px; background: {{ $data['bg'] }} !important;">
                                <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center display-1">
                                    {{ $data['emoji'] }}
                                </div>
                            </div>
                            <h3 class="h5 font-heading fw-bold mb-1 text-dark">{{ $data['label'] }}</h3>
                            <p class="small text-muted mb-0">{{ $data['sub'] }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newest Arrivals -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-end mb-5 animate-fade-up">
                <div>
                    <span class="text-muted extra-small text-uppercase ls-2 fw-bold mb-2 d-block">The Latest Edit</span>
                    <h2 class="display-4 font-heading fw-bold">New Arrivals</h2>
                </div>
                <a href="{{ route('shop.index', ['sort' => 'latest']) }}" class="btn btn-link text-decoration-none text-dark fw-bold text-uppercase ls-1 pb-1 border-bottom border-dark">View Entire Archive</a>
            </div>
            <livewire:featured-products type="recent" />
        </div>
    </section>

    <!-- The Velvet Room: Redefined -->
    <section class="py-5" style="background-color: var(--color-cloud);">
        <div class="container py-5">
            <div class="card card-premium overflow-hidden position-relative shadow-2xl border-0" style="height: 600px; border-radius: 60px;">
                <img src="https://i.pinimg.com/1200x/b3/fc/cc/b3fccc45db34ed2f0da1adee80b32d08.jpg"
                    alt="Luxury Experience" class="w-100 h-100 object-fit-cover" style="filter: brightness(0.6) contrast(1.2);">
                
                <!-- Contrast Overlay -->
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.5) 100%);"></div>

                <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-75 animate-fade-up" style="z-index: 2;">
                    <span class="extra-small text-uppercase ls-3 mb-4 d-block opacity-100" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3); font-weight: 300;">Social Sanctuary</span>
                    <h2 class="display-2 mb-4 font-heading" style="color: #ffffff; letter-spacing: 4px; text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); font-weight: 300;">THE VELVET ROOM</h2>
                    <p class="lead mb-5 opacity-100 fs-5 mx-auto" style="max-width: 750px; text-shadow: 0 2px 8px rgba(0,0,0,0.3); font-weight: 300; letter-spacing: 0.5px;">Step into a private sanctuary designed for the modern connoisseur. Experience curation like never before.</p>
                    <a href="{{ route('personalized.feed', ['view' => 'lookbook']) }}" 
                       class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill text-uppercase ls-2 shadow-lg transition-all"
                       style="border-width: 1px; font-weight: 400; background: rgba(255,255,255,0.05); backdrop-filter: blur(5px);">
                        ENTER THE LOOKBOOK <i class="fa-solid fa-arrow-right ms-3"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Best Sellers -->
    <section class="py-5 bg-white mb-5">
        <div class="container py-5">
            <div class="text-center mb-5 animate-fade-up">
                <span class="text-muted extra-small text-uppercase ls-2 fw-bold mb-2 d-block">Elite Choices</span>
                <h2 class="display-4 font-heading fw-bold">Best Sellers</h2>
            </div>
            <livewire:featured-products type="top" />
        </div>
    </section>
@endsection