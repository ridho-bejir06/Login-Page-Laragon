<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // 2. Upaya Login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Regenerate session untuk keamanan dari session fixation
            $request->session()->regenerate();
            
            return redirect()->route('dashboard');
        }

        // 3. Jika Gagal
        return back()->withErrors(['email' => 'Email atau password salah!'])->withInput();
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        // 1. Validasi Input Register
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        // 2. Simpan User ke Database
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // 3. Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Dashboard (Halaman setelah login)
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        return view('auth.dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Menghapus session lama dan membuat token baru (Praktik Keamanan Laravel)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function updateAvatar(Request $request)
    {
    // Validasi file harus berupa gambar dan maksimal 2MB
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Mengambil user yang sedang login melalui model User agar VS Code tidak bingung
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Jika user sudah punya foto lama, hapus foto tersebut dari penyimpanan
    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        Storage::disk('public')->delete($user->avatar);
    }

    // Simpan file baru ke folder storage/app/public/avatars
    $path = $request->file('avatar')->store('avatars', 'public');

    // Simpan path file ke database
    $user->avatar = $path;
    $user->save(); // Garis merah di sini dijamin akan hilang

    return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}

