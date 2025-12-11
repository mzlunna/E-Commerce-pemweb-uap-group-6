<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Buyer;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
=======
>>>>>>> origin/main

class UserSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        // Cek apakah admin sudah ada
        $admin = User::where('email', 'admin@elshop.com')->first();
        if (!$admin) {
            User::create([
                'name' => 'Admin ELSHOP',
                'email' => 'admin@elshop.com',
=======
        // 1. ADMIN (update jika sudah ada)
        User::updateOrCreate(
            ['email' => 'admin@elshop.com'], // unique column
            [
                'name' => 'Admin ELSHOP',
>>>>>>> origin/main
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_verified' => 1,
                'password' => Hash::make('password'),
<<<<<<< HEAD
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
=======
            ]
        );

        // 2. BUYERS (updateOrCreate untuk aman)
        for ($i = 1; $i <= 3; $i++) {
            $user = User::updateOrCreate(
                ['email' => "buyer$i@test.com"],
                [
                    'name' => "Buyer $i",
>>>>>>> origin/main
                    'email_verified_at' => now(),
                    'role' => 'member',
                    'is_verified' => 1,
                    'password' => Hash::make('password'),
<<<<<<< HEAD
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
=======
                ]
            );

            Buyer::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'profile_picture' => null,
                    'phone_number' => '0812345678' . $i,
                ]
            );
        }

        // 3. SELLERS (aman dari duplicate)
        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => "seller$i@test.com"],
                [
                    'name' => "Seller $i",
>>>>>>> origin/main
                    'email_verified_at' => now(),
                    'role' => 'member',
                    'is_verified' => 1,
                    'password' => Hash::make('password'),
<<<<<<< HEAD
                ]);
            }
        }
    }
}
=======
                ]
            );
        }

        $this->command->info('✅ Users seeded: 1 Admin + 3 Buyers + 3 Sellers (SAFE MODE)');
    }
}
>>>>>>> origin/main
