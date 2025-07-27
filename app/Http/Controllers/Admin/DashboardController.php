<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RankClaim;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan data untuk dashboard admin.
     */
    public function index()
    {
        // 1. Data untuk Kartu Statistik
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalPendingWithdrawalAmount = Withdrawal::where('status', 'pending')->sum('amount');
        $totalPendingRankClaims = RankClaim::where('status', 'pending')->count();

        // 2. Data untuk Tabel Pengguna Baru
        $recentUsers = User::with('parent')->latest()->take(5)->get();

        // 3. Data untuk Aktivitas Terbaru
        $latestPendingWithdrawals = Withdrawal::with('user')->where('status', 'pending')->latest()->take(3)->get();
        $latestPendingRankClaims = RankClaim::with(['user', 'claimedRank'])->where('status', 'pending')->latest()->take(3)->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalProducts',
            'totalPendingWithdrawalAmount',
            'totalPendingRankClaims',
            'recentUsers',
            'latestPendingWithdrawals',
            'latestPendingRankClaims'
        ));
    }
}
