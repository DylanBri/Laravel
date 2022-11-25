<?php

namespace Tests;

use App\Models\User;
use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Right\Entities\RightAndProfile;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return User
     */
    protected function factorySupAdm() 
    {
        /** @var User $user */
        $user = User::factory()->create();
        UserCoordinate::factory()
                ->create([
                    'user_id' => $user->id,
                    'category_id' => FortifyServiceProvider::CATEGORY_SUPADM,
                ]);

        return $user;
    }

    /**
     * @var int $rightId
     * @return User
     */
    protected function factoryAdmin(int $rightId) 
    {
        /** @var User $user */
        $user = User::factory()->create();
        UserCoordinate::factory()
        ->create([
            'user_id' => $user->id,
            'category_id' => FortifyServiceProvider::CATEGORY_ADMIN
        ]);

        RightAndProfile::factory()
        ->create([
            'client_id' => 1,
            'user_id' => $user->id,
            'role_id' => FortifyServiceProvider::ROLE_ADMIN,
            'right_id' => $rightId
        ]);

        return $user;
    }

    /**
     * @var int $rightId
     * @return User
     */
    protected function factoryManager(int $rightId) 
    {
        /** @var User $user */
        $user = User::factory()->create();
        UserCoordinate::factory()
        ->create([
            'user_id' => $user->id,
            'category_id' => FortifyServiceProvider::CATEGORY_MANAGER
        ]);

        RightAndProfile::factory()
        ->create([
            'client_id' => 1,
            'user_id' => $user->id,
            'role_id' => FortifyServiceProvider::ROLE_MANAGER,
            'right_id' => $rightId
        ]);

        return $user;
    }

    /**
     * @var int $rightId
     * @return User
     */
    protected function factoryUser(int $rightId)
    {
        /** @var User $user */
        $user = User::factory()->create();
        UserCoordinate::factory()
        ->create([
            'user_id' => $user->id,
            'category_id' => FortifyServiceProvider::CATEGORY_USER
        ]);

        RightAndProfile::factory()
        ->create([
            'client_id' => 1,
            'user_id' => $user->id,
            'role_id' => FortifyServiceProvider::ROLE_USER,
            'right_id' => $rightId
        ]);

        return $user;
    }
}
