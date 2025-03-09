<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Category;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // Titre aléatoire
            'author' => $this->faker->name(), // Nom aléatoire
            'published_at' => $this->faker->date(), // Date aléatoire
            'category_id' => Category::factory(), // Génère automatiquement une catégorie
            'image' => $this->faker->imageUrl(), // URL aléatoire d’image
            'summary' => $this->faker->paragraph(), // Résumé aléatoire
        ];
    }
}
