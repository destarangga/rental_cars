<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // Menampilkan daftar mobil
    public function index(Request $request)
    {
        $query = Car::query();

        // Filter berdasarkan ketersediaan
        if ($request->has('is_available') && $request->is_available !== '') {
            $query->where('is_available', $request->is_available);
        }

        // Ambil data mobil beserta rental terkait
        $cars = $query->with('rentals')->get();

        return view('cars.index', compact('cars'));
    }

    public function create(){
        return view('cars.create');
    }

    // Menyimpan mobil baru ke dalam database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20|unique:cars,license_plate',
            'rental_price_per_day' => 'required|numeric|min:10000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $directory = public_path('image/cars');

            // Buat direktori jika belum ada
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $image->move($directory, $fileName);
            $imagePath = 'image/cars/' . $fileName;
        }

        // Tambahkan mobil baru
        Car::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'license_plate' => $request->license_plate,
            'rental_price_per_day' => $request->rental_price_per_day,
            'image' => $imagePath, // Simpan path gambar
            'is_available' => true, // Default true
        ]);

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil ditambahkan!');
    }

    // Menampilkan detail mobil
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    // Menampilkan formulir untuk mengedit mobil
    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    // Memperbarui data mobil
    public function update(Request $request, Car $car)
    {
        // Validasi input
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20|unique:cars,license_plate,' . $car->id,
            'rental_price_per_day' => 'required|numeric|min:10000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $directory = public_path('image/cars');

            // Buat direktori jika belum ada
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Hapus gambar lama jika ada
            if ($car->image && file_exists(public_path($car->image))) {
                unlink(public_path($car->image));
            }

            $image->move($directory, $fileName);
            $car->image = 'image/cars/' . $fileName;
        }

        // Perbarui data mobil
        $car->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'license_plate' => $request->license_plate,
            'rental_price_per_day' => $request->rental_price_per_day,
            'is_available' => $request->has('is_available') ? $request->is_available : $car->is_available,
        ]);

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diperbarui!');
    }

    // Menghapus mobil
    public function destroy(Car $car)
    {
        // Hapus file gambar jika ada
        if ($car->image && file_exists(public_path($car->image))) {
            unlink(public_path($car->image));
        }
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil dihapus!');
    }
}
