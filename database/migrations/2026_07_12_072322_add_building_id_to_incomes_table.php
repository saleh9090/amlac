<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->foreignId('building_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->restrictOnDelete();
        });

        // Backfill existing rows to AlGobrah — the only building that
        // existed before this column was added.
        $algobrahId = DB::table('buildings')->where('name', 'AlGobrah')->value('id');

        if ($algobrahId) {
            DB::table('incomes')->whereNull('building_id')->update(['building_id' => $algobrahId]);
        }

        Schema::table('incomes', function (Blueprint $table) {
            $table->foreignId('building_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('building_id');
        });
    }
};
