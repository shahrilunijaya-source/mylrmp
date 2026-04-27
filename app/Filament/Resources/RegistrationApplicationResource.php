<?php

namespace App\Filament\Resources;

use App\Enums\ApplicationStage;
use App\Filament\Resources\RegistrationApplicationResource\Pages;
use App\Models\ProductCategory;
use App\Models\RegistrationApplication;
use App\Services\ApplicationWorkflow;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class RegistrationApplicationResource extends Resource
{
    protected static ?string $model = RegistrationApplication::class;

    protected static ?string $modelLabel = 'Permohonan';

    protected static ?string $pluralModelLabel = 'Permohonan Pendaftaran';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Permohonan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Permohonan Pendaftaran';
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
                TextEntry::make('application_no')
                    ->label('No. Permohonan'),

                TextEntry::make('company.name')
                    ->label('Syarikat'),

                TextEntry::make('category.name_ms')
                    ->label('Kategori'),

                TextEntry::make('product.name')
                    ->label('Produk')
                    ->default('N/A'),

                TextEntry::make('current_stage')
                    ->label('Peringkat')
                    ->badge()
                    ->color(fn (ApplicationStage $state): string => $state->color())
                    ->formatStateUsing(fn (ApplicationStage $state): string => $state->label()),

                TextEntry::make('submitted_at')
                    ->label('Tarikh Dihantar')
                    ->dateTime('d/m/Y H:i'),

                TextEntry::make('decided_at')
                    ->label('Tarikh Keputusan')
                    ->dateTime('d/m/Y H:i'),

                RepeatableEntry::make('documents')
                    ->label('Dokumen')
                    ->schema([
                        TextEntry::make('file_name')
                            ->label('Nama Fail'),
                        TextEntry::make('document_type')
                            ->label('Jenis'),
                    ]),

                RepeatableEntry::make('reviews')
                    ->label('Sejarah Semakan')
                    ->schema([
                        TextEntry::make('reviewer.name')
                            ->label('Pengulas'),
                        TextEntry::make('stage')
                            ->label('Peringkat')
                            ->formatStateUsing(fn (ApplicationStage $state): string => $state->label()),
                        TextEntry::make('decision')
                            ->label('Keputusan'),
                        TextEntry::make('comments')
                            ->label('Ulasan'),
                        TextEntry::make('reviewed_at')
                            ->label('Tarikh')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application_no')
                    ->label('No. Permohonan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('product.name')
                    ->label('Produk')
                    ->default('N/A'),

                TextColumn::make('company.name')
                    ->label('Syarikat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name_ms')
                    ->label('Kategori'),

                TextColumn::make('current_stage')
                    ->label('Peringkat')
                    ->badge()
                    ->color(fn (ApplicationStage $state): string => $state->color())
                    ->formatStateUsing(fn (ApplicationStage $state): string => $state->label()),

                TextColumn::make('submitted_at')
                    ->label('Tarikh Dihantar')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('assignedOfficer')
                    ->label('Pegawai')
                    ->default('Belum Ditetapkan')
                    ->getStateUsing(fn (RegistrationApplication $record): string => optional($record->reviews()->latest()->first()?->reviewer)->name ?? 'Belum Ditetapkan'),
            ])
            ->filters([
                SelectFilter::make('current_stage')
                    ->label('Peringkat')
                    ->options(collect(ApplicationStage::cases())->mapWithKeys(
                        fn (ApplicationStage $stage) => [$stage->value => $stage->label()]
                    )),

                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->options(ProductCategory::pluck('name_ms', 'id')),
            ])
            ->recordActions([
                ViewAction::make(),

                // stage=submitted actions
                Action::make('passIntake')
                    ->label('Lulus Pra-Semak')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (RegistrationApplication $record): bool =>
                        $record->current_stage === ApplicationStage::Submitted &&
                        Auth::user()?->hasRole('Pegawai Pendaftaran')
                    )
                    ->form([
                        Textarea::make('comments')
                            ->label('Ulasan')
                            ->rows(3),
                    ])
                    ->action(fn (RegistrationApplication $record, array $data) =>
                        app(ApplicationWorkflow::class)->passIntake($record, Auth::user(), $data['comments'] ?? '')
                    ),

                Action::make('failIntake')
                    ->label('Perlu Semakan')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->visible(fn (RegistrationApplication $record): bool =>
                        $record->current_stage === ApplicationStage::Submitted &&
                        Auth::user()?->hasRole('Pegawai Pendaftaran')
                    )
                    ->form([
                        Textarea::make('comments')
                            ->label('Ulasan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(fn (RegistrationApplication $record, array $data) =>
                        app(ApplicationWorkflow::class)->failIntake($record, Auth::user(), $data['comments'])
                    ),

                // stage=tech_review actions
                Action::make('passTechnical')
                    ->label('Lulus Teknikal')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (RegistrationApplication $record): bool =>
                        $record->current_stage === ApplicationStage::TechReview &&
                        Auth::user()?->hasRole('Penilai Teknikal')
                    )
                    ->form([
                        Textarea::make('comments')
                            ->label('Ulasan')
                            ->rows(3),
                    ])
                    ->action(fn (RegistrationApplication $record, array $data) =>
                        app(ApplicationWorkflow::class)->passTechnical($record, Auth::user(), $data['comments'] ?? '')
                    ),

                Action::make('failTechnical')
                    ->label('Perlu Semakan Teknikal')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->visible(fn (RegistrationApplication $record): bool =>
                        $record->current_stage === ApplicationStage::TechReview &&
                        Auth::user()?->hasRole('Penilai Teknikal')
                    )
                    ->form([
                        Textarea::make('comments')
                            ->label('Ulasan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(fn (RegistrationApplication $record, array $data) =>
                        app(ApplicationWorkflow::class)->failTechnical($record, Auth::user(), $data['comments'])
                    ),

                // stage=label_review actions
                Action::make('passLabel')
                    ->label('Lulus Label')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (RegistrationApplication $record): bool =>
                        $record->current_stage === ApplicationStage::LabelReview &&
                        Auth::user()?->hasRole('Penilai Label')
                    )
                    ->form([
                        Textarea::make('comments')
                            ->label('Ulasan')
                            ->rows(3),
                    ])
                    ->action(fn (RegistrationApplication $record, array $data) =>
                        app(ApplicationWorkflow::class)->passLabel($record, Auth::user(), $data['comments'] ?? '')
                    ),

                Action::make('failLabel')
                    ->label('Perlu Semakan Label')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->visible(fn (RegistrationApplication $record): bool =>
                        $record->current_stage === ApplicationStage::LabelReview &&
                        Auth::user()?->hasRole('Penilai Label')
                    )
                    ->form([
                        Textarea::make('comments')
                            ->label('Ulasan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(fn (RegistrationApplication $record, array $data) =>
                        app(ApplicationWorkflow::class)->failLabel($record, Auth::user(), $data['comments'])
                    ),

                // stage=decision actions
                Action::make('approveFinal')
                    ->label('Lulus Permohonan')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (RegistrationApplication $record): bool =>
                        $record->current_stage === ApplicationStage::Decision &&
                        Auth::user()?->hasRole('Pendaftar')
                    )
                    ->form([
                        Textarea::make('comments')
                            ->label('Ulasan')
                            ->rows(3),
                    ])
                    ->action(fn (RegistrationApplication $record, array $data) =>
                        app(ApplicationWorkflow::class)->approveFinal($record, Auth::user(), $data['comments'] ?? '')
                    ),

                Action::make('rejectFinal')
                    ->label('Tolak Permohonan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (RegistrationApplication $record): bool =>
                        $record->current_stage === ApplicationStage::Decision &&
                        Auth::user()?->hasRole('Pendaftar')
                    )
                    ->form([
                        Textarea::make('comments')
                            ->label('Ulasan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(fn (RegistrationApplication $record, array $data) =>
                        app(ApplicationWorkflow::class)->rejectFinal($record, Auth::user(), $data['comments'])
                    ),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrationApplications::route('/'),
            'view'  => Pages\ViewRegistrationApplication::route('/{record}'),
        ];
    }
}
