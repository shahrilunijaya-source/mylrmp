<?php

namespace App\Filament\Resources;

use App\Enums\InspectionStatus;
use App\Filament\Resources\InspectionResource\Pages;
use App\Models\Inspection;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InspectionResource extends Resource
{
    protected static ?string $model = Inspection::class;

    protected static ?string $modelLabel = 'Pemeriksaan';

    protected static ?string $pluralModelLabel = 'Pemeriksaan';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-clipboard-document-check';
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'e-Pemeriksaan';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inspection_no')->label('No. Pemeriksaan')->searchable()->sortable(),
                TextColumn::make('inspector.name')->label('Pemeriksa')->searchable(),
                TextColumn::make('scheduled_for')->label('Tarikh Dijadual')->date('d/m/Y')->sortable(),
                TextColumn::make('status')->label('Status')
                    ->badge()
                    ->color(fn (InspectionStatus $state): string => $state->color())
                    ->formatStateUsing(fn (InspectionStatus $state): string => $state->label()),
                TextColumn::make('findings_count')->label('Penemuan')
                    ->counts('findings')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(collect(InspectionStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
            ])
            ->defaultSort('scheduled_for', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInspections::route('/'),
            'view'  => Pages\ViewInspection::route('/{record}'),
        ];
    }
}
