<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->count();

        $totalProviders = User::query()
            ->where('role', User::ROLE_PROVIDER)
            ->count();

        $totalBookings = Booking::query()->count();
        $totalPayments = Payment::query()->count();

        $activeCustomers = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->where('status', User::STATUS_ACTIVE)
            ->count();

        $inactiveCustomers = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->where('status', User::STATUS_DEACTIVATED)
            ->count();

        $activeProviders = User::query()
            ->where('role', User::ROLE_PROVIDER)
            ->where('status', User::STATUS_ACTIVE)
            ->count();

        $inactiveProviders = User::query()
            ->where('role', User::ROLE_PROVIDER)
            ->where('status', User::STATUS_DEACTIVATED)
            ->count();

        $customerActivePct = $totalCustomers > 0
            ? (int) round(($activeCustomers / $totalCustomers) * 100)
            : 0;

        $customerInactivePct = $totalCustomers > 0
            ? (int) max(0, 100 - $customerActivePct)
            : 0;

        $providerActivePct = $totalProviders > 0
            ? (int) round(($activeProviders / $totalProviders) * 100)
            : 0;

        $providerInactivePct = $totalProviders > 0
            ? (int) max(0, 100 - $providerActivePct)
            : 0;

        $latestBookings = Booking::query()
            ->with([
                'customer:id,name',
                'provider:id,name',
                'category:id,code,name',
                'slot:id,start_time,end_time',
                'payment:id,booking_id,payment_status',
            ])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $latestPayments = Payment::query()
            ->with([
                'booking:id,customer_user_id,provider_user_id,total_cost',
                'booking.customer:id,name',
                'booking.provider:id,name',
            ])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProviders',
            'totalBookings',
            'totalPayments',
            'activeCustomers',
            'inactiveCustomers',
            'activeProviders',
            'inactiveProviders',
            'customerActivePct',
            'customerInactivePct',
            'providerActivePct',
            'providerInactivePct',
            'latestBookings',
            'latestPayments'
        ));
    }
}
