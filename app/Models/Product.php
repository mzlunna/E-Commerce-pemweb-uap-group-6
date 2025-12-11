<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\ProductReview;
use App\Models\TransactionDetail;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'product_category_id',
        'name',
        'slug',
        'description',
        'condition',
        'price',
        'weight',
        'stock'
    ];

    // Append accessor otomatis
    protected $appends = ['average_rating', 'reviews_count', 'sold'];

    /**
     * Scope: hanya produk yang stoknya > 0
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Accessor: Rata-rata rating
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 4.5;
    }

    /**
     * Accessor: Jumlah review
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Accessor: Total produk terjual
     */
    public function getSoldAttribute()
    {
        return $this->transactionDetails()->sum('qty') ?? 0;
    }

    // ==============================
    // RELATIONS
    // ==============================

    /**
     * Gambar produk
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Kategori produk
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Toko pemilik produk
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Review produk
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    /**
     * Detail transaksi (produk terjual)
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'product_id');
    }
}
