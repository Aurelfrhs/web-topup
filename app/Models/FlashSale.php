<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'original_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'discount_percentage' => 'integer',
        'stock' => 'integer',
        'sold' => 'integer',
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper Methods dengan timezone Asia/Jakarta
    public function isActive()
    {
        $now = Carbon::now('Asia/Jakarta');
        return $this->status === 'active' &&
            $this->start_time->setTimezone('Asia/Jakarta') <= $now &&
            $this->end_time->setTimezone('Asia/Jakarta') >= $now;
    }

    public function isUpcoming()
    {
        $now = Carbon::now('Asia/Jakarta');
        return $this->status === 'active' &&
            $this->start_time->setTimezone('Asia/Jakarta') > $now;
    }

    public function isExpired()
    {
        $now = Carbon::now('Asia/Jakarta');
        return $this->status === 'inactive' ||
            $this->end_time->setTimezone('Asia/Jakarta') < $now;
    }

    // Get status text
    public function getStatusText()
    {
        if ($this->isActive()) {
            return 'Aktif';
        } elseif ($this->isUpcoming()) {
            return 'Mendatang';
        } else {
            return 'Berakhir';
        }
    }

    // Get status badge color
    public function getStatusColor()
    {
        if ($this->isActive()) {
            return 'green';
        } elseif ($this->isUpcoming()) {
            return 'blue';
        } else {
            return 'gray';
        }
    }

    // Check if stock is available
    public function hasStock()
    {
        return $this->stock > $this->sold;
    }

    // Get remaining stock
    public function getRemainingStock()
    {
        return max(0, $this->stock - $this->sold);
    }

    // Get sold percentage
    public function getSoldPercentage()
    {
        if ($this->stock <= 0) {
            return 0;
        }
        return ($this->sold / $this->stock) * 100;
    }

    // Scope untuk flash sale aktif
    public function scopeActive($query)
    {
        $now = Carbon::now('Asia/Jakarta');
        return $query->where('status', 'active')
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now);
    }

    // Scope untuk flash sale mendatang
    public function scopeUpcoming($query)
    {
        $now = Carbon::now('Asia/Jakarta');
        return $query->where('status', 'active')
            ->where('start_time', '>', $now);
    }

    // Scope untuk flash sale berakhir
    public function scopeExpired($query)
    {
        $now = Carbon::now('Asia/Jakarta');
        return $query->where(function ($q) use ($now) {
            $q->where('status', 'inactive')
                ->orWhere('end_time', '<', $now);
        });
    }
}