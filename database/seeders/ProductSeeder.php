<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProductCategory::all();
        $stores = Store::where('is_verified', 1)->get();

        if ($categories->isEmpty() || $stores->isEmpty()) {
            $this->command->error('⚠ Category atau Store belum ada! Jalankan ProductCategorySeeder & StoreSeeder.');
            return;
        }

        // === DATA PRODUK FINAL (SEMUA KATEGORI) === //
        $productsData = [
            // ========================
            // KERIPIK
            // ========================
            [
                'category' => 'Keripik',
                'products' => [
                    ['name' => 'Keripik Kentang Original', 'desc' => 'Keripik kentang renyah rasa original.', 'price' => 15000, 'w' => 150, 'stock' => 50],
                    ['name' => 'Keripik Singkong Balado', 'desc' => 'Keripik singkong pedas balado mantap.', 'price' => 12000, 'w' => 200, 'stock' => 40],
                    ['name' => 'Keripik Pisang Cokelat', 'desc' => 'Keripik pisang dengan taburan cokelat.', 'price' => 18000, 'w' => 180, 'stock' => 30],
                ],
            ],

            // ========================
            // BISKUIT
            // ========================
            [
                'category' => 'Biskuit',
                'products' => [
                    ['name' => 'Biskuit Marie Susu', 'desc' => 'Biskuit marie klasik dengan susu.', 'price' => 8000, 'w' => 120, 'stock' => 100],
                    ['name' => 'Cookies Choco Chips', 'desc' => 'Cookies premium dengan choco chips banyak.', 'price' => 25000, 'w' => 200, 'stock' => 40],
                    ['name' => 'Wafer Vanilla', 'desc' => 'Wafer lembut dengan vanilla.', 'price' => 12000, 'w' => 150, 'stock' => 80],
                ],
            ],

            // ========================
            // COKELAT
            // ========================
            [
                'category' => 'Cokelat',
                'products' => [
                    ['name' => 'Cokelat Dark 70%', 'desc' => 'Cokelat dark premium 70% kakao.', 'price' => 35000, 'w' => 100, 'stock' => 20],
                    ['name' => 'Cokelat Susu Classic', 'desc' => 'Cokelat susu manis dan lembut.', 'price' => 20000, 'w' => 150, 'stock' => 60],
                    ['name' => 'Wafer Cokelat Crispy', 'desc' => 'Wafer cokelat crispy.', 'price' => 18000, 'w' => 180, 'stock' => 70],
                ],
            ],

            // ========================
            // PERMEN
            // ========================
            [
                'category' => 'Permen',
                'products' => [
                    ['name' => 'Permen Buah Mix', 'desc' => 'Permen keras rasa buah.', 'price' => 10000, 'w' => 150, 'stock' => 90],
                    ['name' => 'Lollipop Rainbow', 'desc' => 'Lollipop warna-warni.', 'price' => 5000, 'w' => 50, 'stock' => 120],
                    ['name' => 'Permen Karet Mint', 'desc' => 'Permen karet rasa mint segar.', 'price' => 8000, 'w' => 100, 'stock' => 85],
                ],
            ],

            // ========================
            // MINUMAN
            // ========================
            [
                'category' => 'Minuman',
                'products' => [
                    ['name' => 'Teh Jasmine Kotak', 'desc' => 'Teh melati dalam kemasan kotak.', 'price' => 5000, 'w' => 200, 'stock' => 150],
                    ['name' => 'Kopi Susu Kemasan', 'desc' => 'Kopi susu siap minum.', 'price' => 6000, 'w' => 200, 'stock' => 130],
                    ['name' => 'Jus Bubuk Buah Mix', 'desc' => 'Minuman serbuk rasa buah.', 'price' => 12000, 'w' => 100, 'stock' => 75],
                ],
            ],

            // ========================
            // MAKANAN INSTAN
            // ========================
            [
                'category' => 'Makanan Instan',
                'products' => [
                    ['name' => 'Mie Goreng Pedas', 'desc' => 'Mie instan goreng pedas.', 'price' => 3500, 'w' => 85, 'stock' => 200],
                    ['name' => 'Mie Kuah Ayam', 'desc' => 'Mie kuah dengan rasa ayam.', 'price' => 3500, 'w' => 75, 'stock' => 160],
                    ['name' => 'Cup Noodles Korea', 'desc' => 'Mie cup rasa Korea pedas.', 'price' => 15000, 'w' => 120, 'stock' => 60],
                ],
            ],

            // ----------------------------------------------------
            // BARU → KERUPUK
            // ----------------------------------------------------
            [
                'category' => 'Kerupuk',
                'products' => [
                    ['name' => 'Kerupuk Udang', 'desc' => 'Kerupuk udang renyah.', 'price' => 9000, 'w' => 120, 'stock' => 80],
                    ['name' => 'Kerupuk Bawang', 'desc' => 'Kerupuk bawang gurih.', 'price' => 8000, 'w' => 150, 'stock' => 100],
                ],
            ],

            // ----------------------------------------------------
            // BARU → Roti
            // ----------------------------------------------------
            [
                'category' => 'Roti',
                'products' => [
                    ['name' => 'Roti Sobek Cokelat', 'desc' => 'Roti lembut isi cokelat.', 'price' => 12000, 'w' => 200, 'stock' => 60],
                ],
            ],

            // ----------------------------------------------------
            // BARU → Minuman Dingin
            // ----------------------------------------------------
            [
                'category' => 'Minuman Dingin',
                'products' => [
                    ['name' => 'Es Teh Manis Cup', 'desc' => 'Teh manis dingin menyegarkan.', 'price' => 7000, 'w' => 250, 'stock' => 100],
                    ['name' => 'Es Kopi Susu Cup', 'desc' => 'Kopi susu dingin creamy.', 'price' => 12000, 'w' => 250, 'stock' => 80],
                ],
            ],
        ];

        // ==========================================================
        // INSERT PRODUK
        // ==========================================================
        foreach ($productsData as $categoryData) {

            $category = $categories->firstWhere('name', $categoryData['category']);
            if (!$category) continue;

            foreach ($categoryData['products'] as $i => $p) {

                $store = $stores[$i % $stores->count()];

                // AUTO UPDATE (no duplicate)
                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($p['name'])],
                    [
                        'store_id' => $store->id,
                        'product_category_id' => $category->id,
                        'name' => $p['name'],
                        'description' => $p['desc'],
                        'condition' => 'new',
                        'price' => $p['price'],
                        'weight' => $p['w'],
                        'stock' => $p['stock'],
                    ]
                );

                // Gambar
                ProductImage::updateOrCreate(
                    ['product_id' => $product->id],
                    [
                        'image' => "https://via.placeholder.com/400x400/98bad5/ffffff?text=" . urlencode($product->name),
                        'is_thumbnail' => true,
                    ]
                );
            }
        }

        $this->command->info('🎉 Berhasil seeding produk lengkap tanpa duplikasi!');
    }
}