<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'firstname' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
            'status' => 'active',
            ]);
        User::factory()->create([
            'firstname' => 'vendor_1',
            'email' => 'vendor1@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'vendor',
            'status' => 'active',
        ]);
        User::factory()->create([
            'firstname' => 'vendor_2',
            'email' => 'vendor2@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'vendor',
            'status' => 'active',
        ]);
        User::factory()->create([
            'firstname' => 'vendor_3',
            'email' => 'vendor3@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'vendor',
            'status' => 'active',
        ]);
        User::factory()->create([
            'firstname' => 'Arlie',
            'email' => 'collier.janie@example.net',
            'password' => Hash::make('123'),
            'role' => 'vendor',
            'status' => 'active',
        ]);
        User::factory()->create([
            'firstname' => 'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'role' => 'user',
            'status' => 'active',
        ]);
    }
}
