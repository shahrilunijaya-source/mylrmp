<?php

namespace App\Filament\Widgets;

use App\Enums\InspectionStatus;
use App\Models\Inspection;
use Filament\Widgets\ChartWidget;

class InspectionsByStatusChart extends ChartWidget
{
    protected static ?int $sort = 4;

    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'Pemeriksaan Mengikut Status';
    }

    protected function getData(): array
    {
        $counts = collect(InspectionStatus::cases())->map(fn ($s) => [
            'label' => $s->label(),
            'count' => Inspection::where('status', $s->value)->count(),
            'color' => match ($s->color()) {
                'success' => 'rgba(22,163,74,0.8)',
                'danger'  => 'rgba(220,38,38,0.8)',
                'warning' => 'rgba(202,138,4,0.8)',
                'info'    => 'rgba(37,99,235,0.8)',
                default   => 'rgba(148,163,184,0.8)',
            },
        ]);

        return [
            'datasets' => [[
                'data'            => $counts->pluck('count')->all(),
                'backgroundColor' => $counts->pluck('color')->all(),
            ]],
            'labels' => $counts->pluck('label')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
