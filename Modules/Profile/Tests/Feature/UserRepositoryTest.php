<?php

namespace Modules\Profile\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\Profile\Repositories\UserRepository;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
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
     * Test de la fonction Create User.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateUserRepository()
    {
        $repository = new UserRepository();
        $user = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'User 1',
            'email' => 'contact_usr1@test.com',
            'password' => 'contact_usr1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($user->coordinate);

        $this->assertEquals($user->name, 'User 1');
        $this->assertEquals($user->email, 'contact_usr1@test.com');
//        $this->assertEquals($user->password, 'contact_usr1@test.com'); // hash

        // Coordinate
        $coordinate = $user->coordinate;
        $this->assertEquals($coordinate->address, '36 Rue de Londres');
        $this->assertEquals($coordinate->country, 'France');
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);

        // Rights
        $this->assertEquals($user->rights()->count(), 11);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $user->id]);
        $profile = DB::table('profiles')->where('user_id', $user->id)->first();
        $this->assertEquals($profile->holding_id, 1);
        $this->assertEquals($profile->company_id, 1);
        $this->assertEquals($profile->office_id, 1);
    }

    /**
     * Test de la fonction Create User.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateUserRepositoryComplete()
    {
        $repository = new UserRepository();
        $user = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'category_id' => 4,
            'quality' => 'Monsieur',
            'name' => 'User 2',
            'email' => 'contact_usr2@test.com',
            'password' => 'contact_usr2@test.com',
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
//        dd($userA->coordinate);

        $this->assertEquals($user->name, 'User 2');
        $this->assertEquals($user->email, 'contact_usr2@test.com');
//        $this->assertEquals($user->password, 'contact_usr1@test.com'); // hash

        // Coordinate
        $coordinate = $user->coordinate;
        $this->assertEquals($coordinate->category_id, 4);
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
        $this->assertEquals($user->rights()->count(), 11);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $user->id]);
        $profile = DB::table('profiles')->where('user_id', $user->id)->first();
        $this->assertEquals($profile->holding_id, 1);
        $this->assertEquals($profile->company_id, 1);
        $this->assertEquals($profile->office_id, 1);
    }

    /**
     * Test de la fonction Update User.
     *
     * @return void
     * @throws \Exception
     */
    public function testUpdateUserRepository()
    {
        $repository = new UserRepository();
        $user = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'User num 1',
            'email' => 'contact_usr_num1@test.com',
            'password' => 'contact_usr1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);
//        dd($user);

        $repository->update($user, [
            'holding_id' => 2,
            'company_id' => 7,
            'office_id' => 5,
            'name' => 'User num 2',
            'email' => 'contact_usr_num2@test.com',
            'password' => 'contact_usr_num1@test.com',
            'address' => '36 Rue de Madrid',
            'country' => 'Espagne',
            'enabled' => false,
            'suppressed' => true
        ]);
//        dd($user->coordinate);

        $this->assertEquals($user->name, 'User num 2');
        $this->assertEquals($user->email, 'contact_usr_num2@test.com');
//        $this->assertEquals($user->password, 'contact_usr1@test.com'); // hash

        // Coordinate
        $coordinate = $user->coordinate;
        $this->assertEquals($coordinate->address, '36 Rue de Madrid');
        $this->assertEquals($coordinate->country, 'Espagne');
        $this->assertEquals($coordinate->enabled, false);
        $this->assertEquals($coordinate->suppressed, true);

        // Rights
        $this->assertEquals($user->rights()->count(), 11);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $user->id]);
        $profile = DB::table('profiles')->where('user_id', $user->id)->first();
        $this->assertEquals($profile->holding_id, 2);
        $this->assertEquals($profile->company_id, 7);
        $this->assertEquals($profile->office_id, 5);
    }

    /**
     * Test de la fonction Update Complete User.
     *
     * @return void
     * @throws \Exception
     */
    public function testUpdateUserRepositoryComplete()
    {
        $repository = new UserRepository();
        $user = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'category_id' => 4,
            'quality' => 'Monsieur',
            'name' => 'User num 3',
            'email' => 'contact_usr_num3@test.com',
            'password' => 'contact_usr_num3@test.com',
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

        $repository->update($user, [
            'holding_id' => 2,
            'company_id' => 7,
            'office_id' => 6,
            'user_id' => 2,
            'category_id' => 5,
            'quality' => 'Mademoiselle',
            'name' => 'User num 4',
            'email' => 'contact_usr_num4@test.com',
            'password' => 'contact_usr_num4@test.com',
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
//        dd($user->coordinate);

        $this->assertEquals($user->name, 'User num 4');
        $this->assertEquals($user->email, 'contact_usr_num4@test.com');
//        $this->assertEquals($user->password, 'contact_usr1@test.com'); // hash

        // Coordinate
        $coordinate = $user->coordinate;
        $this->assertEquals($coordinate->category_id, 4);
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
        $this->assertEquals($user->rights()->count(), 11);

        // Profile
        $this->assertDatabaseHas('profiles', ['user_id' => $user->id]);
        $profile = DB::table('profiles')->where('user_id', $user->id)->first();
        $this->assertEquals($profile->holding_id, 2);
        $this->assertEquals($profile->company_id, 7);
        $this->assertEquals($profile->office_id, 6);
    }

    /**
     * Test de la fonction Delete User.
     *
     * @return void
     * @throws \Exception
     */
    public function testDeleteUserRepository()
    {
        $repository = new UserRepository();
        $user = $repository->create([
            'holding_id' => 1,
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'User 10',
            'email' => 'contact_usr10@test.com',
            'password' => 'contact_usr1@test.com',
            'address' => '36 Rue de Londres',
            'country' => 'France',
            'enabled' => true,
            'suppressed' => false
        ]);

        $repository->delete($user);
        $this->assertDeleted($user);
    }

    /**
     * Test de GetById User
     */
    public function testGetByIdUserRepository()
    {
        $repository = new UserRepository();
        $user = $repository->getById(4);

//        dd($user);
        $this->assertEquals($user->id, 4);
        $this->assertEquals($user->name, "MERINDOL Cécilia User");
        $this->assertEquals($user->email, "user@test.com");
        $this->assertEquals($user->user_id, 4);
        $this->assertEquals($user->category_id, 4);
        $this->assertEquals($user->client_id, 1);
        $this->assertEquals($user->role_id, 4);
        $this->assertEquals($user->holding_id, 4);
        $this->assertEquals($user->company_id, 1);
        $this->assertEquals($user->office_id, 1);
        $this->assertEquals($user->quality, null);
        $this->assertEquals($user->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($user->address2, null);
        $this->assertEquals($user->zip_code, "83600");
        $this->assertEquals($user->city, "Fréjus");
        $this->assertEquals($user->region, "PACA");
        $this->assertEquals($user->country, "France");
        $this->assertEquals($user->phone, "0494457479");
        $this->assertEquals($user->mobile, null);
        $this->assertEquals($user->enabled, true);
        $this->assertEquals($user->suppressed, false);
    }

    /**
     * Test de GetListForOptions User
     */
    public function testGetListForOptionsUserRepository()
    {
        $repository = new UserRepository();
        $users = $repository->getListForOptions([4]);

        //dd($users);
        $user = $users[0];
        $this->assertEquals($user->id, 4);
        $this->assertEquals($user->name,"MERINDOL Cécilia User");
    }

    /**
     * Test de GetList User
     */
    public function testGetPaginateUserRepository()
    {
        $repository = new UserRepository();
        $response = $repository->getPaginate(1, 10, [
            'filters' => [[
                'field' => 'users.name',
                'type' => 'string',
                'value' => "MERINDOL Cécilia User"
            ]]
        ]);

        //dd($response);
        $users = $response->items();
        $user = $users[0];
        $this->assertEquals($user->name, "MERINDOL Cécilia User");
        $this->assertEquals($user->email, "user@test.com");
        $this->assertEquals($user->user_id, 4);
        $this->assertEquals($user->category_id, 4);
        $this->assertEquals($user->client_id, 1);
        $this->assertEquals($user->role_id, 4);
        $this->assertEquals($user->holding_id, 4);
        $this->assertEquals($user->company_id, 1);
        $this->assertEquals($user->office_id, 1);
        $this->assertEquals($user->quality, null);
        $this->assertEquals($user->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($user->address2, null);
        $this->assertEquals($user->zip_code, "83600");
        $this->assertEquals($user->city, "Fréjus");
        $this->assertEquals($user->region, "PACA");
        $this->assertEquals($user->country, "France");
        $this->assertEquals($user->phone, "0494457479");
        $this->assertEquals($user->mobile, null);
        $this->assertEquals($user->enabled, true);
        $this->assertEquals($user->suppressed, false);
    }

    /**
     * Test de Search User
     */
    public function testSearchUserRepository()
    {
        $repository = new UserRepository();
        $response = $repository->search([
            'filters' => [[
                'field' => 'users.name',
                'type' => 'string',
                'value' => "MERINDOL Cécilia User"
            ]]
        ]);

//        dd($response);
        $user = $response[0];
        $this->assertEquals($user->name, "MERINDOL Cécilia User");
        $this->assertEquals($user->email, "user@test.com");
        $this->assertEquals($user->user_id, 4);
        $this->assertEquals($user->category_id, 4);
        $this->assertEquals($user->client_id, 1);
        $this->assertEquals($user->role_id, 4);
        $this->assertEquals($user->holding_id, 4);
        $this->assertEquals($user->company_id, 1);
        $this->assertEquals($user->office_id, 1);
        $this->assertEquals($user->quality, null);
        $this->assertEquals($user->address, "51 Impasse Thomas Edison 1");
        $this->assertEquals($user->address2, null);
        $this->assertEquals($user->zip_code, "83600");
        $this->assertEquals($user->city, "Fréjus");
        $this->assertEquals($user->region, "PACA");
        $this->assertEquals($user->country, "France");
        $this->assertEquals($user->phone, "0494457479");
        $this->assertEquals($user->mobile, null);
        $this->assertEquals($user->enabled, true);
        $this->assertEquals($user->suppressed, false);
    }
}
