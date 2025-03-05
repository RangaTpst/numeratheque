<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            Category::create([
                'name' => ucfirst($faker->word()), // ex : "Aventure", "Historique"
            ]);
        }
    }
}
