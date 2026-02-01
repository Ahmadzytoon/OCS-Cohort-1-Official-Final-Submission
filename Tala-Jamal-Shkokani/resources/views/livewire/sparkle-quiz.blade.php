<div class="row align-items-center justify-content-center min-vh-100 bg-soft-gradient py-5">
    <div class="col-lg-8 animate-fade-up">

        <!-- Quiz Container -->
        <div class="card card-premium overflow-hidden border-0 shadow-lg">

            <!-- Progress Bar -->
            <div class="progress" style="height: 4px; border-radius: 0;">
                <div class="progress-bar" role="progressbar"
                    style="width: {{ ($step / 3) * 100 }}%; background-color: var(--color-warm-gold); transition: width 0.5s ease;">
                </div>
            </div>

            <div class="card-body p-5 text-center">

                <!-- Header -->
                <span class="text-muted text-uppercase ls-3 extra-small fw-bold mb-3 d-block">
                    Step {{ $step }} of 3
                </span>

                <h1 class="display-5 font-heading fw-bold mb-5" style="color: var(--color-ink-black);">
                    {{ $currentQuestion['question'] }}
                </h1>

                <!-- Options Grid -->
                <div class="row g-4 justify-content-center">
                    @foreach($currentQuestion['options'] as $option)
                        <div class="col-md-6">
                            <button wire:click="selectOption('{{ $option['key'] }}')"
                                class="w-100 text-start p-4 bg-white border border-light rounded-4 shadow-sm transition-premium position-relative group hover-scale h-100 d-flex flex-column align-items-center text-center">

                                <div class="mb-3 display-4 group-hover-scale transition-premium">
                                    {{ $option['emoji'] }}
                                </div>

                                <h3 class="h5 font-heading fw-bold mb-2 text-dark">{{ $option['label'] }}</h3>
                                <p class="text-muted small mb-0">{{ $option['desc'] }}</p>

                                <!-- Active/Hover Indicator -->
                                <div
                                    class="position-absolute top-0 start-0 w-100 h-100 rounded-4 border border-2 border-transparent transition-premium group-hover-border-blush">
                                </div>
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Back Button -->
                <div class="mt-5">
                    @if($step > 1)
                        <button wire:click="$set('step', {{ $step - 1 }})"
                            class="btn text-muted fw-bold ls-1 extra-small text-uppercase hover-text-dark">
                            <i class="fa-solid fa-arrow-left me-2"></i> Go Back
                        </button>
                    @else
                        <a href="{{ route('home') }}"
                            class="btn text-muted fw-bold ls-1 extra-small text-uppercase hover-text-dark">
                            <i class="fa-solid fa-times me-2"></i> Cancel
                        </a>
                    @endif
                </div>

            </div>
        </div>

    </div>

    <!-- Custom Styles for Quiz -->
    <style>
        .group-hover-border-blush:hover {
            border-color: var(--color-primary-blush) !important;
            box-shadow: 0 10px 30px rgba(232, 122, 144, 0.15);
        }

        .group:hover .group-hover-scale {
            transform: scale(1.1);
        }

        .bg-soft-gradient {
            background: linear-gradient(135deg, #fdfbf7 0%, #fff0f3 100%);
        }
    </style>
</div>