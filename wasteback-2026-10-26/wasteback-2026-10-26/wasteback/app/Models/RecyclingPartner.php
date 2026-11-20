<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecyclingPartner extends Model
{
    protected $fillable = ['name', 'location', 'contact_phone', 'accepts'];

    public function dispatches(): HasMany
    {
        return $this->hasMany(BulkDispatch::class);
    }
}
