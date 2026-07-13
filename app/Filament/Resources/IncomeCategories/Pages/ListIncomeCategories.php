<?php

namespace App\Filament\Resources\IncomeCategories\Pages;

use App\Filament\Concerns\BlocksListAccessForNonAdmins;
use App\Filament\Resources\IncomeCategories\IncomeCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIncomeCategories extends ListRecords
{
    use BlocksListAccessForNonAdmins;

    protected static string $resource = IncomeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
