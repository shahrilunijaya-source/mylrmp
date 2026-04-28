<?php

namespace App\Filament\Resources;

use App\Enums\MalaysianState;
use App\Filament\Resources\PremisesResource\Pages;
use App\Models\Premises;
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

class PremisesResource extends Resource
{
    protected static ?string $model = Premises::class;

    protected static ?string $modelLabel = 'Premis';

    protected static ?string $pluralModelLabel = 'Premis';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-building-storefront';
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'e-Pemeriksaan';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Maklumat Premis')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->label('Nama Premis')->required()->maxLength(255),
                    TextInput::make('license_no')->label('No. Lesen')->maxLength(50),
                    TextInput::make('address_line1')->label('Alamat Baris 1')->required()->columnSpanFull(),
                    TextInput::make('address_line2')->label('Alamat Baris 2')->columnSpanFull(),
                    TextInput::make('postcode')->label('Poskod')->maxLength(10),
                    TextInput::make('district')->label('Daerah')->maxLength(100),
                    Select::make('state')->label('Negeri')
                        ->options(collect(MalaysianState::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
                ]),
            Section::make('PIC & Status')
                ->columns(2)
                ->schema([
                    TextInput::make('pic_name')->label('Nama PIC')->maxLength(255),
                    TextInput::make('pic_phone')->label('Telefon PIC')->tel()->maxLength(20),
                    Toggle::make('is_active')->label('Aktif')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('license_no')->label('No. Lesen')->searchable(),
                TextColumn::make('district')->label('Daerah'),
                TextColumn::make('state')->label('Negeri')
                    ->formatStateUsing(fn ($state) => $state?->label() ?? '—'),
                TextColumn::make('inspections_count')->label('Pemeriksaan')
                    ->counts('inspections')->sortable(),
                IconColumn::make('is_active')->label('Aktif')->boolean(),
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
            'index'  => Pages\ListPremises::route('/'),
            'create' => Pages\CreatePremises::route('/create'),
            'edit'   => Pages\EditPremises::route('/{record}/edit'),
        ];
    }
}
