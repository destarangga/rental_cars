@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-5">Riwayat Pengembalian Mobil</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mobil</th>
                <th>Tanggal Pengembalian</th>
                <th>Hari Terlambat</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($returns as $return)
                <tr>
                    <td>{{ $return->rental->car->brand }} - {{ $return->rental->car->model }}</td>
                    <td>{{ $return->return_date->format('d-m-Y') }}</td>
                    <td>{{ $return->late_days }}</td>
                    <td>Rp {{ number_format($return->penalty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
