<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin Account',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
        ]);
    }
}
