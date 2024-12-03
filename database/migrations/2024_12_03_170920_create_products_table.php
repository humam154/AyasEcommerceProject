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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->nullable(false);
            $table->unsignedInteger('quantity')->default(0);
            $table->string('description')->nullable(false);
            $table->date('exp_date');
            $table->decimal('offer_value', 8, 2);
            $table->date('offer_exp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
