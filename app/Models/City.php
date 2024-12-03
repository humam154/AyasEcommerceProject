<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class City extends Model
{
    protected $guarded = [];

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }

    public function locations(): HasOne
    {
        return $this->hasOne(Location::class);
    }
}
