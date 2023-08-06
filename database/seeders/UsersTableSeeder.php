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
                'firstname' => 'admin',
                'lastname' => 'admin_admin',
                'username' => 'username_admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'status' => 'active',
            ],
            // Vendor
            [
                'firstname' => 'vendor',
                'lastname' => 'vendor_vendor',
                'username' => 'username_vendor',
                'email' => 'vendor@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'vendor',
                'status' => 'active',
            ],
            // User or Customer
            [
                'firstname' => 'user',
                'lastname' => 'user-user',
                'username' => 'username_user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'user',
                'status' => 'active', 
            ]
        ]);
    }
}
