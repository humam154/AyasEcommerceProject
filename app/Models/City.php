<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $guarded = [];

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
