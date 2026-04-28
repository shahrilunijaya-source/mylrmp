<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectionChecklistItemResource\Pages;
use App\Models\InspectionChecklistItem;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InspectionChecklistItemResource extends Resource
{
    protected static ?string $model = InspectionChecklistItem::class;

    protected static ?string $modelLabel = 'Item Senarai Semak';

    protected static ?string $pluralModelLabel = 'Item Senarai Semak';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-list-bullet';
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'e-Pemeriksaan';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('code')->label('Kod')->required()->maxLength(20)->unique(ignoreRecord: true),
                TextInput::make('category')->label('Kategori')->required()->maxLength(50),
                TextInput::make('prompt_ms')->label('Soalan (BM)')->required()->columnSpanFull(),
                TextInput::make('prompt_en')->label('Soalan (EN)')->columnSpanFull(),
                Select::make('applies_to')->label('Guna Untuk')
                    ->options(['Premises' => 'Premis', 'Company' => 'Syarikat', 'Both' => 'Kedua-dua'])
                    ->required(),
                TextInput::make('display_order')->label('Urutan')->numeric()->default(0),
                Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('Kod')->searchable()->sortable(),
                TextColumn::make('category')->label('Kategori')->sortable(),
                TextColumn::make('prompt_ms')->label('Soalan')->limit(60),
                TextColumn::make('applies_to')->label('Guna Untuk'),
                TextColumn::make('display_order')->label('Urutan')->sortable(),
                IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->defaultSort('display_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListInspectionChecklistItems::route('/'),
            'create' => Pages\CreateInspectionChecklistItem::route('/create'),
            'edit'   => Pages\EditInspectionChecklistItem::route('/{record}/edit'),
        ];
    }
}
