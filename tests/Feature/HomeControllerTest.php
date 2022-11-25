<?php

namespace Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * Test de la fonction index en SA
     */
    public function testViewIndexSupAdm()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/');

        // Contrôle du résultat
        $response->assertStatus(200);
    }

    /**
     * Test de la fonction showDashboard en SA
     */
    public function testViewShowDashboardSupAdm()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/dashboard');

        // Contrôle du résultat
        $response->assertStatus(200);
    }

    /**
     * Test de la fonction translate en SA
     */
//    public function testViewTranslateSupAdm()
//    {
//        // Initialisation du test
//        $this->withoutMiddleware();
//        $user = $this->factorySupAdm();
//
//        // Appel de la route à tester
//        /** @var Authenticatable $user */
//        $response = $this->actingAs($user)
//            ->get('/translate');
//
//        // Contrôle du résultat
//        $response->assertStatus(200);
//    }
}
