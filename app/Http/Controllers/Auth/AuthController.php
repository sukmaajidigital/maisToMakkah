<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BonusHistory;
use App\Models\Product;
use App\Models\Rank;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

        // Coba login sebagai admin terlebih dahulu
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            // Arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard.index'));
        }

        // Jika gagal sebagai admin, coba login sebagai pengguna biasa
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            // Arahkan ke dashboard pengguna
            return redirect()->intended(route('dashboard.index'));
        }

        // Jika keduanya gagal, kembalikan error
        return back()->withErrors([
            'email' => 'Kredensial yang Anda berikan tidak cocok dengan catatan kami.',
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

    /**
     * Memproses registrasi mandiri, membuat transaksi, dan mendistribusikan bonus.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'longname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'parent_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        // Validasi batas downline untuk upline
        if ($request->filled('parent_id')) {
            $upline = User::find($request->parent_id);
            if ($upline && $upline->children()->count() >= 5) {
                return back()->withInput()->withErrors(['parent_id' => 'Upline yang Anda tuju sudah mencapai batas maksimal downline.']);
            }
        }

        $defaultRankId = Rank::where('name', 'Member')->firstOrFail()->id;
        $product = Product::firstOrFail();

        try {
            DB::transaction(function () use ($request, $defaultRankId, $product) {
                // 1. Buat user baru
                $newUser = User::create([
                    'name' => $request->name,
                    'longname' => $request->longname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'parent_id' => $request->parent_id,
                    'rank_id' => $defaultRankId,
                ]);

                // 2. Proses "pembelian" otomatis jika ada upline
                if ($newUser->parent_id) {
                    $this->processRegistrationPurchase($newUser, $product);
                }

                // 3. Login user yang baru dibuat
                Auth::guard('web')->login($newUser);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.');
        }

        return redirect(route('dashboard.index'));
    }
    /**
     * Memproses pembelian otomatis saat registrasi.
     */
    private function processRegistrationPurchase(User $buyer, Product $product)
    {
        $transaction = Transaction::create(['user_id' => $buyer->id, 'product_id' => $product->id, 'price_paid' => $product->base_price, 'transaction_date' => now()]);
        $this->distributeAllBonuses($buyer, $transaction);
    }

    /**
     * Logika untuk mendistribusikan semua bonus.
     */
    private function distributeAllBonuses(User $buyer, Transaction $transaction)
    {
        $currentUpline = $buyer->parent;
        $level = 1;
        while ($currentUpline) {
            if ($level === 1) {
                $directBonus = 1000000;
                $currentUpline->increment('bonus_balance', $directBonus);
                BonusHistory::create(['user_id' => $currentUpline->id, 'source_user_id' => $buyer->id, 'transaction_id' => $transaction->id, 'type' => 'direct_referral', 'amount' => $directBonus, 'description' => "Bonus referral langsung dari {$buyer->longname}"]);
            }
            if ($level === 2) {
                $indirectBonus = 50000;
                $currentUpline->increment('bonus_balance', $indirectBonus);
                BonusHistory::create(['user_id' => $currentUpline->id, 'source_user_id' => $buyer->id, 'transaction_id' => $transaction->id, 'type' => 'indirect_referral', 'amount' => $indirectBonus, 'description' => "Bonus jaringan dari {$buyer->longname}"]);
            }
            if ($currentUpline->rank && $currentUpline->rank->transaction_bonus > 0) {
                $rankBonus = $currentUpline->rank->transaction_bonus;
                $currentUpline->increment('bonus_balance', $rankBonus);
                BonusHistory::create(['user_id' => $currentUpline->id, 'source_user_id' => $buyer->id, 'transaction_id' => $transaction->id, 'type' => 'rank_transaction', 'amount' => $rankBonus, 'description' => "Bonus Peringkat {$currentUpline->rank->name} dari transaksi {$buyer->longname}"]);
            }
            $currentUpline = $currentUpline->parent;
            $level++;
        }
    }

    // --- Logout ---
    public function logout(Request $request)
    {
        // Logout dari guard yang sedang aktif
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login utama
        return redirect()->route('login');
    }
}
