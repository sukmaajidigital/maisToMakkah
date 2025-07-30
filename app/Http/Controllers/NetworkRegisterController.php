<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class NetworkRegisterController extends Controller
{
    /**
     * Menampilkan halaman registrasi dan daftar member yang sudah didaftarkan.
     */
    public function index()
    {
        $downlines = User::where('parent_id', Auth::id())
            ->latest()
            ->get();

        return view('network.register.index', compact('downlines'));
    }

    /**
     * Menyimpan data member baru (downline).
     */
    public function store(Request $request)
    {
        $upline = Auth::user();
        $maxDownlines = 5;

        // --- VALIDASI BARU ---
        // Cek jumlah downline yang sudah dimiliki oleh upline
        if ($upline->children()->count() >= $maxDownlines) {
            return back()
                ->withInput() // Mengembalikan input sebelumnya
                ->with('error', "Pendaftaran gagal. Anda sudah mencapai batas maksimal {$maxDownlines} downline langsung.");
        }

        // Validasi input (tetap sama)
        $request->validate([
            'longname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'bank_account_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        User::create([
            'name' => $request->name,
            'longname' => $request->longname,
            'email' => $request->email,
            'phone' => $request->phone,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
            'password' => Hash::make($request->password),
            'parent_id' => $upline->id,
            'rank_id' => null,
        ]);

        return redirect()->route('network.register.index')->with('success', 'Member baru berhasil didaftarkan!');
    }

    /**
     * Menampilkan form untuk mengedit data member.
     */
    public function edit(User $user)
    {
        if ($user->parent_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit member ini.');
        }
        $downlines = User::where('parent_id', Auth::id())->latest()->get();
        return view('network.register.index', [
            'user_to_edit' => $user,
            'downlines' => $downlines,
        ]);
    }

    /**
     * Memperbarui data member di database.
     */
    public function update(Request $request, User $user)
    {
        if ($user->parent_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate member ini.');
        }
        $request->validate([
            'longname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:15'],
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $user->id],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'bank_account_name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $updateData = $request->only('name', 'longname', 'email', 'phone', 'bank_name', 'bank_account_number', 'bank_account_name');

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('network.register.index')->with('success', 'Data member berhasil diperbarui!');
    }

    /**
     * Menghapus data member.
     */
    public function destroy(User $user)
    {
        if ($user->parent_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus member ini.');
        }
        $user->delete();
        return redirect()->route('network.register.index')->with('success', 'Member berhasil dihapus.');
    }
}
