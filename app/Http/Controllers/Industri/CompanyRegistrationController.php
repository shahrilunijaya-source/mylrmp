<?php

namespace App\Http\Controllers\Industri;

use App\Enums\CompanyStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyRegistrationController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('industri.dashboard');
        }

        return view('industri.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => ['required', 'string', 'max:255'],
            'ssm_no'         => ['required', 'string', 'max:50', 'unique:companies,ssm_no'],
            'address'        => ['required', 'string', 'max:1000'],
            'contact_person' => ['required', 'string', 'max:255'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create company
        $company = Company::create([
            'name'           => $validated['company_name'],
            'ssm_no'         => $validated['ssm_no'],
            'address'        => $validated['address'],
            'contact_person' => $validated['contact_person'],
            'phone'          => $validated['phone'] ?? null,
            'status'         => CompanyStatus::Active,
            'registered_at'  => now(),
        ]);

        // Create user and link to company
        $user = User::create([
            'name'       => $validated['contact_person'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'is_active'  => true,
            'company_id' => $company->id,
        ]);

        // Assign Industri role
        $user->assignRole('Industri');

        // Log the user in
        Auth::login($user);

        return redirect()->route('industri.dashboard')
            ->with('success', 'Pendaftaran syarikat berjaya. Selamat datang ke myLRMP!');
    }
}
