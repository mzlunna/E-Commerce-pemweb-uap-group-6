<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

<<<<<<< HEAD
=======
    protected $table = 'stores';

>>>>>>> origin/main
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

<<<<<<< HEAD
=======
    // Saldo toko
>>>>>>> origin/main
    public function storeBalance()
    {
        return $this->hasOne(StoreBalance::class);
    }

<<<<<<< HEAD
=======
    // Transaksi toko
>>>>>>> origin/main
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

<<<<<<< HEAD
    public function getStatusAttribute()
    {
        if ($this->deleted_at) return 'rejected';
        if ($this->is_verified) return 'approved';
        return 'pending';
    }
}
=======
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
>>>>>>> origin/main
