<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'price_paid',
        'transaction_date',
    ];

    protected $casts = [
        'price_paid' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    /**
     * Mendapatkan user yang melakukan transaksi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan produk yang dibeli.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
