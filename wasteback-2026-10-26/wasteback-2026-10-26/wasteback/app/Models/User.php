<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLES = ['household', 'agent', 'admin'];

    protected $fillable = [
        'name', 'email', 'phone', 'role', 'zone', 'address', 'password', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'wallet_balance' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pickups(): HasMany
    {
        return $this->hasMany(Pickup::class);
    }

    public function assignedPickups(): HasMany
    {
        return $this->hasMany(Pickup::class, 'agent_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    public function isHousehold(): bool
    {
        return $this->role === 'household';
    }

    public function homeRoute(): string
    {
        return match ($this->role) {
            'admin' => 'admin.dashboard',
            'agent' => 'agent.dashboard',
            default => 'household.dashboard',
        };
    }

    public function initials(): string
    {
        return collect(explode(' ', $this->name))
            ->filter()->take(2)
            ->map(fn ($part) => strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
    }
}
