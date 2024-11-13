<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Car;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    // Menampilkan daftar sewa
    public function index()
    {
        // Mengecek peran pengguna yang sedang login
        if (auth()->user()->role === 'admin') {
            // Jika admin, tampilkan semua data rental
            $rentals = Rental::with('user', 'car')->get();
        } else {
            // Jika customer, tampilkan hanya data rental milik customer yang sedang login
            $rentals = Rental::with('user', 'car')
                            ->where('user_id', auth()->id()) // Menambahkan filter berdasarkan user yang sedang login
                            ->get();
        }

        return view('rentals.index', compact('rentals'));
    }


    // Menampilkan formulir untuk menambahkan sewa baru
    public function create($car_id)
    {
        $car = Car::findOrFail($car_id); // Temukan mobil berdasarkan ID
        return view('rentals.create', compact('car')); // Teruskan mobil ke tampilan
    }

    // Menyimpan data sewa baru
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if (Rental::isCarAvailable($request->car_id, $request->start_date, $request->end_date)) {
            return redirect()->back()->with('error', 'Mobil ini sudah disewa pada tanggal tersebut.');
        }

        $car = Car::findOrFail($request->car_id);

        $durationInDays = now()->parse($request->start_date)->diffInDays(now()->parse($request->end_date)); // Termasuk hari pertama
        $totalCost = $durationInDays * $car->rental_price_per_day;

        // Simpan rental
        Rental::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
        ]);

        // Update status ketersediaan mobil menjadi tidak tersedia
        $car->update(['is_available' => false]);

        return redirect()->route('rentals.index')->with('success', 'Sewa berhasil ditambahkan!');
    }




    // Menampilkan detail sewa
    public function show($id)
    {
        // Ambil data rental beserta data pengembalian mobil
        $rental = Rental::with('returnCars')->findOrFail($id);

        return view('rentals.show', compact('rental'));
    }


    // Menampilkan formulir untuk mengedit sewa
    public function edit($id)
    {
        // Ambil data rental berdasarkan ID
        $rental = Rental::findOrFail($id);
        
        // Ambil data mobil yang terkait dengan rental
        $car = $rental->car;

        // Kirimkan data rental dan car ke view
        return view('rentals.edit', compact('rental', 'car'));
    }


    // Memperbarui data sewa
    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // if (Rental::isCarAvailable($request->car_id, $request->start_date, $request->end_date, $rental->id)) {
        //     return redirect()->back()->with('error', 'Mobil ini sudah disewa pada tanggal tersebut.');
        // }

        $car = Car::findOrFail($request->car_id);

        $durationInDays = now()->parse($request->start_date)->diffInDays(now()->parse($request->end_date)); // Termasuk hari pertama
        $totalCost = $durationInDays * $car->rental_price_per_day;

        // Perbarui data rental
        $rental->update([
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
        ]);

        // Pastikan mobil yang sebelumnya disewa menjadi tersedia kembali
        $rental->car->update(['is_available' => true]);

        // Update ketersediaan mobil baru
        $newCar = Car::findOrFail($request->car_id);
        $newCar->update(['is_available' => false]);

        return redirect()->route('rentals.index')->with('success', 'Sewa berhasil diperbarui!');
    }


    // Menghapus data sewa
    public function destroy(Rental $rental)
    {
        $rental->delete();
        return redirect()->route('rentals.index')->with('success', 'Sewa berhasil dihapus!');
    }
}
