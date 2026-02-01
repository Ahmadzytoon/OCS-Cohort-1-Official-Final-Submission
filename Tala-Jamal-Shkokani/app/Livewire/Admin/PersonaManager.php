<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PersonaDiscount;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Persona Discounts')]
class PersonaManager extends Component
{
    public $discounts = [];
    public $aesthetics = [
        'soft' => 'Soft Femme 🌸',
        'alt' => 'Alt Girly 🖤',
        'luxury' => 'Luxury Clean ✨',
        'mix' => 'Modern Mix 🎭'
    ];

    public function mount()
    {
        $existing = PersonaDiscount::all()->pluck('discount_percentage', 'aesthetic')->toArray();

        foreach ($this->aesthetics as $key => $name) {
            $this->discounts[$key] = $existing[$key] ?? 0;
        }
    }

    public function save()
    {
        foreach ($this->discounts as $aesthetic => $percentage) {
            PersonaDiscount::updateOrCreate(
                ['aesthetic' => $aesthetic],
                ['discount_percentage' => $percentage ?: 0]
            );
        }

        $this->dispatch('swal:success', ['title' => 'Updated', 'text' => 'Persona specific discounts have been saved.', 'icon' => 'success']);
    }

    public function render()
    {
        return view('livewire.admin.persona-manager');
    }
}
