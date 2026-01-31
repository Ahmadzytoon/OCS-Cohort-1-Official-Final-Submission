<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UserStatusController extends Controller
{
    public function update(Request $request, User $user): RedirectResponse
    {
        if (!in_array($user->role, [User::ROLE_CUSTOMER, User::ROLE_PROVIDER], true)) {
            abort(404);
        }

        $request->validate([
            'status' => ['required', 'in:' . User::STATUS_ACTIVE . ',' . User::STATUS_DEACTIVATED],
        ]);

        if ($user->status !== $request->status) {
            $user->update(['status' => $request->status]);
        }

        return back()->with('success', 'User status updated.');
    }
}
