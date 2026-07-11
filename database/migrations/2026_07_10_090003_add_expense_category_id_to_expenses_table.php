<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replace the fixed expense_category string with a proper relation
     * to expense_categories, so categories can be managed from the
     * Expense Categories page instead of a hard-coded dropdown.
     */
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('expense_category_id')
                ->nullable()
                ->after('expense_date')
                ->constrained()
                ->restrictOnDelete();
        });

        // Backfill the new relation from the old string column by
        // matching category names (seeded in expense_categories in the
        // previous migration).
        DB::table('expenses')->orderBy('id')->each(function (object $expense): void {
            if (! $expense->expense_category) {
                return;
            }

            $categoryId = DB::table('expense_categories')
                ->where('name', $expense->expense_category)
                ->value('id');

            if ($categoryId) {
                DB::table('expenses')
                    ->where('id', $expense->id)
                    ->update(['expense_category_id' => $categoryId]);
            }
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('expense_category');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('expense_category')->nullable()->after('expense_date');
        });

        DB::table('expenses')->orderBy('id')->each(function (object $expense): void {
            if (! $expense->expense_category_id) {
                return;
            }

            $name = DB::table('expense_categories')
                ->where('id', $expense->expense_category_id)
                ->value('name');

            if ($name) {
                DB::table('expenses')
                    ->where('id', $expense->id)
                    ->update(['expense_category' => $name]);
            }
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('expense_category_id');
        });
    }
};
