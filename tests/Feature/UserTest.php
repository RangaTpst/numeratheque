<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la BDD avant chaque test

    #[Test]
    public function a_valid_user_can_be_created()
    {
        $data = [
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => 'Test@1234',
        ];

        $user = User::createUser($data);

        $this->assertDatabaseHas('users', [
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
        ]);
    }

    #[Test]
    public function a_user_with_invalid_name_should_fail()
    {
        $this->expectException(ValidationException::class);

        User::createUser([
            'name' => 'Jean123', // Contient des chiffres interdits
            'email' => 'jean.dupont@example.com',
            'password' => 'Test@1234',
        ]);
    }

    #[Test]
    public function a_user_with_invalid_email_should_fail()
    {
        $this->expectException(ValidationException::class);

        User::createUser([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@', // Mauvais format d'email
            'password' => 'Test@1234',
        ]);
    }

    #[Test]
    public function a_user_with_a_weak_password_should_fail()
    {
        $this->expectException(ValidationException::class);

        User::createUser([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => 'azertyui', // Pas de majuscule, chiffre, ou caractère spécial
        ]);
    }

    #[Test]
    public function a_user_with_a_too_short_password_should_fail()
    {
        $this->expectException(ValidationException::class);

        User::createUser([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => 'T@1az', // Moins de 8 caractères
        ]);
    }

    #[Test]
    public function a_user_with_duplicate_email_should_fail()
    {
        if (!User::where('email', 'jean.dupont@example.com')->exists()) {
            User::factory()->create(['email' => 'jean.dupont@example.com']);
        }
        

        $this->expectException(ValidationException::class);

        User::createUser([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com', // Email déjà utilisé
            'password' => 'Test@1234',
        ]);
    }
}
