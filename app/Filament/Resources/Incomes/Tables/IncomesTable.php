<?php

namespace App\Filament\Resources\Incomes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class IncomesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'asc')
            ->columns([
                TextColumn::make('building.name')
                    ->label('Building')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('incomeCategory.name')
                    ->label('Category')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->numeric(decimalPlaces: 1)
                    ->sortable()
                    ->summarize(
                        Sum::make()
                            ->label('Total Amount')
                            ->numeric(decimalPlaces: 1),
                    ),
                TextColumn::make('note')
                    ->limit(60)
                    ->wrap()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('income_category_id')
                    ->label('Category')
                    ->relationship('incomeCategory', 'name'),
                Filter::make('date')
                    ->label('Income Date')
                    ->schema([
                        DatePicker::make('income_date_from')
                            ->label('From'),
                        DatePicker::make('income_date_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['income_date_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['income_date_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['income_date_from'] ?? null) {
                            $indicators[] = Indicator::make('Income date from ' . $data['income_date_from'])
                                ->removeField('income_date_from');
                        }

                        if ($data['income_date_until'] ?? null) {
                            $indicators[] = Indicator::make('Income date until ' . $data['income_date_until'])
                                ->removeField('income_date_until');
                        }

                        return $indicators;
                    }),
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
