<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

class Repository
{
    /**
     * @param Builder $query
     * @param array $validatedData
     * @param string $orderDefault
     * @param string $propertyQuery
     * @return Builder
     */
    protected static function queryFilterAndOrder(Builder $query, array $validatedData, string $orderDefault = 'id',
                                                  string $propertyQuery = 'name')
    {
        // Query
        if (isset($validatedData['query'])) {
            $query->where($propertyQuery, 'LIKE', '%' . $validatedData['query'] . '%');
        }

        //Sorter
        if (isset($validatedData['sort']) && isset($validatedData['order'])) {
            $sort = $validatedData['sort'];
            $order = $validatedData['order'];
        } else {
            $sort = null;
            $order = null;
        }

        //Filter
        if (isset($validatedData['filters']) && !empty($validatedData['filters'])) {
            $filters = $validatedData['filters'];
        } else {
            $filters = [];
        }

        if ($sort !== null && $order !== null) {
            $query->orderBy($sort, $order);
        } else {
            $query->orderBy($orderDefault, 'DESC');
        }
        foreach ($filters as $filter) {
            switch ($filter['type']) {
                case 'boolean':
                case 'select':
                case 'number':
                case 'date':
                case 'autocomplete':
                    $query->where($filter['field'], '=', $filter['value']);
                    break;
                case 'number_min':
                case 'date_min':
                    $query->where($filter['field'], '>=', $filter['value']);
                    break;
                case 'number_max':
                case 'date_max':
                    $query->where($filter['field'], '<=', $filter['value']);
                    break;
                case 'begin':
                    $query->where($filter['field'], 'LIKE', sprintf('%s%%', $filter['value']));
                    break;
                case 'end':
                    $query->where($filter['field'], 'LIKE', sprintf('%%%s', $filter['value']));
                    break;
                case 'string':
                default:
                    $query->where($filter['field'], 'LIKE', sprintf('%%%s%%', $filter['value']));
            }
        }

        return $query;
    }
}