<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'name',
        'description',
        'price',
        'stock',
        'is_active', // ← PENTING: Ganti 'status' dan 'type' menjadi 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean', // ← Cast sebagai boolean
        'stock' => 'integer',
    ];

    // Relationships
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function flashSales()
    {
        return $this->hasMany(FlashSale::class);
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

    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('stock')
                ->orWhere('stock', '>', 0);
        });
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock', '<=', $threshold)
            ->whereNotNull('stock');
    }

    // Accessors
    public function getPriceFormattedAttribute()
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getStockStatusAttribute()
    {
        if (is_null($this->stock)) {
            return 'unlimited';
        }

        if ($this->stock <= 0) {
            return 'out_of_stock';
        }

        if ($this->stock < 10) {
            return 'low_stock';
        }

        return 'in_stock';
    }

    public function getIsAvailableAttribute()
    {
        return $this->is_active && ($this->stock === null || $this->stock > 0);
    }

    // Accessor untuk kompatibilitas (jika ada code lama yang masih pakai 'status')
    public function getStatusAttribute()
    {
        return $this->is_active ? 'active' : 'inactive';
    }

    // Helper Methods
    public function getActiveFlashSale()
    {
        return $this->flashSales()
            ->where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();
    }

    public function getFinalPrice()
    {
        $flashSale = $this->getActiveFlashSale();

        if ($flashSale) {
            $discount = ($this->price * $flashSale->discount_percent) / 100;
            return $this->price - $discount;
        }

        return $this->price;
    }

    public function decreaseStock($amount = 1)
    {
        if ($this->stock !== null) {
            $this->decrement('stock', $amount);
        }
    }

    public function increaseStock($amount = 1)
    {
        if ($this->stock !== null) {
            $this->increment('stock', $amount);
        }
    }
}