<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStage;
use App\Models\RegistrationApplication;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Carbon\Carbon;

class RecentActivitiesWidget extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Permohonan Terkini')
            ->description('10 permohonan terbaru yang diserahkan')
            ->query(
                RegistrationApplication::query()
                    ->with(['company', 'product'])
                    ->whereNotNull('submitted_at')
                    ->latest('submitted_at')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('application_no')
                    ->label('No. Permohonan')
                    ->searchable()
                    ->weight('semibold')
                    ->color('primary')
                    ->copyable(),

                TextColumn::make('company.name')
                    ->label('Syarikat')
                    ->searchable()
                    ->limit(32),

                TextColumn::make('product.name')
                    ->label('Produk')
                    ->limit(28)
                    ->placeholder('—'),

                TextColumn::make('current_stage')
                    ->label('Peringkat')
                    ->badge()
                    ->formatStateUsing(fn (ApplicationStage $state): string => $state->label())
                    ->color(fn (ApplicationStage $state): string => $state->color()),

                TextColumn::make('submitted_at')
                    ->label('Tarikh Hantar')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('submitted_at')
                    ->label('Hari Berlalu')
                    ->formatStateUsing(fn ($state): string => $state
                        ? Carbon::parse($state)->diffInDays(now()) . ' hari'
                        : '—')
                    ->color(fn ($state): string => $state && Carbon::parse($state)->diffInDays(now()) > 30
                        ? 'danger'
                        : 'gray'),
            ])
            ->paginated(false)
            ->striped();
    }
}
