<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Book;
use Illuminate\Validation\ValidationException;

class BookTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la BDD avant chaque test

    #[Test]
    public function a_book_with_all_valid_fields_can_be_created()
    {
        // Génère un livre valide avec une catégorie automatiquement
        $book = Book::factory()->create();

        // Vérifie que le livre a bien été ajouté en base
        $this->assertDatabaseHas('books', [
            'title' => $book->title,
            'author' => $book->author,
        ]);
    }

    #[Test]
    public function a_book_with_invalid_title_should_fail()
    {
        $this->expectException(ValidationException::class);

        Book::createBook([
            'title' => '123!!!', // Titre invalide
            'author' => 'Jane Doe',
            'published_at' => '2023-06-10',
            'category_id' => Book::factory()->create()->category_id, 
            'image' => 'https://example.com/book-cover.jpg',
            'summary' => 'Invalid title test.',
        ]);
    }

    #[Test]
    public function a_book_with_invalid_author_should_fail()
    {
        $this->expectException(ValidationException::class);

        Book::createBook([
            'title' => 'Valid Title',
            'author' => 'John123', // Auteur invalide (chiffres interdits)
            'published_at' => '2023-06-10',
            'category_id' => Book::factory()->create()->category_id, 
            'image' => 'https://example.com/book-cover.jpg',
            'summary' => 'Invalid author test.',
        ]);
    }

    #[Test]
    public function a_book_with_invalid_published_at_should_fail()
    {
        $this->expectException(ValidationException::class);

        Book::createBook([
            'title' => 'Valid Title',
            'author' => 'Jane Doe',
            'published_at' => '2050-01-01', // Date future interdite
            'category_id' => Book::factory()->create()->category_id, 
            'image' => 'https://example.com/book-cover.jpg',
            'summary' => 'Invalid published_at test.',
        ]);
    }

    #[Test]
    public function a_book_with_invalid_category_id_should_fail()
    {
        $this->expectException(ValidationException::class);

        Book::createBook([
            'title' => 'Valid Title',
            'author' => 'Jane Doe',
            'published_at' => '2023-06-10',
            'category_id' => 9999, // ID qui n'existe pas
            'image' => 'https://example.com/book-cover.jpg',
            'summary' => 'Invalid category_id test.',
        ]);
    }

    #[Test]
    public function a_book_with_invalid_image_url_should_fail()
    {
        $this->expectException(ValidationException::class);

        Book::createBook([
            'title' => 'Valid Title',
            'author' => 'Jane Doe',
            'published_at' => '2023-06-10',
            'category_id' => Book::factory()->create()->category_id, 
            'image' => 'invalid-url', // Mauvais format d'URL
            'summary' => 'Invalid image URL test.',
        ]);
    }

    #[Test]
    public function a_book_with_invalid_summary_should_fail()
    {
        $this->expectException(ValidationException::class);

        Book::createBook([
            'title' => 'Valid Title',
            'author' => 'Jane Doe',
            'published_at' => '2023-06-10',
            'category_id' => Book::factory()->create()->category_id, 
            'image' => 'https://example.com/book-cover.jpg',
            'summary' => str_repeat('Too long summary ', 100), // Trop long (>1000 caractères)
        ]);
    }
}
