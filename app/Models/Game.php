<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'category',
        'status',
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/games/' . $this->image) : null;
    }
}