<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::create([
            'name' => 'Admin SnackShop',
            'email' => 'admin@snackshop.com',
            'password' => \Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Buyer
        \App\Models\User::create([
            'name' => 'Test Buyer',
            'email' => 'buyer@test.com',
            'password' => \Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        // Seller
        $seller = \App\Models\User::create([
            'name' => 'Test Seller',
            'email' => 'seller@test.com',
            'password' => \Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        // Store
        $store = \App\Models\Store::create([
            'user_id' => $seller->id,
            'name' => 'Toko Snack Test',
            'description' => 'Toko snack terbaik',
            'address' => 'Jl. Test No. 123',
            'phone' => '08123456789',
            'status' => 'approved',
        ]);

        // Categories
        $categories = [
            ['name' => 'Biskuit', 'type' => 'bahan_utama'],
            ['name' => 'Keripik', 'type' => 'bahan_utama'],
            ['name' => 'Permen', 'type' => 'bahan_utama'],
        ];

        foreach ($categories as $cat) {
            \App\Models\ProductCategory::create($cat);
        }

        // Products
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Product::create([
                'store_id' => $store->id,
                'name' => 'Snack Product ' . $i,
                'description' => 'Deskripsi produk ' . $i,
                'price' => rand(10000, 50000),
                'stock' => rand(50, 200),
            ]);
        }
    }
}