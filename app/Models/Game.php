<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'category',
        'publisher',
        'description',
        'is_active', // ← PENTING: Ganti 'status' menjadi 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean', // ← Cast sebagai boolean
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function flashSales()
    {
        return $this->hasManyThrough(FlashSale::class, Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePopular($query)
    {
        return $query->withCount('products')
            ->orderBy('products_count', 'desc');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getCategoryLabelAttribute()
    {
        $categories = [
            'moba' => 'MOBA',
            'battle-royale' => 'Battle Royale',
            'mmorpg' => 'MMORPG',
            'fps' => 'FPS',
            'sports' => 'Sports',
            'others' => 'Lainnya'
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    // Accessor untuk kompatibilitas (jika ada code lama yang masih pakai 'status')
    public function getStatusAttribute()
    {
        return $this->is_active ? 'active' : 'inactive';
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        // Auto-generate slug jika belum ada
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // Helper Methods
    public function getActiveProductsCount()
    {
        return $this->products()->where('is_active', true)->count();
    }

    public function getTotalRevenue()
    {
        return $this->products()
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->where('orders.status', 'completed')
            ->sum('orders.total_price');
    }

    public function hasProducts()
    {
        return $this->products()->count() > 0;
    }

    // Boot method untuk auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->name);
            }
        });

        static::updating(function ($game) {
            if ($game->isDirty('name') && empty($game->slug)) {
                $game->slug = Str::slug($game->name);
            }
        });
    }
}