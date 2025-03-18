<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_a_book_without_loans()
    {
        // Création d'un livre sans prêt
        $book = Book::factory()->create();

        // Création d'un utilisateur admin
        $admin = User::factory()->create(['role' => 'admin']);

        // Suppression du livre par un admin
        $response = $this->actingAs($admin)->delete(route('books.destroy', $book->id));

        // Vérifier que le livre est bien supprimé
        $response->assertRedirect(route('books.index'))
                 ->assertSessionHas('success', 'Livre supprimé avec succès.');

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_admin_cannot_delete_a_book_with_active_loans()
    {
        // Création d'un livre
        $book = Book::factory()->create();

        // Ajout d'un emprunt actif (sans return_date)
        Loan::factory()->create([
            'book_id' => $book->id,
            'return_date' => null, // Prêt toujours actif
        ]);

        // Création d'un utilisateur admin
        $admin = User::factory()->create(['role' => 'admin']);

        // Tenter de supprimer le livre
        $response = $this->actingAs($admin)->delete(route('books.destroy', $book->id));

        // Vérifier que la suppression est bloquée
        $response->assertRedirect(route('books.index'))
                 ->assertSessionHasErrors(['error' => 'Ce livre est actuellement emprunté et ne peut pas être supprimé.']);

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    public function test_non_admin_cannot_delete_a_book()
    {
        // Création d'un livre
        $book = Book::factory()->create();

        // Création d'un utilisateur standard
        $user = User::factory()->create(['role' => 'adherent']);

        // Tenter de supprimer le livre
        $response = $this->actingAs($user)->delete(route('books.destroy', $book->id));

        // Vérifier que l'accès est interdit
        $response->assertStatus(403);

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}
