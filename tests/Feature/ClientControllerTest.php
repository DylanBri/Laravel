<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientControllerTest extends TestCase
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
            ->get('/client');

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
            ->get('/client/create');

        $response->assertStatus(200);
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
            ->post('/client', [
                'name' => 'Client 1',
                'address' => '36 Rue de Limas',
                'city' => 'Paris',
                'country' => 'France',
                'email' => 'contact_cli1@test.com',
                'licence' => 'AAAAA',
                'licence_expired_at' => '2022-12-31 00:00:00',
                'enabled' => true
            ]);
        //dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'name',
            'address',
            'city',
            'country',
            'email',
            'licence',
            'licence_expired_at',
            'enabled'
        ]);

        $this->assertDatabaseHas('clients', ['name' => 'Client 1']);
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
            ->post('/client', [
                'name' => 'Client 2',
                'folder' => 'Test',
                'address' => '36 Rue de Limas',
                'address2' => 'ZA Plat',
                'zip_code' => '75000',
                'city' => 'Paris',
                'country' => 'France',
                'email' => 'contact_cli1@test.com',
                'phone' => '0400000000',
                'licence' => 'AAAAA',
                'licence_expired_at' => '2022-12-31 00:00:00',
                'socket_host' => 'abcd',
                'socket_port' => '1234',
                'enabled' => true
            ]);
        //dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'name',
            'folder',
            'address',
            'address2',
            'zip_code',
            'city',
            'country',
            'email',
            'phone',
            'licence',
            'licence_expired_at',
            'socket_host',
            'socket_port',
            'enabled'
        ]);

        $this->assertDatabaseHas('clients', ['name' => 'Client 2']);
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
            ->post('/client', [
                'name' => '',
                'address' => '',
                'city' => '',
                'country' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'email' => 1,
                'licence' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'licence_expired_at' => '4567899456566',
                'enabled' => true
            ]);
//        dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "name" => "Le champ nom est obligatoire.",
            "address" => "Le champ adresse est obligatoire.",
            "city" => "Le champ ville est obligatoire.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères.",
            "email" => "Le champ adresse email doit être une adresse email valide.",
            "licence" => "Le texte de licence ne peut contenir plus de 50 caractères.",
            "licence_expired_at" => "Le champ licence expired at ne correspond pas au format Y-m-d H:i:s."
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
            ->post('/client', [
                'name' => '',
                'folder' => '',
                'address' => '',
                'address2' => '',
                'zip_code' => 'qsdfghj',
                'city' => '',
                'country' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'email' => 1,
                'phone' => 'sdfghjk',
                'licence' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'licence_expired_at' => 'sdfghj',
                'socket_host' => '',
                'socket_port' => '',
                'enabled' => true
            ]);
//        dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "name" => "Le champ nom est obligatoire.",
            "address" => "Le champ adresse est obligatoire.",
            "zip_code" => "Le format du champ zip code est invalide.",
            "city" => "Le champ ville est obligatoire.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères.",
            "email" => "Le champ adresse email doit être une adresse email valide.",
            "phone" => "Le format du champ téléphone est invalide.",
            "licence" => "Le texte de licence ne peut contenir plus de 50 caractères.",
            "licence_expired_at" => "Le champ licence expired at ne correspond pas au format Y-m-d H:i:s."
        ]);
    }

    /**
     * Test de la fonction view en SA
     */
    public function testViewShowSupAdm()
    {
        $this->withoutMiddleware();
        $client = Client::query()->first();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/client/' . $client->id);

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction edit en SA
     */
    public function testEditShowSupAdm()
    {
        $this->withoutMiddleware();
        $client = Client::query()->first();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->get('/client/' . $client->id . '/edit');

        $response->assertStatus(200);
    }

    /**
     * Test de la fonction update en SA
     */
    public function testUpdateSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user **/
        $response = $this->actingAs($user)
            ->post('/client', [
                'name' => 'Client 1',
                'address' => '36 Rue de Limas',
                'city' => 'Paris',
                'country' => 'France',
                'email' => 'contact_cli1@test.com',
                'licence' => 'AAAAA',
                'licence_expired_at' => '2022-12-31 00:00:00',
                'enabled' => true
            ]);
        $response->assertStatus(200);

        $client = Client::query()->where('name', 'Client 1')->first();

        $response = $this->actingAs($user)
            ->put('client/' . $client->id, [
                'name' => 'Client 2',
                'address' => '38 Rue de Perou',
                'city' => 'Limoge',
                'country' => 'Turquie',
                'email' => 'contact_cli2@test.com',
                'licence' => 'BBBBB',
                'licence_expired_at' => '2022-06-10 00:00:00',
                'enabled' => false
            ]);
        //dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'name',
            'address',
            'city',
            'country',
            'email',
            'licence',
            'licence_expired_at',
            'enabled'
        ]);

        $this->assertDatabaseHas('clients', ['name' => 'Client 2']);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test de la fonction update complete en SA
     */
    public function testUpdateCompleteSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user **/
        $response = $this->actingAs($user)
            ->post('/client', [
                'name' => 'Client 2',
                'folder' => 'Test',
                'address' => '36 Rue de Limas',
                'address2' => 'ZA Plat',
                'zip_code' => '75000',
                'city' => 'Paris',
                'country' => 'France',
                'email' => 'contact_cli1@test.com',
                'phone' => '0400000000',
                'licence' => 'AAAAA',
                'licence_expired_at' => '2022-12-31 00:00:00',
                'socket_host' => 'abcd',
                'socket_port' => '1234',
                'enabled' => true
            ]);
        $response->assertStatus(200);

        $client = Client::query()->where('name', 'Client 2')->first();

        $response = $this->actingAs($user)
            ->put('/client/' . $client->id, [
                'name' => 'Client 3',
                'folder' => 'Test 2',
                'address' => '38 Rue de Perou',
                'address2' => 'ZA Plat 2',
                'zip_code' => '45862',
                'city' => 'Limoge',
                'country' => 'Tibet',
                'email' => 'contact_cli2@test.com',
                'phone' => '0411111111',
                'licence' => 'BBBBB',
                'licence_expired_at' => '2022-06-10 00:00:00',
                'socket_host' => 'kjhg',
                'socket_port' => '5324',
                'enabled' => false
            ]);
        //dd($response->dumpSession());

        $response->assertSessionDoesntHaveErrors([
            'name',
            'folder',
            'address',
            'address2',
            'zip_code',
            'city',
            'country',
            'email',
            'phone',
            'licence',
            'licence_expired_at',
            'socket_host',
            'socket_port',
            'enabled'
        ]);

        $this->assertDatabaseHas('clients', ['name' => 'Client 3']);
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
            ->post('/client', [
                'name' => 'Client 1',
                'address' => '36 Rue de Limas',
                'city' => 'Paris',
                'country' => 'France',
                'email' => 'contact_cli1@test.com',
                'licence' => 'AAAAA',
                'licence_expired_at' => '2022-12-31 00:00:00',
                'enabled' => true
            ]);
        $response->assertStatus(200);

        $client = Client::query()->where('name', 'Client 1')->first();

        $response = $this->actingAs($user)
            ->put('/client/' . $client->id, [
                'name' => '',
                'address' => '',
                'city' => '',
                'country' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'email' => 1,
                'licence' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'licence_expired_at' => '4567899456566',
                'enabled' => true
            ]);
