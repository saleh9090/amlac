<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->cascadeOnDelete();
            $table->string('unit_number');
            $table->string('unit_type');
            $table->string('layout')->nullable();
            $table->string('floor')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->string('electricity_account')->nullable();
            $table->string('water_account')->nullable();
            $table->string('status')->default('vacant');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['building_id', 'unit_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
