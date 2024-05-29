<?php

namespace App\Filament\Resources\DrugCategoryResource\Pages;

use App\Filament\Resources\DrugCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDrugCategory extends ViewRecord
{
    protected static string $resource = DrugCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
