<?php

namespace App\Filament\Resources\ExpenseCategories\Pages;

use App\Filament\Concerns\BlocksListAccessForNonAdmins;
use App\Filament\Resources\ExpenseCategories\ExpenseCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExpenseCategories extends ListRecords
{
    use BlocksListAccessForNonAdmins;

    protected static string $resource = ExpenseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
