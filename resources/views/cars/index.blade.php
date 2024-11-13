@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">Daftar Mobil Tersedia</h2>

        <!-- Form Pencarian yang diatur di tengah -->
        <form method="GET" action="{{ route('cars.index') }}" class="mb-3 mt-4 d-flex justify-content-center">
            <div class="row w-75">
                <div class="col-md-6 col-12">
                    <input type="text" name="search" class="form-control" placeholder="Cari Brand, Model..." value="{{ request()->search }}">
                </div>
                <div class="col-md-3 col-12">
                    <select name="is_available" class="form-control">
                        <option value="">Status Ketersediaan</option>
                        <option value="1" {{ request()->is_available == '1' ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ request()->is_available == '0' ? 'selected' : '' }}>Sedang Disewa</option>
                    </select>
                </div>
                <div class="col-md-3 col-12">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </div>
        </form>

        <!-- Tombol Tambah Mobil hanya untuk admin -->
        @if (auth()->user() && auth()->user()->role === 'admin')
            <a href="{{ route('cars.create') }}" class="btn btn-primary mb-3">Tambah Mobil</a>
        @endif

        <div class="row">
            @foreach ($cars as $car)
                <div class="col-md-4">
                    <div class="card mb-4">
                        @if ($car->image)
                            <img src="{{ asset($car->image) }}" class="custom-img-size" alt="Gambar Mobil">
                        @else
                            <img src="{{ asset('image/cars/default.jpg') }}" class="custom-img-size" alt="Default Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->brand }} - {{ $car->model }}</h5>
                            <p class="card-text">No Plat: {{ $car->license_plate }}</p>
                            <p class="card-text">Harga: Rp {{ number_format($car->rental_price_per_day, 0, ',', '.') }}</p>

                            {{-- Logika Tombol --}}
                            @if ($car->is_available)
                                {{-- Jika mobil tersedia dan tidak pernah disewa --}}
                                @if ($car->rentals->isEmpty())
                                    <p class="text-success">Status: Tersedia</p>
                                    <a href="{{ route('rentals.create', $car->id) }}" class="btn btn-success btn-sm">Sewa</a>
                                @else
                                    @if ($car->rentals->isNotEmpty())
                                    {{-- Ambil rental terakhir --}}
                                    @php
                                        $latestRental = $car->rentals->last();
                                    @endphp
                                    <p class="text-warning">Status: Selesai sewa</p>
                                    <a href="{{ route('rentals.edit', $latestRental->id) }}" class="btn btn-warning btn-sm">Perbarui Status</a>
                                    @endif
                            
                                @endif
                            @else
                                {{-- Jika mobil sedang disewa --}}
                                <p class="text-danger">Status: Sedang Disewa</p>
                            @endif

                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
