<?php

// app/Models/Rental.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'car_id', 'start_date', 'end_date', 'total_cost', 'status',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returnCars()
    {
        return $this->hasOne(ReturnCars::class);
    }

    // Model Rental
    // Di dalam model Rental
    public static function isCarAvailable($carId, $startDate, $endDate, $excludeRentalId = null)
    {
        // Cek apakah mobil sudah disewa pada rentang tanggal yang diminta
        return self::where('car_id', $carId)
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                    });
            })
            ->where('id', '<>', $excludeRentalId) // Mengecualikan rental yang sedang diupdate
            ->exists(); // Jika ada yang cocok, berarti mobil tidak tersedia
    }


}

