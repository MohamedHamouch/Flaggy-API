<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'capital',
        'population',
        'currency',
        'region',
        'flag',
    ];

    //casting for proper data types
    protected $casts = [
        'population' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    //attribute for full flag URL
    public function getFlagUrlAttribute()
    {
        if ($this->flag) {
            return asset('storage/' . $this->flag);
        }
        return null;
    }
}
