<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->orderByDesc('id')
            ->get();

        return view('admin.customers', compact('customers'));
    }
}
