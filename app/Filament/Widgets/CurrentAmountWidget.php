<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CurrentAmountWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalIncome = (float) Income::query()->sum('amount');
        $totalExpenses = (float) Expense::query()->sum('amount');
        $currentAmount = $totalIncome - $totalExpenses;

        $nextMonth = Carbon::now()->addMonthNoOverflow();

        $expiringNextMonth = Contract::query()
            ->whereBetween('end_date', [
                $nextMonth->copy()->startOfMonth(),
                $nextMonth->copy()->endOfMonth(),
            ])
            ->count();

        return [
            Stat::make('Current Amount', number_format($currentAmount, 1))
                ->description('Total income minus total expenses')
                ->color($currentAmount >= 0 ? 'success' : 'danger'),

            Stat::make('Contracts Expiring Next Month', $expiringNextMonth)
                ->description($nextMonth->format('F Y'))
                ->color($expiringNextMonth > 0 ? 'warning' : 'success'),
        ];
    }
}
