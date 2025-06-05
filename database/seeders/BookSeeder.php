<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use Faker\Factory;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        foreach (Category::all() as $category) {
            for ($i = 0; $i < 10; $i++) {
                Book::create([
                    'title' => ucfirst($faker->sentence(4)),
                    'author' => $faker->name(),
                    'published_at' => $faker->date(),
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
