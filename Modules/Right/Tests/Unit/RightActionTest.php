<?php

namespace Modules\Right\Tests\Unit;

use Modules\Right\Entities\RightAction;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class RightActionTest extends TestCase
{

    /**
     * Test de la fonction client.
     *
     * @return void
     */
    public function testGetClient ()
    {
        /** RightAction $action */
        $action = RightAction::query()->find(1);
        $client = $action->client;
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
        /** RightAction $action */
        $action = RightAction::query()->find(1);
        $rights = $action->rights;
//        dd($rights[0]);
        $this->assertSame($rights[0]->name, 'Consulter annonce');
    }
}
