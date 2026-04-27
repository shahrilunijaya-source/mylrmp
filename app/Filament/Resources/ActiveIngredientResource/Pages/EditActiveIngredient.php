<?php

namespace App\Filament\Resources\ActiveIngredientResource\Pages;

use App\Filament\Resources\ActiveIngredientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditActiveIngredient extends EditRecord
{
    protected static string $resource = ActiveIngredientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
