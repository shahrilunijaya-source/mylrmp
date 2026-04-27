<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStage;
use App\Models\Product;
use App\Models\RegistrationApplication;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class KpiOverviewWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getColumns(): int|array|null
    {
        return 4;
    }

    protected function getStats(): array
    {
        $openStages = [
            ApplicationStage::Draft->value,
            ApplicationStage::Submitted->value,
            ApplicationStage::TechReview->value,
            ApplicationStage::LabelReview->value,
            ApplicationStage::Decision->value,
            ApplicationStage::NeedsRevision->value,
        ];

        $actionStages = [
            ApplicationStage::Submitted->value,
            ApplicationStage::TechReview->value,
            ApplicationStage::LabelReview->value,
            ApplicationStage::Decision->value,
        ];

        $permohonanTerbuka = RegistrationApplication::whereIn(
            'current_stage',
            $openStages
        )->count();

        $diluluskanBulanIni = RegistrationApplication::where('current_stage', ApplicationStage::Approved->value)
            ->where('decided_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        $perluTindakan = RegistrationApplication::whereIn(
            'current_stage',
            $actionStages
        )->count();

        $produkAktif = Product::where('status', 'active')->count();

        return [
            Stat::make('Permohonan Terbuka', $permohonanTerbuka)
                ->color('warning')
                ->icon('heroicon-o-document-text'),

            Stat::make('Diluluskan Bulan Ini', $diluluskanBulanIni)
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Perlu Tindakan', $perluTindakan)
                ->color('danger')
                ->icon('heroicon-o-clock'),

            Stat::make('Produk Aktif', $produkAktif)
                ->color('primary')
                ->icon('heroicon-o-beaker'),
        ];
    }
}
