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
        // Créer un utilisateur admin pour les tests
        User::firstOrCreate(
            ['email' => 'admin@test.fr'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Créer un utilisateur utilisateur normal pour les tests
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

