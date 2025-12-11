<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image', 'is_thumbnail'];

    // APPEND accessor otomatis
    protected $appends = ['image_url'];

    /**
     * Accessor untuk mendapatkan URL gambar produk
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        // Kalau image kosong, kembalikan gambar placeholder
        if (!$this->image) {
            return asset('images/placeholder.jpg');  // Gambar placeholder jika tidak ada gambar
        }

        // Kalau image sudah berupa URL penuh (misalnya URL eksternal)
        if (str_starts_with($this->image, 'http')) {
            return $this->image;  // Kembalikan URL gambar eksternal
        }

        // Kalau image sudah ada 'products/' di path, misalnya 'products/keripik-kentang.jpg'
        // Kembalikan gambar dari folder storage
        if (str_starts_with($this->image, 'products/')) {
            return asset('storage/' . $this->image);  // Mengarah ke storage/products/{image_name}
        }

        // Kalau hanya nama file saja (misalnya 'keripik-kentang.jpg'), anggap gambar ada di folder 'storage/products/'
        return asset('storage/products/' . $this->image);  // Mengarah ke storage/products/{image_name}
    }

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);  // Menyatakan relasi ke model Product
    }
}
