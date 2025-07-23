<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data dinamis.
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('rank', 'children', 'bonusHistories');

        $totalBonus = 'Rp ' . number_format($user->bonus_balance, 0, ',', '.');
        $currentRank = $user->rank->name ?? 'Belum ada Peringkat';
        $directDownlines = $user->children->count(); // first downline
        $totalNetwork = $user->downline_count;

        // 4. Buat link referral unik berdasarkan username
        $referralLink = route('register', ['ref' => $user->name]);

        // 5. Ambil 5 riwayat bonus terbaru
        $recentBonuses = $user->bonusHistories()->latest()->take(5)->get();

        // 6. Kirim semua data ke view
        return view('dashboard.index', compact(
            'totalBonus',
            'currentRank',
            'directDownlines',
            'totalNetwork',
            'referralLink',
            'recentBonuses'
        ));
    }
}
