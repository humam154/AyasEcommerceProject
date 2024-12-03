<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Village extends Model
{
    protected $guarded = [];

    public function cities(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function locations(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
