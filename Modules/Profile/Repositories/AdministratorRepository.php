<?php

namespace Modules\Profile\Repositories;

use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use App\Repositories\Repository;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Log;
use Modules\Profile\Entities\Administrator;
use Modules\Right\Entities\RightAndProfile;

class AdministratorRepository extends Repository
{
    /**
     * @param array $datas
     * @return Administrator
     * @throws \Exception
     */
    public static function create(array $datas)
    {
        // Users
        $admin = new Administrator();
        $admin->fill($datas);
        $admin->setAttribute('password', Hash::make($datas['password']));
        $admin->save();

        // UserCoordinates
        $datas['user_id'] = $admin->id;
        $datas['category_id'] = FortifyServiceProvider::CATEGORY_ADMIN;
        UserCoordinateRepository::create($datas);

        // Profiles
        DB::table('profiles')->insert([
            'client_id' => session('clientId'),
            'user_id' => $admin->id,
            'role_id' => FortifyServiceProvider::ROLE_ADMIN
        ]);

        // Rights
        $rights = RightAndProfile::query()
            ->where('client_id', session('clientId'))
            ->where('role_id', FortifyServiceProvider::ROLE_ADMIN)
            ->whereNull('user_id')
            ->get();
        /** @var RightAndProfile $right */
        foreach ($rights as $right) {
            $newRight = $right->replicate();
            $newRight->user_id = $admin->id;
            $newRight->save();
        }

        return $admin;
    }

    /**
     * @param Administrator $admin
     * @param array $datas
     * @throws \Exception
     */
    public static function update(Administrator &$admin, array $datas)
    {
        // Users
        $admin->fill($datas);
        if (isset($datas['password'])) {
            $admin->setAttribute('password', Hash::make($datas['password']));
        }
        $admin->save();

        // UserCoordinates
        $coordinate = $admin->coordinate;
        if ($coordinate === null) {
            $coordinate = new UserCoordinate();
            $coordinate->setAttribute('user_id', $admin->id);
        }
        $coordinate->fill($datas);
        $coordinate->setAttribute('category_id', FortifyServiceProvider::CATEGORY_ADMIN);
        $coordinate->save();

        $exist = DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $admin->id)
            ->where('role_id', FortifyServiceProvider::ROLE_ADMIN)
            ->exists();

        // Profiles
        DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $admin->id)
            ->update([
                'role_id' => FortifyServiceProvider::ROLE_ADMIN
            ]);

        if (!$exist) {
            // Delete old Rights
            RightAndProfile::query()
                ->where('client_id', session('clientId'))
                ->where('user_id', $admin->id)
                ->delete();

            // Create new Rights
            $rights = RightAndProfile::query()
                ->where('client_id', session('clientId'))
                ->where('role_id', FortifyServiceProvider::ROLE_ADMIN)
                ->whereNull('user_id')
                ->get();
            /** @var RightAndProfile $right */
            foreach ($rights as $right) {
                $newRight = $right->replicate();
                $newRight->user_id = $admin->id;
                $newRight->save();
            }
        }
    }

    /**
     * @param Administrator $admin
     */
    public static function delete(Administrator &$admin)
    {
       DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // Delete Users - UserCoordinates - Profiles - Rights
        $admin->coordinate->delete();

        DB::table('profiles')
            ->where('client_id', session('clientId'))
            ->where('user_id', $admin->id)
            ->delete();

        $admin->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Administrator|object
     */
    public static function getById(int $id)
    {
        return Administrator::query()->where('users.id', $id)->first();
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
        $query = Administrator::query();

        return self::queryFilterAndOrder($query, $validatedData, "users.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }
}
