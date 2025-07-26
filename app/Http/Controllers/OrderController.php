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
     * Menampilkan halaman daftar produk dengan harga dinamis.
     */
    public function index()
    {
        $allProducts = Product::all();
        $user = Auth::user();

        // Siapkan data produk dengan harga yang sudah disesuaikan untuk view
        $productsForView = $allProducts->map(function ($product) use ($user) {
            return [
                'product' => $product,
                'price' => $product->getPriceForUser($user),
            ];
        });

        return view('order.index', ['productsForView' => $productsForView]);
    }

    /**
     * Memproses order produk dan mendistribusikan bonus multi-level.
     */
    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $product = Product::find($request->product_id);
        $buyer = Auth::user();
        $pricePaid = $product->getPriceForUser($buyer); // Hitung harga dinamis

        try {
            DB::transaction(function () use ($product, $buyer, $pricePaid) {
                // 1. Buat transaksi dengan harga dinamis
                $transaction = Transaction::create([
                    'user_id' => $buyer->id,
                    'product_id' => $product->id,
                    'price_paid' => $pricePaid,
                    'transaction_date' => now(),
                ]);

                // 2. Distribusikan bonus secara berjenjang
                $this->distributeMultiLevelBonus($buyer, $transaction);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi. Error: ' . $e->getMessage());
        }

        return redirect()->route('order.index')->with('success', "Order untuk produk '{$product->name}' berhasil!");
    }

    /**
     * Logika untuk mendistribusikan bonus ke semua level upline.
     * @param User $buyer - User yang melakukan pembelian
     * @param Transaction $transaction - Transaksi yang terkait
     */
    private function distributeMultiLevelBonus(User $buyer, Transaction $transaction)
    {
        $bonusAmount = 50000; // Bonus per level adalah selisih harga
        $currentUpline = $buyer->parent;

        // Lakukan perulangan selama masih ada upline di atasnya
        while ($currentUpline) {
            // Berikan bonus ke upline saat ini
            $currentUpline->increment('bonus_balance', $bonusAmount);

            BonusHistory::create([
                'user_id' => $currentUpline->id,
                'source_user_id' => $buyer->id,
                'transaction_id' => $transaction->id,
                'type' => 'indirect_referral', // Bisa disebut juga bonus jaringan/pass-up
                'amount' => $bonusAmount,
                'description' => "Bonus jaringan dari pembelian oleh {$buyer->longname}",
            ]);

            // Pindah ke level upline selanjutnya
            $currentUpline = $currentUpline->parent;
        }
    }
}
