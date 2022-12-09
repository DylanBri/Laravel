<?php

namespace Modules\Monitoring\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Monitoring\Entities\WorkSite;
use Modules\Customer\Entities\Address;
use Modules\Customer\Repositories\AddressRepository;

class WorkSiteRepository extends Repository
{
    /**
     * @param array $datas
     * @return WorkSite
     */
    public static function create(array $datas)
    {    
        // Address
        $datas['address'] = [
            'address1' => $datas['address1'],
            'address2' => $datas['address2'],
            'zip_code' => $datas['zip_code'],
            'city' => $datas['city']
        ];
        $address = AddressRepository::create($datas['address']);
    
        // Generate workSite
        $datas['client_id'] = session('clientId');
        $datas['address_id'] = $address->id;
        $worksite = new WorkSite();
        $worksite->fill($datas);
        $worksite->save();

        return $worksite;
    }

    /**
     * @param WorkSite $workSite
     * @param array $datas
     * @return WorkSite
     */
    public static function update(WorkSite &$worksite, array $datas)
    {

        // Address
        $datas['address'] = [
            'address1' => $datas['address1'],
            'address2' => $datas['address2'],
            'zip_code' => $datas['zip_code'],
            'city' => $datas['city']
        ];
        $worksite->address()->update($datas['address']);

        $worksite->update($datas);

        return $worksite;
    }

    /**
     * Update the specified resource in storage.
     * @param WorkSite $workSite
     */
    public static function delete(WorkSite $worksite)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $worksite->address()->delete();

        $worksite->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|WorkSite
     */
    public static function getById(int $id)
    {
        $worksite = WorkSite::query()
        ->select(['work_sites.*','customers.name as customer_name', 'addresses.address1 as address1', 'addresses.address2 as address2', 'addresses.city as city', 'addresses.zip_code as zip_code'])
        ->find($id);

        return $worksite;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function getList(array $validatedData) : Collection
    {
        $query = WorkSite::query()        
        ->select(['work_sites.*','customers.name as customer_name', 'addresses.address1 as address1', 'addresses.address2 as address2', 'addresses.city as city', 'addresses.zip_code as zip_code']);

        $lots = self::queryFilterAndOrder($query, $validatedData, "work_sites.id", "work_sites.name")
            ->get();

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
        $query = WorkSite::query()
        ->select(['work_sites.*','customers.name as customer_name', 'addresses.address1 as address1', 'addresses.address2 as address2', 'addresses.city as city', 'addresses.zip_code as zip_code']);

        $worksites = self::queryFilterAndOrder($query, $validatedData, "work_sites.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $worksites;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = WorkSite::query()
        ->select(['work_sites.*','customers.name as customer_name', 'addresses.address1 as address1', 'addresses.address2 as address2', 'addresses.city as city', 'addresses.zip_code as zip_code']);

        $worksites = self::queryFilterAndOrder($query, $validatedData, "work_sites.id")->get();

        return $worksites;
    }
}
