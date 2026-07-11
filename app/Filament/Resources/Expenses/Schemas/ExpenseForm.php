<?php

namespace App\Filament\Resources\Expenses\Schemas;

use App\Models\Building;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('building_id')
                    ->relationship('building', 'name')
                    ->default(fn (): ?int => Building::query()->where('name', 'AlGobrah')->value('id'))
                    ->required(),
                DatePicker::make('expense_date')
                    ->required(),
                Select::make('expense_category_id')
                    ->label('Expense Category')
                    ->relationship('expenseCategory', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
