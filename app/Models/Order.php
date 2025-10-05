<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'game_user_id',
        'server_id',
        'payment_method',
        'amount',
        'status',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    // Accessors
    public function getAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'success' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Helper Methods
    public function canBeRefunded()
    {
        return in_array($this->status, ['failed', 'pending']);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSuccess()
    {
        return $this->status === 'success';
    }
}
