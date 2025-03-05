<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Faker\Factory;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        foreach (User::all() as $user) {
            Loan::create([
                'user_id' => $user->id,
                'book_id' => Book::inRandomOrder()->first()->id,
                'loan_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'return_date' => $faker->dateTimeBetween('now', '+1 month'),
            ]);
        }
    }
}
