<?php

namespace Modules\Profile\Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Profile\Entities\Manager;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerControllerTest extends TestCase
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
            ->get('/manager');

        // Contrôle du résultat
        $response->assertStatus(200);
    }

    /**
     * Test de la fonction index en Admin
     */
    public function testViewIndexAdmin()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(29);

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager');

        // Contrôle du résultat
        $response->assertStatus(200);
    }

    /**
     * Test de la fonction index en Manager
     */
    public function testViewIndexManager()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factoryManager(29);

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager');

        // Contrôle du résultat
        $response->assertStatus(200);
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
            ->get('/manager/create');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction create en Admin
     */
    public function testViewCreateAdmin()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(30);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/create');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction create en Manager
     */
    public function testViewCreateManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(30);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/create');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction store en SA
     */
    public function testStoreSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user **/
        $response = $this->actingAs($user)
            ->post('/manager', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'name' => 'Manager 1',
                'email' => 'contact_mng1@test.com',
                'password' => 'contact_mng1@test.com',
                'address' => '36 Rue de Londres',
                'country' => 'France',
                'enabled' => true,
                'suppressed' => false
            ]);
//        dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'holding_id',
            'company_id',
            'office_id',
            'name',
            'email',
            'password',
            'address',
            'country',
            'enabled',
            'suppressed'
        ]);

        $this->assertDatabaseHas('users', ['name' => 'Manager 1']);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction store complete en SA
     */
    public function testStoreCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user **/
        $response = $this->actingAs($user)
            ->post('/manager', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'user_id' => 1,
                'category_id' => 3,
                'quality' => 'Monsieur',
                'name' => 'Manager 2',
                'email' => 'contact_mng2@test.com',
                'password' => 'contact_mng2@test.com',
                'address' => '36 Rue de Londres',
                'address2' => 'ZI Lac',
                'zip_code' => '45789',
                'city' => 'Lyon',
                'region' => 'Isere',
                'country' => 'France',
                'phone' => '0400000000',
                'mobile' => '0600000000',
                'enabled' => true,
                'suppressed' => false
            ]);
        //dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'holding_id',
            'company_id',
            'office_id',
            'user_id',
            'category_id',
            'quality',
            'name',
            'email',
            'password',
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

        $this->assertDatabaseHas('users', ['name' => 'Manager 2']);
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
            ->post('/manager', [
                'holding_id' => 'ert',
                'company_id' => 'dfg',
                'office_id' => 'bxc',
                'name' => '',
                'email' => 1,
                'password' => '',
                'address' => '',
                'country' => 'qsdfghjklmazertyuiopwxcvbnazertyuioqsdfghjklwxcvboiuytrezalkjhgfdsnbvcxwgfdretsdgtgdfggdrtgdgtdw',
                'enabled' => true,
                'suppressed' => false
            ]);
//        dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "holding_id" => "Le champ holding id doit être un entier.",
            "company_id" => "Le champ company id doit être un entier.",
            "office_id" => "Le champ office id doit être un entier.",
            "name" => "Le champ nom est obligatoire.",
            "email" => "Le champ adresse email doit être une adresse email valide.",
            "address" => "Le champ adresse est obligatoire.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères."
        ]);
    }

    /**
     * Test de la fonction store error complete en SA
     */
    public function testStoreErrorCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/manager', [
                'holding_id' => 'ert',
                'company_id' => 'dfg',
                'office_id' => 'bxc',
                'user_id' => 'sdf',
                'category_id' => 'sdfg',
                'quality' => 'qsdfghjklmazertyuiopwxcvbnazertyuioqsdfghjklwxcvboiuytrezalkjhgfdsnbvcxwgfdretsdgtgdfggdrtgdgtdw',
                'name' => '',
                'email' => 1,
                'password' => '',
                'address' => '',
                'address2' => '',
                'zip_code' => 'qsdfghj',
                'city' => '',
                'region' => '',
                'country' => 'qsdfghjklmazertyuiopwxcvbnazertyuioqsdfghjklwxcvboiuytrezalkjhgfdsnbvcxwgfdretsdgtgdfggdrtgdgtdw',
                'phone' => 'azertyui',
                'mobile' => 'qsdfghj',
                'enabled' => true,
                'suppressed' => false
            ]);
