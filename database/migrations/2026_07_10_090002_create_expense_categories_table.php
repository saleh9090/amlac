<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Manageable list of expense categories, replacing the fixed
     * dropdown choices that used to live in ExpenseForm.
     */
    public function up(): void
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Seed the categories that used to be hard-coded in the
        // Expense form, plus any distinct values already stored on
        // existing expense rows, so nothing gets lost when the old
        // expenses.expense_category column is dropped.
        $names = collect([
            'Management Commission',
            'Income Commission',
            'Maintenance',
            'Contract Renewal Fee',
            'Cleaning',
        ]);

        if (Schema::hasColumn('expenses', 'expense_category')) {
            $names = $names
                ->merge(
                    DB::table('expenses')
                        ->whereNotNull('expense_category')
                        ->distinct()
                        ->pluck('expense_category')
                )
                ->filter()
                ->unique();
        }

        $now = now();

        DB::table('expense_categories')->insert(
            $names->values()->map(fn (string $name) => [
                'name' => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ])->all()
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};
