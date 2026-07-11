<?php

namespace App\Filament\Resources\Units\Schemas;

use App\Models\Building;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('building_id')
                    ->relationship('building', 'name')
                    ->default(fn (): ?int => Building::query()->where('name', 'AlGobrah')->value('id'))
                    ->required(),
                TextInput::make('unit_number')
                    ->required(),
                TextInput::make('unit_type')
                    ->required(),
                TextInput::make('layout'),
                TextInput::make('floor'),
                TextInput::make('area')
                    ->numeric(),
                TextInput::make('electricity_account'),
                TextInput::make('water_account'),
                Select::make('status')
                    ->options([
                        'vacant' => 'Vacant',
                        'occupied' => 'Occupied',
                    ])
                    ->default('vacant')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
