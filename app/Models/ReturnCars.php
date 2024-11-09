<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnCars extends Model
{
    use HasFactory;

    // Menetapkan nama tabel yang digunakan
    protected $table = 'returns'; // Sesuaikan dengan nama tabel yang benar

    protected $fillable = [
        'rental_id', 'return_date', 'late_days', 'penalty'
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
