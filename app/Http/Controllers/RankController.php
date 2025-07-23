<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\RankClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankController extends Controller
{
    /**
     * Menampilkan halaman kualifikasi peringkat.
     */
    public function qualification()
    {
        $user = Auth::user()->load('rank', 'rankClaims.claimedRank');
        $currentRank = $user->rank;
        $totalNetwork = $user->downline_count;

        $nextRank = Rank::where('id', '>', $currentRank->id ?? 0)
            ->orderBy('id', 'asc')
            ->first();

        // data view
        $progress = 0;
        $canClaim = false;
        $hasPendingClaim = false;

        if ($nextRank) {
            // progress
            $requiredDownlines = $nextRank->min_downline_count;
            if ($requiredDownlines > 0) {
                $progress = ($totalNetwork / $requiredDownlines) * 100;
            }

            // cek relevan claim
            if ($totalNetwork >= $requiredDownlines) {
                $canClaim = true;
            }

            // cek claim pending
            $hasPendingClaim = $user->rankClaims()
                ->where('claimed_rank_id', $nextRank->id)
                ->where('status', 'pending')
                ->exists();
        }

        // claim history check
        $claimHistory = $user->rankClaims()->latest()->get();

        return view('rank.qualification', compact(
            'user',
            'currentRank',
            'nextRank',
            'totalNetwork',
            'progress',
            'canClaim',
            'hasPendingClaim',
            'claimHistory'
        ));
    }

    /**
     * Menyimpan permintaan klaim peringkat baru.
     */
    public function claimRank(Request $request)
    {
        $user = Auth::user();
        $totalNetwork = $user->downline_count;

        // Validasi peringkat yang akan di-klaim dari request
        $request->validate([
            'rank_id_to_claim' => 'required|exists:ranks,id',
        ]);

        $rankToClaimId = $request->rank_id_to_claim;
        $rankToClaim = Rank::find($rankToClaimId);

        // --- Lakukan validasi ulang di backend ---
        // 1. Cek apakah user memenuhi syarat jumlah downline
        if ($totalNetwork < $rankToClaim->min_downline_count) {
            return back()->with('error', 'Anda belum memenuhi syarat untuk klaim peringkat ini.');
        }

        // 2. Cek apakah user sudah pernah klaim peringkat ini dan statusnya pending
        $existingClaim = RankClaim::where('user_id', $user->id)
            ->where('claimed_rank_id', $rankToClaimId)
            ->where('status', 'pending')
            ->exists();

        if ($existingClaim) {
            return back()->with('error', 'Anda sudah memiliki klaim yang sedang diproses untuk peringkat ini.');
        }

        // --- Jika semua validasi lolos, buat klaim baru ---
        RankClaim::create([
            'user_id' => $user->id,
            'claimed_rank_id' => $rankToClaimId,
            'status' => 'pending', // Status awal adalah pending
        ]);

        return redirect()->route('rank.qualification')->with('success', 'Klaim peringkat berhasil diajukan dan sedang menunggu persetujuan admin.');
    }
}
