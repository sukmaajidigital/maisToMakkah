<?php

namespace App\Http\Controllers;

use App\Models\BonusHistory;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman daftar produk.
     */
    public function index()
    {
        // Langsung ambil semua produk, harga tidak lagi dinamis.
        $products = Product::all();
        return view('order.index', compact('products'));
    }

    /**
     * Memproses order produk dan mendistribusikan semua bonus yang berlaku.
     */
    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $product = Product::find($request->product_id);
        $buyer = Auth::user();

        try {
            DB::transaction(function () use ($product, $buyer) {
                // 1. Buat transaksi dengan harga dasar (base_price)
                $transaction = Transaction::create([
                    'user_id' => $buyer->id,
                    'product_id' => $product->id,
                    'price_paid' => $product->base_price, // Menggunakan harga tetap
                    'transaction_date' => now(),
                ]);

                // 2. Distribusikan semua bonus yang berlaku
                $this->distributeAllBonuses($buyer, $transaction);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }

        return redirect()->route('order.index')->with('success', "Order untuk produk '{$product->name}' berhasil!");
    }

    /**
     * Logika untuk mendistribusikan semua bonus:
     * - Bonus Langsung (1jt untuk L1)
     * - Bonus Tidak Langsung (50rb untuk L2)
     * - Bonus Peringkat (berjenjang ke atas)
     */
    private function distributeAllBonuses(User $buyer, Transaction $transaction)
    {
        $currentUpline = $buyer->parent;
        $level = 1;

        while ($currentUpline) {
            // Bonus Langsung (hanya untuk level 1)
            if ($level === 1) {
                $directBonus = 1000000;
                $currentUpline->increment('bonus_balance', $directBonus);
                BonusHistory::create([
                    'user_id' => $currentUpline->id,
                    'source_user_id' => $buyer->id,
                    'transaction_id' => $transaction->id,
                    'type' => 'direct_referral',
                    'amount' => $directBonus,
                    'description' => "Bonus referral langsung dari {$buyer->longname}",
                ]);
            }

            // Bonus Tidak Langsung (hanya untuk level 2)
            if ($level === 2) {
                $indirectBonus = 50000;
                $currentUpline->increment('bonus_balance', $indirectBonus);
                BonusHistory::create([
                    'user_id' => $currentUpline->id,
                    'source_user_id' => $buyer->id,
                    'transaction_id' => $transaction->id,
                    'type' => 'indirect_referral',
                    'amount' => $indirectBonus,
                    'description' => "Bonus jaringan dari {$buyer->longname}",
                ]);
            }

            // Bonus Peringkat (untuk semua level upline yang memenuhi syarat)
            if ($currentUpline->rank && $currentUpline->rank->transaction_bonus > 0) {
                $rankBonus = $currentUpline->rank->transaction_bonus;
                $currentUpline->increment('bonus_balance', $rankBonus);
                BonusHistory::create([
                    'user_id' => $currentUpline->id,
                    'source_user_id' => $buyer->id,
                    'transaction_id' => $transaction->id,
                    'type' => 'rank_transaction',
                    'amount' => $rankBonus,
                    'description' => "Bonus Peringkat {$currentUpline->rank->name} dari transaksi {$buyer->longname}",
                ]);
            }

            // Pindah ke level upline selanjutnya
            $currentUpline = $currentUpline->parent;
            $level++;
        }
    }
}
