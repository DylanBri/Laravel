<?php

namespace Modules\Profile\Repositories;

use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use App\Repositories\Repository;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Log;
use Modules\Profile\Entities\SuperAdministrator;

class SuperAdministratorRepository extends Repository
{
    /**
     * @param array $datas
     * @return SuperAdministrator
     * @throws \Exception
     */
    public static function create(array $datas)
    {
        // Users
        $supadm = new SuperAdministrator();
        $supadm->fill($datas);
        $supadm->setAttribute('password', Hash::make($datas['password']));
        $supadm->save();
//        Log::debug($supadm);

        // UserCoordinates
        $datas['user_id'] = $supadm->id;
        $datas['category_id'] = FortifyServiceProvider::CATEGORY_SUPADM;
        UserCoordinateRepository::create($datas);
//        Log::debug($coordinate);

        // Profiles
        DB::table('profiles')->insert([
            'client_id' => session('clientId'),
            'user_id' => $supadm->id,
            'role_id' => FortifyServiceProvider::ROLE_SUPADM
        ]);

        // All Rights

        return $supadm;
    }

    /**
     * @param SuperAdministrator $supadm
     * @param array $datas
     * @throws \Exception
     */
    public static function update(SuperAdministrator &$supadm, array $datas)
    {
        // Users
        $supadm->fill($datas);
        if (isset($datas['password'])) {
            $supadm->setAttribute('password', Hash::make($datas['password']));
        }
        $supadm->save();
//        Log::debug($user);

        // UserCoordinates
        $coordinate = $supadm->coordinate;
        if ($coordinate === null) {
            $coordinate = new UserCoordinate();
            $coordinate->setAttribute('user_id', $supadm->id);
        }
        $coordinate->fill($datas);
        $coordinate->setAttribute('category_id', FortifyServiceProvider::CATEGORY_SUPADM);
        $coordinate->save();
//        Log::debug($coordinate);

        // Profiles
        DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $supadm->id)
            ->update([
                'role_id' => FortifyServiceProvider::ROLE_SUPADM
            ]);

        // All Rights
        DB::table('right_and_profile')
            ->where('client_id', session('clientId'))
            ->where('user_id', $supadm->id)
            ->delete();
    }

    /**
     * @param SuperAdministrator $supadm
     */
    public static function delete(SuperAdministrator &$supadm)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // Delete Users - UserCoordinates - Profiles - Rights
        $supadm->coordinate->delete();

        DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $supadm->id)
            ->delete();

        $supadm->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|SuperAdministrator|object
     */
    public static function getById(int $id)
    {
        return SuperAdministrator::query()->where('users.id', $id)->first();
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
        $query = SuperAdministrator::query();
        return self::queryFilterAndOrder($query, $validatedData, "users.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }
}
