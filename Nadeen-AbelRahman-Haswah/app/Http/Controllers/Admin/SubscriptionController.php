<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $subscriptions = Subscription::with([
            'company',
            'plan',
            'company.users',
        ])
            ->when($search, function ($q) use ($search) {
                $q->where('status', 'like', "%{$search}%")
                    ->orWhereHas('company', function ($cq) use ($search) {
                        $cq->where('workspace_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('plan', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]); // مهم عشان يضل البحث مع pagination

        return view('admin.subscriptions', compact('subscriptions', 'search'));
    }
}
