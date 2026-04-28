<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('roles');

        return view('officer.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $request->user()->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profil berjaya dikemaskini.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Kata laluan semasa tidak tepat.',
            'password.min'                      => 'Kata laluan baharu mestilah sekurang-kurangnya 8 aksara.',
            'password.confirmed'                => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('password_success', 'Kata laluan berjaya ditukar.');
    }
}
