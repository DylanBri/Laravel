<?php

namespace Modules\Monitoring\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Monitoring\Entities\Lot;

class LotRepository extends Repository
{
    /**
     * @param array $datas
     * @return Lot
     */
    public static function create(array $datas)
    {
        // Generate Lot
        $datas['client_id'] = session('clientId');
        $lot = new Lot();
        $lot->fill($datas);
        $lot->save();

        return $lot;
    }

    /**
     * @param Lot $lot
     * @param array $datas
     * @return Lot
     */
    public static function update(Lot &$lot, array $datas)
    {
        $lot->update($datas);

        return $lot;
    }

    /**
     * Update the specified resource in storage.
     * @param Lot $lot
     */
    public static function delete(Lot $lot)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $lot->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Lot
     */
    public static function getById(int $id)
    {
        $lot = Lot::query()
        ->select(['lots.*'])
        ->find($id);

        return $lot;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function getList(array $validatedData) : Collection
    {
        $query = Lot::query()
        ->select(['lots.*']);
        
        $lots = self::queryFilterAndOrder($query, $validatedData, "lots.id")
            ->get();
        //dd($lots);

        return $lots;
    }

    /**
     * Get Paginate
     *
     * @param integer $currentPage
     * @param integer $perPage
     * @param array $validatedData
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(int $currentPage, int $perPage, array $validatedData)
    {
        $query = Lot::query()
        ->select(['lots.*']);

        $lots = self::queryFilterAndOrder($query, $validatedData, "lots.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $lots;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = Lot::query()
        ->select(['lots.*']);

        $lots = self::queryFilterAndOrder($query, $validatedData, "lots.id")->get();

        return $lots;
    }
}
