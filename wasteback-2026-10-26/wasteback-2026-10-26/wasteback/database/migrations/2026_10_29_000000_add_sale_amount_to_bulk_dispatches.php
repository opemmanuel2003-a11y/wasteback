<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** What the recycling partner pays WasteBack for each bulk load. */
    public function up(): void
    {
        Schema::table('bulk_dispatches', function (Blueprint $table) {
            $table->decimal('price_per_kg', 12, 2)->default(0)->after('quantity_kg');
            $table->decimal('amount', 14, 2)->default(0)->after('price_per_kg');
        });
    }

    public function down(): void
    {
        Schema::table('bulk_dispatches', function (Blueprint $table) {
            $table->dropColumn(['price_per_kg', 'amount']);
        });
    }
};
