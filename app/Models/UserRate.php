<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRate extends Model
{
    protected $guarded = [];

    public function rater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rater_id');
    }

    public function rated(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rated_id');
    }
}
