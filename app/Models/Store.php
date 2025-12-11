<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

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
        'is_verified' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function storeBalance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getStatusAttribute()
    {
        if ($this->deleted_at) return 'rejected';
        if ($this->is_verified) return 'approved';
        return 'pending';
    }
}