<?php

namespace Modules\Profile\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\Profile\Repositories\ManagerRepository;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerRepositoryTest extends TestCase
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
     * Test de la fonction Create Manager.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateManagerRepository()
    {
        $repository = new ManagerRepository();
        $manager = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Manager 1',
            'email' => 'contact_mng1@test.com',
            'password' => 'contact_mng1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($manager->coordinate);

        $this->assertEquals($manager->name, 'Manager 1');
        $this->assertEquals($manager->email, 'contact_mng1@test.com');
//        $this->assertEquals($manager->password, 'contact_mng1@test.com'); // hash

        // Coordinate
        $coordinate = $manager->coordinate;
        $this->assertEquals($coordinate->address, '36 Rue de Londres');
        $this->assertEquals($coordinate->country, 'France');
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);

        // Rights
        $this->assertEquals($manager->rights()->count(), 18);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $manager->id]);
        $profile = DB::table('profiles')->where('user_id', $manager->id)->first();
        $this->assertEquals($profile->holding_id, 1);
        $this->assertEquals($profile->company_id, 1);
        $this->assertEquals($profile->office_id, 1);
    }

    /**
     * Test de la fonction Create Manager.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateManagerRepositoryComplete()
    {
        $repository = new ManagerRepository();
        $manager = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'category_id' => 3,
            'quality' => 'Monsieur',
            'name' => 'Manager 2',
            'email' => 'contact_mng2@test.com',
            'password' => 'contact_mng2@test.com',
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
//        dd($manager->coordinate);

        $this->assertEquals($manager->name, 'Manager 2');
        $this->assertEquals($manager->email, 'contact_mng2@test.com');
//        $this->assertEquals($manager->password, 'contact_mng1@test.com'); // hash

        // Coordinate
        $coordinate = $manager->coordinate;
        $this->assertEquals($coordinate->category_id, 3);
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
        $this->assertEquals($manager->rights()->count(), 18);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $manager->id]);
        $profile = DB::table('profiles')->where('user_id', $manager->id)->first();
        $this->assertEquals($profile->holding_id, 1);
        $this->assertEquals($profile->company_id, 1);
        $this->assertEquals($profile->office_id, 1);
    }

    /**
     * Test de la fonction Update Manager.
     *
     * @return void
     * @throws \Exception
     */
    public function testUpdateManagerRepository()
    {
        $repository = new ManagerRepository();
        $manager = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Manager num 1',
            'email' => 'contact_mng_num1@test.com',
            'password' => 'contact_mng1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($manager);

        $repository->update($manager, [
            'holding_id' => 2,
            'company_id' => 7,
            'office_id' => 5,
            'name' => 'Manager num 2',
            'email' => 'contact_mng_num2@test.com',
            'password' => 'contact_mng_num1@test.com',
            'address' => '36 Rue de Madrid',
            'country' => 'Espagne',
            'enabled' => false,
            'suppressed' => true
        ]);
//        dd($manager->coordinate);

        $this->assertEquals($manager->name, 'Manager num 2');
        $this->assertEquals($manager->email, 'contact_mng_num2@test.com');
//        $this->assertEquals($manager->password, 'contact_mng1@test.com'); // hash

        // Coordinate
        $coordinate = $manager->coordinate;
        $this->assertEquals($coordinate->address, '36 Rue de Madrid');
        $this->assertEquals($coordinate->country, 'Espagne');
        $this->assertEquals($coordinate->enabled, false);
        $this->assertEquals($coordinate->suppressed, true);

        // Rights
        $this->assertEquals($manager->rights()->count(), 18);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $manager->id]);
        $profile = DB::table('profiles')->where('user_id', $manager->id)->first();
        $this->assertEquals($profile->holding_id, 2);
        $this->assertEquals($profile->company_id, 7);
        $this->assertEquals($profile->office_id, 5);
    }

    /**
     * Test de la fonction Update Complete Manager.
     *
     * @return void
     * @throws \Exception
     */
    public function testUpdateManagerRepositoryComplete()
    {
        $repository = new ManagerRepository();
        $manager = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'category_id' => 3,
            'quality' => 'Monsieur',
            'name' => 'Manager num 3',
            'email' => 'contact_mng_num3@test.com',
            'password' => 'contact_mng_num3@test.com',
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

        $repository->update($manager, [
            'holding_id' => 2,
            'company_id' => 7,
            'office_id' => 6,
            'user_id' => 2,
            'category_id' => 4,
            'quality' => 'Mademoiselle',
            'name' => 'Manager num 4',
            'email' => 'contact_mng_num4@test.com',
            'password' => 'contact_mng_num4@test.com',
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
//        dd($manager->coordinate);

        $this->assertEquals($manager->name, 'Manager num 4');
        $this->assertEquals($manager->email, 'contact_mng_num4@test.com');
//        $this->assertEquals($manager->password, 'contact_mng1@test.com'); // hash

        // Coordinate
        $coordinate = $manager->coordinate;
        $this->assertEquals($coordinate->category_id, 3);
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
        $this->assertEquals($manager->rights()->count(), 18);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $manager->id]);
        $profile = DB::table('profiles')->where('user_id', $manager->id)->first();
        $this->assertEquals($profile->holding_id, 2);
        $this->assertEquals($profile->company_id, 7);
        $this->assertEquals($profile->office_id, 6);
    }

    /**
     * Test de la fonction Delete Manager.
     *
     * @return void
     * @throws \Exception
     */
    public function testDeleteManagerRepository()
    {
        $repository = new ManagerRepository();
        $manager = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Manager 10',
            'email' => 'contact_mng10@test.com',
            'password' => 'contact_mng1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);

        $repository->delete($manager);
        $this->assertDeleted($manager);
    }

    /**
     * Test de GetById Manager
     */
    public function testGetByIdManagerRepository()
    {
        $repository = new ManagerRepository();
        $manager = $repository->getById(3);

//        dd($manager);
        $this->assertEquals($manager->id, 3);
        $this->assertEquals($manager->name, "MERINDOL Cécilia Manager");
        $this->assertEquals($manager->email, "manager@test.com");
        $this->assertEquals($manager->user_id, 3);
        $this->assertEquals($manager->category_id, 3);
        $this->assertEquals($manager->client_id, 1);
        $this->assertEquals($manager->role_id, 3);
        $this->assertEquals($manager->holding_id, 4);
        $this->assertEquals($manager->company_id, 1);
        $this->assertEquals($manager->office_id, 1);
        $this->assertEquals($manager->quality, null);
        $this->assertEquals($manager->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($manager->address2, null);
        $this->assertEquals($manager->zip_code, "83600");
        $this->assertEquals($manager->city, "Fréjus");
        $this->assertEquals($manager->region, "PACA");
        $this->assertEquals($manager->country, "France");
        $this->assertEquals($manager->phone, "0494457479");
        $this->assertEquals($manager->mobile, null);
        $this->assertEquals($manager->enabled, true);
        $this->assertEquals($manager->suppressed, false);
    }

    /**
     * Test de GetList Manager
     */
    public function testGetPaginateManagerRepository()
    {
        $repository = new ManagerRepository();
        $response = $repository->getPaginate(1, 10, [
            'filters' => [[
                'field' => 'users.name',
                'type' => 'string',
                'value' => "MERINDOL Cécilia Manager"
            ]]
        ]);

        //dd($response);
        $managers = $response->items();
        $manager = $managers[0];
        $this->assertEquals($manager->name, "MERINDOL Cécilia Manager");
        $this->assertEquals($manager->email, "manager@test.com");
        $this->assertEquals($manager->user_id, 3);
        $this->assertEquals($manager->category_id, 3);
        $this->assertEquals($manager->client_id, 1);
        $this->assertEquals($manager->role_id, 3);
        $this->assertEquals($manager->holding_id, 4);
        $this->assertEquals($manager->company_id, 1);
        $this->assertEquals($manager->office_id, 1);
        $this->assertEquals($manager->quality, null);
        $this->assertEquals($manager->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($manager->address2, null);
        $this->assertEquals($manager->zip_code, "83600");
        $this->assertEquals($manager->city, "Fréjus");
        $this->assertEquals($manager->region, "PACA");
        $this->assertEquals($manager->country, "France");
        $this->assertEquals($manager->phone, "0494457479");
        $this->assertEquals($manager->mobile, null);
        $this->assertEquals($manager->enabled, true);
        $this->assertEquals($manager->suppressed, false);
    }
}
