<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Tampilkan form login ──────────────────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    // ── Proses login ──────────────────────────────────────────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.alat.index');
            }

            return redirect()->route('user.peminjaman.index');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    // ── Tampilkan form register ───────────────────────────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    // ── Proses register + auto-create peminjam ────────────────────
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:150',
            'nim_nip'  => 'required|string|max:50|unique:peminjams,nim_nip',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // 1. Buat akun user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        // 2. Otomatis buat data peminjam yang terhubung via email (kontak)
        Peminjam::create([
            'nama'    => $validated['name'],
            'nim_nip' => $validated['nim_nip'],
            'kontak'  => $validated['email'],
        ]);

        Auth::login($user);

        return redirect()->route('user.peminjaman.index')
                         ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!');
    }

    // ── Logout ────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}