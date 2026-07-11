<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use Illuminate\Database\Seeder;

class RemoveSharesIncomeSeeder extends Seeder
{
    /**
     * Cleans up the "Shares" income entries that were seeded by mistake
     * (moved to expenses instead). Deletes the income rows and removes
     * the "Shares" income category if nothing else is using it.
     *
     * Run with: php artisan db:seed --class=RemoveSharesIncomeSeeder
     */
    public function run(): void
    {
        $category = IncomeCategory::query()->where('name', 'Shares')->first();

        if (! $category) {
            $this->command?->info('No "Shares" income category found — nothing to clean up.');

            return;
        }

        $deleted = $category->incomes()->delete();

        if ($category->incomes()->doesntExist()) {
            $category->delete();
        }

        $this->command?->info("Removed {$deleted} \"Shares\" income record(s).");
    }
}
