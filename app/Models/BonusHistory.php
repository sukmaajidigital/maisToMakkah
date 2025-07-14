<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusHistory extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit karena 'histories' adalah bentuk jamak yang tidak umum
    protected $table = 'bonus_histories';

    protected $fillable = [
        'user_id',
        'source_user_id',
        'transaction_id',
        'type',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Mendapatkan user yang menerima bonus.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mendapatkan user yang menjadi sumber bonus (misal: downline baru).
     */
    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    /**
     * Mendapatkan transaksi yang menjadi sumber bonus.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
