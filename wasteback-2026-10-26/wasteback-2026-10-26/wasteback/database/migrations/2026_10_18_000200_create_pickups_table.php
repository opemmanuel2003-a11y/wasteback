<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('zone');
            $table->string('address');
            $table->date('pickup_date');
            $table->enum('time_slot', ['morning', 'afternoon', 'evening']);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'assigned', 'collected', 'cancelled'])->default('pending');
            $table->decimal('estimated_total', 12, 2)->default(0);
            $table->decimal('verified_total', 12, 2)->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('collected_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pickup_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pickup_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->restrictOnDelete();
            $table->decimal('estimated_kg', 10, 2);
            $table->decimal('verified_kg', 10, 2)->nullable();
            $table->decimal('price_per_kg', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_items');
        Schema::dropIfExists('pickups');
    }
};
