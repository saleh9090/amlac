<?php

namespace App\Filament\Resources\Contracts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContractsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('contract_number')
                    ->label('Contract #')
                    ->searchable(),
                TextColumn::make('tenant.name')
                    ->searchable(),
                TextColumn::make('unit.unit_number')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Start')
                    ->date()
                    ->sortable(),
                TextColumn::make('duration_months')
                    ->label('Duration(M)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End')
                    ->date()
                    ->sortable(),
                TextColumn::make('rent_amount')
                    ->label('Amount')
                    ->numeric(decimalPlaces: 1)
                    ->sortable(),
                TextColumn::make('payment_frequency')
                    ->label('Frequency')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'yearly' => 'Yearly',
                        default => 'Monthly',
                    }),
                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cheque' => 'Cheque',
                        'cash' => 'Cash',
                        default => 'Bank transfer',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'inactive' ? 'Inactive' : 'Active')
                    ->color(fn (string $state): string => $state === 'inactive' ? 'danger' : 'success'),
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
                Action::make('viewContract')
                    ->label('Download PDF')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->color('gray')
                    ->iconButton()
                    ->tooltip('Download PDF')
                    ->url(fn ($record): string => route('contracts.download', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record): bool => filled($record->contract_image)),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
