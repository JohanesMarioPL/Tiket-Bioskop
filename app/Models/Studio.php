<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Studio extends Model
{
    protected $fillable = ['location_id', 'studio_name', 'studio_type', 'capacity'];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}