@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Daftar Sewa Mobil</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Mobil</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentals as $rental)
                <tr>
                    <td>{{ $rental->user->name }}</td> <!-- Nama pelanggan -->
                    <td>{{ $rental->car->brand }} - {{ $rental->car->model }}</td> <!-- Mobil -->
                    <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($rental->end_date)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($rental->total_cost, 0, ',', '.') }}</td>
                    
                    <td>
                        @if ($rental->car->is_available)
                            <span class="text-danger">Selesai</span> <!-- Mobil sudah tersedia kembali -->
                        @elseif (\Carbon\Carbon::now()->isBefore($rental->start_date))
                            <span class="text-warning">Menunggu Mulai</span> <!-- Belum dimulai -->
                        @elseif (\Carbon\Carbon::now()->isBetween($rental->start_date, $rental->end_date))
                            <span class="text-success">Sedang Berlangsung</span> <!-- Sedang berlangsung -->
                        @else
                            <span class="text-muted">Selesai (Tidak Ada Pengembalian)</span> <!-- Seharusnya tidak terjadi, tapi jika ada logika lain -->
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-info btn-sm">Detail</a>
                    
                        <!-- Tombol Return hanya muncul jika mobil belum dikembalikan (is_available = false) -->
                        @if (!$rental->car->is_available)
                            <a href="{{ route('returns.create', $rental->id) }}" class="btn btn-info btn-sm">Return</a>
                        @endif
                    
                        <!-- Tombol Perbarui Status hanya muncul jika mobil sudah dikembalikan (is_available = true) -->
                        @if ($rental->car->is_available && !$rental->return_date)
                            <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-warning btn-sm">Perbarui Status</a>
                        @endif
                    </td>                                       
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
