<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class SharesExpensesSeeder extends Seeder
{
    /**
     * Adds 5 Shares expense records of 4400 each on the given dates,
     * against the first building in the system.
     *
     * Run with: php artisan db:seed --class=SharesExpensesSeeder
     */
    public function run(): void
    {
        $building = Building::query()->orderBy('name')->first();

        if (! $building) {
            $this->command?->error('No building found — create a building first.');

            return;
        }

        $category = ExpenseCategory::query()->firstOrCreate(['name' => 'Shares']);

        $dates = [
            '2026-02-15',
            '2026-03-12',
            '2026-04-15',
            '2026-05-12',
            '2026-06-11',
        ];

        foreach ($dates as $date) {
            Expense::query()->updateOrCreate(
                [
                    'building_id' => $building->id,
                    'expense_category_id' => $category->id,
                    'expense_date' => $date,
                ],
                [
                    'amount' => 4400,
                ],
            );
        }

        $this->command?->info("Added 5 Shares expenses (4400 each) to \"{$building->name}\".");
    }
}
