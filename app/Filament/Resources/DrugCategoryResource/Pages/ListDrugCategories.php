<?php

namespace App\Filament\Resources\DrugCategoryResource\Pages;

use App\Filament\Resources\DrugCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDrugCategories extends ListRecords
{
    protected static string $resource = DrugCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