//        dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "holding_id" => "Le champ holding id doit être un entier.",
            "company_id" => "Le champ company id doit être un entier.",
            "office_id" => "Le champ office id doit être un entier.",
            "user_id" => "Le champ user id doit être un entier.",
            "category_id" => "Le champ category id doit être un entier.",
            "name" => "Le champ nom est obligatoire.",
            "quality" => "Le texte de quality ne peut contenir plus de 50 caractères.",
            "email" => "Le champ adresse email doit être une adresse email valide.",
            "address" => "Le champ adresse est obligatoire.",
            "zip_code" => "Le format du champ zip code est invalide.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères.",
            "phone" => "Le format du champ téléphone est invalide.",
            "mobile" => "Le format du champ portable est invalide."
        ]);
    }

    /**
     * Test de la fonction view en SA
     */
    public function testViewShowSupAdm()
    {
        $this->withoutMiddleware();
        $manager = Manager::query()->first();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/' . $manager->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction view en Admin
     */
    public function testViewShowAdmin()
    {
        $this->withoutMiddleware();
        $manager = Manager::query()->first();
        $user = $this->factoryAdmin(29);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/' . $manager->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction view en Manager
     */
    public function testViewShowManager()
    {
        $this->withoutMiddleware();
        $manager = Manager::query()->first();
        $user = $this->factoryManager(29);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/' . $manager->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en SA
     */
    public function testEditSupAdm()
    {
        $this->withoutMiddleware();
        $manager = Manager::query()->first();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/' . $manager->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en Admin
     */
    public function testEditAdmin()
    {
        $this->withoutMiddleware();
        $manager = Manager::query()->first();
        $user = $this->factoryAdmin(31);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/' . $manager->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en Manager
     */
    public function testEditManager()
    {
        $this->withoutMiddleware();
        $manager = Manager::query()->first();
        $user = $this->factoryManager(31);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/' . $manager->id . '/edit');

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
            ->post('/manager', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'name' => 'Manager num 1',
                'email' => 'contact_mng_num1@test.com',
                'password' => 'contact_mng1@test.com',
                'address' => '36 Rue de Londres',
                'country' => 'France',
                'enabled' => true,
                'suppressed' => false
            ]);
        $response->assertStatus(200);

        $manager = Manager::query()->where('name', 'Manager num 1')->first();

        $response = $this->actingAs($user)
            ->put('/manager/' . $manager->user_id, [
                'holding_id' => 2,
                'company_id' => 7,
                'office_id' => 5,
                'name' => 'Manager num 2',
                'email' => 'contact_mng_num2@test.com',
                'password' => 'contact_mng_num1@test.com',
                'address' => '36 Rue de Madrid',
                'country' => 'Espagne',
                'enabled' => false,
                'suppressed' => true
            ]);
//        dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'holding_id',
            'company_id',
            'office_id',
            'name',
            'email',
            'password',
            'address',
            'country',
            'enabled',
            'suppressed'
        ]);

//        $this->assertDatabaseHas('users', ['name' => 'Manager num 1']);
        $this->assertDatabaseHas('users', ['name' => 'Manager num 2']);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction update complete en SA
     */
    public function testUpdateCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/manager', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'user_id' => 1,
                'category_id' => 3,
                'quality' => 'Monsieur',
                'name' => 'Manager num 3',
                'email' => 'contact_mng_num3@test.com',
                'password' => 'contact_mng_num3@test.com',
                'address' => '36 Rue de Londres',
                'address2' => 'ZI Lac',
                'zip_code' => '45789',
                'city' => 'Lyon',
                'region' => 'Isere',
                'country' => 'France',
                'phone' => '0400000000',
                'mobile' => '0600000000',
                'enabled' => true,
                'suppressed' => false
            ]);
        $response->assertStatus(200);

        $manager = Manager::query()->where('name', 'Manager num 3')->first();

        $response = $this->actingAs($user)
            ->put('/manager/' . $manager->user_id, [
                'holding_id' => 2,
                'company_id' => 7,
                'office_id' => 6,
                'user_id' => 2,
                'category_id' => 4,
                'quality' => 'Mademoiselle',
                'name' => 'Manager num 4',
                'email' => 'contact_mng_num4@test.com',
                'password' => 'contact_mng_num4@test.com',
                'address' => '36 Rue de Madrid',
                'address2' => 'ZI Lac 2',
                'zip_code' => '78456',
                'city' => 'Lilles',
                'region' => 'Nord',
                'country' => 'Suede',
                'phone' => '0411111111',
                'mobile' => '0622222222',
                'enabled' => false,
                'suppressed' => true
            ]);
//        dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'holding_id',
            'company_id',
            'office_id',
            'user_id',
            'category_id',
            'quality',
            'name',
            'email',
            'password',
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

//        $this->assertDatabaseHas('users', ['name' => 'Manager num 3']);
        $this->assertDatabaseHas('users', ['name' => 'Manager num 4']);
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
            ->post('/manager', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'name' => 'Manager 1',
                'email' => 'contact_mng1@test.com',
                'password' => 'contact_mng1@test.com',
                'address' => '36 Rue de Londres',
                'country' => 'France',
                'enabled' => true,
                'suppressed' => false
            ]);
        $response->assertStatus(200);

        $manager = Manager::query()->where('name', 'Manager 1')->first();

        $response = $this->actingAs($user)
            ->put('/manager/' . $manager->user_id, [
                'holding_id' => 'ert',
                'company_id' => 'dfg',
                'office_id' => 'bxc',
                'name' => '',
                'email' => 1,
                'password' => '',
                'address' => '',
                'country' => 'qsdfghjklmazertyuiopwxcvbnazertyuioqsdfghjklwxcvboiuytrezalkjhgfdsnbvcxwgfdretsdgtgdfggdrtgdgtdw',
                'enabled' => true,
                'suppressed' => false
            ]);
        //dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "holding_id" => "Le champ holding id doit être un entier.",
            "company_id" => "Le champ company id doit être un entier.",
            "office_id" => "Le champ office id doit être un entier.",
            "name" => "Le champ nom est obligatoire.",
            "email" => "Le champ adresse email doit être une adresse email valide.",
            "address" => "Le champ adresse est obligatoire.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères."
        ]);
    }

    /**
     * Test de la fonction update error en SA
     */
    public function testUpdateCompleteErrorSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/manager', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'user_id' => 1,
                'category_id' => 3,
                'quality' => 'Monsieur',
                'name' => 'Manager 2',
                'email' => 'contact_mng2@test.com',
                'password' => 'contact_mng2@test.com',
                'address' => '36 Rue de Londres',
                'address2' => 'ZI Lac',
                'zip_code' => '45789',
                'city' => 'Lyon',
                'region' => 'Isere',
                'country' => 'France',
                'phone' => '0400000000',
                'mobile' => '0600000000',
                'enabled' => true,
                'suppressed' => false
            ]);
        $response->assertStatus(200);

        $manager = Manager::query()->where('name', 'Manager 2')->first();

        $response = $this->actingAs($user)
            ->put('/manager/' . $manager->user_id, [
                'holding_id' => 'ert',
                'company_id' => 'dfg',
                'office_id' => 'bxc',
                'user_id' => 'sdf',
                'category_id' => 'sdfg',
                'quality' => 'qsdfghjklmazertyuiopwxcvbnazertyuioqsdfghjklwxcvboiuytrezalkjhgfdsnbvcxwgfdretsdgtgdfggdrtgdgtdw',
                'name' => '',
                'email' => 1,
                'password' => '',
                'address' => '',
                'address2' => '',
                'zip_code' => 'qsdfghj',
                'city' => '',
                'region' => '',
                'country' => 'qsdfghjklmazertyuiopwxcvbnazertyuioqsdfghjklwxcvboiuytrezalkjhgfdsnbvcxwgfdretsdgtgdfggdrtgdgtdw',
                'phone' => 'azertyui',
                'mobile' => 'qsdfghj',
                'enabled' => true,
                'suppressed' => false
            ]);
        //dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "holding_id" => "Le champ holding id doit être un entier.",
            "company_id" => "Le champ company id doit être un entier.",
            "office_id" => "Le champ office id doit être un entier.",
            "user_id" => "Le champ user id doit être un entier.",
            "category_id" => "Le champ category id doit être un entier.",
            "name" => "Le champ nom est obligatoire.",
            "quality" => "Le texte de quality ne peut contenir plus de 50 caractères.",
            "email" => "Le champ adresse email doit être une adresse email valide.",
            "address" => "Le champ adresse est obligatoire.",
            "zip_code" => "Le format du champ zip code est invalide.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères.",
            "phone" => "Le format du champ téléphone est invalide.",
            "mobile" => "Le format du champ portable est invalide."
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
            ->post('/manager', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'name' => 'Manager 10',
                'email' => 'contact_mng10@test.com',
                'password' => 'contact_mng1@test.com',
                'address' => '36 Rue de Londres',
                'country' => 'France',
                'enabled' => true,
                'suppressed' => false
            ]);
        $response->assertStatus(200);

        // Récuperation de la companie créée
        $manager = Manager::query()->where('name', 'Manager 10')->first();

        // Appel de la route à tester
