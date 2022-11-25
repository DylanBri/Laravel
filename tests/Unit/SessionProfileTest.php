<?php

namespace Tests\Unit;

use App\Models\SessionProfile;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionProfileTest extends TestCase
{

    /**
     * Test de la fonction user.
     *
     * @return void
     */
    public function testGetUser ()
    {
        /** SessionProfile $sessionProfile */
        $sessionProfile = SessionProfile::query()->where('user_id', 1)->first();
        $user = $sessionProfile->user;
//        dd($user);
        $this->assertSame($user->name, 'MERINDOL Cécilia SA');
    }

    /**
     * Test de la fonction role.
     *
     * @return void
     */
    public function testGetRole ()
    {
        /** SessionProfile $sessionProfile */
        $sessionProfile = SessionProfile::query()->where('user_id', 1)->first();
        $role = $sessionProfile->role;
//        dd($role);
        $this->assertSame($role->name, 'SA');
    }

    /**
     * Test de la fonction client.
     *
     * @return void
     */
    public function testGetClient ()
    {
        /** SessionProfile $sessionProfile */
        $sessionProfile = SessionProfile::query()->where('user_id', 1)->first();
        $client = $sessionProfile->client;
//        dd($client);
        $this->assertSame($client->name, 'APAC Association');
    }

    /**
     * Test de la fonction holding.
     *
     * @return void
     */
    public function testGetHolding ()
    {
        /** SessionProfile $sessionProfile */
        $sessionProfile = SessionProfile::query()->where('user_id', 1)->first();
        $holding = $sessionProfile->holding;
//        dd($holding);
        $this->assertSame($holding->name, 'Parc d\'activités La Palud - Gabian');
    }

    /**
     * Test de la fonction company.
     *
     * @return void
     */
    public function testGetCompany ()
    {
        /** SessionProfile $sessionProfile */
        $sessionProfile = SessionProfile::query()->where('user_id', 1)->first();
        $company = $sessionProfile->company;
//        dd($company);
        $this->assertSame($company->name, 'PlanisphereInfo');
    }

    /**
     * Test de la fonction office.
     *
     * @return void
     */
    public function testGetOffice ()
    {
        /** SessionProfile $sessionProfile */
        $sessionProfile = SessionProfile::query()->where('user_id', 1)->first();
        $office = $sessionProfile->office;
//        dd($office);
        $this->assertSame($office->name, 'Developpement');
    }
}
