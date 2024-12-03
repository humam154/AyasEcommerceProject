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
        Schema::create('advert_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advert_id')->constrained('adverts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->nullable(false);
            $table->string('description')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advert_types');
    }
};
