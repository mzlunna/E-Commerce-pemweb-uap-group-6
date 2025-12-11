<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $table = 'stores';

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'about',
        'phone',
        'city',
        'address',
        'address_id',
        'postal_code', 
        'is_verified'
    ];

    protected $attributes = [
        'address_id' => '0', 
        'postal_code' => '00000', 
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    /* ============================================
       RELASI
    ============================================ */

    // User pemilik toko
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Produk toko
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Saldo toko
    public function balance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    // Transaksi toko
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Withdrawals (has many through store_balance)
    public function withdrawals()
    {
        return $this->hasManyThrough(
            \App\Models\Withdrawal::class,
            \App\Models\StoreBalance::class,
            'store_id',
            'store_balance_id',
            'id',
            'id'
        );
    }

    /* ============================================
       ACCESSOR STATUS (auto)
    ============================================ */
    public function getStatusAttribute()
    {
        if ($this->deleted_at !== null) {
            return 'rejected';
        }

        return $this->is_verified ? 'approved' : 'pending';
    }
}
