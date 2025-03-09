<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Validation\ValidationException;

class LoanTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la BDD avant chaque test

    #[Test]
    public function a_valid_loan_can_be_created()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $data = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => now()->subDays(2),
            'return_date' => now()->addDays(5),
        ];

        $loan = Loan::createLoan($data);

        $this->assertDatabaseHas('loans', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    #[Test]
    public function a_loan_with_invalid_user_id_should_fail()
    {
        $this->expectException(ValidationException::class);

        $book = Book::factory()->create();

        Loan::createLoan([
            'user_id' => 9999, // ID qui n'existe pas
            'book_id' => $book->id,
            'loan_date' => now()->subDays(2),
            'return_date' => now()->addDays(5),
        ]);
    }

    #[Test]
    public function a_loan_with_invalid_book_id_should_fail()
    {
        $this->expectException(ValidationException::class);

        $user = User::factory()->create();

        Loan::createLoan([
            'user_id' => $user->id,
            'book_id' => 9999, // ID qui n'existe pas
            'loan_date' => now()->subDays(2),
            'return_date' => now()->addDays(5),
        ]);
    }

    #[Test]
    public function a_loan_with_a_future_loan_date_should_fail()
    {
        $this->expectException(ValidationException::class);

        $user = User::factory()->create();
        $book = Book::factory()->create();

        Loan::createLoan([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => now()->addDays(5), // Date future interdite
            'return_date' => now()->addDays(10),
        ]);
    }

    #[Test]
    public function a_loan_with_return_date_before_loan_date_should_fail()
    {
        $this->expectException(ValidationException::class);

        $user = User::factory()->create();
        $book = Book::factory()->create();

        Loan::createLoan([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => now()->subDays(2),
            'return_date' => now()->subDays(5), // Retour avant l’emprunt
        ]);
    }


    #[Test]
public function a_book_cannot_be_loaned_twice_without_being_returned()
{
    $this->expectException(ValidationException::class);

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $book = Book::factory()->create();

    // Premier prêt sans date de retour (le livre est emprunté)
    Loan::createLoan([
        'user_id' => $user1->id,
        'book_id' => $book->id,
        'loan_date' => now()->subDays(3),
        'return_date' => null, // Pas encore retourné
    ]);

    // Deuxième prêt du même livre par un autre utilisateur
    Loan::createLoan([
        'user_id' => $user2->id,
        'book_id' => $book->id,
        'loan_date' => now(),
        'return_date' => null,
    ]);
}

    
}
