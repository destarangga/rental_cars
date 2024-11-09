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
                <p class="card-text">Anda memiliki akses sebagai merchant. Anda dapat mengelola menu, order dan melihat invoice</p>
                <a href="" class="btn btn-info">Siapkan Menu</a>
            @else
                <p class="card-text">Anda adalah Customer. Silahkan untuk memesan minuman atau makanan yang di cari</p>
                <a href="" class="btn btn-secondary">Buat Orderan</a>
            @endif
        </div>
    </div>
    
</div>
@endsection
