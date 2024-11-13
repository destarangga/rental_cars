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
                {{-- Jika mobil tersedia dan tidak pernah disewa --}}
                @if ($car->rentals->isEmpty())
                    <a href="{{ route('rentals.create', $car->id) }}" class="btn btn-success btn-sm">Sewa</a>
                @else
                    @if ($car->rentals->isNotEmpty())
                    {{-- Ambil rental terakhir --}}
                    @php
                        $latestRental = $car->rentals->last();
                    @endphp
                
                    <a href="{{ route('rentals.edit', $latestRental->id) }}" class="btn btn-warning btn-sm">Perbarui Status</a>
                    @endif
            
                @endif
                @else
                    {{-- Jika mobil sedang disewa --}}
                    <p class="text-danger">Status: Sedang Disewa</p>
                @endif
            </div>
        </div>
    </div>
@endsection
