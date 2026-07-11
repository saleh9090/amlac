<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE contracts MODIFY payment_method VARCHAR(255) NOT NULL DEFAULT 'bank_transfer'");
        DB::statement("ALTER TABLE contracts MODIFY payment_frequency VARCHAR(255) NOT NULL DEFAULT 'monthly'");
        DB::statement("ALTER TABLE contracts MODIFY status VARCHAR(255) NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE contracts MODIFY payment_method VARCHAR(255) NOT NULL DEFAULT 'cash'");
        DB::statement("ALTER TABLE contracts MODIFY payment_frequency VARCHAR(255) NOT NULL DEFAULT 'monthly'");
        DB::statement("ALTER TABLE contracts MODIFY status VARCHAR(255) NOT NULL DEFAULT 'draft'");
    }
};
