<!-- resources/views/cars/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Detail Mobil</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $car->brand }} - {{ $car->model }}</h5>
                <p class="card-text"><strong>No Plat:</strong> {{ $car->license_plate }}</p>
                <p class="card-text"><strong>Harga Sewa (Per Hari):</strong> Rp {{ number_format($car->rental_price_per_day, 0, ',', '.') }}</p>
                {{-- Logika Tombol --}}
                @if ($car->is_available)
                {{-- Cek apakah pengguna sudah pernah menyewa mobil ini --}}
                @php
                    $userRental = $car->rentals->where('user_id', auth()->id())->last();
                @endphp

                @if (!$userRental)
                    {{-- Belum pernah menyewa, tampilkan tombol "Sewa" --}}
                    <p class="text-success">Status: Tersedia</p>
                    <a href="{{ route('rentals.create', $car->id) }}" class="btn btn-success btn-sm">Sewa</a>
                @else
                    {{-- Jika mobil sudah dikembalikan (return_date ada), tampilkan tombol "Perbarui Status" --}}
                    <p class="text-warning">Status: Selesai sewa</p>
                    <a href="{{ route('rentals.edit', $userRental->id) }}" class="btn btn-warning btn-sm">Perbarui Status</a>
                @endif
                @else
                    {{-- Jika mobil sedang disewa --}}
                    <p class="text-danger">Status: Sedang Disewa</p>
                @endif
            </div>
        </div>
    </div>
@endsection
