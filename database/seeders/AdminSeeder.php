<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
    ['username' => 'admin'], // Gunakan username sebagai identifier
    [
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]
);
    }
}
