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
            'image' => $this->faker->imageUrl(), // URL aléatoire d’image
            'summary' => $this->faker->paragraph(), // Résumé aléatoire
        ];
    }

    /**
     * Associe aléatoirement des catégories au livre après création.
     */
    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            // Associe entre 1 et 3 catégories aléatoires
            $categories = Category::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $book->categories()->attach($categories);
        });
    }
}
