<?php

namespace App\Filament\Resources\DrugCategoryResource\Pages;

use App\Filament\Resources\DrugCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDrugCategory extends EditRecord
{
    protected static string $resource = DrugCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
