<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    public function getAccessToken()
    {
        $mode = config('paypal.mode', 'sandbox');
        $clientId = config("paypal.{$mode}.client_id");
        $secret = config("paypal.{$mode}.secret");
        $baseUrl = config("paypal.{$mode}.base_url");

        if (!$clientId || !$secret || !$baseUrl) {
            Log::error('PayPal config missing for mode.', ['mode' => $mode]);
            throw new \RuntimeException('PayPal configuration is incomplete.');
        }

        $response = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post("{$baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            Log::error('PayPal access token request failed.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            throw new \RuntimeException('Unable to authenticate with PayPal.');
        }

        return $response->json('access_token');
    }

    public function createOrder($booking)
    {
        $token = $this->getAccessToken();
        $mode = config('paypal.mode', 'sandbox');
        $baseUrl = config("paypal.{$mode}.base_url");

        $amount = number_format((float) $booking->total_cost, 2, '.', '');
        $currency = config('paypal.currency', 'USD');

        $response = Http::withToken($token)
            ->acceptJson()
            ->post("{$baseUrl}/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => 'BOOKING-'.$booking->id,
                        'custom_id' => (string) $booking->id,
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => $amount,
                        ],
                    ],
                ],
                'application_context' => [
                    'return_url' => config('paypal.return_url'),
                    'cancel_url' => config('paypal.cancel_url'),
                ],
            ]);

        if (!$response->successful()) {
            Log::error('PayPal create order failed.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            throw new \RuntimeException('Unable to create PayPal order.');
        }

        return $response->json();
    }

    public function getOrderDetails($token)
    {
        $accessToken = $this->getAccessToken();
        $mode = config('paypal.mode', 'sandbox');
        $baseUrl = config("paypal.{$mode}.base_url");

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->get("{$baseUrl}/v2/checkout/orders/{$token}");

        if (!$response->successful()) {
            Log::error('PayPal get order failed.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            throw new \RuntimeException('Unable to fetch PayPal order.');
        }

        return $response->json();
    }

    public function captureOrder($token)
    {
        $accessToken = $this->getAccessToken();
        $mode = config('paypal.mode', 'sandbox');
        $baseUrl = config("paypal.{$mode}.base_url");

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->post("{$baseUrl}/v2/checkout/orders/{$token}/capture", new \stdClass());

        if (!$response->successful()) {
            Log::error('PayPal capture order failed.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            throw new \RuntimeException('Unable to capture PayPal order.');
        }

        return $response->json();
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $booking = Booking::with('payment')->findOrFail($validated['booking_id']);

        if ($booking->customer_user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'accepted') {
            return back()->withErrors(['payment' => 'Booking must be accepted before payment.']);
        }

        if ($booking->payment && $booking->payment->payment_status === 'paid') {
            return back()->with('success', 'Payment already completed.');
        }

        $expectedAmount = (float) $booking->total_cost;
        $amount = (float) $validated['amount'];

        if (abs($amount - $expectedAmount) > 0.01) {
            return back()->withErrors(['amount' => 'Payment amount does not match booking total.']);
        }

        $order = $this->createOrder($booking);
        $approvalUrl = collect($order['links'] ?? [])
            ->firstWhere('rel', 'approve')['href'] ?? null;

        if (!empty($order['id'])) {
            session()->put('paypal_order_'.$order['id'], $booking->id);
        }

        if (!$approvalUrl) {
            Log::error('PayPal approval link missing.', ['order' => $order]);
            return back()->withErrors(['payment' => 'Unable to start PayPal checkout.']);
        }

        return redirect()->away($approvalUrl);
    }

    public function success(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()
                ->route('seeker.bookings.index')
                ->withErrors(['payment' => 'Missing PayPal token.']);
        }

        $capture = $this->captureOrder($token);
        $purchaseUnit = $capture['purchase_units'][0] ?? null;
        $bookingId = $purchaseUnit['custom_id'] ?? null;

        if (!$bookingId && !empty($purchaseUnit['reference_id']) && str_starts_with($purchaseUnit['reference_id'], 'BOOKING-')) {
            $bookingId = (int) str_replace('BOOKING-', '', $purchaseUnit['reference_id']);
        }

        if (!$bookingId) {
            $bookingId = session()->pull('paypal_order_'.$token);
        }

        if (!$bookingId) {
            $orderDetails = $this->getOrderDetails($token);
            $unit = $orderDetails['purchase_units'][0] ?? null;
            $bookingId = $unit['custom_id'] ?? null;

            if (!$bookingId && !empty($unit['reference_id']) && str_starts_with($unit['reference_id'], 'BOOKING-')) {
                $bookingId = (int) str_replace('BOOKING-', '', $unit['reference_id']);
            }
        }

        if (!$bookingId) {
            Log::error('PayPal capture missing booking reference.', ['capture' => $capture]);
            return redirect()
                ->route('seeker.bookings.index')
                ->withErrors(['payment' => 'Unable to match PayPal payment to a booking.']);
        }

        $booking = Booking::with('payment')->findOrFail($bookingId);

        if ($booking->customer_user_id !== auth()->id()) {
            abort(403);
        }

        $status = $capture['status'] ?? null;
        if ($status !== 'COMPLETED') {
            return redirect()
                ->route('seeker.bookings.show', $booking)
                ->withErrors(['payment' => 'PayPal payment was not completed.']);
        }

        \App\Models\Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]
        );

        return redirect()
            ->route('seeker.bookings.show', $booking)
            ->with('success', 'Payment completed successfully.');
    }

    public function cancel()
    {
        return redirect()
            ->route('seeker.bookings.index')
            ->withErrors(['payment' => 'PayPal payment was cancelled.']);
    }
}
