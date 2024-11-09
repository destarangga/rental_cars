<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi pengguna
    public function register(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'sim_number' => 'required|unique:users,sim_number', // Validasi untuk sim_number yang unik
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,customer', // Validasi role
        ]);

        // Membuat pengguna baru
        User::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'sim_number' => $request->sim_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role, // Menyimpan role
        ]);

        // Mengarahkan pengguna ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login pengguna
    public function login(Request $request)
    {
        // Validasi data yang diterima dari form login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Mengecek kredensial pengguna
        if (Auth::attempt($request->only('email', 'password'))) {
            // Jika login berhasil, arahkan ke halaman utama
            return redirect()->route('dashboard');
        }

        // Jika login gagal, kembalikan dengan error
        return back()->withErrors(['email' => 'Kredensial tidak valid.']);
    }

    // Logout pengguna
    public function logout()
    {
        // Proses logout dan arahkan ke halaman login
        Auth::logout();
        return redirect()->route('login');
    }
}
