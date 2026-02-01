<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status'); // optional: pending | active | canceled

        $subs = Subscription::with(['user','plan'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        return view('admin.subscriptions.index', compact('subs', 'status'));
    }

    public function approve(Subscription $subscription)
    {
        $subscription->load('plan');

        // ✅ اقفل أي اشتراك Active قديم لنفس المستخدم
        Subscription::where('user_id', $subscription->user_id)
            ->where('status', 'active')
            ->where('id', '!=', $subscription->id)
            ->update([
                'status' => 'canceled',
                'payment_status' => 'canceled',
                'ends_at' => now(),
                'auto_renew' => false,
            ]);

        $isFree = (float)($subscription->plan->price_jod ?? 0) <= 0;

        $subscription->update([
            'status' => 'active',
            'payment_status' => 'active',
            'starts_at' => now(),
            'ends_at' => $isFree ? null : now()->addMonth(),
            'auto_renew' => !$isFree, // free عادةً ما بدها auto renew
        ]);

        return back()->with('success', 'Subscription approved.');
    }

    public function cancel(Subscription $subscription)
    {
        $subscription->update([
            'status' => 'canceled',
            'payment_status' => 'canceled',
            'ends_at' => now(),
            'auto_renew' => false,
        ]);

        return back()->with('success', 'Subscription canceled.');
    }
}
