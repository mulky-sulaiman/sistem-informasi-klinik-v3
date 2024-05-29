<?php

namespace App\Filament\Resources\TreatmentCategoryResource\Pages;

use App\Filament\Resources\TreatmentCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTreatmentCategories extends ListRecords
{
    protected static string $resource = TreatmentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
