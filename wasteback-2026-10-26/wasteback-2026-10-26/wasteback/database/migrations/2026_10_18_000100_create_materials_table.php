<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('category', ['plastic', 'metal', 'paper', 'glass', 'ewaste']);
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('bulk_threshold_kg', 10, 2)->default(500);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
