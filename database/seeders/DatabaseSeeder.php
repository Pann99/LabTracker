<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@labtracker.com'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@labtracker.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // Akun User biasa (contoh)
        User::updateOrCreate(
            ['email' => 'user@labtracker.com'],
            [
                'name'     => 'User Biasa',
                'email'    => 'user@labtracker.com',
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]
        );
    }
}