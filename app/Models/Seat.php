<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    protected $fillable = ['studio_id', 'seat_number'];

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }
}