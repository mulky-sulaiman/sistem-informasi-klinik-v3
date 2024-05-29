<?php

namespace App\Filament\Resources\TreatmentCategoryResource\Pages;

use App\Filament\Resources\TreatmentCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTreatmentCategory extends ViewRecord
{
    protected static string $resource = TreatmentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
