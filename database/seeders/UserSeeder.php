<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Buyer;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN (update jika sudah ada)
        User::updateOrCreate(
            ['email' => 'admin@elshop.com'], // unique column
            [
                'name' => 'Admin ELSHOP',
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_verified' => 1,
                'password' => Hash::make('password'),
            ]
        );

        // 2. BUYERS (updateOrCreate untuk aman)
        for ($i = 1; $i <= 3; $i++) {
            $user = User::updateOrCreate(
                ['email' => "buyer$i@test.com"],
                [
                    'name' => "Buyer $i",
                    'email_verified_at' => now(),
                    'role' => 'member',
                    'is_verified' => 1,
                    'password' => Hash::make('password'),
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
                    'email_verified_at' => now(),
                    'role' => 'member',
                    'is_verified' => 1,
                    'password' => Hash::make('password'),
                ]
            );
        }

        $this->command->info('✅ Users seeded: 1 Admin + 3 Buyers + 3 Sellers (SAFE MODE)');
    }
}
