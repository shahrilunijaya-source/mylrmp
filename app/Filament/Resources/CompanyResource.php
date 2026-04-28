<?php

namespace App\Filament\Resources;

use App\Enums\CompanyStatus;
use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $modelLabel = 'Syarikat';

    protected static ?string $pluralModelLabel = 'Syarikat';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-building-office';
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Pengurusan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Syarikat';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Maklumat Asas')
                    ->description('Nama, nombor pendaftaran dan alamat syarikat')
                    ->icon('heroicon-o-building-office-2')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Syarikat')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('ssm_no')
                            ->label('No. SSM')
                            ->maxLength(100),

                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Maklumat Hubungan')
                    ->description('Nombor telefon, e-mel dan pegawai perhubungan')
                    ->icon('heroicon-o-phone')
                    ->columns(2)
                    ->schema([
                        TextInput::make('phone')
                            ->label('Telefon')
                            ->tel()
                            ->maxLength(20),

                        TextInput::make('contact_person')
                            ->label('Pegawai Perhubungan')
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('E-mel')
                            ->email()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('Status & Pendaftaran')
                    ->description('Status operasi dan tarikh daftar dengan LRMP')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                CompanyStatus::Active->value    => 'Aktif',
                                CompanyStatus::Suspended->value => 'Digantung',
                                CompanyStatus::Inactive->value  => 'Tidak Aktif',
                            ])
                            ->default(CompanyStatus::Active->value)
                            ->required(),

                        DatePicker::make('registered_at')
                            ->label('Tarikh Pendaftaran'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Syarikat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ssm_no')
                    ->label('No. SSM')
                    ->searchable(),

                TextColumn::make('contact_person')
                    ->label('Pegawai Perhubungan'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (CompanyStatus $state): string => match ($state) {
                        CompanyStatus::Active    => 'success',
                        CompanyStatus::Suspended => 'warning',
                        CompanyStatus::Inactive  => 'danger',
                    })
                    ->formatStateUsing(fn (CompanyStatus $state): string => match ($state) {
                        CompanyStatus::Active    => 'Aktif',
                        CompanyStatus::Suspended => 'Digantung',
                        CompanyStatus::Inactive  => 'Tidak Aktif',
                    }),

                TextColumn::make('registered_at')
                    ->label('Tarikh Daftar')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('applications_count')
                    ->label('Permohonan')
                    ->counts('applications')
                    ->sortable(),
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
            'index'  => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit'   => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
