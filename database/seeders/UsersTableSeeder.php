<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Admin
            [   
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'evangelos.ilias87@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'status' => 'active',
            ],
            // Vendor
            [
                'name' => 'vendor',
                'username' => 'vendor',
                'email' => 'vag.ilias87@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'vendor',
                'status' => 'active',
            ],
            // User or Customer
            [
                'name' => 'user',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'user',
                'status' => 'active', 
            ]
        ]);
    }
}
