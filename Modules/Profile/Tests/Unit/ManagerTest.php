<?php

namespace Modules\Profile\Tests\Unit;

use Modules\Profile\Entities\Manager;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerTest extends TestCase
{

    /**
     * SetUp Initiation des tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession(['clientId' => 1]);
    }

    /**
     * Test de la fonction coordinate.
     *
     * @return void
     */
    public function testGetCoordinate()
    {
        /** Manager $manager */
        $manager = Manager::query()->where('users.id',3)->first();
        $coordinate = $manager->coordinate;
        $this->assertSame($coordinate->id, 3);
    }

    /**
     * Test de la fonction isManager.
     *
     * @return void
     */
    public function testGetIsManager ()
    {
        /** Manager $manager */
        $manager = Manager::query()->first();
        $user = $manager->isManager();
//        dd($user);
        $this->assertSame($user, true);
    }
}
