<?php

namespace App\Filament\Resources\IncomeCategories\Pages;

use App\Filament\Resources\IncomeCategories\IncomeCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIncomeCategory extends EditRecord
{
    protected static string $resource = IncomeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
