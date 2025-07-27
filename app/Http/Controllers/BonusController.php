<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class BonusController extends Controller
{
    /**
     * Menampilkan halaman riwayat bonus.
     */
    public function history()
    {
        $user = Auth::user();
        $bonusHistory = $user->bonusHistories()->with('sourceUser')->latest()->paginate(15);

        return view('bonus.history', compact('bonusHistory'));
    }

    /**
     * Menampilkan halaman untuk mengajukan penarikan.
     */
    public function withdraw()
    {
        $user = Auth::user();
        $withdrawalHistory = $user->withdrawals()->latest()->paginate(10);

        return view('bonus.withdraw', [
            'user' => $user,
            'withdrawalHistory' => $withdrawalHistory,
        ]);
    }

    /**
     * Menyimpan permintaan penarikan baru.
     */
    public function storeWithdrawal(Request $request)
    {
        $user = Auth::user();
        $minWithdrawal = 50000; // Atur minimum penarikan

        // Validasi input
        $request->validate([
            'amount' => ['required', 'numeric', "min:{$minWithdrawal}", "max:{$user->bonus_balance}"],
            'password' => ['required', 'string'],
        ]);

        // Validasi password
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password konfirmasi yang Anda masukkan salah.',
            ]);
        }

        // Buat permintaan penarikan baru
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending', // Status awal
        ]);

        return redirect()->route('bonus.withdraw')->with('success', 'Permintaan penarikan berhasil diajukan dan sedang menunggu persetujuan admin.');
    }
}
