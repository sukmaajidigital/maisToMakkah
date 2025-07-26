<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Data Login & Nama
        'name', // username
        'longname',
        'email',
        'password',

        // Data Kontak & Bank
        'phone',
        'bank_name',
        'bank_account_name',
        'bank_account_number',

        // Relasi & Status
        'parent_id',
        'rank_id',
        'bonus_balance',
    ];
    protected $networkLevel = null;

    /**
     * Menghitung level/kedalaman user dalam jaringan secara rekursif.
     * Level 0 adalah root/puncak.
     *
     * @return int
     */
    public function getNetworkLevel(): int
    {
        // Gunakan cache jika sudah pernah dihitung untuk efisiensi
        if ($this->networkLevel !== null) {
            return $this->networkLevel;
        }

        if ($this->parent_id === null) {
            return $this->networkLevel = 0;
        }

        // Load relasi parent jika belum ada untuk menghindari N+1 problem
        $this->loadMissing('parent');

        return $this->networkLevel = 1 + $this->parent->getNetworkLevel();
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'bonus_balance' => 'decimal:2',
        ];
    }
    // RELASI DASAR

    /**
     * Mendapatkan Upline (user yang merekrut).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Mendapatkan semua downline langsung (direct referral).
     */
    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Mendapatkan SEMUA downline di bawah user ini secara rekursif.
     * Ini berguna untuk menampilkan struktur pohon jaringan.
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Mendapatkan peringkat user.
     */
    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * Mendapatkan semua transaksi yang dilakukan user ini.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Mendapatkan riwayat bonus user ini.
     */
    public function bonusHistories(): HasMany
    {
        return $this->hasMany(BonusHistory::class);
    }

    /**
     * Mendapatkan riwayat penarikan user ini.
     */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    /**
     * Mendapatkan riwayat klaim peringkat user ini.
     */
    public function rankClaims(): HasMany
    {
        return $this->hasMany(RankClaim::class);
    }

    // =================================================================
    // LOGIC & HELPERS
    // =================================================================

    /**
     * Menghitung jumlah semua downline di bawahnya secara efisien.
     * Ini sangat penting untuk kualifikasi peringkat.
     * * @return int
     */
    public function getDownlineCountAttribute(): int
    {
        $count = 0;
        foreach ($this->children as $child) {
            // Tambahkan 1 untuk child ini, lalu tambahkan semua anak dari child tersebut secara rekursif
            $count += 1 + $child->downline_count;
        }
        return $count;
    }
}
