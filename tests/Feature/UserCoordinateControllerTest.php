<?php

namespace Tests\Feature;

use App\Models\UserCoordinate;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCoordinateControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * SetUp Initiation des tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession(['clientId' => 1]);
    }

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
            ->get('/user/coordinate');

        // Contrôle du résultat
        $response->assertStatus(500);
    }

    /**
     * Test de la fonction index en Adm
     */
    public function testViewIndexAdmin()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(32);

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate');

        // Contrôle du résultat
        $response->assertStatus(500);
    }

    /**
     * Test de la fonction index en Mng
     */
    public function testViewIndexManager()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factoryManager(32);

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate');

        // Contrôle du résultat
        $response->assertStatus(500);
    }

    /**
     * Test de la fonction create en SA
     */
    public function testViewCreateSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/create');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction create en Adm
     */
    public function testViewCreateAdmin()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(33);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/create');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction create en Mng
     */
    public function testViewCreateManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(33);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/create');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction store en SA
     */
    public function testStoreSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => $user->getAuthIdentifier(),
                'category_id' => 1,
                'address' => '54 Chemin des Lilas',
                'enabled' => true,
                'suppressed' => false,
            ]);

        $response->assertSessionDoesntHaveErrors([
            'user_id',
            'category_id',
            'address',
            'enabled',
            'suppressed'
        ]);

        $this->assertDatabaseHas('user_coordinates', ['user_id' => $user->id]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction store error en SA
     */
    public function testStoreErrorSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => 'sdfghj',
                'category_id' => 'fghjk',
                'address' => '',
                'enabled' => true,
                'suppressed' => false,
            ]);
//        dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "user_id" => "Le champ user id doit contenir un nombre.",
            "category_id" => "Le champ category id doit contenir un nombre.",
            "address" => "Le champ adresse est obligatoire.",
        ]);
    }

    /**
     * Test de la fonction store en SA
     */
    public function testStoreCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => $user->getAuthIdentifier(),
                'category_id' => 1,
                'quality' => 'Monsieur',
                'address' => '54 Chemin des Lilas',
                'address2' => 'BP 1254',
                'zip_code' => '58762',
                'city' => 'Angouleme',
                'region' => 'Sud',
                'country' => 'France',
                'phone' => '0400000000',
                'mobile' => '0600000000',
                'enabled' => true,
                'suppressed' => false,
            ]);

        $response->assertSessionDoesntHaveErrors([
            'user_id',
            'category_id',
            'quality',
            'address',
            'address2',
            'zip_code',
            'city',
            'region',
            'country',
            'phone',
            'mobile',
            'enabled',
            'suppressed'
        ]);

        $this->assertDatabaseHas('user_coordinates', ['user_id' => $user->id]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction store error en SA
     */
    public function testStoreErrorCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => 'sdfghj',
                'category_id' => 'fghjk',
                'quality' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'address' => '',
                'address2' => '',
                'zip_code' => 'dfgh',
                'city' => '',
                'region' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'country' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'phone' => 'sdfghji',
                'mobile' => 'dfghjk',
                'enabled' => true,
                'suppressed' => false,
            ]);
