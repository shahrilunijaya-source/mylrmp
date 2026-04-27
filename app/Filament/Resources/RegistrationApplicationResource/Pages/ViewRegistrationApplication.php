<?php

namespace App\Filament\Resources\RegistrationApplicationResource\Pages;

use App\Filament\Resources\RegistrationApplicationResource;
use Filament\Resources\Pages\ViewRecord;

class ViewRegistrationApplication extends ViewRecord
{
    protected static string $resource = RegistrationApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
