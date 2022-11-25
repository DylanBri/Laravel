<?php

namespace App\Repositories;

use App\Models\UserCoordinate;

class UserCoordinateRepository extends Repository
{
    /**
     * @param array $datas
     * @return UserCoordinate
     */
    public static function create(array $datas)
    {
        $coordinate = new UserCoordinate();
        $coordinate->fill($datas);
        $coordinate->save();

        return $coordinate;
    }

    /**
     * @param UserCoordinate $coordinate
     * @param array $datas
     */
    public static function update(UserCoordinate &$coordinate, array $datas)
    {
        $coordinate->update($datas);
    }

    /**
     * @param UserCoordinate $coordinate
     */
    public static function delete(UserCoordinate &$coordinate)
    {
        $coordinate->delete();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|UserCoordinate|object
     */
    public static function getById(int $id)
    {
        return UserCoordinate::query()->find($id);
    }

    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|UserCoordinate|object
     */
    public static function getByUserId(int $userId)
    {
        return UserCoordinate::query()->where('user_id', $userId)->first();
    }

    /**
     * @param array $validatedData
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function autocomplete(array $validatedData)
    {
        return UserCoordinate::query()
            ->select("quality")
            ->where("quality","LIKE","%{$validatedData['query']}%")
            ->get();
    }
}
