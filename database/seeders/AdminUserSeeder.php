<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // condition
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345'),
                'phone_number' => '0123456789',
                'role' => 'admin',
            ]
        );
    }
}
