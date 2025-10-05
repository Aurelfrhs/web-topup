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
        'price',
        'type',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
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
        return $query->where('status', 'active');
    }

    public function scopeAuto($query)
    {
        return $query->where('type', 'auto');
    }

    public function scopeManual($query)
    {
        return $query->where('type', 'manual');
    }

    // Accessors
    public function getPriceFormattedAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Helper Methods
    public function getActiveFlashSale()
    {
        return $this->flashSales()
            ->where('status', 'active')
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
}
