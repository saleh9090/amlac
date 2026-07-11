<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Manageable list of income categories (e.g. Rent, Other Income),
     * so categories can be added/edited from the system instead of
     * being a fixed list of choices.
     */
    public function up(): void
    {
        Schema::create('income_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income_categories');
    }
};
