<?php

namespace App\Filament\Resources\InspectionChecklistItemResource\Pages;

use App\Filament\Resources\InspectionChecklistItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInspectionChecklistItems extends ListRecords
{
    protected static string $resource = InspectionChecklistItemResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
