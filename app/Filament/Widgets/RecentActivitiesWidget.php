<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Spatie\Activitylog\Models\Activity;

class RecentActivitiesWidget extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Aktiviti Terkini')
            ->query(
                Activity::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('causer.name')
                    ->label('Pengguna')
                    ->default('Sistem'),

                TextColumn::make('description')
                    ->label('Tindakan'),

                TextColumn::make('created_at')
                    ->label('Tarikh & Masa')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
