<?php

namespace Modules\Profile\Tests\Unit;

use Modules\Profile\Entities\SuperAdministrator;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class SuperAdministratorTest extends TestCase
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
        /** SuperAdministrator $supadm */
        $supadm = SuperAdministrator::query()->where('users.id',1)->first();
        $coordinate = $supadm->coordinate;
        $this->assertSame($coordinate->id, 1);
    }

    /**
     * Test de la fonction isSuperAdministrator.
     *
     * @return void
     */
    public function testGetIsSuperAdministrator ()
    {
        /** SuperAdministrator $sa */
        $sa = SuperAdministrator::query()->first();
        $user = $sa->isSuperAdministrator();
//        dd($user);
        $this->assertSame($user, true);
    }
}
