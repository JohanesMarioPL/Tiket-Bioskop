<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = ['name', 'city', 'address'];

    public function studios(): HasMany
    {
        return $this->hasMany(Studio::class);
    }
}