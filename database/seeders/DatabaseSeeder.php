<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
{
    \App\Models\User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('Admin123456'),
        'role' => 'admin',
        'email_verified_at' => now(),

    ]);
}
}
