<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CenturyService
{
    /**
     * Track a specific event in the system.
     */
    public function track($eventType, $properties = [])
    {
        try {
            AnalyticsEvent::create([
                'event_type' => $eventType,
                'user_id' => Auth::id(),
                'session_id' => session()->getId(),
                'url' => Request::fullUrl(),
                'properties' => $properties,
                'context' => [
                    'ip' => Request::ip(),
                    'user_agent' => Request::userAgent(),
                    'referer' => Request::header('referer'),
                    'device' => $this->getDeviceType(),
                ],
            ]);
        } catch (\Exception $e) {
            // Silently fail to not disrupt user experience, but log if needed
            // Log::error('Century Tracking Failed: ' . $e->getMessage());
        }
    }

    /**
     * Convenience method for tracking page views.
     */
    public function trackPageView()
    {
        $this->track('page_view', [
            'route' => Request::route()->getName(),
        ]);
    }

    /**
     * Track a purchase event.
     */
    public function trackPurchase($order)
    {
        $this->track('purchase_completed', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'amount' => $order->total_amount,
            'currency' => $order->currency,
            'items_count' => $order->items->count(),
            'payment_method' => $order->payment_method,
        ]);

        foreach ($order->items as $item) {
            $this->track('product_purchased', [
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'variant' => $item->size . ' / ' . $item->color,
            ]);
        }
    }

    /**
     * Track view of a product.
     */
    public function trackProductView($product)
    {
        $this->track('product_viewed', [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'category' => $product->category->name ?? 'Uncategorized',
        ]);
    }

    private function getDeviceType()
    {
        $agent = strtolower(Request::userAgent());
        if (strpos($agent, 'mobile') !== false)
            return 'mobile';
        if (strpos($agent, 'tablet') !== false)
            return 'tablet';
        return 'desktop';
    }
}
