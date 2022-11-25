<?php

namespace Modules\Profile\Tests\Unit;

use Modules\Profile\Entities\User;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
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
        /** User $user */
        $user = User::query()->where('users.id',4)->first();
        $coordinate = $user->coordinate;
        $this->assertSame($coordinate->id, 4);
    }

    /**
     * Test de la fonction isUser.
     *
     * @return void
     */
    public function testGetIsUser ()
    {
        /** User $user */
        $user = User::query()->first();
        $isUser = $user->isUser();
//        dd($isUser);
        $this->assertSame($isUser, true);
    }
}
