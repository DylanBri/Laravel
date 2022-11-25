<?php

namespace Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionProfileControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * Test de la fonction getLogged en SA
     */
    public function testViewGetLoggedSupAdm()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/session/profile/logged');

        // Contrôle du résultat
        $response->assertStatus(200);
    }

    /**
     * Test de la fonction reset en SA
     */
    public function testViewResetSupAdm()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/session/reset');

        // Contrôle du résultat
        $response->assertStatus(200);
    }
}
