<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'brand', 'year', 'daily_price', 'location_id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
