<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class SparkleQuiz extends Component
{
    public $step = 1;
    public $answers = [];

    protected $questions = [
        1 => [
            'question' => "First, what's your vibe?",
            'options' => [
                ['key' => 'soft', 'label' => 'Soft & Romantic', 'emoji' => '🌸', 'desc' => 'Pastels, florals, and dreamy fabrics.'],
                ['key' => 'luxury', 'label' => 'Clean & Minimal', 'emoji' => '✨', 'desc' => 'Structured, neutral, and timeless.'],
                ['key' => 'alt', 'label' => 'Bold & Edgy', 'emoji' => '🖤', 'desc' => 'Dark tones, leather, and statement pieces.'],
                ['key' => 'mix', 'label' => 'Modern Mix', 'emoji' => '🎭', 'desc' => 'A little bit of everything, tailored to mood.'],
            ]
        ],
        2 => [
            'question' => "What brings you here today?",
            'options' => [
                ['key' => 'casual', 'label' => 'Everyday Chic', 'emoji' => '☕', 'desc' => 'Effortless looks for coffee runs and brunch.'],
                ['key' => 'work', 'label' => 'Power Dressing', 'emoji' => '💼', 'desc' => 'Commanding attention in the office.'],
                ['key' => 'party', 'label' => 'Night Out', 'emoji' => '🥂', 'desc' => 'Turning heads at dinner or events.'],
                ['key' => 'vacation', 'label' => 'Resort Wear', 'emoji' => '🌴', 'desc' => 'Breezy styles for your next escape.'],
            ]
        ],
        3 => [
            'question' => "What's your preferred price point?",
            'options' => [
                ['key' => 'budget', 'label' => 'Smart Steals', 'emoji' => '🏷️', 'desc' => 'Looking for value and style.'],
                ['key' => 'mid', 'label' => 'Quality Basics', 'emoji' => '💎', 'desc' => 'Investing in pieces that last.'],
                ['key' => 'premium', 'label' => 'Luxury Investment', 'emoji' => '👑', 'desc' => 'Spare no expense for the perfect fit.'],
            ]
        ]
    ];

    public function selectOption($key)
    {
        if ($this->step == 1) {
            $this->answers['aesthetic'] = $key;
        } elseif ($this->step == 2) {
            $this->answers['occasion'] = $key;
        } elseif ($this->step == 3) {
            $this->answers['price_tier'] = $key;
            $this->completeQuiz();
            return;
        }

        $this->step++;
    }

    public function completeQuiz()
    {
        // 1. Determine Persona
        $persona = $this->answers['aesthetic']; // Main driver

        // 2. Save to Session for Algo
        Session::put('style_profile', [
            'aesthetic' => $persona,
            'price_tier' => $this->answers['price_tier'],
            'occasions' => [$this->answers['occasion']],
            'quiz_completed_at' => now(),
        ]);

        // 3. Redirect to Personalized Feed
        return redirect()->route('personalized.feed', ['aesthetic' => $persona])
            ->with('message', 'Your style profile is ready! Welcome to your curated edit.');
    }

    public function render()
    {
        return view('livewire.sparkle-quiz', [
            'currentQuestion' => $this->questions[$this->step]
        ])->layout('layouts.app', ['title' => 'Style Calibrator']);
    }
}
