<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Monthly rent payments, recorded directly against a unit.
     *
     * Tenant name and rent amount are not duplicated here — they are
     * read live from the unit's current contract when displaying the
     * Rent Payments sheet.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('payment_for_month');
            $table->unsignedSmallInteger('payment_for_year');
            $table->decimal('due_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->string('status')->default('unpaid');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unique(['unit_id', 'payment_for_year', 'payment_for_month'], 'payments_unit_month_year_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
