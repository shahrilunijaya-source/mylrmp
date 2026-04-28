<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'company'])->paginate(20);

        return view('officer.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validRoleNames = Role::pluck('name')->toArray();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'string', 'in:' . implode(',', $validRoleNames)],
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => $validated['password'],
            'is_active' => true,
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('officer.users.index')
            ->with('success', 'Pengguna berjaya ditambah');
    }
}
