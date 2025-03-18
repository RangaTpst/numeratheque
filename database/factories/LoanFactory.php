<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition()
    {
        return [
            'book_id' => Book::factory(),
            'user_id' => User::factory(),
            'loan_date' => Carbon::now(), // Ajout d'une date d'emprunt par défaut
            'return_date' => null, // Le livre est actuellement emprunté
        ];
    }
}
