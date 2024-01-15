<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'slug' => Str::slug('adminoukos-admin-adminoukos'),
        ]);

        User::factory()->create([
            'firstname' => 'mpgiouli',
            'email' => 'vendor1@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'vendor',
            'status' => 'active',
            'slug' => Str::slug('mpgiouli-mprouli-mpgiouli'),
        ]);

        User::factory()->create([
            'firstname' => 'nouli',
            'email' => 'vendor2@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'vendor',
            'status' => 'active',
            'slug' => Str::slug('nouli-noulako-nouli'),
        ]);

        User::factory()->create([
            'firstname' => 'zouli',
            'email' => 'vendor3@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'vendor',
            'status' => 'active',
            'slug' => Str::slug('zouli-zoulako-zouli'),
        ]);

        User::factory()->create([
            'firstname' => 'arlie',
            'email' => 'collier.janie@example.net',
            'password' => Hash::make('123'),
            'role' => 'vendor',
            'status' => 'active',
            'slug' => Str::slug('arlie-arlieno-arlie'),
        ]);

        User::factory()->create([
            'firstname' => 'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'role' => 'user',
            'status' => 'active',
            'slug' => Str::slug('user-newsure-user'),
        ]);
    }
}
