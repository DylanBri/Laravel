<?php

namespace Modules\Log\Repositories;

use App\Repositories\Repository;
use Modules\Log\Entities\LogQueue;

class LogQueueRepository extends Repository
{
    /**
     * @param array $datas
     * @return LogQueue
     */
    public static function create(array $datas)
    {
        // Customer
        $customer = new LogQueue();
        $customer->fill($datas);
        $customer->save();

        return $customer;
    }

    /**
     * @param LogQueue $customer
     * @param array $datas
     */
    public static function update(LogQueue &$customer, array $datas)
    {
        $customer->update($datas);
    }

    /**
     * @param LogQueue $customer
     */
    public static function delete(LogQueue &$customer)
    {
        $customer->delete();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|LogQueue|null|static|static[]
     */
    public static function getById(int $id)
    {
        return LogQueue::query()->find($id);
    }

    /**
     * @param array $validatedData
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getList(array $validatedData)
    {
        // Begin with function queryBase
        $query = LogQueue::query();
        return self::queryFilterAndOrder($query, $validatedData, "log_queues.id")->get();
    }

    /**
     * @param $currentPage
     * @param $perPage
     * @param $validatedData
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getListPaginate($currentPage, $perPage, $validatedData)
    {
        // Begin with function queryBase
        $query = LogQueue::query();
        return self::queryFilterAndOrder($query, $validatedData, "log_queues.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }
}
