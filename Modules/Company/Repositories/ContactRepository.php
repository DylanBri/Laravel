<?php

namespace Modules\Company\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Company\Entities\Contact;

class ContactRepository extends Repository
{
    /**
     * @param array $datas
     * @return Contact
     */
    public static function create(array $datas)
    {
        // Generate Contact
        $datas['client_id'] = session('clientId');
        $contact = new Contact();
        $contact->fill($datas);
        $contact->save();

        return $contact;
    }

    /**
     * @param Contact $contact
     * @param array $datas
     * @return Contact
     */
    public static function update(Contact &$contact, array $datas)
    {
        $contact->update($datas);

        return $contact;
    }

    /**
     * Update the specified resource in storage.
     * @param Contact $contact
     */
    public static function delete(Contact $contact)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $contact->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Contact
     */
    public static function getById(int $id)
    {
        $contact = Contact::query()
        ->select(['contacts.*','companies.name as company_name'])
        ->find($id);

        return $contact;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function getList(array $validatedData) : Collection
    {
        $query = Contact::query()
        ->select(['contacts.*','companies.name as company_name']);

        $contacts = self::queryFilterAndOrder($query, $validatedData, "contacts.id")
            ->get();

        return $contacts;
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
        $query = Contact::query()
        ->select(['contacts.*','companies.name as company_name']);

        $contacts = self::queryFilterAndOrder($query, $validatedData, "contacts.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $contacts;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = Contact::query()
        ->select(['contacts.*','companies.name as company_name']);

        $contacts = self::queryFilterAndOrder($query, $validatedData, "contacts.id")->get();

        return $contacts;
    }
}
