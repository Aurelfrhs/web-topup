<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'link',
        'position',
        'status',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeHome($query)
    {
        return $query->where('position', 'home');
    }

    public function scopePromo($query)
    {
        return $query->where('position', 'promo');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/banners/' . $this->image) : null;
    }
}
