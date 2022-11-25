<?php

namespace Modules\Right\Tests\Unit;

use Modules\Right\Entities\RightFamily;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class RightFamilyTest extends TestCase
{

    /**
     * Test de la fonction client.
     *
     * @return void
     */
    public function testGetClient ()
    {
        /** RightFamily $family */
        $family = RightFamily::query()->find(1);
        $client = $family->client;
//        dd($client);
        $this->assertSame($client->name, 'APAC Association');
    }

    /**
     * Test de la fonction rights.
     *
     * @return void
     */
    public function testGetRights ()
    {
        /** RightFamily $family */
        $family = RightFamily::query()->find(1);
        $rights = $family->rights;
//        dd($rights[0]);
        $this->assertSame($rights[0]->name, 'Conversation Tous');
    }
}
