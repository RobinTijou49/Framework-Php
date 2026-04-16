<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@test.fr'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@test.fr'],
            [
                'name' => 'Utilisateur',
                'password' => bcrypt('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}

