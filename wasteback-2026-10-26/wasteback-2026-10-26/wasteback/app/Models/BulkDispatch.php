<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulkDispatch extends Model
{
    protected $fillable = [
        'reference', 'material_id', 'recycling_partner_id', 'created_by',
        'quantity_kg', 'price_per_kg', 'amount', 'truck_plate', 'notes',
    ];

    protected function casts(): array
    {
        return ['quantity_kg' => 'decimal:2', 'price_per_kg' => 'decimal:2', 'amount' => 'decimal:2'];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(RecyclingPartner::class, 'recycling_partner_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
