@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-5">Detail Sewa Mobil</h2>

    <table class="table table-bordered">
        <tr>
            <th>Pelanggan</th>
            <td>{{ $rental->user->name }}</td>
        </tr>
        <tr>
            <th>Mobil</th>
            <td>{{ $rental->car->brand }} - {{ $rental->car->model }}</td>
        </tr>
        <tr>
            <th>Tanggal Mulai</th>
            <td>{{ $rental->start_date }}</td>
        </tr>
        <tr>
            <th>Tanggal Selesai</th>
            <td>{{ $rental->end_date }}</td>
        </tr>
        <tr>
            <th>Tanggal Pengembalian</th>
            <td>{{ $rental->returnCars ? $rental->returnCars->return_date : 'Belum Dikembalikan' }}</td>
        </tr>
        <tr>
            <th>Total Biaya</th>
            <td>Rp {{ number_format($rental->total_cost, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if ($rental->car->is_available)
                    <span class="text-success">Mobil Tersedia</span>
                @else
                    <span class="text-danger">Mobil Tidak Tersedia</span>
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('rentals.index') }}" class="btn btn-primary">Kembali ke Daftar Sewa</a>
</div>
@endsection
