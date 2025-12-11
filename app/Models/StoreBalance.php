<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    protected $fillable = [
        'store_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2', // Sesuai DB decimal(26,2)
    ];

    // Relationships
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function histories()
    {
        return $this->hasMany(StoreBalanceHistory::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    // Accessors
    public function getFormattedBalanceAttribute()
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }
}