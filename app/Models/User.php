<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'parent_id',
        'rank_id',
        'bonus_balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Mendapatkan semua downline langsung (direct referral).
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Mendapatkan peringkat user.
     */
    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * Mendapatkan semua transaksi yang dilakukan user ini.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Mendapatkan riwayat bonus user ini.
     */
    public function bonusHistories()
    {
        return $this->hasMany(BonusHistory::class);
    }

    /**
     * Mendapatkan riwayat penarikan user ini.
     */
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    /**
     * Mendapatkan riwayat klaim peringkat user ini.
     */
    public function rankClaims()
    {
        return $this->hasMany(RankClaim::class);
    }

    // RELASI REKURSIF (PENTING)

    /**
     * Mendapatkan SEMUA downline di bawah user ini secara rekursif.
     * Ini sangat penting untuk menghitung total downline untuk kualifikasi peringkat.
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
