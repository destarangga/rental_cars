<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Car;
use App\Models\ReturnCars;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReturnController extends Controller
{
    // Menampilkan formulir pengembalian
    public function create()
    {
        return view('returns.create');
    }

    // Proses penyimpanan data pengembalian mobil
        public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'license_plate' => 'required|string|max:20',
        ]);

        // Cari mobil berdasarkan nomor plat
        $car = Car::where('license_plate', $request->license_plate)->first();

        // Jika mobil tidak ditemukan
        if (!$car) {
            return redirect()->back()->with('error', 'Mobil tidak ditemukan.');
        }

        // Verifikasi bahwa mobil ini disewa oleh pengguna yang saat ini login
        // Cek apakah mobil sudah dikembalikan
        $rental = Rental::where('car_id', $car->id)
                        ->where('user_id', auth()->id())
                        ->first();

        // Jika rental tidak ditemukan
        if (!$rental) {
            return redirect()->back()->with('error', 'Mobil ini tidak disewa oleh Anda.');
        }

        // // Cek apakah mobil sudah pernah dikembalikan
        // $return = ReturnCars::where('rental_id', $rental->id)->first();

        // if ($return) {
        //     return redirect()->back()->with('error', 'Mobil ini sudah dikembalikan.');
        // }

        // Hitung jumlah hari penyewaan
        $startDate = Carbon::parse($rental->start_date);
        $endDate = Carbon::now(); // Tanggal pengembalian adalah tanggal sekarang
        $duration = $startDate->diffInDays($endDate); // Menghitung selisih hari

        // Jika pengembalian terlambat, hitung denda
        $lateDays = 0;
        $penalty = 0;
        if ($endDate->gt(Carbon::parse($rental->end_date))) {
            $lateDays = $endDate->diffInDays(Carbon::parse($rental->end_date), false); // hitung keterlambatan
            $penalty = $lateDays * 10000; // Contoh denda Rp 10,000 per hari keterlambatan
        }

        // Simpan data pengembalian
        $return = ReturnCars::create([  // Tabel return_cars
            'rental_id' => $rental->id,
            'return_date' => $endDate,
            'late_days' => $lateDays,
            'penalty' => $penalty,
        ]);

        // Update status mobil menjadi tersedia
        $rental->car->update(['is_available' => true]);

        // Update status rental menjadi selesai di tabel rentals
        $rental->update(['return_date' => $endDate]);

        return redirect()->route('rentals.index')->with('success', 'Mobil berhasil dikembalikan.');
    }


    // Menampilkan riwayat pengembalian mobil oleh pengguna
    public function showReturnHistory()
    {
        // Ambil riwayat pengembalian mobil oleh pengguna yang sedang login
        $returns = ReturnCars::with('rental.car')
                            ->whereHas('rental', function ($query) {
                                $query->where('user_id', auth()->id());
                            })
                            ->get();

        return view('returns.history', compact('returns'));
    }
}
