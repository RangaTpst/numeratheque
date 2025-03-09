<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function an_admin_can_access_admin_dashboard()
    {
        // Créer un utilisateur admin
        $admin = User::factory()->admin()->create();

        // Authentifier l'admin et essayer d'accéder à la page /admin
        $response = $this->actingAs($admin)->get('/admin');

        // Vérifier l'accès avec un status 200 (OK)
        $response->assertStatus(200);
    }

    #[Test]
    public function a_non_admin_user_cannot_access_admin_dashboard()
    {
        // Créer un utilisateur normal (adherent)
        $user = User::factory()->adherent()->create();

        // Authentifier l'utilisateur normal et essayer d'accéder à /admin
        $response = $this->actingAs($user)->get('/admin');

        // Vérifier qu'il reçoit une erreur 403 (Access Denied)
        $response->assertStatus(403);
    }

    #[Test]
public function a_guest_cannot_access_admin_dashboard()
{
    // Essayer d'accéder à la page admin sans être authentifié
    $response = $this->get('/admin');

    // Vérifier que l'invité est redirigé vers la page de connexion
    $response->assertRedirect('/login');
}

    

}
