<?php

namespace App\Filament\Resources\Expenses\Tables;

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

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('expense_date', 'asc')
            ->columns([
                TextColumn::make('building.name')
                    ->searchable(),
                TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('expenseCategory.name')
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
                TextColumn::make('description')
                    ->limit(60)
                    ->wrap()
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
                SelectFilter::make('expense_category_id')
                    ->label('Category')
                    ->relationship('expenseCategory', 'name'),
                Filter::make('expense_date')
                    ->label('Expense Date')
                    ->schema([
                        DatePicker::make('expense_date_from')
                            ->label('From'),
                        DatePicker::make('expense_date_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['expense_date_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('expense_date', '>=', $date),
                            )
                            ->when(
                                $data['expense_date_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('expense_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['expense_date_from'] ?? null) {
                            $indicators[] = Indicator::make('Expense date from ' . $data['expense_date_from'])
                                ->removeField('expense_date_from');
                        }

                        if ($data['expense_date_until'] ?? null) {
                            $indicators[] = Indicator::make('Expense date until ' . $data['expense_date_until'])
                                ->removeField('expense_date_until');
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
