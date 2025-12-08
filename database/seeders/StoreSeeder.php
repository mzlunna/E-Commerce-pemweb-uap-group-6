<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\StoreBalance;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // Get seller users (id 5, 6, 7 dari UserSeeder)
        $sellerIds = [5, 6, 7];
        
        $stores = [
            [
                'user_id' => 5,
                'name' => 'Snack House',
                'logo' => 'stores/default-logo.png',
                'about' => 'Toko snack terlengkap dengan berbagai pilihan keripik, biskuit, dan cokelat berkualitas. Kami menyediakan snack lokal dan import dengan harga terjangkau.',
                'phone' => '081234567890',
                'address_id' => 'malang_001',
                'city' => 'Malang',
                'address' => 'Jl. Soekarno Hatta No. 123, Malang',
                'postal_code' => '65141',
                'is_verified' => 1,
            ],
            [
                'user_id' => 6,
                'name' => 'Delicious Corner',
                'logo' => 'stores/default-logo.png',
                'about' => 'Menyediakan berbagai macam snack premium dan makanan ringan berkualitas tinggi. Spesialis cokelat import dan cookies homemade.',
                'phone' => '081234567891',
                'address_id' => 'malang_002',
                'city' => 'Malang',
                'address' => 'Jl. Veteran No. 456, Malang',
                'postal_code' => '65145',
                'is_verified' => 1,
            ],
            [
                'user_id' => 7,
                'name' => 'Cemilan Nusantara',
                'logo' => 'stores/default-logo.png',
                'about' => 'Pusat jajanan dan cemilan tradisional Indonesia. Kami bangga menyajikan snack khas Nusantara dengan cita rasa autentik dan kemasan modern.',
                'phone' => '081234567892',
                'address_id' => 'malang_003',
                'city' => 'Malang',
                'address' => 'Jl. Ijen No. 789, Malang',
                'postal_code' => '65119',
                'is_verified' => 1,
            ],
        ];

        foreach ($stores as $storeData) {
            $store = Store::create($storeData);
            
            // Create store balance
            StoreBalance::create([
                'store_id' => $store->id,
                'balance' => 0,
            ]);
        }
    }
}