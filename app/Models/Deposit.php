<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'method',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
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
            'success' => 'success',
            'failed' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Helper Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSuccess()
    {
        return $this->status === 'success';
    }
}

