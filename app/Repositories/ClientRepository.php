<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository extends Repository
{
    /**
     * @param array $datas
     * @return Client
     */
    public static function create(array $datas)
    {
        $client = new Client();
        $client->fill($datas);
        $client->save();
        return $client;
    }

    /**
     * @param Client $client
     * @param array $datas
     */
    public static function update(Client &$client, array $datas)
    {
        $client->update($datas);
    }

    /**
     * @param Client $client
     */
    public static function delete(Client &$client)
    {
        $client->delete();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|Client|null|static|static[]
     */
    public static function getById(int $id)
    {
        return Client::query()->find($id);
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
        $query = Client::query();
        return self::queryFilterAndOrder($query, $validatedData, "clients.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }
}
