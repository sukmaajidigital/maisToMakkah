<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'claimed_rank_id',
        'status',
        'admin_notes',
    ];

    /**
     * Mendapatkan user yang mengklaim peringkat.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan data peringkat yang diklaim.
     */
    public function claimedRank()
    {
        return $this->belongsTo(Rank::class, 'claimed_rank_id');
    }
}
