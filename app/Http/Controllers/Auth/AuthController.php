<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- Login ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login sebagai admin terlebih dahulu
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            // Arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard.index'));
        }

        // Jika gagal sebagai admin, coba login sebagai pengguna biasa
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            // Arahkan ke dashboard pengguna
            return redirect()->intended(route('dashboard.index'));
        }

        // Jika keduanya gagal, kembalikan error
        return back()->withErrors([
            'email' => 'Kredensial yang Anda berikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }

    // --- Register ---
    public function showRegistrationForm(string $ref = null)
    {
        $upline = null;
        if ($ref) {
            $upline = User::where('name', $ref)->first();
        }
        return view('auth.register', compact('upline'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'longname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'parent_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'longname' => $request->longname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'parent_id' => $request->parent_id,
            'rank_id' => 1, // Default rank
        ]);

        Auth::guard('web')->login($user);

        return redirect(route('dashboard.index'));
    }

    // --- Logout ---
    public function logout(Request $request)
    {
        // Logout dari guard yang sedang aktif
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login utama
        return redirect()->route('login');
    }
}
