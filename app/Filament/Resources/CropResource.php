<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CropResource\Pages;
use App\Models\Crop;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CropResource extends Resource
{
    protected static ?string $model = Crop::class;

    protected static ?string $modelLabel = 'Tanaman';

    protected static ?string $pluralModelLabel = 'Tanaman';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-sparkles';
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Maklumat Rujukan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Tanaman';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ms')
                    ->label('Nama (BM)')
                    ->required()
                    ->maxLength(255),

                TextInput::make('name_en')
                    ->label('Nama (EN)')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_ms')
                    ->label('Nama (BM)')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name_en')
                    ->label('Nama (EN)')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCrops::route('/'),
            'create' => Pages\CreateCrop::route('/create'),
            'edit'   => Pages\EditCrop::route('/{record}/edit'),
        ];
    }
}
