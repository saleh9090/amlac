<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Income;
use Filament\Widgets\ChartWidget;

class IncomeExpenseChartWidget extends ChartWidget
{
    protected ?string $heading = 'Income vs Expenses';

    protected int|string|array $columnSpan = 2;

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * @return array<int, string>
     */
    protected function getFilters(): ?array
    {
        $currentYear = (int) now()->year;

        $years = range($currentYear, $currentYear - 4);

        return array_combine(
            array_map('strval', $years),
            array_map('strval', $years),
        );
    }

    protected function getData(): array
    {
        $year = (int) ($this->filter ?? now()->year);

        $incomeByMonth = Income::query()
            ->whereYear('date', $year)
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $expenseByMonth = Expense::query()
            ->whereYear('expense_date', $year)
            ->selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = range(1, 12);

        return [
            'datasets' => [
                [
                    'label' => 'Income',
                    'data' => array_map(fn (int $month): float => round((float) ($incomeByMonth[$month] ?? 0), 1), $months),
                    'backgroundColor' => '#22c55e',
                ],
                [
                    'label' => 'Expenses',
                    'data' => array_map(fn (int $month): float => round((float) ($expenseByMonth[$month] ?? 0), 1), $months),
                    'backgroundColor' => '#ef4444',
                ],
            ],
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
            ],
        ];
    }
}
