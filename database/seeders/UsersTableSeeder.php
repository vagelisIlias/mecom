<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'vendor_shop_name' => '',
                'job_title' => 'admin_job_title',
                'phone' => '',
                'address' => '',
                'postcode' => '',
                'vendor_join' => '',
                'vendor_short_info' => '',
                'role' => 'admin',
                'status' => 'active',
                'remember_token' => Str::random(10),
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            // Vendors
            [
                'firstname' => 'vendor_1',
                'lastname' => 'vendor_1',
                'username' => 'glukoulis_vendor_1',
                'email' => 'vendor1@gmail.com',
                'password' => Hash::make('123'),
                'vendor_shop_name' => 'tavernaki',
                'job_title' => 'Chef',
                'phone' => '1234567890',
                'address' => '123 Street, City',
                'postcode' => '12345',
                'vendor_join' => now(),
                'vendor_short_info' => 'This is a popular restaurant serving delicious dishes.',
                'role' => 'vendor',
                'status' => 'active',
                'remember_token' => Str::random(10),
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'firstname' => 'vendor_2',
                'lastname' => 'vendor_2',
                'username' => 'apithanos_vendor_2',
                'email' => 'vendor2@gmail.com',
                'password' => Hash::make('123'),
                'vendor_shop_name' => 'plateia',
                'job_title' => 'Manager',
                'phone' => '9876543210',
                'address' => '456 Avenue, Town',
                'postcode' => '54321',
                'vendor_join' => now(),
                'vendor_short_info' => 'A wonderful place for gatherings and events.',
                'role' => 'vendor',
                'status' => 'active',
                'remember_token' => Str::random(10),
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'firstname' => 'vendor_3',
                'lastname' => 'vendor_3',
                'username' => 'leventis_vendor_3',
                'email' => 'vendor3@gmail.com',
                'password' => Hash::make('123'),
                'vendor_shop_name' => 'glarokavlos',
                'job_title' => 'Baker',
                'phone' => '5551234567',
                'address' => '789 Boulevard, Village',
                'postcode' => '67890',
                'vendor_join' => now(),
                'vendor_short_info' => 'A bakery providing fresh and delicious treats.',
                'role' => 'vendor',
                'status' => 'active',
                'remember_token' => Str::random(10),
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'firstname' => 'Arlie',
                'lastname' => 'Stiedemann',
                'username' => 'holden.altenwerth',
                'email' => 'collier.janie@example.net',
                'password' => Hash::make('123'),
                'vendor_shop_name' => 'To mikro kima',
                'job_title' => 'Manager',
                'phone' => '+1.346.521.2876',
                'address' => '72984 Lebsack Stream Lake Gracie, MT 83916-1927',
                'postcode' => '67890',
                'vendor_join' => now(),
                'vendor_short_info' => 'A taveranki providing fresh meats.',
                'role' => 'vendor',
                'status' => 'active',
                'remember_token' => Str::random(10),
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            // User or Customer`
            [
                'firstname' => 'user',
                'lastname' => 'user-user',
                'username' => 'username_user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('123'),
                'vendor_shop_name' => '',
                'job_title' => 'user_job_title',
                'phone' => '',
                'address' => '',
                'postcode' => '',
                'vendor_join' => '',
                'vendor_short_info' => '',
                'role' => 'user',
                'status' => 'active',
                'remember_token' => Str::random(10),
                'created_at' => now(), 
                'updated_at' => now(), 
            ]
        ]);
    }
}
