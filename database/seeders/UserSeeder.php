<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mandiri.com',
            'password' => Hash::make('buddies123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pipin',
            'email' => 'pipin@mandiri.com',
            'password' => Hash::make('pipinmandiri123'),
            'role' => 'implementor',
        ]);

        User::create([
            'name' => 'Adit',
            'email' => 'adit@mandiri.com',
            'password' => Hash::make('aditmandiri123'),
            'role' => 'implementor',
        ]);

        User::create([
            'name' => 'Nabhyla',
            'email' => 'nabhyla@mandiri.com',
            'password' => Hash::make('nabhyla123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Nabillah',
            'email' => 'nabillah@mandiri.com',
            'password' => Hash::make('nabillahmandiri123'),
            'role' => 'admin',
        ]);
    }
}