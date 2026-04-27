<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticated();
        }

        return view('industri.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectAuthenticated();
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

        return redirect()->route('industri.login');
    }

    private function redirectAuthenticated()
    {
        $user = Auth::user();

        if ($user && $user->hasRole('Industri')) {
            return redirect()->route('industri.dashboard');
        }

        return redirect('/admin');
    }
}
