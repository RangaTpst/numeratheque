<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création d'un utilisateur test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            //'role' => 'admin', // Optionnel si on veut qu'il soit admin directement
        ]);

        // Exécution des seeders personnalisés
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
            LoanSeeder::class,
        ]);
    }
}
