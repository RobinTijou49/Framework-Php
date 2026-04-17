<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();
        $users = User::where('is_admin', false)->get();

        if (! $admin || $users->isEmpty()) {
            return;
        }

        Film::factory(25)
            ->create(['user_id' => $admin->id])
            ->each(function ($film) use ($users) {
                $film->locations()->createMany(
                    collect(range(1, rand(2, 5)))->map(fn () => [
                        'user_id' => $users->random()->id,
                        'name' => fake()->word(),
                        'city' => fake()->city(),
                        'country' => fake()->country(),
                        'description' => fake()->paragraph(),
                        'upvotes_count' => 0,
                    ])->toArray()
                );
            });
    }
}
