<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class CleaningExpensesSeeder extends Seeder
{
    /**
     * Adds 7 monthly Cleaning expense records of 30 each, dated the 1st
     * of every month from January 2026 through July 2026, against the
     * first building in the system.
     *
     * Run with: php artisan db:seed --class=CleaningExpensesSeeder
     */
    public function run(): void
    {
        $building = Building::query()->orderBy('name')->first();

        if (! $building) {
            $this->command?->error('No building found — create a building first.');

            return;
        }

        $category = ExpenseCategory::query()->firstOrCreate(['name' => 'Cleaning']);

        for ($month = 1; $month <= 7; $month++) {
            Expense::query()->updateOrCreate(
                [
                    'building_id' => $building->id,
                    'expense_category_id' => $category->id,
                    'expense_date' => sprintf('2026-%02d-01', $month),
                ],
                [
                    'amount' => 30,
                ],
            );
        }

        $this->command?->info("Added 7 Cleaning expenses (30 each, Jan–Jul 2026) to \"{$building->name}\".");
    }
}
