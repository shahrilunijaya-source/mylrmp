<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStage;
use App\Enums\InspectionStatus;
use App\Models\Company;
use App\Models\Inspection;
use App\Models\Product;
use App\Models\RegistrationApplication;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class KpiOverviewWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getColumns(): int|array|null
    {
        return 4;
    }

    protected function getStats(): array
    {
        $now  = Carbon::now();
        $som  = $now->copy()->startOfMonth();
        $sopm = $now->copy()->subMonth()->startOfMonth();
        $eopm = $now->copy()->subMonth()->endOfMonth();

        $actionStages = [
            ApplicationStage::Submitted->value,
            ApplicationStage::TechReview->value,
            ApplicationStage::LabelReview->value,
            ApplicationStage::Decision->value,
        ];

        // Permohonan masuk bulan ini vs bulan lepas
        $bulanIni  = RegistrationApplication::where('submitted_at', '>=', $som)->count();
        $bulanLepas = RegistrationApplication::whereBetween('submitted_at', [$sopm, $eopm])->count();
        $trendBulan = $bulanLepas > 0
            ? round((($bulanIni - $bulanLepas) / $bulanLepas) * 100)
            : ($bulanIni > 0 ? 100 : 0);

        // Diluluskan bulan ini
        $diluluskan = RegistrationApplication::where('current_stage', ApplicationStage::Approved->value)
            ->where('decided_at', '>=', $som)
            ->count();

        // Menunggu tindakan
        $perluTindakan = RegistrationApplication::whereIn('current_stage', $actionStages)->count();

        // Syarikat aktif
        $syarikatAktif = Company::where('status', 'active')->count();

        // Build sparkline: submissions per day for last 7 days
        $sparkline = collect(range(6, 0))->map(fn ($d) => RegistrationApplication::whereDate('submitted_at', $now->copy()->subDays($d))->count())->toArray();

        return [
            Stat::make('Permohonan Bulan Ini', $bulanIni)
                ->description(($trendBulan >= 0 ? '+' : '') . $trendBulan . '% berbanding bulan lepas')
                ->descriptionIcon($trendBulan >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($trendBulan >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-document-plus')
                ->chart($sparkline),

            Stat::make('Diluluskan Bulan Ini', $diluluskan)
                ->description($now->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->icon('heroicon-o-check-badge'),

            Stat::make('Menunggu Tindakan', $perluTindakan)
                ->description('Perlu semakan pegawai DOA')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($perluTindakan > 10 ? 'danger' : 'warning')
                ->icon('heroicon-o-clock'),

            Stat::make('Syarikat Berdaftar', $syarikatAktif)
                ->description('Syarikat aktif dalam sistem')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary')
                ->icon('heroicon-o-building-office-2'),

            Stat::make('Pemeriksaan Bulan Ini', Inspection::where('scheduled_for', '>=', $som)->count())
                ->description(Inspection::whereIn('status', [InspectionStatus::MinorNC->value, InspectionStatus::MajorNC->value])->whereDate('conducted_at', '>=', $som)->count() . ' ketidakpatuhan')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info')
                ->icon('heroicon-o-clipboard-document-check'),
        ];
    }
}
