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
                {{-- Tampilkan status ketersediaan --}}
                @if ($car->is_available)
                <p class="text-success">Status: Tersedia</p>
                <a href="{{ route('rentals.create', $car->id) }}" class="btn btn-success btn-sm">Sewa</a>
                @else
                    <p class="text-danger">Status: Sedang Disewa</p>
                @endif
            </div>
        </div>
    </div>
@endsection
