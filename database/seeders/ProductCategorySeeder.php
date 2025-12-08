<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Keripik',
                'slug' => 'keripik',
                'image' => '🍟',
                'tagline' => 'Berbagai macam keripik renyah',
                'description' => 'Keripik kentang, singkong, tempe, pisang, dan lainnya',
            ],
            [
                'name' => 'Biskuit',
                'slug' => 'biskuit',
                'image' => '🍪',
                'tagline' => 'Biskuit dan cookies favorit',
                'description' => 'Berbagai jenis biskuit manis, gurih, dan cookies premium',
            ],
            [
                'name' => 'Cokelat',
                'slug' => 'cokelat',
                'image' => '🍫',
                'tagline' => 'Cokelat premium untuk semua',
                'description' => 'Cokelat batangan, praline, truffle, dan wafer cokelat',
            ],
            [
                'name' => 'Permen',
                'slug' => 'permen',
                'image' => '🍬',
                'tagline' => 'Permen manis untuk Anda',
                'description' => 'Permen keras, lunak, permen karet, dan lollipop',
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'image' => '🥤',
                'tagline' => 'Minuman segar dan nikmat',
                'description' => 'Minuman kemasan, serbuk, teh, kopi, dan jus',
            ],
            [
                'name' => 'Makanan Instan',
                'slug' => 'makanan-instan',
                'image' => '🍜',
                'tagline' => 'Praktis dan lezat',
                'description' => 'Mie instan, sup instan, bubur, dan makanan siap saji',
            ],

            // ⭐ Tambahan baru ⭐
            [
                'name' => 'Roti & Pastry',
                'slug' => 'roti-pastry',
                'image' => '🥐',
                'tagline' => 'Soft bread & pastry lezat',
                'description' => 'Roti manis, roti sobek, croissant, pastry dan roti mini',
            ],
            [
                'name' => 'Kopi',
                'slug' => 'kopi',
                'image' => '☕',
                'tagline' => 'Kopi untuk hari-harimu',
                'description' => 'Kopi instan, kopi susu, dan minuman kopi praktis',
            ],
            [
                'name' => 'Teh',
                'slug' => 'teh',
                'image' => '🍵',
                'tagline' => 'Aneka teh segar',
                'description' => 'Teh celup, teh botol, dan berbagai varian rasa',
            ],
            [
                'name' => 'Minuman Soda',
                'slug' => 'minuman-soda',
                'image' => '🥤',
                'tagline' => 'Segar dan berkarbonasi',
                'description' => 'Cola, soda rasa buah, dan sparkling drink',
            ],
            [
                'name' => 'Air Mineral',
                'slug' => 'air-mineral',
                'image' => '💧',
                'tagline' => 'Segar dan menyehatkan',
                'description' => 'Air mineral kemasan kecil dan besar',
            ],
            [
                'name' => 'Susu',
                'slug' => 'susu',
                'image' => '🥛',
                'tagline' => 'Minuman sehat untuk semua',
                'description' => 'Susu UHT, susu cokelat, susu stroberi, dan bubuk susu',
            ],
            [
                'name' => 'Camilan Pedas',
                'slug' => 'camilan-pedas',
                'image' => '🌶',
                'tagline' => 'Pedas nikmat bikin nagih',
                'description' => 'Keripik pedas, makaroni pedas, dan snack rasa ekstra pedas',
            ],
            [
                'name' => 'Camilan Manis',
                'slug' => 'camilan-manis',
                'image' => '🍰',
                'tagline' => 'Manis yang memanjakan',
                'description' => 'Snack manis, wafer, dan kue kemasan',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}