<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProvidersController extends Controller
{
    public function index()
    {
        $providers = User::query()
            ->where('role', User::ROLE_PROVIDER)
            ->with(['providerProfile.services.category'])
            ->orderByDesc('id')
            ->get();

        return view('admin.providers', compact('providers'));
    }
}
