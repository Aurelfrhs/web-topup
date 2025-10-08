<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'original_price',
        'discounted_price',
        'discount_percentage',
        'stock',
        'sold',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'original_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('is_active', true)
            ->where('start_time', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_time', '<', now());
    }

    // Accessors
    public function getDiscountAmountAttribute()
    {
        return $this->original_price - $this->discounted_price;
    }

    public function getSavingsAttribute()
    {
        return $this->discount_amount;
    }

    // Helper Methods
    public function isActive()
    {
        return $this->is_active
            && $this->start_time <= now()
            && $this->end_time >= now();
    }

    public function isExpired()
    {
        return $this->end_time < now();
    }

    public function isUpcoming()
    {
        return $this->start_time > now() && $this->is_active;
    }

    public function getRemainingStockAttribute()
    {
        return max(0, $this->stock - $this->sold);
    }

    public function getStockPercentageAttribute()
    {
        if ($this->stock <= 0)
            return 0;
        return ($this->remaining_stock / $this->stock) * 100;
    }
}