<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GeneralUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user01@gmail.com'], // condition
            [
                'name' => 'General User 01',
                'password' => Hash::make('12345'),
                'phone_number' => '0123456781',
                'role' => 'user',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user02@gmail.com'], // condition
            [
                'name' => 'General User 02',
                'password' => Hash::make('12345'),
                'phone_number' => '0123456780',
                'role' => 'user',
            ]
        );
    }
}
