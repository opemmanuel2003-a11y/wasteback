<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    public const CHANNELS = [
        'mtn' => 'MTN Mobile Money',
        'airtel' => 'Airtel Money',
    ];

    protected $fillable = [
        'reference', 'user_id', 'pickup_id', 'type', 'amount', 'balance_after',
        'channel', 'phone', 'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'balance_after' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pickup(): BelongsTo
    {
        return $this->belongsTo(Pickup::class);
    }
}
