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
        $categories = ProductCategory::whereIn('name', [
            'Keripik', 'Biskuit', 'Minuman'
        ])->get();

        $stores = Store::where('is_verified', 1)->get();

        if ($categories->isEmpty() || $stores->isEmpty()) {
            $this->command->error('⚠️ Category atau Store belum ada!');
            return;
        }

        // ------- URL GAMBAR -------
        $productImages = [
            // Keripik
            'Keripik Kentang Original' => 'https://tse2.mm.bing.net/th/id/OIP.qaRPg9rh1ZPn9JFq_fkMewHaEK?pid=Api&P=0&h=180',
            'Keripik Singkong Balado' => 'https://resepkoki.id/wp-content/uploads/2020/12/Resep-Keripik-Singkong-Balado.jpg',
            'Keripik Pisang Cokelat' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkFKRm07F_MTWiq3-ds6mxftp_3jym8whYeA&s',
            'Keripik Tempe Crispy' => 'https://img.lazcdn.com/g/ff/kf/Sf31faf9e42ef4601a790ecc2f6071425b.jpg',
            'Keripik Talas Original' => 'https://id-live-01.slatic.net/p/ee9abf99b1c404858be5678914be89fc.jpg',
  

            // Biskuit
            'Biskuit Marie Susu' => 'https://ubmbiscuits.com/wp-content/uploads/2025/05/Borneo-Marie-Susu-28g.png',
            'Cookies Choco Chips' => 'https://cafeniloufer.com/cdn/shop/files/ChocoChip.webp',
            'Wafer Vanilla' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrzrf_NURe7_0cO3q-0WL-Z7NvUAb4nTSlug&s',
            'Biskuit Kelapa' => 'https://c.alfagift.id/product/1/1_A10160000601_base.jpg',
            'Cookies Oatmeal Raisin' => 'https://www.allrecipes.com/thmb/JbnVNNMYuKZIgDvy1gDQcrTkorQ=/1500x0/filters:no_upscale()/10264-oatmeal-raisin.jpg',


            // Minuman
            'Teh Jasmine Kotak' => 'https://example.com/teh-jasmine.jpg',
            'Kopi Susu Kemasan' => 'https://example.com/kopi-susu.jpg',
            'Jus Bubuk Buah Mix' => 'https://example.com/jus-bubuk.jpg',
        ];

        // ------- PRODUK PER KATEGORI -------
        $productsData = [
            [
                'category' => 'Keripik',
                'products' => [
                    ['name' => 'Keripik Kentang Original', 'desc' => 'Keripik kentang renyah rasa original.', 'price' => 15000, 'w' => 150, 'stock' => 50],
                    ['name' => 'Keripik Singkong Balado', 'desc' => 'Pedas balado mantap.', 'price' => 12000, 'w' => 200, 'stock' => 40],
                    ['name' => 'Keripik Pisang Cokelat', 'desc' => 'Pisang renyah manis.', 'price' => 18000, 'w' => 180, 'stock' => 30],
                    ['name' => 'Keripik Tempe Crispy', 'desc' => 'Tempe renyah.', 'price' => 10000, 'w' => 150, 'stock' => 60],
                    ['name' => 'Keripik Talas Original', 'desc' => 'Talas gurih.', 'price' => 13000, 'w' => 170, 'stock' => 45],
                    ['name' => 'Keripik Seblak Kering', 'desc' => 'Seblak kering pedas.', 'price' => 16000, 'w' => 160, 'stock' => 35],
                    ['name' => 'Keripik Pedas Level 5', 'desc' => 'Super pedas.', 'price' => 17000, 'w' => 150, 'stock' => 25],
                    ['name' => 'Keripik Bayam Renyah', 'desc' => 'Bayam crispy.', 'price' => 9000, 'w' => 80, 'stock' => 50],
                    ['name' => 'Keripik Usus Pedas', 'desc' => 'Usus renyah pedas.', 'price' => 20000, 'w' => 100, 'stock' => 20],
                    ['name' => 'Keripik Kulit Ayam', 'desc' => 'Kulit ayam crispy.', 'price' => 25000, 'w' => 120, 'stock' => 25],
                ],
            ],

            [
                'category' => 'Biskuit',
                'products' => [
                    ['name' => 'Biskuit Marie Susu', 'desc' => 'Biskuit lezat.', 'price' => 8000, 'w' => 120, 'stock' => 50],
                    ['name' => 'Cookies Choco Chips', 'desc' => 'Cookies coklat.', 'price' => 14000, 'w' => 150, 'stock' => 40],
                    ['name' => 'Wafer Vanilla', 'desc' => 'Wafer creamy.', 'price' => 6000, 'w' => 100, 'stock' => 60],
                    ['name' => 'Biskuit Kelapa', 'desc' => 'Kelapa renyah.', 'price' => 9000, 'w' => 130, 'stock' => 45],
                    ['name' => 'Cookies Oatmeal Raisin', 'desc' => 'Sehat & enak.', 'price' => 19000, 'w' => 160, 'stock' => 35],
                    ['name' => 'Sandwich Cokelat', 'desc' => 'Cream cokelat.', 'price' => 11000, 'w' => 150, 'stock' => 50],
                    ['name' => 'Cookies Red Velvet', 'desc' => 'Red velvet premium.', 'price' => 20000, 'w' => 150, 'stock' => 25],
                    ['name' => 'Biskuit Kacang', 'desc' => 'Biskuit kacang.', 'price' => 7000, 'w' => 90, 'stock' => 70],
                    ['name' => 'Cookies Matcha', 'desc' => 'Matcha Jepang.', 'price' => 22000, 'w' => 140, 'stock' => 20],
                    ['name' => 'Biskuit Butter', 'desc' => 'Butter premium.', 'price' => 15000, 'w' => 130, 'stock' => 40],
                ],
            ],

            [
                'category' => 'Minuman',
                'products' => [
                    ['name' => 'Teh Jasmine Kotak', 'desc' => 'Teh jasmine segar.', 'price' => 5000, 'w' => 250, 'stock' => 100],
                    ['name' => 'Kopi Susu Kemasan', 'desc' => 'Kopi susu creamy.', 'price' => 8000, 'w' => 250, 'stock' => 80],
                    ['name' => 'Jus Bubuk Buah Mix', 'desc' => 'Jus aneka rasa.', 'price' => 7000, 'w' => 50, 'stock' => 150],
                    ['name' => 'Es Teh Manis Botol', 'desc' => 'Teh manis dingin.', 'price' => 6000, 'w' => 300, 'stock' => 80],
                    ['name' => 'Soda Lemon', 'desc' => 'Soda rasa lemon.', 'price' => 12000, 'w' => 330, 'stock' => 50],
                    ['name' => 'Minuman Cokelat Panas', 'desc' => 'Cokelat panas creamy.', 'price' => 15000, 'w' => 200, 'stock' => 60],
                    ['name' => 'Kopi Hitam Premium', 'desc' => 'Kopi hitam strong.', 'price' => 10000, 'w' => 250, 'stock' => 70],
                    ['name' => 'Susu Stroberi Botol', 'desc' => 'Susu stroberi manis.', 'price' => 9000, 'w' => 250, 'stock' => 60],
                    ['name' => 'Air Mineral Besar', 'desc' => 'Air mineral 1L.', 'price' => 7000, 'w' => 1000, 'stock' => 200],
                    ['name' => 'Matcha Latte Kemasan', 'desc' => 'Matcha creamy.', 'price' => 13000, 'w' => 250, 'stock' => 45],
                ],
            ],
        ];

        // -------- PROSES SEEDING ----------
        $totalProducts = 0;

        foreach ($productsData as $categoryData) {

            $category = $categories->firstWhere('name', $categoryData['category']);
            if (!$category) continue;

            foreach ($categoryData['products'] as $i => $p) {

                $store = $stores[$i % $stores->count()];

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

                // Simpan gambar
                $imageUrl = $productImages[$p['name']] ?? 'https://via.placeholder.com/300';

                ProductImage::updateOrCreate(
                    ['product_id' => $product->id],
                    [
                        'image' => $imageUrl,
                        'is_thumbnail' => true,
                    ]
                );

                $totalProducts++;
            }
        }

        $this->command->info("🎉 Berhasil seeding {$totalProducts} produk!");
    }
}
