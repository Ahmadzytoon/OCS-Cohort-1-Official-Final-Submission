<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\UserAddress;
use App\Models\UserPaymentMethod;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserBehavior;
use App\Models\LoyaltyPoint;
use App\Models\ScheduledCommunication;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Checkout extends Component
{
    public $cart = [];
    public $total = 0;

    // Saved Data
    public $savedAddresses = [];
    public $selectedAddressId = 'new';
    public $savedPaymentMethods = [];
    public $selectedPaymentMethodId = 'new';

    // Form fields for New Address
    public $email;
    public $firstName;
    public $lastName;
    public $area;
    public $streetAddress;
    public $buildingNo;
    public $apartmentNo;
    public $phone;
    public $city = 'Amman';
    public $zip;

    // Form fields for New Payment
    public $paymentMethod = 'cod'; // Default to COD to prevent Stripe errors on load
    public $cardName;
    public $cardNumber;
    public $cardExpiry;
    public $cardCvc;

    protected function rules()
    {
        $rules = [
            'email' => 'required|email',
            'firstName' => ['required', 'regex:/^[a-zA-Z\s]{2,50}$/'],
            'lastName' => ['required', 'regex:/^[a-zA-Z\s]{2,50}$/'],
        ];

        if ($this->selectedAddressId === 'new') {
            $rules = array_merge($rules, [
                'area' => 'required',
                'streetAddress' => 'required',
                'phone' => ['required', 'regex:/^(07[789]\d{7})$/'],
            ]);
        }

        if ($this->paymentMethod === 'card' && $this->selectedPaymentMethodId === 'new') {
            $rules = array_merge($rules, [
                'cardName' => ['required', 'regex:/^[a-zA-Z\s]{2,50}$/'],
                'cardNumber' => ['required', 'regex:/^\d{16}$/'],
                'cardExpiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
                'cardCvc' => ['required', 'regex:/^\d{3}$/'],
            ]);
        }

        return $rules;
    }

    protected $messages = [
        'firstName.regex' => 'First name should only contain letters.',
        'lastName.regex' => 'Last name should only contain letters.',
        'phone.regex' => 'Phone number must be a valid Jordanian mobile (e.g., 079XXXXXXX).',
        'cardName.regex' => 'Cardholder name should only contain letters.',
        'cardNumber.regex' => 'Card number must be exactly 16 digits.',
        'cardExpiry.regex' => 'Expiry must be in MM/YY format.',
        'cardCvc.regex' => 'CVV must be exactly 3 digits.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->loadItems();

        if (auth()->check()) {
            $user = auth()->user();
            $this->email = $user->email;
            $nameParts = explode(' ', trim($user->name));
            $this->firstName = $nameParts[0] ?? '';
            $this->lastName = count($nameParts) > 1 ? end($nameParts) : '';

            $this->savedAddresses = UserAddress::where('user_id', $user->id)->get();
            $defaultAddr = $this->savedAddresses->where('is_default', true)->first();
            if ($defaultAddr) {
                $this->selectedAddressId = $defaultAddr->id;
            } elseif ($this->savedAddresses->count() > 0) {
                $this->selectedAddressId = $this->savedAddresses->first()->id;
            }

            $this->savedPaymentMethods = UserPaymentMethod::where('user_id', $user->id)->get();
            $defaultPay = $this->savedPaymentMethods->where('is_default', true)->first();

            // Check for valid Stripe keys - define Mock Mode if placeholders exist
            $stripeKey = config('services.stripe.secret');
            $this->isMockMode = empty($stripeKey) || Str::contains($stripeKey, 'placeholder');

            if (!$this->isMockMode) {
                if ($defaultPay) {
                    $this->selectedPaymentMethodId = $defaultPay->id;
                    $this->paymentMethod = 'card';
                } elseif ($this->savedPaymentMethods->count() > 0) {
                    $this->selectedPaymentMethodId = $this->savedPaymentMethods->first()->id;
                    $this->paymentMethod = 'card';
                }

                if ($this->paymentMethod === 'card') {
                    $this->initializeStripe();
                }
            } else {
                // In Mock Mode, we still allow selecting card for demo purposes
                $this->paymentMethod = 'card';
            }
        }
    }

    public $isMockMode = false;

    public function loadItems()
    {
        $cartService = new \App\Services\CartService();
        $items = $cartService->getItems();

        $this->cart = $items->map(function ($item) {
            return [
                'id' => $item->product_id,
                'name' => $item->product->name,
                'image' => $item->product->image ?? ($item->product->images->first()?->url ?? asset('images/placeholder.jpg')),
                'price' => $item->product->discounted_price,
                'quantity' => $item->quantity,
                'size' => $item->size,
                'color' => $item->color
            ];
        })->toArray();

        $this->calculateTotal();
    }

    public function updatedPaymentMethod($value)
    {
        if ($value === 'card') {
            $this->initializeStripe();
        }
    }

    public function initializeStripe()
    {
        if ($this->isMockMode) {
            return; // Skip Stripe init in Mock Mode
        }

        try {
            $stripeService = new \App\Services\StripeService();
            // Create a temporary intent for the amount
            $intentData = $stripeService->createPaymentIntent([
                'total_amount' => $this->total,
                'currency' => 'USD',
                'id' => 'temp_' . md5(session()->getId()),
                'order_number' => 'DRAFT',
            ]);
            $this->clientSecret = $intentData['client_secret'];
        } catch (\Exception $e) {
            \Log::error('Stripe Init Error: ' . $e->getMessage());
            session()->flash('error', 'Payment system unavailable: ' . $e->getMessage());
        }
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += ((float) ($item['price'] ?? 0)) * ($item['quantity'] ?? 1);
        }
        $this->total += 10; // Shipping
    }

    public function selectAddress($id)
    {
        $this->selectedAddressId = $id;
    }

    public function selectPaymentMethod($id)
    {
        $this->selectedPaymentMethodId = $id;
        $this->paymentMethod = 'card';
    }

    public function confirmOrder()
    {
        $this->validate();

        $this->dispatch(
            'trigger-confirm',
            title: 'Finalize Acquisition?',
            text: 'We are about to curate your selection into a final order. Shall we proceed?',
            confirmButtonText: 'Confirm Order',
            method: 'place-order-confirmed'
        );
    }

    public $clientSecret;

    #[\Livewire\Attributes\On('place-order-confirmed')]
    public function placeOrder()
    {
        $this->validate();

        if (!auth()->check()) {
            session(['url.intended' => route('checkout')]);
            $this->dispatch('swal:auth-prompt');
            return;
        }

        $user = auth()->user();

        // Refresh cart
        $cartService = new \App\Services\CartService();
        $this->loadItems();

        if (empty($this->cart)) {
            $this->dispatch('swal:error', ['title' => 'Empty Bag', 'text' => 'Your selection has vanished. Please re-curate.']);
            return;
        }

        // Validate Stock
        foreach ($this->cart as $item) {
            $product = Product::find($item['id']);
            if (!$product)
                continue;

            // Basic stock check logic (simplified for brevity, should match Service logic)
            if ($product->stock < $item['quantity']) {
                $this->dispatch('swal:error', ['title' => 'Stock Error', 'text' => "Insufficient stock for {$product->name}"]);
                return;
            }
        }

        // Create Address/Payment if new (Same as before, implicit logic)
        if ($this->selectedAddressId === 'new') {
            $address = UserAddress::create([
                'user_id' => $user->id,
                'area' => $this->area,
                'street_address' => $this->streetAddress,
                'phone' => $this->phone,
                // Add other fields as needed or defaults
                'city' => $this->city,
                'is_default' => true
            ]);
            $this->selectedAddressId = $address->id;
        }

        if ($this->selectedAddressId !== 'new') {
            $existingAddress = UserAddress::find($this->selectedAddressId);
            $finalAddress = $existingAddress ? $existingAddress->street_address : $this->streetAddress;
        } else {
            $finalAddress = $this->streetAddress;
        }

        // Use OrderService to Create Order (Pending)
        $orderService = new \App\Services\OrderService();
        $orderData = [
            'total' => $this->total,
            'tax' => $this->total * 0.08, // Approx
            'shipping' => 10,
            'payment_method' => $this->paymentMethod,
            'shipping_address_text' => $finalAddress
        ];

        $order = $orderService->createOrder($user, $this->cart, $orderData);

        // STRIPE FLOW
        if ($this->paymentMethod === 'card') {
            // Handle Mock Flow
            if ($this->isMockMode) {
                $transactionId = 'MOCK_' . Str::random(12);
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $transactionId
                ]);

                $orderService->finalizeOrder($order);
                $cartService->clear();

                return redirect()->route('checkout.success', ['order' => $order->id])
                    ->with('success', 'Demo Payment successful! (Mock Mode enabled via placeholder keys)');
            }

            // Real Stripe Flow logic...
            try {
                $stripeService = new \App\Services\StripeService();

                // If using a saved card, pass its token/ID
                if ($this->selectedPaymentMethodId !== 'new') {
                    $savedCard = UserPaymentMethod::find($this->selectedPaymentMethodId);
                    if ($savedCard) {
                        $order->saved_payment_method_id = $savedCard->token;
                    }
                }

                $intentData = $stripeService->createPaymentIntent($order);
                $this->clientSecret = $intentData['client_secret'];

                // Dispatch event to frontend to trigger Stripe Elements submit
                $this->dispatch('stripe-init', [
                    'clientSecret' => $this->clientSecret,
                    'orderId' => $order->id
                ]);
                return; // Stop here, wait for JS to finish payment
            } catch (\Exception $e) {
                $this->dispatch('swal:error', ['title' => 'Payment Error', 'text' => $e->getMessage()]);
                return;
            }
        }

        // CASH FLOW (COD)
        $orderService->finalizeOrder($order);

        try {
            $century = new \App\Services\CenturyService();
            $century->trackPurchase($order);
        } catch (\Exception $e) {
        }

        $cartService->clear();
        return redirect()->route('checkout.success', ['order' => $order->id]);
    }

    public function handleAuthRedirect()
    {
        return redirect()->route('login', ['intended' => route('checkout')]);
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
