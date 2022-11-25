<?php

namespace Modules\Profile\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\Profile\Repositories\SuperAdministratorRepository;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class SuperAdministratorRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * SetUp Initiation des tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession(['clientId' => 1]);
    }

    /**
     * Test de la fonction Create SuperAdministrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateSuperAdministratorRepository()
    {
        $repository = new SuperAdministratorRepository();
        $supadm = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Super Admin 1',
            'email' => 'contact_sa1@test.com',
            'password' => 'contact_sa1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($supadm->coordinate);

        $this->assertEquals($supadm->name, 'Super Admin 1');
        $this->assertEquals($supadm->email, 'contact_sa1@test.com');
//        $this->assertEquals($supadm->password, 'contact_sa1@test.com'); // hash

        // Coordinate
        $coordinate = $supadm->coordinate;
        $this->assertEquals($coordinate->address, '36 Rue de Londres');
        $this->assertEquals($coordinate->country, 'France');
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);

        // Rights
        $this->assertEquals($supadm->rights()->count(), 0);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $supadm->id]);
        $profile = DB::table('profiles')->where('user_id', $supadm->id)->first();
        $this->assertEquals($profile->holding_id, 1);
        $this->assertEquals($profile->company_id, 1);
        $this->assertEquals($profile->office_id, 1);
    }

    /**
     * Test de la fonction Create SuperAdministrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateSuperAdministratorRepositoryComplete()
    {
        $repository = new SuperAdministratorRepository();
        $supadm = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'category_id' => 1,
            'quality' => 'Monsieur',
            'name' => 'Super Admin 2',
            'email' => 'contact_sa2@test.com',
            'password' => 'contact_sa2@test.com',
            'address' => '36 Rue de Londres',
            'address2' => 'ZI Lac',
            'zip_code' => '45789',
            'city' => 'Lyon',
            'region' => 'Isere',
            'country' => 'France',
            'phone' => '0400000000',
            'mobile' => '0600000000',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($supadm->coordinate);

        $this->assertEquals($supadm->name, 'Super Admin 2');
        $this->assertEquals($supadm->email, 'contact_sa2@test.com');
//        $this->assertEquals($supadm->password, 'contact_sa1@test.com'); // hash

        // Coordinate
        $coordinate = $supadm->coordinate;
        $this->assertEquals($coordinate->category_id, 1);
        $this->assertEquals($coordinate->quality, 'Monsieur');
        $this->assertEquals($coordinate->address, '36 Rue de Londres');
        $this->assertEquals($coordinate->address2, 'ZI Lac');
        $this->assertEquals($coordinate->zip_code, '45789');
        $this->assertEquals($coordinate->city, 'Lyon');
        $this->assertEquals($coordinate->region, 'Isere');
        $this->assertEquals($coordinate->country, 'France');
        $this->assertEquals($coordinate->phone, '0400000000');
        $this->assertEquals($coordinate->mobile, '0600000000');
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);

        // Rights
        $this->assertEquals($supadm->rights()->count(), 0);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $supadm->id]);
        $profile = DB::table('profiles')->where('user_id', $supadm->id)->first();
        $this->assertEquals($profile->holding_id, 1);
        $this->assertEquals($profile->company_id, 1);
        $this->assertEquals($profile->office_id, 1);
    }

    /**
     * Test de la fonction Update SuperAdministrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testUpdateSuperAdministratorRepository()
    {
        $repository = new SuperAdministratorRepository();
        $supadm = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Super Admin num 1',
            'email' => 'contact_sa_num1@test.com',
            'password' => 'contact_sa1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($supadm);

        $repository->update($supadm, [
            'holding_id' => 2,
            'company_id' => 7,
            'office_id' => 5,
            'name' => 'Super Admin num 2',
            'email' => 'contact_sa_num2@test.com',
            'password' => 'contact_sa_num1@test.com',
            'address' => '36 Rue de Madrid',
            'country' => 'Espagne',
            'enabled' => false,
            'suppressed' => true
        ]);
//        dd($supadm->coordinate);

        $this->assertEquals($supadm->name, 'Super Admin num 2');
        $this->assertEquals($supadm->email, 'contact_sa_num2@test.com');
//        $this->assertEquals($supadm->password, 'contact_sa1@test.com'); // hash

        // Coordinate

        $coordinate = $supadm->coordinate;
        $this->assertEquals($coordinate->address, '36 Rue de Madrid');
        $this->assertEquals($coordinate->country, 'Espagne');
        $this->assertEquals($coordinate->enabled, false);
        $this->assertEquals($coordinate->suppressed, true);

        // Rights
        $this->assertEquals($supadm->rights()->count(), 0);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $supadm->id]);
        $profile = DB::table('profiles')->where('user_id', $supadm->id)->first();
        $this->assertEquals($profile->holding_id, 2);
        $this->assertEquals($profile->company_id, 7);
        $this->assertEquals($profile->office_id, 5);
    }

    /**
     * Test de la fonction Update Complete SuperAdministrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testUpdateSuperAdministratorRepositoryComplete()
    {
        $repository = new SuperAdministratorRepository();
        $supadm = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'category_id' => 1,
            'quality' => 'Monsieur',
            'name' => 'Super Admin num 3',
            'email' => 'contact_sa_num3@test.com',
            'password' => 'contact_sa_num3@test.com',
            'address' => '36 Rue de Londres',
            'address2' => 'ZI Lac',
            'zip_code' => '45789',
            'city' => 'Lyon',
            'region' => 'Isere',
            'country' => 'France',
            'phone' => '0400000000',
            'mobile' => '0600000000',
            'enabled' => true,
            'suppressed' => false
        ]);

        $repository->update($supadm, [
            'holding_id' => 2,
            'company_id' => 7,
            'office_id' => 6,
            'user_id' => 2,
            'category_id' => 2,
            'quality' => 'Mademoiselle',
            'name' => 'Super Admin num 4',
            'email' => 'contact_sa_num4@test.com',
            'password' => 'contact_sa_num4@test.com',
            'address' => '36 Rue de Madrid',
            'address2' => 'ZI Lac 2',
            'zip_code' => '78456',
            'city' => 'Lilles',
            'region' => 'Nord',
            'country' => 'Suede',
            'phone' => '0411111111',
            'mobile' => '0622222222',
            'enabled' => false,
            'suppressed' => true
        ]);
//        dd($supadm->coordinate);

        $this->assertEquals($supadm->name, 'Super Admin num 4');
        $this->assertEquals($supadm->email, 'contact_sa_num4@test.com');
//        $this->assertEquals($supadm->password, 'contact_sa1@test.com'); // hash

        // Coordinate

        $coordinate = $supadm->coordinate;
        $this->assertEquals($coordinate->category_id, 1);
        $this->assertEquals($coordinate->quality, 'Mademoiselle');
        $this->assertEquals($coordinate->address, '36 Rue de Madrid');
        $this->assertEquals($coordinate->address2, 'ZI Lac 2');
        $this->assertEquals($coordinate->zip_code, '78456');
        $this->assertEquals($coordinate->city, 'Lilles');
        $this->assertEquals($coordinate->region, 'Nord');
        $this->assertEquals($coordinate->country, 'Suede');
        $this->assertEquals($coordinate->phone, '0411111111');
        $this->assertEquals($coordinate->mobile, '0622222222');
        $this->assertEquals($coordinate->enabled, false);
        $this->assertEquals($coordinate->suppressed, true);

        // Rights
        $this->assertEquals($supadm->rights()->count(), 0);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $supadm->id]);
        $profile = DB::table('profiles')->where('user_id', $supadm->id)->first();
        $this->assertEquals($profile->holding_id, 2);
        $this->assertEquals($profile->company_id, 7);
        $this->assertEquals($profile->office_id, 6);
    }

    /**
     * Test de la fonction Delete SuperAdministrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testDeleteSuperAdministratorRepository()
    {
        $repository = new SuperAdministratorRepository();
        $supadm = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Super Admin 10',
            'email' => 'contact_sa10@test.com',
            'password' => 'contact_sa1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);

        $repository->delete($supadm);
        $this->assertDeleted($supadm);
    }

    /**
     * Test de GetById SuperAdministrator
     */
    public function testGetByIdSuperAdministratorRepository()
    {
        $repository = new SuperAdministratorRepository();
        $supadm = $repository->getById(1);

//        dd($supadm);
        $this->assertEquals($supadm->id, 1);
        $this->assertEquals($supadm->name, "MERINDOL Cécilia SA");
        $this->assertEquals($supadm->email, "cecilia.merindol@planisphereinfo.com");
        $this->assertEquals($supadm->user_id, 1);
        $this->assertEquals($supadm->category_id, 1);
        $this->assertEquals($supadm->client_id, 1);
        $this->assertEquals($supadm->role_id, 1);
        $this->assertEquals($supadm->holding_id, 4);
        $this->assertEquals($supadm->company_id, 1);
        $this->assertEquals($supadm->office_id, 1);
        $this->assertEquals($supadm->quality, "Madame");
        $this->assertEquals($supadm->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($supadm->address2, null);
        $this->assertEquals($supadm->zip_code, "83600");
        $this->assertEquals($supadm->city, "Fréjus");
        $this->assertEquals($supadm->region, "PACA");
        $this->assertEquals($supadm->country, "France");
        $this->assertEquals($supadm->phone, "0494457479");
        $this->assertEquals($supadm->mobile, null);
        $this->assertEquals($supadm->enabled, true);
        $this->assertEquals($supadm->suppressed, false);
    }

    /**
     * Test de GetList SuperAdministrator
     */
    public function testGetPaginateSuperAdministratorRepository()
    {
        $repository = new SuperAdministratorRepository();
        $response = $repository->getPaginate(1, 10, [
            'filters' => [[
                'field' => 'users.name',
                'type' => 'string',
                'value' => "MERINDOL Cécilia SA"
            ]]
        ]);

        //dd($response);
        $supadms = $response->items();
        $supadm = $supadms[0];
        $this->assertEquals($supadm->name, "MERINDOL Cécilia SA");
        $this->assertEquals($supadm->email, "cecilia.merindol@planisphereinfo.com");
        $this->assertEquals($supadm->user_id, 1);
        $this->assertEquals($supadm->category_id, 1);
        $this->assertEquals($supadm->client_id, 1);
        $this->assertEquals($supadm->role_id, 1);
        $this->assertEquals($supadm->holding_id, 4);
        $this->assertEquals($supadm->company_id, 1);
        $this->assertEquals($supadm->office_id, 1);
        $this->assertEquals($supadm->quality, "Madame");
        $this->assertEquals($supadm->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($supadm->address2, null);
        $this->assertEquals($supadm->zip_code, "83600");
        $this->assertEquals($supadm->city, "Fréjus");
        $this->assertEquals($supadm->region, "PACA");
        $this->assertEquals($supadm->country, "France");
        $this->assertEquals($supadm->phone, "0494457479");
        $this->assertEquals($supadm->mobile, null);
        $this->assertEquals($supadm->enabled, true);
        $this->assertEquals($supadm->suppressed, false);
    }
}
