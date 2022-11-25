<?php

namespace Tests\Feature;

use App\Repositories\ClientRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * SetUp Initiation des tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession(['clientId' => 1]);
    }

    /**
     * Test de la fonction Create Client.
     *
     * @return void
     */
    public function testCreateClientRepository()
    {
        $client = ClientRepository::create([
            'name' => 'Client 1',
            'address' => '36 Rue de Limas',
            'city' => 'Paris',
            'country' => 'France',
            'email' => 'contact_cli1@test.com',
            'licence' => 'AAAAA',
            'licence_expired_at' => '2022-12-31 00:00:00',
            'enabled' => true
        ]);

        $this->assertEquals($client->name, 'Client 1');
        $this->assertEquals($client->address, '36 Rue de Limas');
        $this->assertEquals($client->city, 'Paris');
        $this->assertEquals($client->country, 'France');
        $this->assertEquals($client->email, 'contact_cli1@test.com');
        $this->assertEquals($client->licence, 'AAAAA');
        $this->assertEquals($client->licence_expired_at, '2022-12-31 00:00:00');
        $this->assertEquals($client->enabled, true);
    }

    /**
     * Test de la fonction Create Complete Client.
     *
     * @return void
     */
    public function testCreateClientRepositoryComplete()
    {
        $client = ClientRepository::create([
            'name' => 'Client 2',
            'folder' => 'Test',
            'address' => '36 Rue de Limas',
            'address2' => 'ZA Plat',
            'zip_code' => '75000',
            'city' => 'Paris',
            'country' => 'France',
            'email' => 'contact_cli2@test.com',
            'phone' => '0400000000',
            'licence' => 'AAAAA',
            'licence_expired_at' => '2022-12-31 00:00:00',
            'socket_host' => 'abcd',
            'socket_port' => '1234',
            'enabled' => true
        ]);

        $this->assertEquals($client->name, 'Client 2');
        $this->assertEquals($client->folder, 'Test');
        $this->assertEquals($client->address, '36 Rue de Limas');
        $this->assertEquals($client->address2, 'ZA Plat');
        $this->assertEquals($client->zip_code, '75000');
        $this->assertEquals($client->city, 'Paris');
        $this->assertEquals($client->country, 'France');
        $this->assertEquals($client->email, 'contact_cli2@test.com');
        $this->assertEquals($client->phone, '0400000000');
        $this->assertEquals($client->licence, 'AAAAA');
        $this->assertEquals($client->licence_expired_at, '2022-12-31 00:00:00');
        $this->assertEquals($client->socket_host, 'abcd');
        $this->assertEquals($client->socket_port, '1234');
        $this->assertEquals($client->enabled, true);
    }

    /**
     * Test de la fonction Update Client.
     *
     * @return void
     */
    public function testUpdateClientRepository()
    {
        $client = ClientRepository::create([
            'name' => 'Client 1',
            'address' => '36 Rue de Limas',
            'city' => 'Paris',
            'country' => 'France',
            'email' => 'contact_cli1@test.com',
            'licence' => 'AAAAA',
            'licence_expired_at' => '2022-12-31 00:00:00',
            'enabled' => true
        ]);

        ClientRepository::update($client, [
            'name' => 'Client num 1',
            'address' => '38 Rue de Suede',
            'city' => 'Limoge',
            'country' => 'Turquie',
            'email' => 'contact_cli_num1@test.com',
            'licence' => 'BBBBB',
            'licence_expired_at' => '2022-10-10 00:00:00',
            'enabled' => false
        ]);

        $this->assertEquals($client->name, 'Client num 1');
        $this->assertEquals($client->address, '38 Rue de Suede');
        $this->assertEquals($client->city, 'Limoge');
        $this->assertEquals($client->country, 'Turquie');
        $this->assertEquals($client->email, 'contact_cli_num1@test.com');
        $this->assertEquals($client->licence, 'BBBBB');
        $this->assertEquals($client->licence_expired_at, '2022-10-10 00:00:00');
        $this->assertEquals($client->enabled, false);
    }

    /**
     * Test de la fonction Update Complete Client.
     *
     * @return void
     */
    public function testUpdateClientRepositoryComplete()
    {
        $client = ClientRepository::create([
            'name' => 'Client 2',
            'folder' => 'Test',
            'address' => '36 Rue de Limas',
            'address2' => 'ZA Plat',
            'zip_code' => '75000',
            'city' => 'Paris',
            'country' => 'France',
            'email' => 'contact_cli2@test.com',
            'phone' => '0400000000',
            'licence' => 'AAAAA',
            'licence_expired_at' => '2022-12-31 00:00:00',
            'socket_host' => 'abcd',
            'socket_port' => '1234',
            'enabled' => true
        ]);

        ClientRepository::update($client, [
            'name' => 'Client num 2',
            'folder' => 'Test 2',
            'address' => '38 Rue de Suede',
            'address2' => 'ZA Plat 2',
            'zip_code' => '45862',
            'city' => 'Limoge',
            'country' => 'Perou',
            'email' => 'contact_cli_num2@test.com',
            'phone' => '0411111111',
            'licence' => 'BBBBB',
            'licence_expired_at' => '2022-10-10 00:00:00',
            'socket_host' => 'jhgfd',
            'socket_port' => '32154',
            'enabled' => false
        ]);

        $this->assertEquals($client->name, 'Client num 2');
        $this->assertEquals($client->folder, 'Test 2');
        $this->assertEquals($client->address, '38 Rue de Suede');
        $this->assertEquals($client->address2, 'ZA Plat 2');
        $this->assertEquals($client->zip_code, '45862');
        $this->assertEquals($client->city, 'Limoge');
        $this->assertEquals($client->country, 'Perou');
        $this->assertEquals($client->email, 'contact_cli_num2@test.com');
        $this->assertEquals($client->phone, '0411111111');
        $this->assertEquals($client->licence, 'BBBBB');
        $this->assertEquals($client->licence_expired_at, '2022-10-10 00:00:00');
        $this->assertEquals($client->socket_host, 'jhgfd');
        $this->assertEquals($client->socket_port, '32154');
        $this->assertEquals($client->enabled, false);
    }

    /**
     * Test de la fonction Delete Client.
     *
     * @return void
     */
    public function testDeleteClientRepository()
    {
        $client = ClientRepository::create([
            'name' => 'Client 1',
            'address' => '36 Rue de Limas',
            'city' => 'Paris',
            'country' => 'France',
            'email' => 'contact_cli1@test.com',
            'licence' => 'AAAAA',
            'licence_expired_at' => '2022-12-31 00:00:00',
            'enabled' => true
        ]);

        ClientRepository::delete($client);
        $this->assertDeleted($client);
    }

    /**
     * Test de GetById Client
     */
    public function testGetByIdClientRepository()
    {
        $client = ClientRepository::getById(1);

//        dd($client);
        $this->assertEquals($client->name, 'APAC Association');
        $this->assertEquals($client->folder, null);
        $this->assertEquals($client->address, '34 rue Laurent Barbero');
        $this->assertEquals($client->address2, 'Pôle BTP');
        $this->assertEquals($client->zip_code, '83600');
        $this->assertEquals($client->city, 'Fréjus');
        $this->assertEquals($client->country, 'France');
        $this->assertEquals($client->email, 'cecilia.merindol@planisphereinfo.com');
        $this->assertEquals($client->phone, null);
        $this->assertEquals($client->licence, 'AAAAA');
        $this->assertEquals($client->licence_expired_at, '2030-08-15 00:00:00');
        $this->assertEquals($client->socket_host, null);
        $this->assertEquals($client->socket_port, null);
        $this->assertEquals($client->enabled, true);
    }

    /**
     * Test de GetPaginate Client
     */
    public function testGetPaginateClientRepository()
    {
        $response = ClientRepository::getPaginate(1, 10, [
            'filters' => [[
                'field' => 'clients.name',
                'type' => 'string',
                'value' => "APAC Association"
            ]]
        ]);

        //dd($response);
        $clients = $response->items();
        $client = $clients[0];
        $this->assertEquals($client->name, 'APAC Association');
        $this->assertEquals($client->folder, null);
        $this->assertEquals($client->address, '34 rue Laurent Barbero');
        $this->assertEquals($client->address2, 'Pôle BTP');
        $this->assertEquals($client->zip_code, '83600');
        $this->assertEquals($client->city, 'Fréjus');
        $this->assertEquals($client->country, 'France');
        $this->assertEquals($client->email, 'cecilia.merindol@planisphereinfo.com');
        $this->assertEquals($client->phone, null);
        $this->assertEquals($client->licence, 'AAAAA');
        $this->assertEquals($client->licence_expired_at, '2030-08-15 00:00:00');
        $this->assertEquals($client->socket_host, null);
        $this->assertEquals($client->socket_port, null);
        $this->assertEquals($client->enabled, true);
    }
}
