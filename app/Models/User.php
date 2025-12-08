<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin' or 'member'
        'phone',
        'city',
        'province',
        'address',
        'postal_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * User bisa punya 1 Store (untuk jadi seller)
     */
    public function store()
    {
        return $this->hasOne(Store::class, 'user_id');
    }

    /**
     * User bisa punya 1 Buyer profile
     */
    public function buyer()
    {
        return $this->hasOne(Buyer::class, 'user_id');
    }

    /**
     * User punya banyak Transactions
     */
    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Buyer::class,
            'user_id',
            'buyer_id',
            'id',
            'id'
        );
    }

    /**
     * User punya banyak Orders (direct)
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * User punya Wishlist
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // ============================================
    // ACCESSORS & HELPERS
    // ============================================

    /**
     * Cek apakah user adalah admin
     */
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user punya store verified (adalah seller)
     */
    public function getIsSellerAttribute()
    {
        return $this->store()->where('is_verified', 1)->exists();
    }

    /**
     * Cek apakah user punya pending store application
     */
    public function getHasPendingStoreAttribute()
    {
        return $this->store()->where('is_verified', 0)->exists();
    }

    /**
     * Get verified store
     */
    public function getVerifiedStoreAttribute()
    {
        return $this->store()->where('is_verified', 1)->first();
    }

    /**
     * Get cart items count (untuk badge di header)
     */
    public function getCartItemsCountAttribute()
    {
        // TODO: Implement cart system
        return 0;
    }
}