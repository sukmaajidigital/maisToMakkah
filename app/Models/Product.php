<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_price',
        'description',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    /**
     * Mendapatkan semua transaksi untuk produk ini.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