//        $response =
        $this->actingAs($user)
            ->delete('/manager/' . $manager->user_id);
        //dd($response->dumpSession());

        //$this->assertDatabaseHas('users', ['name' => 'Manager 10']);
        $this->assertDatabaseMissing('users', ['name' => 'Manager 10']);
        $this->assertDeleted($manager);
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
            ->delete('/manager/' . 0);

        $response->assertStatus(500);
        //dd($response->dumpSession());
        //$this->expectException(\Exception::class);
        //$this->expectExceptionMessage('Bad company id');
    }

    /**
     * Test de la fonction showDashboard en SA
     */
    public function testShowDashboardSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction showDashboard en Admin
     */
    public function testShowDashboardAdmin()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(29);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction showDashboard en Manager
     */
    public function testShowDashboardManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(29);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test de GetById en SA
     */
    public function testGetByIdSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/byId/3');
//        dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['name'], 'MERINDOL Cécilia Manager');
        $this->assertEquals($data['email'], 'manager@test.com');
        $this->assertEquals($data['category_id'], 3);
        $this->assertEquals($data['client_id'], 1);
        $this->assertEquals($data['role_id'], 3);
        $this->assertEquals($data['holding_id'], 4);
        $this->assertEquals($data['company_id'], 1);
        $this->assertEquals($data['office_id'], 1);
        $this->assertEquals($data['quality'], null);
        $this->assertEquals($data['address'], "51 Impasse Thomas Edison 1");
        $this->assertEquals($data['address2'], null);
        $this->assertEquals($data['zip_code'], "83600");
        $this->assertEquals($data['city'], "Fréjus");
        $this->assertEquals($data['region'], "PACA");
        $this->assertEquals($data['country'], "France");
        $this->assertEquals($data['phone'], "0494457479");
        $this->assertEquals($data['mobile'], null);
        $this->assertEquals($data['enabled'], true);
        $this->assertEquals($data['suppressed'], false);
    }

    /**
     * Test de GetById en Admin
     */
    public function testGetByIdAdmin()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(29);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/byId/3');
