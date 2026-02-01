<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\CartItem;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with('items.book')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('user.shop-cart')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart->items as $item) {
            if ($item->book) {
                $itemPrice = $item->book->discount_amount > 0 
                    ? ($item->book->discount_type === 'percentage' 
                        ? $item->book->price - ($item->book->price * $item->book->discount_amount / 100)
                        : $item->book->price - $item->book->discount_amount)
                    : $item->book->price;
                $total += $itemPrice * $item->quantity;
            }
        }

        // Coupon Logic
        $couponDiscount = 0;
        $appliedCoupon = session('applied_coupon');
        if ($appliedCoupon) {
            $coupon = Coupon::find($appliedCoupon['id']);
            if ($coupon && $coupon->isValid($total)) {
                $couponDiscount = $coupon->calculateDiscount($total);
            }
        }
        $finalTotal = max(0, $total - $couponDiscount);

        return view('user.checkout', compact('cart', 'total', 'finalTotal', 'couponDiscount'));
    }

    public function createPaymentIntent(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.book')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $total = 0;
        foreach ($cart->items as $item) {
            if ($item->book) {
                $itemPrice = $item->book->discount_amount > 0 
                    ? ($item->book->discount_type === 'percentage' 
                        ? $item->book->price - ($item->book->price * $item->book->discount_amount / 100)
                        : $item->book->price - $item->book->discount_amount)
                    : $item->book->price;
                $total += $itemPrice * $item->quantity;
            }
        }

        $couponDiscount = session('coupon_discount', 0);
        $finalTotal = max(1, $total - $couponDiscount); // Stripe min amount is $0.50

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($finalTotal * 100),
                'currency' => 'usd',
                'metadata' => [
                    'user_id' => Auth::id(),
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address_1' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'payment_intent_id' => 'required',
        ]);

        $cart = Cart::where('user_id', Auth::id())->with('items.book')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('user.shop')->with('error', 'Cart is empty');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status !== 'succeeded') {
                return back()->with('error', 'Payment was not successful. Status: ' . $paymentIntent->status);
            }

            DB::beginTransaction();

            // 1. Create Address
            $address = Address::create([
                'user_id' => Auth::id(),
                'full_name' => $request->first_name . ' ' . $request->last_name,
                'address_line1' => $request->address_1,
                'address_line2' => $request->address_2 ?? null,
                'city' => $request->city,
                'state' => 'N/A',
                'postal_code' => '00000',
                'country' => $request->country,
                'is_default' => true
            ]);

            // 2. Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'address_id' => $address->id,
                'order_status' => 'pending',
                'total_amount' => $paymentIntent->amount / 100
            ]);

            // 3. Create Order Items and Update Stock
            foreach ($cart->items as $item) {
                if ($item->book) {
                    $price = $item->book->discount_amount > 0 
                        ? ($item->book->discount_type === 'percentage' 
                            ? $item->book->price - ($item->book->price * $item->book->discount_amount / 100)
                            : $item->book->price - $item->book->discount_amount)
                        : $item->book->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->book->id,
                        'quantity' => $item->quantity,
                        'price_at_time' => $price
                    ]);

                    // Update Stock
                    $item->book->decrement('stock_quantity', $item->quantity);
                }
            }

            // 4. Create Payment Record
            Payment::create([
                'order_id' => $order->id,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'payment_status' => 'succeeded',
                'payment_method' => 'stripe'
            ]);

            // 5. Clear Cart
            CartItem::whereHas('cart', function($q) {
                $q->where('user_id', Auth::id());
            })->delete();
            
            // 6. Update Coupon Usage if applied
            $appliedCoupon = session('applied_coupon');
            if ($appliedCoupon) {
                $coupon = Coupon::find($appliedCoupon['id']);
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            // Clear Coupon
            session()->forget(['applied_coupon', 'coupon_discount']);

            DB::commit();

            return redirect()->route('user.orders')->with('success', 'Payment successful! Your order has been placed.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error processing order: ' . $e->getMessage());
        }
    }
}
