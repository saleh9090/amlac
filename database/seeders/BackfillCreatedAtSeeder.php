<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackfillCreatedAtSeeder extends Seeder
{
    /**
     * Fixes created_at on existing income/expense records so it matches
     * their own date instead of whenever the row happened to be
     * inserted (e.g. by an earlier seeder run). updated_at is left
     * untouched.
     *
     * Run with: php artisan db:seed --class=BackfillCreatedAtSeeder
     */
    public function run(): void
    {
        $expenses = DB::table('expenses')
            ->whereNotNull('expense_date')
            ->update(['created_at' => DB::raw('expense_date')]);

        $incomes = DB::table('incomes')
            ->whereNotNull('date')
            ->update(['created_at' => DB::raw('date')]);

        $this->command?->info("Backfilled created_at on {$expenses} expense(s) and {$incomes} income(s).");
    }
}
