<?php

namespace App\Filament\Resources\Buildings\Pages;

use App\Filament\Concerns\BlocksListAccessForNonAdmins;
use App\Filament\Resources\Buildings\BuildingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBuildings extends ListRecords
{
    use BlocksListAccessForNonAdmins;

    protected static string $resource = BuildingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
