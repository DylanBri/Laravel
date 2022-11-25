<?php

namespace Modules\Right\Tests\Unit;

use Modules\Right\Entities\Right;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class RightTest extends TestCase
{
    /**
     * Test de la fonction family.
     *
     * @return void
     */
    public function testGetFamily ()
    {
        /** Right $right */
        $right = Right::query()->find(1);
        $family = $right->family;
//        dd($family);
        $this->assertSame($family->name, 'Annonce');
    }

    /**
     * Test de la fonction action.
     *
     * @return void
     */
    public function testGetAction ()
    {
        /** Right $right */
        $right = Right::query()->find(1);
        $action = $right->action;
//        dd($action);
        $this->assertSame($action->name, 'Consulter');
    }

    /**
     * Test de la fonction client.
     *
     * @return void
     */
    public function testGetClient ()
    {
        /** Right $right */
        $right = Right::query()->find(1);
        $client = $right->client;
//        dd($client);
        $this->assertSame($client->name, 'APAC Association');
    }

    /**
     * Test de la fonction holdings.
     *
     * @return void
     */
    public function testGetHoldings ()
    {
        /** Right $right */
        $right = Right::query()->find(1);
        $holdings = $right->holdings;
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
        /** Right $right */
        $right = Right::query()->find(1);
        $companies = $right->companies;
//        dd($companies[0]);
        $this->assertSame($companies[0]->name, 'PlanisphereInfo');
    }

    /**
     * Test de la fonction offices.
     *
     * @return void
     */
    public function testGetOffices ()
    {
        /** Right $right */
        $right = Right::query()->find(1);
        $offices = $right->offices;
//        dd($offices[0]);
        $this->assertSame($offices[0]->name, 'Developpement');
    }
}
