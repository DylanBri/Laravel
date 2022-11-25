<?php

namespace Tests\Feature;

use App\Repositories\UserCoordinateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCoordinateRepositoryTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * SetUp Initiation des tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession(['clientId' => 1]);
    }

    /**
     * Test de la fonction Create UserCoordinate.
     *
     * @return void
     */
    public function testCreateUserCoordinateRepository()
    {
        $user = $this->factorySupAdm();
        $coordinate = userCoordinateRepository::create([
            'user_id' => $user->id,
            'category_id' => 1,
            'address' => '54 Chemin des Lilas',
            'enabled' => true,
            'suppressed' => false,
        ]);

//        dd($coordinate);
        $this->assertEquals($coordinate->user_id, $user->id);
        $this->assertEquals($coordinate->category_id, 1);
        $this->assertEquals($coordinate->address, '54 Chemin des Lilas');
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);
    }

    /**
     * Test de la fonction Create UserCoordinate.
     *
     * @return void
     */
    public function testCreateUserCoordinateCompleteRepository()
    {
        $user = $this->factorySupAdm();
        $coordinate = userCoordinateRepository::create([
            'user_id' => $user->id,
            'category_id' => 1,
            'quality' => 'Monsieur',
            'address' => '54 Chemin des Lilas',
            'address2' => 'BP 1254',
            'zip_code' => '58762',
            'city' => 'Angouleme',
            'region' => 'Sud',
            'country' => 'France',
            'phone' => '0400000000',
            'mobile' => '0600000000',
            'enabled' => true,
            'suppressed' => false,
        ]);

//        dd($coordinate);
        $this->assertEquals($coordinate->user_id, $user->id);
        $this->assertEquals($coordinate->category_id, 1);
        $this->assertEquals($coordinate->quality, 'Monsieur');
        $this->assertEquals($coordinate->address, '54 Chemin des Lilas');
        $this->assertEquals($coordinate->address2, 'BP 1254');
        $this->assertEquals($coordinate->zip_code, '58762');
        $this->assertEquals($coordinate->city, 'Angouleme');
        $this->assertEquals($coordinate->region, 'Sud');
        $this->assertEquals($coordinate->country, 'France');
        $this->assertEquals($coordinate->phone, '0400000000');
        $this->assertEquals($coordinate->mobile, '0600000000');
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);
    }

    /**
     * Test de la fonction update UserCoordinate.
     *
     * @return void
     */
    public function testUpdateUserCoordinateRepository()
    {
        $user = $this->factorySupAdm();
        $coordinate = userCoordinateRepository::create([
            'user_id' => $user->id,
            'category_id' => 1,
            'address' => '54 Chemin des Lilas',
            'enabled' => true,
            'suppressed' => false,
        ]);

        userCoordinateRepository::update($coordinate, [
            'user_id' => $user->id,
            'category_id' => 2,
            'address' => '58 Chemin des Mimosas',
            'enabled' => false,
            'suppressed' => true,
        ]);

        $this->assertEquals($coordinate->user_id, $user->id);
        $this->assertEquals($coordinate->category_id, 2);
        $this->assertEquals($coordinate->address, '58 Chemin des Mimosas');
        $this->assertEquals($coordinate->enabled, false);
        $this->assertEquals($coordinate->suppressed, true);
    }

    /**
     * Test de la fonction update complete UserCoordinate.
     *
     * @return void
     */
    public function testUpdateUserCoordinateRepositoryComplete()
    {
        $user = $this->factorySupAdm();
        $coordinate = userCoordinateRepository::create([
            'user_id' => $user->id,
            'category_id' => 1,
            'quality' => 'Monsieur',
            'address' => '54 Chemin des Lilas',
            'address2' => 'BP 1254',
            'zip_code' => '58762',
            'city' => 'Angouleme',
            'region' => 'Sud',
            'country' => 'France',
            'phone' => '0400000000',
            'mobile' => '0600000000',
            'enabled' => true,
            'suppressed' => false,
        ]);

        userCoordinateRepository::update($coordinate, [
            'user_id' => $user->id,
            'category_id' => 2,
            'quality' => 'Mademoiselle',
            'address' => '58 Chemin des Mimosas',
            'address2' => 'BP 584',
            'zip_code' => '68423',
            'city' => 'Strasbourg',
            'region' => 'Nord',
            'country' => 'Thaiti',
            'phone' => '0411111111',
            'mobile' => '0622222222',
            'enabled' => false,
            'suppressed' => true,
        ]);

        $this->assertEquals($coordinate->user_id, $user->id);
        $this->assertEquals($coordinate->category_id, 2);
        $this->assertEquals($coordinate->quality, 'Mademoiselle');
        $this->assertEquals($coordinate->address, '58 Chemin des Mimosas');
        $this->assertEquals($coordinate->address2, 'BP 584');
        $this->assertEquals($coordinate->zip_code, '68423');
        $this->assertEquals($coordinate->city, 'Strasbourg');
        $this->assertEquals($coordinate->region, 'Nord');
        $this->assertEquals($coordinate->country, 'Thaiti');
        $this->assertEquals($coordinate->phone, '0411111111');
        $this->assertEquals($coordinate->mobile, '0622222222');
        $this->assertEquals($coordinate->enabled, false);
        $this->assertEquals($coordinate->suppressed, true);
    }

    /**
     * Test de la fonction delete UserCoordinate.
     *
     * @return void
     */
    public function testDeleteUserCoordinateRepository()
    {
        $user = $this->factorySupAdm();
        $coordinate = userCoordinateRepository::create([
            'user_id' => $user->id,
            'category_id' => 1,
            'address' => '54 Chemin des Lilas',
            'enabled' => true,
            'suppressed' => false,
        ]);

        userCoordinateRepository::delete($coordinate);
        $this->assertDeleted($coordinate);
    }

    /**
     * Test de GetbyId UserCoordinate
     */
    public function testGetByIdUserCoordinateRepository()
    {
        $coordinate = userCoordinateRepository::getById(1);

//        dd($coordinate);
        $this->assertEquals($coordinate->user_id, 1);
        $this->assertEquals($coordinate->category_id, 1);
        $this->assertEquals($coordinate->quality, 'Madame');
        $this->assertEquals($coordinate->address, '51 Impasse Thomas Edison 1');
        $this->assertEquals($coordinate->address2, null);
        $this->assertEquals($coordinate->zip_code, '83600');
        $this->assertEquals($coordinate->city, 'Fréjus');
        $this->assertEquals($coordinate->region, 'PACA');
        $this->assertEquals($coordinate->country, 'France');
        $this->assertEquals($coordinate->phone, '0494457479');
        $this->assertEquals($coordinate->mobile, null);
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);
    }

    /**
     * Test de GetByUserId UserCoordinate
     */
    public function testGetByUserIdUserCoordinateRepository()
    {
        $coordinate = userCoordinateRepository::getByUserId(1);

//        dd($coordinate);
        $this->assertEquals($coordinate->user_id, 1);
        $this->assertEquals($coordinate->category_id, 1);
        $this->assertEquals($coordinate->quality, 'Madame');
        $this->assertEquals($coordinate->address, '51 Impasse Thomas Edison 1');
        $this->assertEquals($coordinate->address2, null);
        $this->assertEquals($coordinate->zip_code, '83600');
        $this->assertEquals($coordinate->city, 'Fréjus');
        $this->assertEquals($coordinate->region, 'PACA');
        $this->assertEquals($coordinate->country, 'France');
        $this->assertEquals($coordinate->phone, '0494457479');
        $this->assertEquals($coordinate->mobile, null);
        $this->assertEquals($coordinate->enabled, true);
        $this->assertEquals($coordinate->suppressed, false);
    }

    /**
     * Test de autocomplete UserCoordinate
     */
    public function testGetAutocompleteUserCoordinateRepository()
    {
        $qualities = userCoordinateRepository::autocomplete(['query' => 'Mada']);

//        dd($qualities[0]);
        $this->assertEquals($qualities[0]->quality, 'Madame');
    }
}
