<?php

namespace App\Filament\Resources\Incomes\Schemas;

use App\Models\Building;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class IncomeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('building_id')
                    ->label('Building')
                    ->relationship('building', 'name')
                    ->default(fn (): ?int => Building::query()->where('name', 'AlGobrah')->value('id'))
                    ->required(),
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('income_category_id')
                    ->relationship('incomeCategory', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}
