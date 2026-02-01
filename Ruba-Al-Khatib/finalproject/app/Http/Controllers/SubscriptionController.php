<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $user = $request->user();
        $plan = Plan::where('is_active', true)->findOrFail($data['plan_id']);

        // ✅ منع اختيار خطة مش لنفس نوع الحساب
        if ($plan->for !== $user->account_type) {
            return back()->with('error', 'This plan is not for your account type.');
        }

        // ✅ تأكد من وجود بروفايل (إذا النوع photographer/studio)
        if ($user->account_type === 'photographer' && !$user->photographerProfile) {
            return back()->with('error', 'Photographer profile is required.');
        }

        if ($user->account_type === 'studio' && !$user->studioProfile) {
            return back()->with('error', 'Studio profile is required.');
        }

        // ✅ اقفل أي اشتراك Active سابق
        Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update([
                'status' => 'canceled',
                'ends_at' => now(),
                'auto_renew' => false,
                'payment_status' => 'canceled',
            ]);

        $isPaid = (float) $plan->price_jod > 0;

        $starts = now();
        $ends = $isPaid ? null : null; // للـ MVP خليها null، لأننا مش عاملين دورة دفع حقيقية

        // ✅ إنشاء اشتراك جديد
        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => $isPaid ? 'pending' : 'active',
            'starts_at' => $starts,
            'ends_at' => $ends,
            'auto_renew' => $isPaid ? false : true, // المدفوع مؤقتًا false لحد ما يتم الدفع
            'payment_status' => $isPaid ? 'pending_payment' : 'active',
        ]);

        // ✅ لو الخطة مدفوعة: روح على checkout (تعليمات دفع)
        if ($isPaid) {
            return redirect()->route('checkout')
                ->with('success', 'Subscription created. Please complete payment to activate your plan.');
        }

        return back()->with('success', 'Subscription activated successfully.');
    }

    public function cancel(Request $request)
    {
        $user = $request->user();
        $sub = $user->activeSubscription()->first();

        if (!$sub) {
            return back()->with('error', 'No active subscription found.');
        }

        $sub->update([
            'status' => 'canceled',
            'ends_at' => now(),
            'auto_renew' => false,
            'payment_status' => 'canceled',
        ]);

        return back()->with('success', 'Subscription canceled.');
    }
}
