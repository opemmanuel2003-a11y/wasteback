<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recycling_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('contact_phone', 20)->nullable();
            $table->string('accepts');
            $table->timestamps();
        });

        Schema::create('bulk_dispatches', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('material_id')->constrained()->restrictOnDelete();
            $table->foreignId('recycling_partner_id')->constrained()->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->decimal('quantity_kg', 10, 2);
            $table->string('truck_plate', 20)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('subject');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('bulk_dispatches');
        Schema::dropIfExists('recycling_partners');
    }
};
