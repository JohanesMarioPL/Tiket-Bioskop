<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'genre', 'duration_minutes', 'rating_age', 'poster_url'];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        return $query;
    }

    public function scopeFilterGenre(Builder $query, ?string $genre): Builder
    {
        if ($genre) {
            $query->where('genre', $genre);
        }
        return $query;
    }

    public function scopeFilterRating(Builder $query, ?string $rating): Builder
    {
        if ($rating) {
            $query->where('rating_age', $rating);
        }
        return $query;
    }

    public function getPosterUrlAttribute($value)
    {
        if ($value && file_exists(public_path('storage/' . $value))) {
            return asset('storage/' . $value);
        }
        return 'https://placehold.co/300x400/222432/FFFFFF?text=' . urlencode($this->title);
    }
}