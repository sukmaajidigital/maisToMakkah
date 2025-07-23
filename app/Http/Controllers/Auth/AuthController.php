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

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
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
            'parent_id' => ['nullable', 'integer', 'exists:users,id'], // Validasi parent_id
        ]);

        $user = User::create([
            'name' => $request->name,
            'longname' => $request->longname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'parent_id' => $request->parent_id, // Simpan ID upline
            'rank_id' => 1, // Default rank, misalnya ID 1 untuk 'Member'
        ]);

        // Berikan bonus referral kepada upline jika ada
        if ($request->filled('parent_id')) {
            $upline = User::find($request->parent_id);
            if ($upline) {
                // MASIH DIPROSES VALIDASI FUNGSI
                // Logika pemberian bonus bisa ditambahkan di sini.
                // Contoh:
                // $upline->bonus_balance += 50000; // Tambah saldo bonus
                // $upline->save();
                // BonusHistory::create([...]); // Catat riwayat bonus
            }
        }


        Auth::guard('web')->login($user);

        return redirect(route('dashboard.index'));
    }

    // --- Logout ---
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login');
        } else {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }
}
