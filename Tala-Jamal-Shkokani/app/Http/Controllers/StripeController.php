<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StripeService;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Create a payment intent
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Verify order belongs to current user
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $result = $this->stripeService->createPaymentIntent($order);

            return response()->json([
                'success' => true,
                'client_secret' => $result['client_secret'],
                'payment_intent_id' => $result['payment_intent_id'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle successful payment
     */
    public function handleSuccess(Request $request)
    {
        $id = $request->input('payment_intent_id') ?? $request->input('payment_intent');

        if (!$id) {
            return redirect()->route('checkout')->with('error', 'Invalid payment identifier.');
        }

        $request->merge(['payment_intent_id' => $id]);

        $request->validate([
            'payment_intent_id' => 'required',
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Verify order belongs to current user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('checkout')->with('error', 'Unauthorized access');
        }

        $result = $this->stripeService->confirmPayment($request->payment_intent_id);

        if ($result['success']) {
            // Update transaction info first
            $order->markAsPaid(
                $result['transaction_id'],
                $result['payment_intent']->charges->data[0]->payment_method_details->type ?? 'card'
            );

            // Finalize order (Stock, Points, Email)
            $orderService = new \App\Services\OrderService();
            $orderService->finalizeOrder($order);

            // Track with Century
            try {
                $century = new \App\Services\CenturyService();
                $century->trackPurchase($order);
            } catch (\Exception $e) {
                // Ignore analytics failures
            }

            // Clear cart session
            session()->forget('cart');
            session()->forget('order_id');

            // Dispatch cart update for frontend if using livewire global events (optional but good practice)
            // Since this is a redirect, it might not catch, but the page reload handles it.

            return redirect()->route('order.confirmation', $order->order_number)
                ->with('success', 'Payment successful!');
        }

        return redirect()->route('checkout')
            ->with('error', 'Payment failed: ' . ($result['message'] ?? 'Unknown error'));
    }

    /**
     * Handle cancelled payment
     */
    public function handleCancel()
    {
        return redirect()->route('checkout')
            ->with('warning', 'Payment was cancelled. You can try again.');
    }

    /**
     * Handle Stripe webhook
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();

        return $this->stripeService->handleWebhook($payload);
    }

    /**
     * Create a refund
     */
    public function createRefund(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'numeric|min:0',
        ]);

        $order = Order::findOrFail($request->order_id);

        if (!$order->transaction_id) {
            return response()->json(['error' => 'No transaction found to refund'], 400);
        }

        $result = $this->stripeService->refundPayment(
            $order->transaction_id,
            $request->amount ?? null
        );

        if ($result['success']) {
            $order->update(['payment_status' => 'refunded']);
            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully',
                'refund_id' => $result['refund_id'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Refund failed: ' . $result['message'],
        ], 500);
    }
}
