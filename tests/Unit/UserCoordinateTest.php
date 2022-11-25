<?php

namespace Tests\Unit;

use App\Models\UserCoordinate;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCoordinateTest extends TestCase
{

    /**
     * Test de la fonction user.
     *
     * @return void
     */
    public function testGetUser ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(1);
        $user = $coordinate->user;
//        dd($user);
        $this->assertSame($user->name, 'MERINDOL Cécilia SA');
    }

    /**
     * Test de la fonction category.
     *
     * @return void
     */
    public function testGetCategory ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(1);
        $category = $coordinate->category;
//        dd($category);
        $this->assertSame($category->name, 'Super Administrateur');
    }

    /**
     * Test de la fonction versions.
     *
     * @return void
     */
    public function testGetVersions ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(1);
        $versions = $coordinate->versions;
//        dd($versions);
        $this->assertSame($versions->isEmpty(), true);
    }

    /**
     * Test de la fonction isSuperAdministrator.
     *
     * @return void
     */
    public function testGetIsSuperAdministrator ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(1);
        $sa = $coordinate->isSuperAdministrator();
//        dd($sa);
        $this->assertSame($sa, true);
    }

    /**
     * Test de la fonction isAdministrator.
     *
     * @return void
     */
    public function testGetIsAdministrator ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(2);
        $admin = $coordinate->isAdministrator();
//        dd($admin);
        $this->assertSame($admin, true);
    }

    /**
     * Test de la fonction isManager.
     *
     * @return void
     */
    public function testGetIsManager ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(3);
        $manager = $coordinate->isManager();
//        dd($manager);
        $this->assertSame($manager, true);
    }

    /**
     * Test de la fonction isUser.
     *
     * @return void
     */
    public function testGetIsUser ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(4);
        $user = $coordinate->isUser();
//        dd($user);
        $this->assertSame($user, true);
    }

    /**
     * Test de la fonction isRoleSuperAdministrator.
     *
     * @return void
     */
    public function testGetIsRoleSuperAdministrator ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(1);
        $sa = $coordinate->isRoleSuperAdministrator();
//        dd($sa);
        $this->assertSame($sa, true);
    }

    /**
     * Test de la fonction isRoleAdministrator.
     *
     * @return void
     */
    public function testGetIsRoleAdministrator ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(2);
        $admin = $coordinate->isRoleAdministrator();
//        dd($admin);
        $this->assertSame($admin, true);
    }

    /**
     * Test de la fonction isRoleManager.
     *
     * @return void
     */
    public function testGetIsRoleManager ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(3);
        $manager = $coordinate->isRoleManager();
//        dd($manager);
        $this->assertSame($manager, true);
    }

    /**
     * Test de la fonction isRoleUser.
     *
     * @return void
     */
    public function testGetIsRoleUser ()
    {
        /** UserCoordinate $coordinate */
        $coordinate = UserCoordinate::query()->find(4);
        $user = $coordinate->isRoleUser();
//        dd($user);
        $this->assertSame($user, true);
    }
}
