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

    // protected $casts = [
    //     'base_price' => 'decimal:2',
    // ];

    /**
     * Mendapatkan semua transaksi untuk produk ini.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    // public function getPriceForUser(User $user): float
    // {
    //     $level = $user->getNetworkLevel();
    //     $priceIncrease = 50000; // Kenaikan harga per level

    //     return $this->base_price + ($level * $priceIncrease);
    // }
}
