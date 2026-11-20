<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PickupItem extends Model
{
    protected $fillable = ['pickup_id', 'material_id', 'estimated_kg', 'verified_kg', 'price_per_kg'];

    protected function casts(): array
    {
        return [
            'estimated_kg' => 'decimal:2',
            'verified_kg' => 'decimal:2',
            'price_per_kg' => 'decimal:2',
        ];
    }

    public function pickup(): BelongsTo
    {
        return $this->belongsTo(Pickup::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
