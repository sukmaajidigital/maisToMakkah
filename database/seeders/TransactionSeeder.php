<?php

namespace Database\Seeders;

use App\Models\BonusHistory;
use App\Models\Product;
use App\Models\RankClaim;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $product = Product::first();
        if (!$product) {
            $this->command->error('No products found. Please run ProductSeeder first.');
            return;
        }

        // Ambil semua user kecuali user paling atas (root)
        $buyers = User::whereNotNull('parent_id')->get();

        // Hanya 30% user yang akan kita buatkan transaksi untuk realisme
        foreach ($buyers->random(floor($buyers->count() * 0.3)) as $buyer) {
            $this->processTransactionAndBonuses($buyer, $product);
        }

        // Buat beberapa permintaan penarikan yang pending
        $this->createPendingWithdrawals();

        // Buat beberapa permintaan klaim peringkat yang pending
        $this->createPendingRankClaims();
    }

    private function processTransactionAndBonuses(User $buyer, Product $product)
    {
        $pricePaid = $product->getPriceForUser($buyer);

        DB::transaction(function () use ($buyer, $product, $pricePaid) {
            // 1. Buat Transaksi
            $transaction = Transaction::create([
                'user_id' => $buyer->id,
                'product_id' => $product->id,
                'price_paid' => $pricePaid,
                'transaction_date' => now()->subDays(rand(1, 30)),
            ]);

            $upline = $buyer->parent;

            // 2. Bonus Langsung (Level 1) & Tidak Langsung (Level 2)
            if ($upline) {
                // Bonus Langsung
                $directBonus = 1000000;
                $upline->increment('bonus_balance', $directBonus);
                BonusHistory::create([
                    'user_id' => $upline->id,
                    'source_user_id' => $buyer->id,
                    'transaction_id' => $transaction->id,
                    'type' => 'direct_referral',
                    'amount' => $directBonus,
                    'description' => "Bonus rekrut langsung dari {$buyer->longname}",
                ]);

                // Bonus Tidak Langsung
                $grandUpline = $upline->parent;
                if ($grandUpline) {
                    $indirectBonus = 50000;
                    $grandUpline->increment('bonus_balance', $indirectBonus);
                    BonusHistory::create([
                        'user_id' => $grandUpline->id,
                        'source_user_id' => $buyer->id,
                        'transaction_id' => $transaction->id,
                        'type' => 'indirect_referral',
                        'amount' => $indirectBonus,
                        'description' => "Bonus jaringan dari {$buyer->longname}",
                    ]);
                }
            }

            // 3. Bonus Transaksi Peringkat (Berjenjang ke atas)
            $currentUpline = $buyer->parent;
            while ($currentUpline) {
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
                $currentUpline = $currentUpline->parent;
            }
        });
    }

    private function createPendingWithdrawals()
    {
        // Ambil 5 user dengan saldo bonus tertinggi
        $usersWithBalance = User::where('bonus_balance', '>', 100000)->orderBy('bonus_balance', 'desc')->take(5)->get();

        foreach ($usersWithBalance as $user) {
            Withdrawal::create([
                'user_id' => $user->id,
                'amount' => floor($user->bonus_balance / 2), // Tarik setengah saldo
                'status' => 'pending',
            ]);
        }
    }

    private function createPendingRankClaims()
    {
        $users = User::with('rank')->get();
        foreach ($users as $user) {
            $nextRank = DB::table('ranks')->where('id', '>', $user->rank_id ?? 0)->orderBy('id', 'asc')->first();
            if ($nextRank && $user->downline_count >= $nextRank->min_downline_count) {
                // Cek apakah sudah ada klaim pending untuk rank ini
                $hasPending = RankClaim::where('user_id', $user->id)->where('claimed_rank_id', $nextRank->id)->where('status', 'pending')->exists();
                if (!$hasPending) {
                    RankClaim::create([
                        'user_id' => $user->id,
                        'claimed_rank_id' => $nextRank->id,
                        'status' => 'pending',
                    ]);
                }
            }
        }
    }
}
