<?php

namespace Modules\Profile\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\Profile\Repositories\AdministratorRepository;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class AdministratorRepositoryTest extends TestCase
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
     * Test de la fonction Create Administrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateAdministratorRepository()
    {
        $repository = new AdministratorRepository();
        $admin = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Admin 1',
            'email' => 'contact_adm1@test.com',
            'password' => 'contact_adm1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($admin->coordinate);

        $this->assertEquals($admin->name, 'Admin 1');
        $this->assertEquals($admin->email, 'contact_adm1@test.com');
//        $this->assertEquals($admin->password, 'contact_adm1@test.com'); // hash

        // Coordinate
        $coordinate = $admin->coordinate;
        $this->assertEquals($coordinate->address, '36 Rue de Londres');
        $this->assertEquals($coordinate->country, 'France');
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);

        // Rights
        $this->assertEquals($admin->rights()->count(), 28);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $admin->id]);
        $profile = DB::table('profiles')->where('user_id', $admin->id)->first();
        $this->assertEquals($profile->holding_id, 1);
        $this->assertEquals($profile->company_id, 1);
        $this->assertEquals($profile->office_id, 1);
    }

    /**
     * Test de la fonction Create Administrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateAdministratorRepositoryComplete()
    {
        $repository = new AdministratorRepository();
        $admin = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'category_id' => 2,
            'quality' => 'Monsieur',
            'name' => 'Admin 2',
            'email' => 'contact_adm2@test.com',
            'password' => 'contact_adm2@test.com',
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
//        dd($admin->coordinate);

        $this->assertEquals($admin->name, 'Admin 2');
        $this->assertEquals($admin->email, 'contact_adm2@test.com');
//        $this->assertEquals($admin->password, 'contact_adm1@test.com'); // hash

        // Coordinate
        $coordinate = $admin->coordinate;
        $this->assertEquals($coordinate->category_id, 2);
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
        $this->assertEquals($admin->rights()->count(), 28);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $admin->id]);
        $profile = DB::table('profiles')->where('user_id', $admin->id)->first();
        $this->assertEquals($profile->holding_id, 1);
        $this->assertEquals($profile->company_id, 1);
        $this->assertEquals($profile->office_id, 1);
    }

    /**
     * Test de la fonction Update Administrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testUpdateAdministratorRepository()
    {
        $repository = new AdministratorRepository();
        $admin = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Admin num 1',
            'email' => 'contact_adm_num1@test.com',
            'password' => 'contact_adm1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($admin);

        $repository->update($admin, [
            'holding_id' => 2,
            'company_id' => 7,
            'office_id' => 5,
            'name' => 'Admin num 2',
            'email' => 'contact_adm_num2@test.com',
            'password' => 'contact_adm_num1@test.com',
            'address' => '36 Rue de Madrid',
            'country' => 'Espagne',
            'enabled' => false,
            'suppressed' => true
        ]);
//        dd($admin->coordinate);

        $this->assertEquals($admin->name, 'Admin num 2');
        $this->assertEquals($admin->email, 'contact_adm_num2@test.com');
//        $this->assertEquals($admin->password, 'contact_adm1@test.com'); // hash

        // Coordinate
        $coordinate = $admin->coordinate;
        $this->assertEquals($coordinate->address, '36 Rue de Madrid');
        $this->assertEquals($coordinate->country, 'Espagne');
        $this->assertEquals($coordinate->enabled, false);
        $this->assertEquals($coordinate->suppressed, true);

        // Rights
        $this->assertEquals($admin->rights()->count(), 28);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $admin->id]);
        $profile = DB::table('profiles')->where('user_id', $admin->id)->first();
        $this->assertEquals($profile->holding_id, 2);
        $this->assertEquals($profile->company_id, 7);
        $this->assertEquals($profile->office_id, 5);
    }

    /**
     * Test de la fonction Update Complete Administrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testUpdateAdministratorRepositoryComplete()
    {
        $repository = new AdministratorRepository();
        $admin = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'category_id' => 2,
            'quality' => 'Monsieur',
            'name' => 'Admin num 3',
            'email' => 'contact_adm_num3@test.com',
            'password' => 'contact_adm_num3@test.com',
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

        $repository->update($admin, [
            'holding_id' => 2,
            'company_id' => 7,
            'office_id' => 6,
            'user_id' => 2,
            'category_id' => 3,
            'quality' => 'Mademoiselle',
            'name' => 'Admin num 4',
            'email' => 'contact_adm_num4@test.com',
            'password' => 'contact_adm_num4@test.com',
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
//        dd($admin->coordinate);

        $this->assertEquals($admin->name, 'Admin num 4');
        $this->assertEquals($admin->email, 'contact_adm_num4@test.com');
//        $this->assertEquals($admin->password, 'contact_adm1@test.com'); // hash

        // Coordinate
        $coordinate = $admin->coordinate;
        $this->assertEquals($coordinate->category_id, 2);
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
        $this->assertEquals($admin->rights()->count(), 28);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $admin->id]);
        $profile = DB::table('profiles')->where('user_id', $admin->id)->first();
        $this->assertEquals($profile->holding_id, 2);
        $this->assertEquals($profile->company_id, 7);
        $this->assertEquals($profile->office_id, 6);
    }

    /**
     * Test de la fonction Delete Administrator.
     *
     * @return void
     * @throws \Exception
     */
    public function testDeleteAdministratorRepository()
    {
        $repository = new AdministratorRepository();
        $admin = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Admin 10',
            'email' => 'contact_adm10@test.com',
            'password' => 'contact_adm1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);

        $repository->delete($admin);
        $this->assertDeleted($admin);
    }

    /**
     * Test de GetById Administrator
     */
    public function testGetByIdAdministratorRepository()
    {
        $repository = new AdministratorRepository();
        $admin = $repository->getById(2);

//        dd($admin);
        $this->assertEquals($admin->id, 2);
        $this->assertEquals($admin->name, "MERINDOL Cécilia Admin");
        $this->assertEquals($admin->email, "admin@test.com");
        $this->assertEquals($admin->user_id, 2);
        $this->assertEquals($admin->category_id, 2);
        $this->assertEquals($admin->client_id, 1);
        $this->assertEquals($admin->role_id, 2);
        $this->assertEquals($admin->holding_id, 1);
        $this->assertEquals($admin->company_id, 4);
        $this->assertEquals($admin->office_id, 3);
        $this->assertEquals($admin->quality, null);
        $this->assertEquals($admin->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($admin->address2, null);
        $this->assertEquals($admin->zip_code, "83600");
        $this->assertEquals($admin->city, "Fréjus");
        $this->assertEquals($admin->region, "PACA");
        $this->assertEquals($admin->country, "France");
        $this->assertEquals($admin->phone, "0494457479");
        $this->assertEquals($admin->mobile, null);
        $this->assertEquals($admin->enabled, true);
        $this->assertEquals($admin->suppressed, false);
    }

    /**
     * Test de GetList Administrator
     */
    public function testGetPaginateAdministratorRepository()
    {
        $repository = new AdministratorRepository();
        $response = $repository->getPaginate(1, 10, [
            'filters' => [[
                'field' => 'users.name',
                'type' => 'string',
                'value' => "MERINDOL Cécilia Admin"
            ]]
        ]);

        //dd($response);
        $admins = $response->items();
        $admin = $admins[0];
        $this->assertEquals($admin->name, "MERINDOL Cécilia Admin");
        $this->assertEquals($admin->email, "admin@test.com");
        $this->assertEquals($admin->user_id, 2);
        $this->assertEquals($admin->category_id, 2);
        $this->assertEquals($admin->client_id, 1);
        $this->assertEquals($admin->role_id, 2);
        $this->assertEquals($admin->holding_id, 1);
        $this->assertEquals($admin->company_id, 4);
        $this->assertEquals($admin->office_id, 3);
        $this->assertEquals($admin->quality, null);
        $this->assertEquals($admin->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($admin->address2, null);
        $this->assertEquals($admin->zip_code, "83600");
        $this->assertEquals($admin->city, "Fréjus");
        $this->assertEquals($admin->region, "PACA");
        $this->assertEquals($admin->country, "France");
        $this->assertEquals($admin->phone, "0494457479");
        $this->assertEquals($admin->mobile, null);
        $this->assertEquals($admin->enabled, true);
        $this->assertEquals($admin->suppressed, false);
    }
}
