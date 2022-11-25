<?php

namespace Modules\Profile\Repositories;

use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use App\Repositories\Repository;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Profile\Entities\Manager;
use Modules\Right\Entities\RightAndProfile;

class ManagerRepository extends Repository
{
    /**
     * @param array $datas
     * @return Manager
     * @throws \Exception
     */
    public static function create(array $datas)
    {
        // Users
        $manager = new Manager();
        $manager->fill($datas);
        $manager->setAttribute('password', Hash::make($datas['password']));
        $manager->save();

        // UserCoordinates
        $requestData = $datas;
        $requestData['user_id'] = $manager->id;
        $requestData['category_id'] = FortifyServiceProvider::CATEGORY_MANAGER;
        UserCoordinateRepository::create($requestData);

        // Profiles
        DB::table('profiles')->insert([
            'client_id' => session('clientId'),
            'user_id' => $manager->id,
            'role_id' => FortifyServiceProvider::ROLE_MANAGER
        ]);

        // Rights
        $rights = RightAndProfile::query()
            ->where('client_id', session('clientId'))
            ->where('role_id', FortifyServiceProvider::ROLE_MANAGER)
            ->whereNull('user_id')
            ->get();
        /** @var RightAndProfile $right */
        foreach ($rights as $right) {
            $newRight = $right->replicate();
            $newRight->user_id = $manager->id;
            $newRight->save();
        }

        return $manager;
    }

    /**
     * @param Manager $manager
     * @param array $datas
     */
    public static function update(Manager &$manager, array $datas)
    {
        // Users
        $manager->fill($datas);
        if (isset($datas['password'])) {
            $manager->setAttribute('password', Hash::make($datas['password']));
        }
        $manager->save();

        // UserCoordinates
        $coordinate = $manager->coordinate;
        $coordinate->fill($datas);
        $coordinate->setAttribute('category_id', FortifyServiceProvider::CATEGORY_MANAGER);
        $coordinate->save();

        $exist = DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $manager->id)
            ->where('role_id', FortifyServiceProvider::ROLE_MANAGER)
            ->exists();

        // Profiles
        DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $manager->id)
            ->update([
                'role_id' => FortifyServiceProvider::ROLE_MANAGER
            ]);

        if (!$exist) {
            // Delete old Rights
            RightAndProfile::query()
                ->where('client_id', session('clientId'))
                ->where('user_id', $manager->id)
                ->delete();

            // Create new Rights
            $rights = RightAndProfile::query()
                ->where('client_id', session('clientId'))
                ->where('role_id', FortifyServiceProvider::ROLE_MANAGER)
                ->whereNull('user_id')
                ->get();
            /** @var RightAndProfile $right */
            foreach ($rights as $right) {
                $newRight = $right->replicate();
                $newRight->user_id = $manager->id;
                $newRight->save();
            }
        }
    }

    /**
     * @param Manager $manager
     */
    public static function delete(Manager &$manager)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // Delete Users - UserCoordinates - Profiles - Rights
        $manager->coordinate->delete();

        DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $manager->id)
            ->delete();

        $manager->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Manager|object
     */
    public static function getById(int $id)
    {
        return Manager::query()->where('users.id', $id)->first();
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
        $query = Manager::query();

        return self::queryFilterAndOrder($query, $validatedData, "users.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }
}
