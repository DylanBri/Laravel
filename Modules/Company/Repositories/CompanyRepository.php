<?php

namespace Modules\Company\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Company\Entities\Company;
use Modules\Customer\Entities\Address;
use Modules\Customer\Repositories\AddressRepository;

class CompanyRepository extends Repository
{
    /**
     * @param array $datas
     * @return Company
     */
    public static function create(array $datas)
    {
        // Address
        $datas['address'] = [
            'address1' => $datas['address_1'],
            'address2' => $datas['address_2'],
            'zip_code' => $datas['zip_code'],
            'city' => $datas['city'],
            'country' => $datas['country']
        ];
        $address = AddressRepository::create($datas['address']);

        // Generate Company
        $datas['client_id'] = session('clientId');
        $datas['address_id'] = $address->id;
        $company = new Company();
        $company->fill($datas);
        $company->save();

        return $company;
    }

    /**
     * @param Company $company
     * @param array $datas
     * @return Company
     */
    public static function update(Company &$company, array $datas)
    {
        $company->update($datas);
        
        // Address
        $datas['address'] = [
            'address1' => $datas['address_1'],
            'address2' => $datas['address_2'],
            'zip_code' => $datas['zip_code'],
            'city' => $datas['city'],
            'country' => $datas['country']
        ];
        $company->address()->update($datas['address']);

        return $company;
    }

    /**
     * Update the specified resource in storage.
     * @param Company $company
     */
    public static function delete(Company $company)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $company->address()->delete();

        $company->delete();

        $company->contacts()->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Company
     */
    public static function getById(int $id)
    {
        $company = Company::query()
        ->select(['companies.*', 'addresses.address1 as address_1', 'addresses.address2 as address_2', 'addresses.city as city', 'addresses.zip_code as zip_code', 'addresses.country as country'])
        ->find($id);

        return $company;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function getList(array $validatedData) : Collection
    {
        $query = Company::query()
        ->select(['companies.*', 'addresses.address1 as address_1', 'addresses.address2 as address_2', 'addresses.city as city', 'addresses.zip_code as zip_code', 'addresses.country as country']);
        
        $companies = self::queryFilterAndOrder($query, $validatedData, "companies.id", "companies.name")
            ->get();

        return $companies;
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
        $query = Company::query()
        ->select(['companies.id', 'companies.name', 'addresses.address1 as address1', 'addresses.address2 as address2', 'addresses.city as city', 'addresses.zip_code as zip_code', 'addresses.country as country']);

        $companies = self::queryFilterAndOrder($query, $validatedData, "companies.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $companies;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = Company::query()
        ->select(['companies.id', 'companies.name', 'addresses.address1 as address1', 'addresses.address2 as address2', 'addresses.city as city', 'addresses.zip_code as zip_code', 'addresses.country as country']);

        $companies = self::queryFilterAndOrder($query, $validatedData, "companies.id")->get();

        return $companies;
    }
}