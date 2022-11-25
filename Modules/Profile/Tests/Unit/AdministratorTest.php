<?php

namespace Modules\Profile\Tests\Unit;

use Modules\Profile\Entities\Administrator;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class AdministratorTest extends TestCase
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
        /** Administrator $admin */
        $admin = Administrator::query()->where('users.id',2)->first();
        $coordinate = $admin->coordinate;
        $this->assertSame($coordinate->id, 2);
    }

    /**
     * Test de la fonction isAdministrator.
     *
     * @return void
     */
    public function testGetIsAdministrator ()
    {
        /** Administrator $admin */
        $admin = Administrator::query()->first();
        $user = $admin->isAdministrator();
//        dd($user);
        $this->assertSame($user, true);
    }
}
