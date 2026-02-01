<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Refund;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a payment intent
     * @param mixed $order Order model or object with properties
     */
    public function createPaymentIntent($order)
    {
        try {
            $user = $order instanceof Order ? $order->user : auth()->user();
            $amount = $order instanceof Order ? $order->total_amount : ($order['total_amount'] ?? 0);
            $currency = $order instanceof Order ? $order->currency : ($order['currency'] ?? 'USD');
            $orderId = $order instanceof Order ? $order->id : ($order['id'] ?? 'temp_' . time());
            $orderNumber = $order instanceof Order ? $order->order_number : ($order['order_number'] ?? 'TEMP');
            $userId = $user ? $user->id : 'guest';

            $customer = $this->getOrCreateCustomer($user);

            $intentParams = [
                'amount' => $this->convertToCents($amount),
                'currency' => strtolower($currency),
                'customer' => $customer->id,
                'metadata' => [
                    'order_id' => $orderId,
                    'order_number' => $orderNumber,
                    'user_id' => $userId,
                ],
                'description' => "Order #{$orderNumber}",
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'setup_future_usage' => 'off_session',
            ];

            if ($order instanceof Order && !empty($order->saved_payment_method_id)) {
                $intentParams['payment_method'] = $order->saved_payment_method_id;
            }

            $intent = PaymentIntent::create($intentParams);

            // Update order if it's a real model
            if ($order instanceof Order) {
                $order->update(['stripe_payment_intent_id' => $intent->id]);
            }

            return [
                'client_secret' => $intent->client_secret,
                'payment_intent_id' => $intent->id,
                'status' => $intent->status,
            ];

        } catch (\Exception $e) {
            Log::error('Stripe Payment Intent Creation Failed: ' . $e->getMessage());
            throw new \Exception('Payment initialization failed: ' . $e->getMessage());
        }
    }

    /**
     * Get or create Stripe customer
     */
    public function getOrCreateCustomer($user)
    {
        if ($user && $user->stripe_customer_id) {
            try {
                return Customer::retrieve($user->stripe_customer_id);
            } catch (\Exception $e) {
                // Customer not found, create new one
            }
        }

        // Handle guest guest checkout or user without stripe ID
        $email = $user ? $user->email : 'guest@example.com';
        $name = $user ? $user->name : 'Guest';

        $customer = Customer::create([
            'email' => $email,
            'name' => $name,
            'metadata' => [
                'user_id' => $user ? $user->id : 'guest',
            ],
        ]);

        if ($user) {
            $user->update(['stripe_customer_id' => $customer->id]);
        }

        return $customer;
    }

    /**
     * Confirm payment intent
     */
    public function confirmPayment($paymentIntentId)
    {
        try {
            $intent = PaymentIntent::retrieve($paymentIntentId);

            if ($intent->status === 'succeeded') {
                return [
                    'success' => true,
                    'payment_intent' => $intent,
                    'transaction_id' => $intent->charges->data[0]->id ?? null,
                ];
            }

            return [
                'success' => false,
                'status' => $intent->status,
                'message' => 'Payment not completed',
            ];

        } catch (\Exception $e) {
            Log::error('Stripe Payment Confirmation Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment($chargeId, $amount = null)
    {
        try {
            $params = ['charge' => $chargeId];

            if ($amount) {
                $params['amount'] = $this->convertToCents($amount);
            }

            $refund = Refund::create($params);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'status' => $refund->status,
            ];

        } catch (\Exception $e) {
            Log::error('Stripe Refund Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Convert amount to cents (Stripe uses smallest currency unit)
     */
    private function convertToCents($amount)
    {
        return (int) round($amount * 100);
    }

    /**
     * Convert cents to dollars
     */
    private function convertToDollars($cents)
    {
        return $cents / 100;
    }

    /**
     * Handle Stripe webhook
     */
    public function handleWebhook($payload)
    {
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '',
                config('services.stripe.webhook')
            );
        } catch (\Exception $e) {
            Log::error('Stripe Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;
            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event->data->object);
                break;
            case 'charge.refunded':
                $this->handleChargeRefunded($event->data->object);
                break;
            default:
                Log::info('Unhandled Stripe event type: ' . $event->type);
        }

        return response()->json(['received' => true]);
    }

    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if ($order) {
            $order->markAsPaid(
                $paymentIntent->charges->data[0]->id ?? $paymentIntent->id,
                $paymentIntent->charges->data[0]->payment_method_details->type ?? 'card'
            );

            Log::info('Order marked as paid via webhook: ' . $order->order_number);
        }
    }

    private function handlePaymentIntentFailed($paymentIntent)
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if ($order) {
            $order->update(['payment_status' => 'failed']);
            Log::error('Payment failed for order: ' . $order->order_number);
        }
    }

    private function handleChargeRefunded($charge)
    {
        $order = Order::where('transaction_id', $charge->id)->first();

        if ($order) {
            $order->update(['payment_status' => 'refunded']);
            Log::info('Order refunded: ' . $order->order_number);
        }
    }
}
