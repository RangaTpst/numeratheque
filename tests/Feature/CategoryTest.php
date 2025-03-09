<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Category;
use Illuminate\Validation\ValidationException;

class CategoryTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la BDD avant chaque test

    #[Test]
    public function a_valid_category_can_be_created()
    {
        $data = ['name' => 'Fantasy'];

        $category = Category::createCategory($data);

        $this->assertDatabaseHas('categories', [
            'name' => 'Fantasy',
        ]);
    }

    #[Test]
    public function an_invalid_category_name_should_fail()
    {
        $this->expectException(ValidationException::class);

        Category::createCategory(['name' => 'Sci-Fi@123']); // Contient @ et chiffres interdits
    }

    #[Test]
    public function a_category_name_too_long_should_fail()
    {
        $this->expectException(ValidationException::class);

        Category::createCategory(['name' => str_repeat('A', 51)]); // Plus de 50 caractères
    }

    #[Test]
    public function a_category_name_cannot_be_empty()
    {
        $this->expectException(ValidationException::class);

        Category::createCategory(['name' => '']); // Nom vide
    }

    #[Test]
    public function a_category_name_with_special_characters_should_fail()
    {
        $this->expectException(ValidationException::class);

        Category::createCategory(['name' => 'Rock & Roll!']); // Caractères spéciaux interdits
    }
}
