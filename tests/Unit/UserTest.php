<?php

namespace Tests\Unit;

use App\Models\User;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * Test de la fonction coordinate.
     *
     * @return void
     */
    public function testGetCoordinate ()
    {
        /** User $user */
        $user = User::query()->find(1);
        $coordinate = $user->coordinate;
//        dd($coordinate);
        $this->assertSame($coordinate->address, '51 Impasse Thomas Edison 1');
    }

    /**
     * Test de la fonction advertComments.
     *
     * @return void
     */
    public function testGetAdvertComments ()
    {
        /** User $user */
        $user = User::query()->find(1);
        $advertComments = $user->advertComments;
//        dd($advertComments[0]);
        $this->assertSame($advertComments[0]->comment, 'testcomment');
    }

    /**
     * Test de la fonction adverts.
     *
     * @return void
     */
    public function testGetAdverts ()
    {
        /** User $user */
        $user = User::query()->find(1);
        $adverts = $user->adverts;
//        dd($adverts[0]);
        $this->assertSame($adverts[0]->name, 'test');
    }

    /**
     * Test de la fonction conversationQueues.
     *
     * @return void
     */
    public function testGetConversationQueues ()
    {
        /** User $user */
        $user = User::query()->find(1);
        $conversationQueues = $user->conversationQueues;
//        dd($conversationQueues[0]);
        $this->assertSame($conversationQueues[0]->message, 'Test');
    }

    /**
     * Test de la fonction conversations.
     *
     * @return void
     */
    public function testGetConversations ()
    {
        /** User $user */
        $user = User::query()->find(1);
        $conversations = $user->conversations;
//        dd($conversations[0]);
        $this->assertSame($conversations[0]->title, 'test');
    }

    /**
     * Test de la fonction holdings.
     *
     * @return void
     */
    public function testGetHoldings ()
    {
        /** User $user */
        $user = User::query()->find(2);
        $holdings = $user->holdings;
//        dd($holdings[0]);
        $this->assertSame($holdings[0]->name, 'Parc d\'activités du Capitou');
    }

    /**
     * Test de la fonction companies.
     *
     * @return void
     */
    public function testGetCompanies ()
    {
        /** User $user */
        $user = User::query()->find(2);
        $companies = $user->companies;
//        dd($companies[0]);
        $this->assertSame($companies[0]->name, 'Veolia');
    }

    /**
     * Test de la fonction offices.
     *
     * @return void
     */
    public function testGetOffices ()
    {
        /** User $user */
        $user = User::query()->find(2);
        $offices = $user->offices;
//        dd($offices[0]);
        $this->assertSame($offices[0]->name, 'Direction');
    }

    /**
     * Test de la fonction rights.
     *
     * @return void
     */
    public function testGetRights ()
    {
        /** User $user */
        $user = User::query()->find(2);
        $rights = $user->rights;
//        dd($rights[0]);
        $this->assertSame($rights[0]->name, 'Consulter annonce');
    }
}
