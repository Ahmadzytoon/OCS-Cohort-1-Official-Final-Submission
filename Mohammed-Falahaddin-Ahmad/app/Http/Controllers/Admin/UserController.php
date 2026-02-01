<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show list of users
    public function index()
    {

     $users = User::orderBy('id', 'asc')->simplePaginate(5);
    return view('admin.users', compact('users'));
    }

    // Show form to create new user
    public function create()
    {
        return view('admin.users-create'); // Create this view later
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }


public function edit(User $user)
{
    return view('admin.users-edit', compact('user'));
}

public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable',
        'password' => 'nullable|min:6',
    ]);

    $updateData = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ];

    // Only update password if provided
    if ($request->filled('password')) {
        $updateData['password'] = bcrypt($request->password);
    }

    $user->update($updateData);

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
}

public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
}


public function restore(User $user)
{
    $user->restore(); 
    return redirect()->route('admin.users.index')->with('success', 'User restored successfully');
}
}