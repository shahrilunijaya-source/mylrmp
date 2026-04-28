<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOfficerRole
{
    private const OFFICER_ROLES = [
        'Super Admin',
        'Pendaftar',
        'Penilai Teknikal',
        'Penilai Label',
        'Pegawai Pendaftaran',
        'Pegawai Pemeriksaan',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->hasAnyRole(self::OFFICER_ROLES)) {
            return redirect()->route('officer.login');
        }

        return $next($request);
    }
}
