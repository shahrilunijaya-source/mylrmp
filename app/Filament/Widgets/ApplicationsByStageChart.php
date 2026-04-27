<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStage;
use App\Models\RegistrationApplication;
use Filament\Widgets\ChartWidget;

class ApplicationsByStageChart extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'Permohonan Mengikut Peringkat';
    }

    protected int|string|array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $colorMap = [
            'gray'    => '#6B7280',
            'info'    => '#3B82F6',
            'warning' => '#F59E0B',
            'primary' => '#006837',
            'success' => '#10B981',
            'danger'  => '#EF4444',
        ];

        $labels = [];
        $data = [];
        $colors = [];

        foreach (ApplicationStage::cases() as $stage) {
            $count = RegistrationApplication::where('current_stage', $stage->value)->count();
            $labels[] = $stage->label();
            $data[] = $count;
            $colors[] = $colorMap[$stage->color()] ?? '#6B7280';
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Permohonan',
                    'data'            => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
