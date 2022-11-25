<?php

namespace Modules\Profile\Repositories;

use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use App\Repositories\Repository;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Profile\Entities\Administrator;
use Modules\Profile\Entities\Manager;
use Modules\Profile\Entities\User;
use Modules\Right\Entities\RightAndProfile;

class UserRepository extends Repository
{
    /**
     * @param array $datas
     * @return User
     * @throws \Exception
     */
    public static function create(array $datas)
    {
        $user = new User();
        $user->fill($datas);
        $user->setAttribute('password', Hash::make($datas['password']));
        $user->save();

        $requestData = $datas;
        $requestData['user_id'] = $user->id;
        $requestData['category_id'] = FortifyServiceProvider::CATEGORY_USER;
        UserCoordinateRepository::create($requestData);

        DB::table('profiles')->insert([
            'client_id' => session('clientId'),
            'user_id' => $user->id,
            'role_id' => FortifyServiceProvider::ROLE_USER
        ]);

        // Rights
        $rights = RightAndProfile::query()
            ->where('client_id', session('clientId'))
            ->where('role_id', FortifyServiceProvider::ROLE_USER)
            ->whereNull('user_id')
            ->get();
        /** @var RightAndProfile $right */
        foreach ($rights as $right) {
            $newRight = $right->replicate();
            $newRight->user_id = $user->id;
            $newRight->save();
        }

        return $user;
    }

    /**
     * @param User $user
     * @param array $datas
     */
    public static function update(User &$user, array $datas)
    {
        $user->fill($datas);
        if (isset($datas['password'])) {
            $user->setAttribute('password', Hash::make($datas['password']));
        }
        $user->save();

        $coordinate = $user->coordinate;
        if ($coordinate === null) {
            $coordinate = new UserCoordinate();
            $coordinate->setAttribute('user_id', $user->id);
        }
        $coordinate->fill($datas);
        $coordinate->setAttribute('category_id', FortifyServiceProvider::CATEGORY_USER);
        $coordinate->save();

        $exist = DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $user->id)
            ->where('role_id', FortifyServiceProvider::ROLE_USER)
            ->exists();

        DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $user->id)
            ->update([
                'role_id' => FortifyServiceProvider::ROLE_USER
            ]);

        if (!$exist) {
            // Delete old Rights
            RightAndProfile::query()
                ->where('client_id', session('clientId'))
                ->where('user_id', $user->id)
                ->delete();

            // Create new Rights
            $rights = RightAndProfile::query()
                ->where('client_id', session('clientId'))
                ->where('role_id', FortifyServiceProvider::ROLE_USER)
                ->whereNull('user_id')
                ->get();
            /** @var RightAndProfile $right */
            foreach ($rights as $right) {
                $newRight = $right->replicate();
                $newRight->user_id = $user->id;
                $newRight->save();
            }
        }
    }

    /**
     * @param User $user
     */
    public static function delete(User &$user)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // Delete Users - UserCoordinates - Profiles - Rights
        $user->coordinate->delete();

        DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $user->id)
            ->delete();

        $user->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|User|object
     */
    public static function getById(int $id)
    {
        return User::query()->where('users.id', $id)->first();
    }

    /**
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getListForOptions(array $ids = [])
    {
        $users = User::query()
            ->where('company_id', session('companyId'))
            ->orWhereIn('users.id', $ids)
            ->get(['users.id', 'users.name']);

        return $users;
    }

    /**
     * @param int $currentPage
     * @param int $perPage
     * @param array $validatedData
     * @return mixed
     */
    public static function getPaginate(int $currentPage, int $perPage, array $validatedData)
    {
        // Begin with function queryBase
        $query = User::query();

        return self::queryFilterAndOrder($query, $validatedData, "users.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }

    /**
     * @param array $validatedData
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function search(array $validatedData)
    {
        // Admin spécifique
        $subQuery = '(SELECT name FROM user_categories WHERE user_categories.id = user_coordinates.category_id)' .
            ' as category_name';
        $query = Administrator::query()
            ->select('*')
            ->selectRaw($subQuery)
            ->where('holding_id', session('holdingId'));
        $admins = self::queryFilterAndOrder($query, $validatedData, "users.id")
            ->get();

        // Manager spécifique
        $subQuery = '(SELECT name FROM user_categories WHERE user_categories.id = user_coordinates.category_id)' .
            ' as category_name';
        $query = Manager::query()
            ->select('*')
            ->selectRaw($subQuery)
            ->where('company_id', session('companyId'));
        $managers = self::queryFilterAndOrder($query, $validatedData, "users.id")
            ->get();

        foreach ($managers as $manager) {
            $admins->add($manager);
        }

        // Begin with function queryBase
        $subQuery = '(SELECT name FROM user_categories WHERE user_categories.id = user_coordinates.category_id)' .
            ' as category_name';
        $query = User::query()
            ->select('*')
            ->selectRaw($subQuery);
        $users = self::queryFilterAndOrder($query, $validatedData, "users.id")
            ->get();

        foreach ($users as $user) {
            $admins->add($user);
        }

        return $admins;
    }
}
