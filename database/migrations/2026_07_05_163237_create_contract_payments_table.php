<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->date('due_date');
            $table->unsignedTinyInteger('payment_for_month');
            $table->unsignedSmallInteger('payment_for_year');
            $table->decimal('amount_due', 12, 2);
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->date('paid_date')->nullable();
            $table->string('status')->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['contract_id', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_payments');
    }
};
