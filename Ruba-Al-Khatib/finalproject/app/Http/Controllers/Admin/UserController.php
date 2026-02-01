<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
{
    $q      = $request->get('q');
    $role   = $request->get('role', 'all');      // customer/photographer/studio/all
    $status = $request->get('status', 'all');    // approved/pending/rejected/all
    $sort   = $request->get('sort', 'newest');   // newest/oldest/name_az/name_za

    $query = User::query()->where('account_type', '!=', 'admin');

    if ($q) {
        $query->where(function ($w) use ($q) {
            $w->where('full_name', 'like', "%{$q}%")
              ->orWhere('email', 'like', "%{$q}%");
        });
    }

    if ($role !== 'all') {
        $query->where('account_type', $role);
    }

    if ($status !== 'all') {
        $query->where('status', $status);
    }

    // Sorting
    if ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } elseif ($sort === 'name_az') {
        $query->orderBy('full_name', 'asc');
    } elseif ($sort === 'name_za') {
        $query->orderBy('full_name', 'desc');
    } else {
        $query->orderBy('created_at', 'desc'); // newest
    }

    $users = $query->paginate(10)->withQueryString();

    // Stats (بدون فلترة — إجمالي)
    $totalUsers     = User::where('account_type', '!=', 'admin')->count();
    $approvedUsers  = User::where('account_type', '!=', 'admin')->where('status','approved')->count();
    $pendingUsers   = User::where('account_type', '!=', 'admin')->where('status','pending')->count();
    $rejectedUsers  = User::where('account_type', '!=', 'admin')->where('status','rejected')->count();

    return view('admin.users', compact(
        'users','totalUsers','approvedUsers','pendingUsers','rejectedUsers'
    ));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required','string','min:2','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8'],
            'account_type' => ['required','in:customer,photographer,studio,admin'],
            'status' => ['required','in:approved,pending,rejected'],
        ]);

        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'account_type' => $data['account_type'],
            'status' => $data['status'],
            'approved_at' => $data['status'] === 'approved' ? now() : null,
        ]);

        return redirect()->route('admin.users')->with('success', 'User added successfully.');
    }

    public function destroy(User $user)
    {
        // حماية: ما نخلي أي حد يحذف الأدمن
        if ($user->account_type === 'admin') {
            return back()->with('error', 'You cannot delete an admin user.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted.');

    }
}
