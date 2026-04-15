<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\User;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::count() === 0 ? User::factory(5)->create() : User::all();

        Film::factory(25)
            ->create()
            ->each(function ($film) use ($users) {
                $film->locations()->createMany(
                    collect(range(1, rand(2, 5)))->map(fn() => [
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
