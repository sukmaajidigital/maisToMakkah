<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'min_downline_count',
        'transaction_bonus',
    ];

    /**
     * Tabel ini tidak menggunakan kolom created_at dan updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Mendapatkan semua user yang memiliki peringkat ini.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
