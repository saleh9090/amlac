<?php

namespace App\Filament\Resources\Units\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('building.name')
                    ->searchable(),
                TextColumn::make('unit_number')
                    ->searchable(),
                TextColumn::make('unit_type')
                    ->searchable(),
                TextColumn::make('layout')
                    ->searchable(),
                TextColumn::make('floor')
                    ->searchable(),
                TextColumn::make('area')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('electricity_account')
                    ->searchable(),
                TextColumn::make('water_account')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'occupied' ? 'Occupied' : 'Vacant')
                    ->color(fn (string $state): string => $state === 'occupied' ? 'danger' : 'success')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
