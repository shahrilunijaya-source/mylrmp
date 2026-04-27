<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatus;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $modelLabel = 'Produk';

    protected static ?string $pluralModelLabel = 'Produk';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-beaker';
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Pengurusan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Produk';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nama Produk'),

                TextEntry::make('registration_no')
                    ->label('No. Pendaftaran'),

                TextEntry::make('registrant.name')
                    ->label('Syarikat Pendaftar'),

                TextEntry::make('formulationType.code')
                    ->label('Jenis Formulasi'),

                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ProductStatus $state): string => $state->color())
                    ->formatStateUsing(fn (ProductStatus $state): string => $state->label()),

                TextEntry::make('expires_at')
                    ->label('Tamat Tempoh')
                    ->date('d/m/Y'),

                RepeatableEntry::make('activeIngredients')
                    ->label('Perawis Aktif')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('pivot.concentration_percent')
                            ->label('Kepekatan (%)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('registration_no')
                    ->label('No. Pendaftaran')
                    ->searchable(),

                TextColumn::make('registrant.name')
                    ->label('Syarikat Pendaftar')
                    ->sortable(),

                TextColumn::make('formulationType.code')
                    ->label('Formulasi'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ProductStatus $state): string => $state->color())
                    ->formatStateUsing(fn (ProductStatus $state): string => $state->label()),

                TextColumn::make('expires_at')
                    ->label('Tamat Tempoh')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'view'  => Pages\ViewProduct::route('/{record}'),
        ];
    }
}