//        dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "user_id" => "Le champ user id doit contenir un nombre.",
            "category_id" => "Le champ category id doit contenir un nombre.",
            "quality" => "Le texte de quality ne peut contenir plus de 50 caractères.",
            "address" => "Le champ adresse est obligatoire.",
            "zip_code" => "Le format du champ zip code est invalide.",
            "region" => "Le texte de region ne peut contenir plus de 50 caractères.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères.",
            "phone" => "Le format du champ téléphone est invalide.",
            "mobile" => "Le format du champ portable est invalide.",
        ]);
    }

    /**
     * Test de la fonction view en SA
     */
    public function testViewShowSupAdm()
    {
        $this->withoutMiddleware();
        $coordinate = UserCoordinate::query()->first();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/' . $coordinate->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction view en Adm
     */
    public function testViewShowAdmin()
    {
        $this->withoutMiddleware();
        $coordinate = UserCoordinate::query()->first();
        $user = $this->factoryAdmin(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/' . $coordinate->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction view en Mng
     */
    public function testViewShowManager()
    {
        $this->withoutMiddleware();
        $coordinate = UserCoordinate::query()->first();
        $user = $this->factoryManager(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/' . $coordinate->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en SA
     */
    public function testEditShowSupAdm()
    {
        $this->withoutMiddleware();
        $coordinate = UserCoordinate::query()->first();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/' . $coordinate->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en Adm
     */
    public function testEditShowAdmin()
    {
        $this->withoutMiddleware();
        $coordinate = UserCoordinate::query()->first();
        $user = $this->factoryAdmin(34);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/' . $coordinate->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en Mng
     */
    public function testEditShowManager()
    {
        $this->withoutMiddleware();
        $coordinate = UserCoordinate::query()->first();
        $user = $this->factoryManager(34);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/' . $coordinate->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction update en SA
     */
    public function testUpdateSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => $user->getAuthIdentifier(),
                'category_id' => 1,
                'address' => '54 Chemin des Lilas',
                'enabled' => true,
                'suppressed' => false,
            ]);

        $response->assertStatus(200);

        $coordinate = UserCoordinate::query()->where('user_id', $user->id)->first();

        $response = $this->actingAs($user)
            ->put('/user/coordinate/' . $coordinate->id, [
                'user_id' => $user->id,
                'category_id' => 2,
                'address' => '58 Chemin des Mimosas',
                'enabled' => false,
                'suppressed' => true,
            ]);
        //dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'category_id',
            'address',
            'enabled',
            'suppressed'
        ]);

        $this->assertDatabaseHas('user_coordinates', ['user_id' => $user->getAuthIdentifier()]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction update error en SA
     */
    public function testUpdateErrorSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => $user->getAuthIdentifier(),
                'category_id' => 1,
                'address' => '54 Chemin des Lilas',
                'enabled' => true,
                'suppressed' => false,
            ]);
        $response->assertStatus(200);

        $coordinate = UserCoordinate::query()->where('user_id', $user->id)->first();

        $response = $this->actingAs($user)
            ->put('/user/coordinate/' . $coordinate->id, [
                'user_id' => 'dfgh',
                'category_id' => 'fghjk',
                'address' => '',
                'enabled' => true,
                'suppressed' => false,
            ]);
        //dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "user_id" => "Le champ user id doit contenir un nombre.",
            "category_id" => "Le champ category id doit contenir un nombre.",
            "address" => "Le champ adresse est obligatoire.",
        ]);
    }

    /**
     * Test de la fonction update en SA
     */
    public function testUpdateCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => $user->getAuthIdentifier(),
                'category_id' => 1,
                'quality' => 'Monsieur',
                'address' => '54 Chemin des Lilas',
                'address2' => 'BP 1254',
                'zip_code' => '58762',
                'city' => 'Angouleme',
                'region' => 'Sud',
                'country' => 'France',
                'phone' => '0400000000',
                'mobile' => '0600000000',
                'enabled' => true,
                'suppressed' => false,
            ]);

        $response->assertStatus(200);

        $coordinate = UserCoordinate::query()->where('user_id', $user->id)->first();

        $response = $this->actingAs($user)
            ->put('/user/coordinate/' . $coordinate->id, [
                'user_id' => $user->id,
                'category_id' => 2,
                'quality' => 'Mademoiselle',
                'address' => '58 Chemin des Mimosas',
                'address2' => 'BP 584',
                'zip_code' => '68423',
                'city' => 'Strasbourg',
                'region' => 'Nord',
                'country' => 'Thaiti',
                'phone' => '0411111111',
                'mobile' => '0622222222',
                'enabled' => true,
                'suppressed' => false,
            ]);
        //dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'user_id',
            'category_id',
            'quality',
            'address',
            'address2',
            'zip_code',
            'city',
            'region',
            'country',
            'phone',
            'mobile',
            'enabled',
            'suppressed'
        ]);

        $this->assertDatabaseHas('user_coordinates', ['user_id' => $user->getAuthIdentifier()]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction update error en SA
     */
    public function testUpdateErrorCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => $user->getAuthIdentifier(),
                'category_id' => 1,
                'quality' => 'Monsieur',
                'address' => '54 Chemin des Lilas',
                'address2' => 'BP 1254',
                'zip_code' => '58762',
                'city' => 'Angouleme',
                'region' => 'Sud',
                'country' => 'France',
                'phone' => '0400000000',
                'mobile' => '0600000000',
                'enabled' => true,
                'suppressed' => false,
            ]);
        $response->assertStatus(200);

        $coordinate = UserCoordinate::query()->where('user_id', $user->id)->first();

        $response = $this->actingAs($user)
            ->put('/user/coordinate/' . $coordinate->id, [
                'user_id' => 'sdfghj',
                'category_id' => 'fghjk',
                'quality' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'address' => '',
                'address2' => '',
                'zip_code' => 'dfgh',
                'city' => '',
                'region' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'country' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'phone' => 'sdfghji',
                'mobile' => 'dfghjk',
                'enabled' => true,
                'suppressed' => false,
            ]);
        //dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "user_id" => "Le champ user id doit contenir un nombre.",
            "category_id" => "Le champ category id doit contenir un nombre.",
            "quality" => "Le texte de quality ne peut contenir plus de 50 caractères.",
            "address" => "Le champ adresse est obligatoire.",
            "zip_code" => "Le format du champ zip code est invalide.",
            "region" => "Le texte de region ne peut contenir plus de 50 caractères.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères.",
            "phone" => "Le format du champ téléphone est invalide.",
            "mobile" => "Le format du champ portable est invalide.",
        ]);
    }

    /**
     * Test de la fonction destroy en SA
     */
    public function testDestroySupAdm()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        // Ajout de la companie à supprimer 
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/user/coordinate', [
                'user_id' => $user->getAuthIdentifier(),
                'category_id' => 1,
                'address' => '54 Chemin des Lilas',
                'enabled' => true,
                'suppressed' => false,
            ]);

        $response->assertStatus(200);

        // Récuperation des coordinates créées
        $coordinate = UserCoordinate::query()->where('user_id', $user->getAuthIdentifier())->first();

        // Appel de la route à tester 
