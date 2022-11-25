<?php

namespace Modules\Profile\Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Profile\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
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
            ->get('/user');

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
        $user = $this->factoryAdmin(32);

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user');

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
        $user = $this->factoryManager(32);

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user');

        // Contrôle du résultat
        $response->assertStatus(200);
    }

    /**
     * Test de la fonction index en User
     */
    public function testViewIndexUser()
    {
        // Initialisation du test
        $this->withoutMiddleware();
        $user = $this->factoryUser(32);

        // Appel de la route à tester
        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user');

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
            ->get('/user/create');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction create en Admin
     */
    public function testViewCreateAdmin()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(33);

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
        $user = $this->factoryManager(33);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/create');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction create en User
     */
    public function testViewCreateUser()
    {
        $this->withoutMiddleware();
        $user = $this->factoryUser(33);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/create');

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
            ->post('/user', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'name' => 'User 1',
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

        $this->assertDatabaseHas('users', ['name' => 'User 1']);
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
            ->post('/user', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'user_id' => 1,
                'category_id' => 4,
                'quality' => 'Monsieur',
                'name' => 'User 2',
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

        $this->assertDatabaseHas('users', ['name' => 'User 2']);
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
            ->post('/user', [
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
            ->post('/user', [
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
        $user = User::query()->first();
        $userBase = $this->factorySupAdm();

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->get('/user/' . $user->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction view en Admin
     */
    public function testViewShowAdmin()
    {
        $this->withoutMiddleware();
        $user = User::query()->first();
        $userBase = $this->factoryAdmin(32);

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->get('/user/' . $user->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction view en Manager
     */
    public function testViewShowManager()
    {
        $this->withoutMiddleware();
        $user = User::query()->first();
        $userBase = $this->factoryUser(32);

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->get('/user/' . $user->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction view en User
     */
    public function testViewShowUser()
    {
        $this->withoutMiddleware();
        $user = User::query()->first();
        $userBase = $this->factoryUser(32);

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->get('/user/' . $user->id);

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en SA
     */
    public function testEditSupAdm()
    {
        $this->withoutMiddleware();
        $user = User::query()->first();
        $userBase = $this->factorySupAdm();

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->get('/user/' . $user->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en Admin
     */
    public function testEditAdmin()
    {
        $this->withoutMiddleware();
        $user = User::query()->first();
        $userBase = $this->factoryAdmin(34);

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->get('/user/' . $user->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en Manager
     */
    public function testEditManager()
    {
        $this->withoutMiddleware();
        $user = User::query()->first();
        $userBase = $this->factoryUser(34);

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->get('/user/' . $user->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction edit en User
     */
    public function testEditUser()
    {
        $this->withoutMiddleware();
        $user = User::query()->first();
        $userBase = $this->factoryUser(34);

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->get('/user/' . $user->id . '/edit');

        $response->assertStatus(500);
    }

    /**
     * Test de la fonction update en SA
     */
    public function testUpdateSupAdm()
    {
        $this->withoutMiddleware();
        $userBase = $this->factorySupAdm();

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->post('/user', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'name' => 'User num 1',
                'email' => 'contact_mng_num1@test.com',
                'password' => 'contact_mng1@test.com',
                'address' => '36 Rue de Londres',
                'country' => 'France',
                'enabled' => true,
                'suppressed' => false
            ]);
        $response->assertStatus(200);

        $user = User::query()->where('name', 'User num 1')->first();

        $response = $this->actingAs($userBase)
            ->put('/user/' . $user->user_id, [
                'holding_id' => 2,
                'company_id' => 7,
                'office_id' => 5,
                'name' => 'User num 2',
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

//        $this->assertDatabaseHas('users', ['name' => 'User num 1']);
        $this->assertDatabaseHas('users', ['name' => 'User num 2']);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction update complete en SA
     */
    public function testUpdateCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $userBase = $this->factorySupAdm();

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->post('/user', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'user_id' => 1,
                'category_id' => 4,
                'quality' => 'Monsieur',
                'name' => 'User num 3',
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

        $user = User::query()->where('name', 'User num 3')->first();

        $response = $this->actingAs($userBase)
            ->put('/user/' . $user->user_id, [
                'holding_id' => 2,
                'company_id' => 7,
                'office_id' => 6,
                'user_id' => 2,
                'category_id' => 5,
                'quality' => 'Mademoiselle',
                'name' => 'User num 4',
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

//        $this->assertDatabaseHas('users', ['name' => 'User num 3']);
        $this->assertDatabaseHas('users', ['name' => 'User num 4']);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction update error en SA
     */
    public function testUpdateErrorSupAdm()
    {
        $this->withoutMiddleware();
        $userBase = $this->factorySupAdm();

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->post('/user', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'name' => 'User 1',
                'email' => 'contact_mng1@test.com',
                'password' => 'contact_mng1@test.com',
                'address' => '36 Rue de Londres',
                'country' => 'France',
                'enabled' => true,
                'suppressed' => false
            ]);
        $response->assertStatus(200);

        $user = User::query()->where('name', 'User 1')->first();

        $response = $this->actingAs($userBase)
            ->put('/user/' . $user->user_id, [
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
        $userBase = $this->factorySupAdm();

        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->post('/user', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'user_id' => 1,
                'category_id' => 4,
                'quality' => 'Monsieur',
                'name' => 'User 2',
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

        $user = User::query()->where('name', 'User 2')->first();

        $response = $this->actingAs($userBase)
            ->put('/user/' . $user->user_id, [
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
        $userBase = $this->factorySupAdm();

        // Ajout de la companie à supprimer
        /** @var Authenticatable $userBase */
        $response = $this->actingAs($userBase)
            ->post('/user', [
                'holding_id' => 1,
                'company_id' => 1,
                'office_id' => 1,
                'name' => 'User 10',
                'email' => 'contact_mng10@test.com',
                'password' => 'contact_mng1@test.com',
                'address' => '36 Rue de Londres',
                'country' => 'France',
                'enabled' => true,
                'suppressed' => false
            ]);
        $response->assertStatus(200);

        // Récuperation de la companie créée
        $user = User::query()->where('name', 'User 10')->first();

        // Appel de la route à tester
//        $response =
        $this->actingAs($userBase)
            ->delete('/user/' . $user->user_id);
        //dd($response->dumpSession());

        //$this->assertDatabaseHas('users', ['name' => 'User 10']);
        $this->assertDatabaseMissing('users', ['name' => 'User 10']);
        $this->assertDeleted($user);
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
            ->delete('/user/' . 0);

        $response->assertStatus(500);
        //dd($response->dumpSession());
        //$this->expectException(\Exception::class);
        //$this->expectExceptionMessage('Bad company id');
    }

    /**
     * Test de la fonction showSearch en SA
     */
    public function testShowSearchSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/list/search');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction showSearchByOffice en SA
     */
    public function testShowSearchByOfficeSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/office/1/list/search');

        $response->assertStatus(200);
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
            ->get('/user/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction showDashboard en Admin
     */
    public function testShowDashboardAdmin()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction showDashboard en Manager
     */
    public function testShowDashboardManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction showDashboard en User
     */
    public function testShowDashboardUser()
    {
        $this->withoutMiddleware();
        $user = $this->factoryUser(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/dashboard');

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
            ->get('/user/byId/4');
//        dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['name'], 'MERINDOL Cécilia User');
        $this->assertEquals($data['email'], 'user@test.com');
        $this->assertEquals($data['category_id'], 4);
        $this->assertEquals($data['client_id'], 1);
        $this->assertEquals($data['role_id'], 4);
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
        $user = $this->factoryAdmin(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/byId/4');
//        dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['name'], 'MERINDOL Cécilia User');
        $this->assertEquals($data['email'], 'user@test.com');
        $this->assertEquals($data['category_id'], 4);
        $this->assertEquals($data['client_id'], 1);
        $this->assertEquals($data['role_id'], 4);
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
        $user = $this->factoryManager(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/byId/4');
//        dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['name'], 'MERINDOL Cécilia User');
        $this->assertEquals($data['email'], 'user@test.com');
        $this->assertEquals($data['category_id'], 4);
        $this->assertEquals($data['client_id'], 1);
        $this->assertEquals($data['role_id'], 4);
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
     * Test de GetById en User
     */
    public function testGetByIdUser()
    {
        $this->withoutMiddleware();
        $user = $this->factoryUser(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/byId/4');
//        dd($response->dumpSession());

        $data = $response->json();
        $this->assertEquals($data['name'], 'MERINDOL Cécilia User');
        $this->assertEquals($data['email'], 'user@test.com');
        $this->assertEquals($data['category_id'], 4);
        $this->assertEquals($data['client_id'], 1);
        $this->assertEquals($data['role_id'], 4);
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
            ->get('/user/list/pageable?current_page=1&per_page=10');
        //dd($response->dumpSession());

        $response->assertStatus(200);
    }

    /**
     * Test de GetListPageable en Admin
     */
    public function testGetListPageableAdmin()
    {
        $this->withoutMiddleware();
        $user = $this->factoryAdmin(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/list/pageable?current_page=1&per_page=10');
        //dd($response->dumpSession());

        $response->assertStatus(200);
    }

    /**
     * Test de GetListPageable en Manager
     */
    public function testGetListPageableManager()
    {
        $this->withoutMiddleware();
        $user = $this->factoryManager(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/list/pageable?current_page=1&per_page=10');
        //dd($response->dumpSession());

        $response->assertStatus(200);
    }

    /**
     * Test de GetListPageable en User
     */
    public function testGetListPageableUser()
    {
        $this->withoutMiddleware();
        $user = $this->factoryUser(32);

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/list/pageable?current_page=1&per_page=10');
        //dd($response->dumpSession());

        $response->assertStatus(200);
    }

    /**
     * Test de Search en SA
     */
    public function testSearchSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/user/search');
        //dd($response->dumpSession());

        $response->assertStatus(200);
    }
}
