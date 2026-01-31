<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::query()
            ->with([
                'booking:id,customer_user_id,provider_user_id,total_cost',
                'booking.customer:id,name',
                'booking.provider:id,name',
            ])
            ->orderByDesc('id')
            ->get();

        return view('admin.payments', compact('payments'));
    }
}