//        dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "name" => "Le champ nom est obligatoire.",
            "address" => "Le champ adresse est obligatoire.",
            "city" => "Le champ ville est obligatoire.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères.",
            "email" => "Le champ adresse email doit être une adresse email valide.",
            "licence" => "Le texte de licence ne peut contenir plus de 50 caractères.",
            "licence_expired_at" => "Le champ licence expired at ne correspond pas au format Y-m-d H:i:s."
        ]);
    }

    /**
     * Test de la fonction update error complete en SA
     */
    public function testUpdateCompleteErrorSupAdm()
    {
        $this->withoutMiddleware();
        $user = $this->factorySupAdm();

        /** @var Authenticatable $user */
        $response = $this->actingAs($user)
            ->post('/client', [
                'name' => 'Client 2',
                'folder' => 'Test',
                'address' => '36 Rue de Limas',
                'address2' => 'ZA Plat',
                'zip_code' => '75000',
                'city' => 'Paris',
                'country' => 'France',
                'email' => 'contact_cli1@test.com',
                'phone' => '0400000000',
                'licence' => 'AAAAA',
                'licence_expired_at' => '2022-12-31 00:00:00',
                'socket_host' => 'abcd',
                'socket_port' => '1234',
                'enabled' => true
            ]);
        $response->assertStatus(200);

        $client = Client::query()->where('name', 'Client 2')->first();

        $response = $this->actingAs($user)
            ->put('/client/' . $client->id, [
                'name' => '',
                'folder' => '',
                'address' => '',
                'address2' => '',
                'zip_code' => 'qsdfghj',
                'city' => '',
                'country' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'email' => 1,
                'phone' => 'sdfghjk',
                'licence' => 'qazertyuiopsdfghjksxdcfghjdcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxcfghxswdfcdgvhcdfgvhwbxwcvbwxcvxcvbwxvvsdfghjklm',
                'licence_expired_at' => 'sdfghj',
                'socket_host' => '',
                'socket_port' => '',
                'enabled' => true
            ]);
//        dd($response->dumpSession());

        $response->assertSessionHasErrors([
            "name" => "Le champ nom est obligatoire.",
            "address" => "Le champ adresse est obligatoire.",
            "zip_code" => "Le format du champ zip code est invalide.",
            "city" => "Le champ ville est obligatoire.",
            "country" => "Le texte de pays ne peut contenir plus de 50 caractères.",
            "email" => "Le champ adresse email doit être une adresse email valide.",
            "phone" => "Le format du champ téléphone est invalide.",
            "licence" => "Le texte de licence ne peut contenir plus de 50 caractères.",
            "licence_expired_at" => "Le champ licence expired at ne correspond pas au format Y-m-d H:i:s."
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
            ->post('/client', [
                'name' => 'Client 1',
                'address' => '36 Rue de Limas',
                'city' => 'Paris',
                'country' => 'France',
                'email' => 'contact_cli1@test.com',
                'licence' => 'AAAAA',
                'licence_expired_at' => '2022-12-31 00:00:00',
                'enabled' => true
            ]);
        $response->assertStatus(200);

        // Récuperation de la companie créée
        $client = Client::query()->where('name', 'Client 1')->first();

        // Appel de la route à tester
//        $response =
            $this->actingAs($user)
            ->delete('/client/' . $client->id);
        //dd($response->dumpSession());

        //$this->assertDatabaseHas('clients', ['name' => 'Client 1']);
        //$this->assertDatabaseMissing('clients', ['name' => 'Client 1']);
        $this->assertDeleted($client);
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
            ->delete('client/' . 0);

        $response->assertStatus(500);
        //dd($response->dumpSession());
        //$this->expectException(\Exception::class);
        //$this->expectExceptionMessage('Bad company id');
    }
}
