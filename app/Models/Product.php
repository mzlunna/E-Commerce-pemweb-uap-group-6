<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'weight'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}