<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'balance',
        'membership',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:2',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    // Accessors & Mutators
    public function getBalanceFormattedAttribute()
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }

    // Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasEnoughBalance($amount)
    {
        return $this->balance >= $amount;
    }
}
