<?php

namespace Modules\Customer\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Entities\Address;

class CustomerRepository extends Repository
{
    /**
     * @param array $datas
     * @return Customer
     */
    public static function create(array $datas)
    {
        // Address
        $datas['address'] = [
            'address1' => $datas['address_1'],
            'address2' => $datas['address_2'],
            'zip_code' => $datas['zip_code'],
            'city' => $datas['city'],
            //'country' => $datas['country'],
        ];
        $address = AddressRepository::create($datas['address']);

        // Generate Customer
        $datas['client_id'] = session('clientId');
        $datas['address_id'] = $address->id;
        $customer = new Customer();
        $customer->fill($datas);
        $customer->save();

        return $customer;
    }

    /**
     * @param Customer $customer
     * @param array $datas
     * @return Customer
     */
    public static function update(Customer &$customer, array $datas)
    {
        $customer->update($datas);

        // Address
        $datas['address'] = [
            'address1' => $datas['address_1'],
            'address2' => $datas['address_2'],
            'zip_code' => $datas['zip_code'],
            'city' => $datas['city'],
            //'country' => $datas['country'],
        ];

        $customer->address()->update($datas['address']);

        return $customer;
    }

    /**
     * Update the specified resource in storage.
     * @param Customer $customer
     */
    public static function delete(Customer $customer)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $customer->address()->delete();

        $customer->delete();

        $customer->workSites()->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Customer
     */
    public static function getById(int $id)
    {
        $customer = Customer::query()
        ->select(['customers.*', 'addresses.address1 as address_1', 'addresses.address2 as address_2',
        'addresses.zip_code as zip_code', 'addresses.city as city'])
            ->find($id);

        if ($customer !== null) {
            $customer->address;
        }

        return $customer;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function getList(array $validatedData) : Collection
    {
        $query = Customer::query()
        ->select(['customers.*', 'addresses.address1 as address_1', 'addresses.address2 as address_2',
        'addresses.zip_code as zip_code', 'addresses.city as city']);
        $users = self::queryFilterAndOrder($query, $validatedData, "customers.id")
            ->get();

        return $users;
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
        $query = Customer::query()
        ->select(['customers.*', 'addresses.address1 as address_1', 'addresses.address2 as address_2',
        'addresses.zip_code as zip_code', 'addresses.city as city']);

        $customers = self::queryFilterAndOrder($query, $validatedData, "customers.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $customers;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = Customer::query()
            ->select(['customers.*', 'addresses.address1 as address_1', 'addresses.address2 as address_2',
            'addresses.zip_code as zip_code', 'addresses.city as city']);

        $customers = self::queryFilterAndOrder($query, $validatedData, "customers.id")->get();

        return $customers;
    }
}
