<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    protected $fillable = [
        'parent_id',
        'image',
        'name',
        'slug',
        'tagline',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    // Scopes
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    // Accessors
    public function getTotalProductsAttribute()
    {
        return $this->products()->count();
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        
        if (str_starts_with($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        
        return asset('storage/' . $this->image);
    }
}