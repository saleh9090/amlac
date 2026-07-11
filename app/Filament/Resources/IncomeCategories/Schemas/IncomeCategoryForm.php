<?php

namespace App\Filament\Resources\IncomeCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IncomeCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }
}
