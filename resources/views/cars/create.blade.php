@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Tambah Mobil Baru</h2>

        <!-- Menampilkan alert error jika ada -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" name="brand" id="brand" class="form-control" required value="{{ old('brand') }}">
            </div>
        
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" name="model" id="model" class="form-control" required value="{{ old('model') }}">
            </div>
        
            <div class="form-group">
                <label for="license_plate">License Plate</label>
                <input type="text" name="license_plate" id="license_plate" class="form-control" required value="{{ old('license_plate') }}">
            </div>
        
            <div class="form-group">
                <label for="rental_price_per_day">Rental Price per Day</label>
                <input type="number" name="rental_price_per_day" id="rental_price_per_day" class="form-control" required min="10000" value="{{ old('rental_price_per_day') }}">
            </div>
        
            <!-- Input untuk gambar -->
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>
        
            <button type="submit" class="btn btn-primary">Add Car</button>
        </form>                
    </div>
@endsection
