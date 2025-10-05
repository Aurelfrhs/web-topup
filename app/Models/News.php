<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'status',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/news/' . $this->image) : null;
    }

    public function getExcerptAttribute()
    {
        return substr(strip_tags($this->content), 0, 150) . '...';
    }
}