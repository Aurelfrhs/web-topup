<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'discount_percent',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'active')
            ->where('start_time', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_time', '<', now());
    }

    // Accessors
    public function getDiscountedPriceAttribute()
    {
        if ($this->product) {
            $discount = ($this->product->price * $this->discount_percent) / 100;
            return $this->product->price - $discount;
        }
        return 0;
    }

    public function getDiscountAmountAttribute()
    {
        if ($this->product) {
            return ($this->product->price * $this->discount_percent) / 100;
        }
        return 0;
    }

    // Helper Methods
    public function isActive()
    {
        return $this->status === 'active'
            && $this->start_time <= now()
            && $this->end_time >= now();
    }

    public function isExpired()
    {
        return $this->end_time < now();
    }

    public function isUpcoming()
    {
        return $this->start_time > now();
    }
}
