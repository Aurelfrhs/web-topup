<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'position',
        'is_active', // ← PENTING: Ganti 'status' menjadi 'is_active'
    ];

    // Cast is_active sebagai boolean
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeHome($query)
    {
        return $query->where('position', 'home');
    }

    public function scopeGames($query)
    {
        return $query->where('position', 'games');
    }

    public function scopeFlashSale($query)
    {
        return $query->where('position', 'flash-sale');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Accessor untuk status text (untuk kompatibilitas)
    public function getStatusAttribute()
    {
        return $this->is_active ? 'active' : 'inactive';
    }
}