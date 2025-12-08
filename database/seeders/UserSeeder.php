<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Buyer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $admin = User::where('email', 'admin@elshop.com')->first();
        if (!$admin) {
            User::create([
                'name' => 'Admin ELSHOP',
                'email' => 'admin@elshop.com',
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_verified' => 1,
                'password' => Hash::make('password'),
            ]);
        }

        // Membuat 3 Member / Buyers
        for ($i = 1; $i <= 3; $i++) {
            $email = "buyer$i@test.com";
            $user = User::where('email', $email)->first();
            
            // Cek apakah user sudah ada
            if (!$user) {
                $user = User::create([
                    'name' => "Buyer $i",
                    'email' => $email,
                    'email_verified_at' => now(),
                    'role' => 'member',
                    'is_verified' => 1,
                    'password' => Hash::make('password'),
                ]);
            }

            // Membuat profil buyer
            Buyer::create([
                'user_id' => $user->id,
                'profile_picture' => null,
                'phone_number' => '0812345678' . $i,
            ]);
        }

        // Membuat 3 Member / Sellers
        for ($i = 1; $i <= 3; $i++) {
            $email = "seller$i@test.com";
            // Cek apakah seller sudah ada
            if (!User::where('email', $email)->exists()) {
                User::create([
                    'name' => "Seller $i",
                    'email' => $email,
                    'email_verified_at' => now(),
                    'role' => 'member',
                    'is_verified' => 1,
                    'password' => Hash::make('password'),
                ]);
            }
        }
    }
}