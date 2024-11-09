<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand', 'model', 'license_plate', 'rental_price_per_day', 'is_available', 'image',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function returnCars()
    {
        return $this->hasOne(ReturnCars::class);
    }
}


