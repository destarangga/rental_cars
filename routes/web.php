<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReturnController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman login dan register
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('masuk');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('daftar');

// Halaman dashboard yang hanya bisa diakses setelah login
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Middleware untuk autentikasi
Route::middleware('auth')->group(function() {

    // Route untuk Cars (mobil)
    Route::get('cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('cars/store', [CarController::class, 'store'])->name('cars.store');
    Route::get('cars/show/{car}', [CarController::class, 'show'])->name('cars.show');
    Route::get('cars/edit/{car}', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('cars/update/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('cars/destroy/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    
    // Route untuk Rentals (sewa mobil)
    Route::get('rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('rentals/create/{car_id}', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('rentals/store', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('rentals/show/{rental}', [RentalController::class, 'show'])->name('rentals.show');
    Route::get('rentals/edit/{rental}', [RentalController::class, 'edit'])->name('rentals.edit');
    Route::put('rentals/update/{rental}', [RentalController::class, 'update'])->name('rentals.update');
    Route::delete('rentals/destroy/{rental}', [RentalController::class, 'destroy'])->name('rentals.destroy');
    
    // Route untuk Returns (pengembalian mobil)
    Route::get('returns/create', [ReturnController::class, 'create'])->name('returns.create');
    Route::post('returns/store', [ReturnController::class, 'store'])->name('returns.store');
    Route::get('returns/history', [ReturnController::class, 'showReturnHistory'])->name('returns.history');

    // Route untuk logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
