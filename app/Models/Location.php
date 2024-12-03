<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model
{
    protected $guarded = [];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function village(): HasOne
    {
        return $this->hasOne(Village::class);
    }

    public function userLocations(): HasMany
    {
        return $this->hasMany(UserLocation::class);
    }
}
