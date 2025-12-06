<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // buyer, seller, admin
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function store()
    {
        return $this->hasOne(Store::class, 'owner_id');
    }

    public function buyerTransactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'buyer_id');
    }

    // Helper Methods
    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasStore()
    {
        return $this->store()->exists();
    }

    public function hasVerifiedStore()
    {
        return $this->store()->where('is_verified', true)->exists();
    }
}