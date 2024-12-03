<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertType extends Model
{
    protected $guarded = [];

    public function adverts(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }
}
