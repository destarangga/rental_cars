@extends('layouts.app')

@section('content')
<div class="container">
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

    <!-- Menampilkan error atau pesan success jika ada -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="mt-5">Pengembalian Mobil</h2>

    <!-- Formulir pengembalian mobil -->
    <form action="{{ route('returns.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="license_plate">Nomor Plat Mobil</label>
            <input type="text" class="form-control" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Kembalikan Mobil</button>
    </form>
</div>
@endsection