//        $response =
            $this->actingAs($user)
            ->delete('/user/coordinate/' . $coordinate->id);
        //dd($response->dumpSession());

        //$this->assertDatabaseHas('user_coordinates', ['user_id' => $user->id]);
        //$this->assertDatabaseMissing('user_coordinates', ['user_id' => $user->id]);
        $this->assertDeleted($coordinate);
    }

    /**
     * Test de la fonction destroy error en SA
     */
    public function testDestroyErrorSupAdm()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->delete('/user/coordinate/' . 0);

        $response->assertStatus(500);
        //dd($response->dumpSession());
        //$this->expectException(\Exception::class);
        //$this->expectExceptionMessage('Bad user coordinate id');
    }

    /**
     * Test de la fonction View showUserAuth en SA
     */
    public function testViewShowUserAuthSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/form');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction View showUserAuth en SA
     */
    public function testViewShowUserAuthAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/form');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction View showUserAuth en SA
     */
    public function testViewShowUserAuthManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/form');

        $response->assertStatus(200);
    }

    /**
     * Test de GetbyId en SA
     */
    public function testGetByIdSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/byId/1');
//        dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['user_id'], 1);
        $this->assertEquals($data['category_id'], 1);
        $this->assertEquals($data['address'], '51 Impasse Thomas Edison 1');
        $this->assertEquals($data['enabled'], true);
        $this->assertEquals($data['suppressed'], false);
    }

    /**
     * Test de GetbyId en Adm
     */
    public function testGetByIdAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(33);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/byId/1');
        //dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['user_id'], 1);
        $this->assertEquals($data['category_id'], 1);
        $this->assertEquals($data['address'], '51 Impasse Thomas Edison 1');
        $this->assertEquals($data['enabled'], true);
        $this->assertEquals($data['suppressed'], false);
    }

    /**
     * Test de GetbyId en Mng
     */
    public function testGetByIdManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(33);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/byId/1');
        //dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['user_id'], 1);
        $this->assertEquals($data['category_id'], 1);
        $this->assertEquals($data['address'], '51 Impasse Thomas Edison 1');
        $this->assertEquals($data['enabled'], true);
        $this->assertEquals($data['suppressed'], false);
    }

    /**
     * Test de la fonction autocomplete en supAdm
     */
    public function testGetAutocompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/coordinate/autocomplete?query=Madame');
//        dd($response->dumpSession());

        $data = $response->json();
//        dd($data);
        $this->assertEquals($data, [
            ["quality" => "Madame"]
        ]);
    }

}
