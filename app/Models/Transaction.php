<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code',
        'buyer_id',
        'store_id',
        'address',
        'address_id',
        'city',
        'postal_code',
        'shipping',
        'shipping_type',
        'shipping_cost',
        'tracking_number',
        'tax',
        'grand_total',
        'payment_status',
        'payment_proof',
        'order_status',
        'balance_credited_at',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'balance_credited_at' => 'datetime',
    ];

    // ============================
    // RELATIONS
    // ============================

    // Buyer pemilik pesanan
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    // Jika ingin akses user buyer dengan nama "user"
    public function user()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    // Toko penjual
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    // Detail item transaksi
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    // Alias details (bebas dipakai buyer/seller)
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    // Review produk setelah completed
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'transaction_id');
    }
}
