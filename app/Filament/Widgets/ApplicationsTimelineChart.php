<?php

namespace App\Filament\Widgets;

use App\Models\RegistrationApplication;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ApplicationsTimelineChart extends ChartWidget
{
    protected static ?int $sort = 3;

    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'Permohonan 30 Hari Terakhir';
    }

    protected int|string|array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $labels = [];
        $counts = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->startOfDay();
            $labels[] = $date->format('d M');
            $counts[] = RegistrationApplication::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Permohonan',
                    'data'            => $counts,
                    'borderColor'     => '#006837',
                    'backgroundColor' => 'rgba(0, 104, 55, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
