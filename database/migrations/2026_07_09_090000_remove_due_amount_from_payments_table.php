<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Due amount duplicated the unit's contract rent amount and isn't
     * needed as its own stored value. The rent amount (from the unit's
     * contract) is used directly wherever "due" was shown.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('due_amount');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('due_amount', 12, 2)->default(0)->after('unit_id');
        });
    }
};
