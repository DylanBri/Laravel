<?php

namespace Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCategoryControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * Test de la fonction getList en SA
     */
    public function testViewgetListSupAdm()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/category/list');

        // Contrôle du résultat
        $response->assertStatus(200);
    }
}
