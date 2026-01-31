<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\UserPaymentMethod;
use Illuminate\Support\Facades\Auth;

class Payments extends Component
{
    public $payments;
    public $type = 'card';
    public $provider;
    public $last_four;
    public $expiry;
    public $is_default = false;

    public $showModal = false;

    protected function rules()
    {
        return [
            'provider' => 'required',
            'last_four' => 'required|digits:4',
            'expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
        ];
    }

    protected $messages = [
        'expiry.regex' => 'Expiry must be in MM/YY format.',
        'last_four.digits' => 'Last 4 digits must be exactly 4 numbers.'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->loadPayments();
    }

    public function loadPayments()
    {
        $this->payments = Auth::user()->paymentMethods()->orderBy('is_default', 'desc')->get();
    }

    public function openModal()
    {
        $this->reset(['provider', 'last_four', 'expiry', 'is_default']);
        $this->type = 'card';
        $this->showModal = true;
        $this->dispatch('open-payment-modal');
    }

    public function save()
    {
        $this->validate();

        if ($this->is_default) {
            Auth::user()->paymentMethods()->update(['is_default' => false]);
        }

        UserPaymentMethod::create([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'provider' => $this->provider,
            'last_four' => $this->last_four,
            'expiry' => $this->expiry,
            'is_default' => $this->is_default,
        ]);

        $this->showModal = false;
        $this->loadPayments();
        $this->dispatch('close-payment-modal');
        $this->dispatch('swal:success', [
            'title' => 'Success',
            'text' => 'Payment method added.',
            'icon' => 'success'
        ]);
    }

    public function remove($id)
    {
        UserPaymentMethod::where('id', $id)->where('user_id', Auth::id())->delete();
        $this->loadPayments();
    }

    public function render()
    {
        return view('livewire.user.payments');
    }
}
