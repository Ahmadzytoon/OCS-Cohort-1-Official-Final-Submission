<?php

use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public $currentQuestion = 1;
    public $selectedAnswers = [];
    public $aestheticRevealed = false;
    public $userAesthetic = null;
    public $sparkleEffect = false;

    public $questions = [
        1 => [
            'question' => "What's your go-to Friday night in Amman?",
            'options' => [
                ['text' => 'Turbulence + rooftop drinks', 'emoji' => '🖤', 'aesthetic' => 'alt'],
                ['text' => 'Dinner at Vinaigrette', 'emoji' => '✨', 'aesthetic' => 'luxury'],
                ['text' => 'Art gallery in Lweibdeh', 'emoji' => '🌸', 'aesthetic' => 'soft'],
                ['text' => 'Abdoun casual cafe hop', 'emoji' => '🎭', 'aesthetic' => 'mix'],
            ],
            'image' => 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e03a?q=80&w=800&auto=format&fit=crop'
        ],
        2 => [
            'question' => "Your ideal outfit color palette?",
            'options' => [
                ['text' => 'Black with statement gold', 'emoji' => '⚫', 'aesthetic' => 'alt'],
                ['text' => 'Creams and quiet luxury', 'emoji' => '🥥', 'aesthetic' => 'luxury'],
                ['text' => 'Blush and flowing fabrics', 'emoji' => '💗', 'aesthetic' => 'soft'],
                ['text' => 'Unexpected combinations', 'emoji' => '🎨', 'aesthetic' => 'mix'],
            ],
            'image' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=800&auto=format&fit=crop'
        ],
        3 => [
            'question' => "Which Amman neighborhood is your soulmate?",
            'options' => [
                ['text' => 'Abdoun Edge', 'emoji' => '🏙️', 'aesthetic' => 'alt'],
                ['text' => 'Al-Rabieh Minimalism', 'emoji' => '🏛️', 'aesthetic' => 'luxury'],
                ['text' => 'Dabouq Elegance', 'emoji' => '🏰', 'aesthetic' => 'soft'],
                ['text' => 'Jabal Amman Heritage', 'emoji' => '🏘️', 'aesthetic' => 'mix'],
            ],
            'image' => 'https://images.unsplash.com/photo-1540961316121-65391e98826c?q=80&w=800&auto=format&fit=crop'
        ],
        4 => [
            'question' => "Your signature coffee order?",
            'options' => [
                ['text' => 'Double Espresso Shot', 'emoji' => '☕', 'aesthetic' => 'alt'],
                ['text' => 'Aesthetic Oat Latte', 'emoji' => '🥛', 'aesthetic' => 'luxury'],
                ['text' => 'Rosewater Infused Tea', 'emoji' => '🍵', 'aesthetic' => 'soft'],
                ['text' => 'Traditional Shada', 'emoji' => '🇸🇾', 'aesthetic' => 'mix'],
            ],
            'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=800&auto=format&fit=crop'
        ],
        5 => [
            'question' => "Pick a weekend escape...",
            'options' => [
                ['text' => 'Wadi Rum Stargazing', 'emoji' => '🌌', 'aesthetic' => 'alt'],
                ['text' => 'Dead Sea Luxury Spa', 'emoji' => '💆', 'aesthetic' => 'luxury'],
                ['text' => 'Picnic at Dibeen', 'emoji' => '🧺', 'aesthetic' => 'soft'],
                ['text' => 'Aqaba Yacht Party', 'emoji' => '🚤', 'aesthetic' => 'mix'],
            ],
            'image' => 'https://images.unsplash.com/photo-1544131464-6449175d6579?q=80&w=800&auto=format&fit=crop'
        ],
    ];

    public function selectAnswer($aesthetic)
    {
        $this->selectedAnswers[$this->currentQuestion] = $aesthetic;

        if ($this->currentQuestion < 5) {
            $this->currentQuestion++;
        } else {
            $this->calculateResult();
        }
    }

    public function calculateResult()
    {
        $counts = array_count_values($this->selectedAnswers);
        arsort($counts);
        $this->userAesthetic = array_key_first($counts);

        if (auth()->check()) {
            auth()->user()->update([
                'primary_aesthetic' => $this->userAesthetic,
                'style_persona' => $this->getAestheticName($this->userAesthetic)
            ]);
        } else {
            session(['user_aesthetic' => $this->userAesthetic]);
        }

        $this->aestheticRevealed = true;
    }

    public function getAestheticName($key)
    {
        return [
            'alt' => 'Alt Girly 🖤',
            'luxury' => 'Luxury Clean ✨',
            'soft' => 'Soft Femme 🌸',
            'mix' => 'Modern Mix 🎭'
        ][$key] ?? 'Modern Mix 🎭';
    }
};
?>

<div class="sparkle-quiz-container">
    @if(!$aestheticRevealed)
        <div class="quiz-card p-4 p-md-5 text-center animate-fade-in"
            style="background: white; border-radius: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
            <div class="progress mb-4" style="height: 6px; border-radius: 3px; background: rgba(0,0,0,0.05);">
                <div class="progress-bar"
                    style="width: {{ $currentQuestion * 20 }}%; background: var(--color-primary-blush); border-radius: 3px; transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                </div>
            </div>

            <span class="small text-muted text-uppercase fw-bold mb-2 d-block" style="letter-spacing: 2px;">Step
                {{ $currentQuestion }} of 5</span>
            <h2 class="mb-4" style="font-family: 'Playfair Display', serif;">{{ $questions[$currentQuestion]['question'] }}
            </h2>

            <div class="quiz-image mb-4">
                <img src="{{ $questions[$currentQuestion]['image'] }}" class="img-fluid rounded-4 shadow-sm"
                    style="height: 200px; width: 100%; object-fit: cover;">
            </div>

            <div class="row g-3">
                @foreach($questions[$currentQuestion]['options'] as $option)
                    <div class="col-md-6">
                        <button wire:click="selectAnswer('{{ $option['aesthetic'] }}')"
                            class="btn btn-outline-dark w-100 py-3 rounded-4 d-flex align-items-center justify-content-between px-4 quiz-option-btn">
                            <span class="fw-medium">{{ $option['text'] }}</span>
                            <span class="fs-4">{{ $option['emoji'] }}</span>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="result-card p-5 text-center animate-fade-in"
            style="background: white; border-radius: 30px; box-shadow: 0 20px 40px rgba(246, 166, 178, 0.1);">
            <div class="sparkle-celebration mb-4">
                <span class="display-1">✨</span>
            </div>
            <h3 class="mb-2">Your Aesthetic is...</h3>
            <h1 class="display-3 mb-4" style="font-family: 'Playfair Display', serif; color: var(--color-ink-black);">
                {{ $this->getAestheticName($userAesthetic) }}</h1>
            <p class="lead text-muted mb-5">We've curated a personalized wonderland for your unique style.</p>

            <a href="{{ url('/shop') }}" class="btn btn-primary-custom px-5 py-3 rounded-pill fw-bold"
                style="letter-spacing: 1px;">Enter Your Wonderland</a>
        </div>
    @endif

    <style>
        .quiz-option-btn {
            border: 2px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .quiz-option-btn:hover {
            border-color: var(--color-primary-blush);
            background: white !important;
            color: var(--color-ink-black) !important;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(246, 166, 178, 0.1);
        }

        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
    </style>
</div>