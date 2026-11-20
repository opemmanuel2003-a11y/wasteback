<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pickup extends Model
{
    public const SLOTS = [
        'morning' => '8:00 to 11:00',
        'afternoon' => '11:00 to 15:00',
        'evening' => '15:00 to 18:00',
    ];

    public const STATUSES = ['pending', 'assigned', 'collected', 'cancelled'];

    protected $fillable = [
        'reference', 'user_id', 'agent_id', 'zone', 'address', 'pickup_date', 'time_slot',
        'notes', 'status', 'estimated_total', 'verified_total', 'assigned_at', 'collected_at',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date' => 'date',
            'assigned_at' => 'datetime',
            'collected_at' => 'datetime',
            'estimated_total' => 'decimal:2',
            'verified_total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PickupItem::class);
    }

    public function slotLabel(): string
    {
        return ucfirst($this->time_slot).', '.(self::SLOTS[$this->time_slot] ?? '');
    }

    public function estimatedKg(): float
    {
        return (float) $this->items->sum('estimated_kg');
    }

    public function verifiedKg(): float
    {
        return (float) $this->items->sum('verified_kg');
    }
}
