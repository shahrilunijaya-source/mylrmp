<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private const OFFICER_ROLES = [
        'Super Admin',
        'Pendaftar',
        'Penilai Teknikal',
        'Penilai Label',
        'Pegawai Pendaftaran',
        'Pegawai Pemeriksaan',
    ];

    public function showLogin()
    {
        if (Auth::check() && Auth::user()->hasAnyRole(self::OFFICER_ROLES)) {
            return redirect()->route('officer.dashboard');
        }

        return view('officer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (! $user->hasAnyRole(self::OFFICER_ROLES)) {
                Auth::logout();
                $request->session()->invalidate();

                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Akaun ini tidak mempunyai akses ke Portal Pegawai.']);
            }

            $request->session()->regenerate();

            return redirect()->route('officer.dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'E-mel atau kata laluan tidak sah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('officer.login');
    }
}
