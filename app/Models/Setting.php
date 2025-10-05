<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];

    // Static helper method
    public static function get($name, $default = null)
    {
        $setting = static::where('name', $name)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($name, $value)
    {
        return static::updateOrCreate(
            ['name' => $name],
            ['value' => $value]
        );
    }

    // Helper Methods
    public function getValueAsBoolean()
    {
        return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
    }

    public function getValueAsInteger()
    {
        return (int) $this->value;
    }

    public function getValueAsArray()
    {
        return json_decode($this->value, true) ?? [];
    }
}