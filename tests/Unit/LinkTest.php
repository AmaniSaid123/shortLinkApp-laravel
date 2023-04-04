<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_shorten_link()
    {
        // Créer un utilisateur
        $user = User::factory()->create();

        // Se connecter en tant qu'utilisateur
        $this->actingAs($user);

        // Créer un lien raccourci
        $response = $this->post('/links', [
            'url' => 'https://www.example.com'
        ]);

        // Vérifier que le lien a été créé avec succès
        $response->assertRedirect('/links');
        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'url' => 'https://www.example.com'
        ]);
    }

    /** @test */
    public function test_registration()
    {
        // Créer un nouvel utilisateur avec des données de test
        $user = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        // Envoyer une requête POST à la route d'inscription
        $response = $this->post('/register', $user);

        // Vérifier que la réponse a un code de statut HTTP de 302 (redirection)
        $response->assertStatus(302);

        // Vérifier que l'utilisateur est redirigé vers la page de connexion
        $response->assertRedirect('/home');

        // Vérifier que l'utilisateur a bien été enregistré dans la base de données
        $this->assertDatabaseHas('users', ['email' => $user['email']]);
    }
    /** @test */
    public function test_user_can_delete_own_link()
    {
        // Créer un utilisateur avec des données de test

        $user = User::factory()->create();

        // Créer un lien pour l'utilisateur
        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);


        // Authentifier l'utilisateur
        $this->actingAs($user);

        // Envoyer une requête DELETE à la route de suppression du lien
        $response = $this->delete(route('links.destroy', $link->id));

        // Vérifier que la réponse a un code de statut HTTP de 302 (redirection)
        $response->assertStatus(302);

        // Vérifier que l'utilisateur est redirigé vers la page de liens
        $response->assertRedirect(route('links.index'));

        // Vérifier que le lien n'existe plus dans la base de données
        $this->assertDatabaseMissing('links', [
            'id' => $link->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function test_user_can_create_up_to_5_links()
    {
        // Créer un utilisateur avec des données de test
        $user = User::factory()->create();

        // Authentifier l'utilisateur
        $this->actingAs($user);

        // Créer 5 liens pour l'utilisateur
        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);


        // Essayer de créer un sixième lien pour l'utilisateur
        $linkData = [
            'url' => 'https://example.com/sixth-link',
            'short_url' => Str::random(6),
        ];
        $response = $this->post(route('links.store'), $linkData);

        // Vérifier que la réponse a un code de statut HTTP de 302 (redirection)
        $response->assertStatus(302);

        // Vérifier que l'utilisateur est redirigé vers la page de liens
        $response->assertRedirect(route('links.index'));

        // Vérifier que le lien n'a pas été créé dans la base de données
        $this->assertDatabaseMissing('links', [
            'short_url' => Str::random(6),
            'expires_at' => now()->addDay(),
            'url' => $linkData['url'],
            'user_id' => $user->id
        ]);
    }
}
