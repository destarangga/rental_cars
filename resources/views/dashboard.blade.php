@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card border-info mb-2 mt-4" style="max-width: 60rem;">
        <h2 class="card-header mt">Dashboard</h5>
        <div class="card-body">
            <h5 class="card-title">Selamat datang, {{ $user->name }}!</h5>
            <p class="card-text">Email: {{ $user->email }}</p>
            <p class="card-text">Role: {{ $user->role }}</p>

            @if ($user->role === 'admin')
                <p class="card-text">Kelola mobil dan tambahkan mobil baru untuk di sewakan!!!</p>
                <a href="" class="btn btn-info">Kelola Mobil</a>
            @else
                <p class="card-text">Segera pilih mobil yang ingin anda sewa!!!</p>
                <a href="" class="btn btn-secondary">Rental Mobil</a>
            @endif
        </div>
    </div>
    
</div>
@endsection