//        dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['name'], 'MERINDOL Cécilia Manager');
        $this->assertEquals($data['email'], 'manager@test.com');
        $this->assertEquals($data['category_id'], 3);
        $this->assertEquals($data['client_id'], 1);
        $this->assertEquals($data['role_id'], 3);
        $this->assertEquals($data['holding_id'], 4);
        $this->assertEquals($data['company_id'], 1);
        $this->assertEquals($data['office_id'], 1);
        $this->assertEquals($data['quality'], null);
        $this->assertEquals($data['address'], "51 Impasse Thomas Edison 1");
        $this->assertEquals($data['address2'], null);
        $this->assertEquals($data['zip_code'], "83600");
        $this->assertEquals($data['city'], "Fréjus");
        $this->assertEquals($data['region'], "PACA");
        $this->assertEquals($data['country'], "France");
        $this->assertEquals($data['phone'], "0494457479");
        $this->assertEquals($data['mobile'], null);
        $this->assertEquals($data['enabled'], true);
        $this->assertEquals($data['suppressed'], false);
    }

    /**
     * Test de GetById en Manager
     */
    public function testGetByIdManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(29);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/byId/3');
//        dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['name'], 'MERINDOL Cécilia Manager');
        $this->assertEquals($data['email'], 'manager@test.com');
        $this->assertEquals($data['category_id'], 3);
        $this->assertEquals($data['client_id'], 1);
        $this->assertEquals($data['role_id'], 3);
        $this->assertEquals($data['holding_id'], 4);
        $this->assertEquals($data['company_id'], 1);
        $this->assertEquals($data['office_id'], 1);
        $this->assertEquals($data['quality'], null);
        $this->assertEquals($data['address'], "51 Impasse Thomas Edison 1");
        $this->assertEquals($data['address2'], null);
        $this->assertEquals($data['zip_code'], "83600");
        $this->assertEquals($data['city'], "Fréjus");
        $this->assertEquals($data['region'], "PACA");
        $this->assertEquals($data['country'], "France");
        $this->assertEquals($data['phone'], "0494457479");
        $this->assertEquals($data['mobile'], null);
        $this->assertEquals($data['enabled'], true);
        $this->assertEquals($data['suppressed'], false);
    }

    /**
     * Test de GetListPageable en SA
     */
    public function testGetListPageableSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/list/pageable?current_page=1&per_page=10');
        //dd($response->dumpSession());

        $response->assertStatus(200);
    }

    /**
     * Test de GetListPageable en Admin
     */
    public function testGetListPageableAdmin()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(29);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/list/pageable?current_page=1&per_page=10');
        //dd($response->dumpSession());

        $response->assertStatus(200);
    }

    /**
     * Test de GetListPageable en Manager
     */
    public function testGetListPageableManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(29);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/manager/list/pageable?current_page=1&per_page=10');
        //dd($response->dumpSession());

        $response->assertStatus(200);
    }
}
