<?php

namespace Modules\Customer\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Entities\Address;

class AddressRepository extends Repository
{
    /**
     * @param array $datas
     * @return Address
     */
    public static function create(array $datas)
    {
        // Generate Address
        $datas['client_id'] = session('clientId');
        $address = new Address();
        $address->fill($datas);
        $address->save();

        return $address;
    }

    /**
     * @param Address $address
     * @param array $datas
     * @return Address
     */
    public static function update(Address &$address, array $datas)
    {
        // Companies
        $address->update($datas);

        return $address;
    }

    /**
     * Update the specified resource in storage.
     * @param Address $address
     */
    public static function delete(Address $address)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $address->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Address
     */
    public static function getById(int $id)
    {
        $address = Address::query()->find($id);

        return $address;
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
        $query = Address::query();

        $addresss = self::queryFilterAndOrder($query, $validatedData, "addresses.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $addresss;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = Address::query()
            ->select('id', 'address1', 'address2', 'zip_code', 'city', 'country');

        $addresss = self::queryFilterAndOrder($query, $validatedData, "addresses.id")->get();

        return $addresss;
    }
}
