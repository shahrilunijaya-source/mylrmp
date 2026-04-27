<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActiveIngredientResource\Pages;
use App\Models\ActiveIngredient;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActiveIngredientResource extends Resource
{
    protected static ?string $model = ActiveIngredient::class;

    protected static ?string $modelLabel = 'Perawis Aktif';

    protected static ?string $pluralModelLabel = 'Perawis Aktif';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-eye-dropper';
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Maklumat Rujukan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Perawis Aktif';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('cas_no')
                    ->label('No. CAS')
                    ->maxLength(50),

                Toggle::make('is_gazetted')
                    ->label('Dalam Warta')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cas_no')
                    ->label('No. CAS')
                    ->searchable(),

                IconColumn::make('is_gazetted')
                    ->label('Dalam Warta')
                    ->boolean(),
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
            'index'  => Pages\ListActiveIngredients::route('/'),
            'create' => Pages\CreateActiveIngredient::route('/create'),
            'edit'   => Pages\EditActiveIngredient::route('/{record}/edit'),
        ];
    }
}
