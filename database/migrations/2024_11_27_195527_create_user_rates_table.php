<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rater_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('rated')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('value', 8, 2)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rates');
    }
};
