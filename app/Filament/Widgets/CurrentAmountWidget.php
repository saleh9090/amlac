<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Income;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CurrentAmountWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalIncome = (float) Income::query()->sum('amount');
        $totalExpenses = (float) Expense::query()->sum('amount');
        $currentAmount = $totalIncome - $totalExpenses;

        return [
            Stat::make('Current Amount', number_format($currentAmount, 1))
                ->description('Total income minus total expenses')
                ->color($currentAmount >= 0 ? 'success' : 'danger'),
        ];
    }
}
