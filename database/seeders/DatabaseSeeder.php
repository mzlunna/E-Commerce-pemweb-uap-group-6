<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,              // 1. Create users (admin, buyers, sellers)
            ProductCategorySeeder::class,   // 2. Create categories
            StoreSeeder::class,             // 3. Create stores (verified)
            ProductSeeder::class,           // 4. Create products
        ]);
    }
}