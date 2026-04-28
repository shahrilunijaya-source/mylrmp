<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Papan Pemuka';

    protected static ?int $navigationSort = 1;

    public function getColumns(): int|array
    {
        return 2;
    }

    public function getHeading(): string
    {
        $user = Auth::user();
        $hour = Carbon::now()->hour;

        $greeting = match(true) {
            $hour < 12 => 'Selamat Pagi',
            $hour < 17 => 'Selamat Tengah Hari',
            default    => 'Selamat Petang',
        };

        return "{$greeting}, {$user?->name}";
    }

    public function getSubheading(): ?string
    {
        return Carbon::now()->translatedFormat('l, d F Y') . ' · Sistem myLRMP — Jabatan Pertanian Malaysia';
    }
}
