<?php

namespace Tests\Unit;

use App\Models\Role;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * Test de la fonction categories.
     *
     * @return void
     */
    public function testGetCategories ()
    {
        /** Role $role */
        $role = Role::query()->find(1);
        $categories = $role->categories;
//        dd($categories[0]);
        $this->assertSame($categories[0]->name, 'Super Administrateur');
    }

    /**
     * Test de la fonction clients.
     *
     * @return void
     */
    public function testGetClients ()
    {
        /** Role $role */
        $role = Role::query()->find(1);
        $clients = $role->clients;
//        dd($clients[0]);
        $this->assertSame($clients[0]->name, 'APAC Association');
    }

    /**
     * Test de la fonction users.
     *
     * @return void
     */
    public function testGetUsers ()
    {
        /** Role $role */
        $role = Role::query()->find(1);
        $users = $role->users;
//        dd($users[0]);
        $this->assertSame($users[0]->name, 'MERINDOL Cécilia SA');
    }
}
