<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    public const CATEGORIES = [
        'plastic' => 'Plastics',
        'metal' => 'Metals',
        'paper' => 'Paper and Cardboard',
        'glass' => 'Glass',
        'ewaste' => 'Electronic Scrap',
    ];

    protected $fillable = [
        'name', 'slug', 'category', 'description', 'image',
        'price_per_kg', 'bulk_threshold_kg', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_per_kg' => 'decimal:2',
            'bulk_threshold_kg' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pickupItems(): HasMany
    {
        return $this->hasMany(PickupItem::class);
    }

    public function dispatches(): HasMany
    {
        return $this->hasMany(BulkDispatch::class);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    /** Verified kilograms collected from households and not yet sent to a recycling plant. */
    public function stockKg(): float
    {
        $collected = (float) $this->pickupItems()
            ->whereHas('pickup', fn ($q) => $q->where('status', 'collected'))
            ->sum('verified_kg');

        return max(0, round($collected - (float) $this->dispatches()->sum('quantity_kg'), 2));
    }

    public function thresholdPercent(): int
    {
        $threshold = (float) $this->bulk_threshold_kg;

        return $threshold > 0 ? (int) min(100, round($this->stockKg() / $threshold * 100)) : 0;
    }
}
