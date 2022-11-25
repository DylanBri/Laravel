<?php

namespace Tests\Unit;

use App\Models\Client;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * Test de la fonction companies.
     *
     * @return void
     */
    public function testGetCompanies ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $companies = $client->companies;
//        dd($companies[0]);
        $this->assertSame($companies[0]->name, 'PlanisphereInfo');
    }

    /**
     * Test de la fonction holdings.
     *
     * @return void
     */
    public function testGetHoldings ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $holdings = $client->holdings;
//        dd($holdings[0]);
        $this->assertSame($holdings[0]->name, 'Parc d\'activités du Capitou');
    }

    /**
     * Test de la fonction offices.
     *
     * @return void
     */
    public function testGetOffices ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $offices = $client->offices;
//        dd($offices[0]);
        $this->assertSame($offices[0]->name, 'Developpement');
    }

    /**
     * Test de la fonction advertThemes.
     *
     * @return void
     */
    public function testGetAdvertThemes ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $advertThemes = $client->advertThemes;
//        dd($advertThemes[0]);
        $this->assertSame($advertThemes[0]->name, 'General');
    }

    /**
     * Test de la fonction advertThemes.
     *
     * @return void
     */
    public function testGetAdvertDocuments ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $advertDocuments = $client->advertDocuments;
//        dd($advertDocuments[0]);
        $this->assertSame($advertDocuments->isEmpty(), true);
    }

    /**
     * Test de la fonction advertThemes.
     *
     * @return void
     */
    public function testGetAdvertComments ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $advertComments = $client->advertComments;
//        dd($advertComments[0]);
        $this->assertSame($advertComments[0]->comment, 'testcomment');
    }

    /**
     * Test de la fonction conversations.
     *
     * @return void
     */
    public function testGetConversations ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $conversations = $client->conversations;
//        dd($conversations[0]);
        $this->assertSame($conversations[0]->title, 'test');
    }

    /**
     * Test de la fonction users.
     *
     * @return void
     */
    public function testGetUsers ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $users = $client->users;
//        dd($users[0]);
        $this->assertSame($users[0]->name, 'MERINDOL Cécilia SA');
    }

    /**
     * Test de la fonction roles.
     *
     * @return void
     */
    public function testGetRoles ()
    {
        /** Client $client */
        $client = Client::query()->find(1);
        $roles = $client->roles;
//        dd($roles[0]);
        $this->assertSame($roles[0]->name, 'SA');
    }
}
