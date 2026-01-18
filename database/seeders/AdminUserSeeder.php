<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'Admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('Admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
