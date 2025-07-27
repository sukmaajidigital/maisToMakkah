<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RankClaim;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    /**
     * Menampilkan halaman dashboard persetujuan.
     */
    public function index()
    {
        // Menghitung jumlah permintaan yang pending untuk ditampilkan di dashboard
        $pendingWithdrawalsCount = Withdrawal::where('status', 'pending')->count();
        $pendingRankClaimsCount = RankClaim::where('status', 'pending')->count();

        return view('admin.approvals.index', compact('pendingWithdrawalsCount', 'pendingRankClaimsCount'));
    }

    /**
     * Menampilkan daftar permintaan penarikan dana yang pending.
     */
    public function withdrawals()
    {
        $pendingWithdrawals = Withdrawal::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.approvals.withdrawals', compact('pendingWithdrawals'));
    }

    /**
     * Menampilkan daftar klaim peringkat yang pending.
     */
    public function rankClaims()
    {
        $pendingRankClaims = RankClaim::with(['user.rank', 'claimedRank'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.approvals.rank-claims', compact('pendingRankClaims'));
    }

    /**
     * Menyetujui permintaan penarikan dana.
     */
    public function approveWithdrawal(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $user = $withdrawal->user;

        if ($user->bonus_balance < $withdrawal->amount) {
            $withdrawal->update([
                'status' => 'rejected',
                'processed_at' => now(),
                'admin_notes' => 'Ditolak otomatis: saldo tidak mencukupi.',
            ]);
            return back()->with('error', 'Penarikan ditolak. Saldo pengguna tidak mencukupi.');
        }

        DB::transaction(function () use ($withdrawal, $user) {
            $user->decrement('bonus_balance', $withdrawal->amount);
            $withdrawal->update([
                'status' => 'approved',
                'processed_at' => now(),
                'admin_notes' => 'Disetujui oleh admin.',
            ]);
        });

        return back()->with('success', 'Permintaan penarikan berhasil disetujui.');
    }

    /**
     * Menolak permintaan penarikan dana.
     */
    public function rejectWithdrawal(Request $request, Withdrawal $withdrawal)
    {
        $request->validate(['admin_notes' => 'required|string|max:255']);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $withdrawal->update([
            'status' => 'rejected',
            'processed_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Permintaan penarikan telah ditolak.');
    }

    /**
     * Menyetujui klaim peringkat.
     */
    public function approveRankClaim(RankClaim $rankClaim)
    {
        if ($rankClaim->status !== 'pending') {
            return back()->with('error', 'Klaim ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($rankClaim) {
            $rankClaim->user()->update(['rank_id' => $rankClaim->claimed_rank_id]);
            $rankClaim->update([
                'status' => 'approved',
                'admin_notes' => 'Peringkat berhasil diperbarui.',
            ]);
        });

        return back()->with('success', 'Klaim peringkat berhasil disetujui.');
    }

    /**
     * Menolak klaim peringkat.
     */
    public function rejectRankClaim(Request $request, RankClaim $rankClaim)
    {
        $request->validate(['admin_notes' => 'required|string|max:255']);

        if ($rankClaim->status !== 'pending') {
            return back()->with('error', 'Klaim ini sudah diproses sebelumnya.');
        }

        $rankClaim->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Klaim peringkat telah ditolak.');
    }
}
