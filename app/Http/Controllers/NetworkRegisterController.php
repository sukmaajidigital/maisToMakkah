<?php

namespace App\Http\Controllers;

use App\Models\BonusHistory;
use App\Models\Product;
use App\Models\Rank;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        if ($upline->children()->count() >= 5) {
            return back()->withInput()->with('error', "Pendaftaran gagal. Anda sudah mencapai batas maksimal 5 downline langsung.");
        }

        $request->validate([
            'longname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Ambil rank default "Member"
        $defaultRankId = Rank::where('name', 'Member')->firstOrFail()->id;

        // Ambil produk pendaftaran utama
        $product = Product::firstOrFail();

        try {
            DB::transaction(function () use ($request, $upline, $defaultRankId, $product) {
                // 1. Buat user baru
                $newUser = User::create([
                    'name' => $request->name,
                    'longname' => $request->longname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'bank_name' => $request->bank_name,
                    'bank_account_number' => $request->bank_account_number,
                    'bank_account_name' => $request->bank_account_name,
                    'password' => Hash::make($request->password),
                    'parent_id' => $upline->id,
                    'rank_id' => $defaultRankId, // Langsung set rank "Member"
                ]);

                // 2. Proses "pembelian" otomatis
                $this->processRegistrationPurchase($newUser, $product);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi. Error: ' . $e->getMessage());
        }

        return redirect()->route('network.register.index')->with('success', 'Member baru berhasil didaftarkan dan transaksi telah dibuat secara otomatis.');
    }
    /**
     * Memproses pembelian otomatis saat registrasi.
     */
    private function processRegistrationPurchase(User $buyer, Product $product)
    {
        // Buat transaksi dengan harga dasar
        $transaction = Transaction::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'price_paid' => $product->base_price,
            'transaction_date' => now(),
        ]);

        // Distribusikan semua bonus yang berlaku
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
