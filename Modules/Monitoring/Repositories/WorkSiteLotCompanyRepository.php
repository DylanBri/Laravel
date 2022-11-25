<?php

namespace Modules\Monitoring\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Monitoring\Entities\WorkSiteLotCompany;

class WorkSiteLotCompanyRepository extends Repository
{
    /**
     * @param array $datas
     * @return WorkSiteLotCompany
     */
    public static function create(array $datas)
    {
        // Generate Lot
        $datas['client_id'] = session('clientId');
        $workSiteLotCompany = new WorkSiteLotCompany();
        $workSiteLotCompany->fill($datas);
        $workSiteLotCompany->save();

        $query = WorkSiteLotCompany::query()
                ->selectRaw("SUM(work_site_lot_company.amount_ttc) as sum_amount")
                ->where('work_site_id', $workSiteLotCompany->work_site_id)
                ->groupBy('work_site_id');
        $wslc = $query->get();

        if (!$wslc->isEmpty()) {
            $cumul = $wslc[0]->sum_amount;
            $ws = $workSiteLotCompany->workSite;
            $ws->cumul = $cumul;
            $ws->save();
        }
        else{
            $ws = $workSiteLotCompany->workSite;
            $ws->cumul = 0;
            $ws->save();
        }

        return $workSiteLotCompany;
    }

    /**
     * @param WorkSiteLotCompany $workSiteLotCompany
     * @param array $datas
     * @return WorkSiteLotCompany
     */
    public static function update(WorkSiteLotCompany &$workSiteLotCompany, array $datas)
    {
        $workSiteLotCompany->update($datas);

        $query = WorkSiteLotCompany::query()
                ->selectRaw("SUM(work_site_lot_company.amount_ttc) as sum_amount")
                ->where('work_site_id', $workSiteLotCompany->work_site_id)
                ->groupBy('work_site_id');
        $wslc = $query->get();

        if (!$wslc->isEmpty()) {
            $cumul = $wslc[0]->sum_amount;
            $ws = $workSiteLotCompany->workSite;
            $ws->cumul = $cumul;
            $ws->save();
        }
        else{
            $ws = $workSiteLotCompany->workSite;
            $ws->cumul = 0;
            $ws->save();
        }

        return $workSiteLotCompany;
    }

    /**
     * Update the specified resource in storage.
     * @param WorkSiteLotCompany $workSiteLotCompany
     */
    public static function delete(WorkSiteLotCompany $workSiteLotCompany)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $workSiteLotCompany->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|WorkSiteLotCompany
     */
    public static function getById(int $id)
    {
        $workSiteLotCompany = WorkSiteLotCompany::query()
        ->select(['work_site_lot_company.*', 'lots.name AS lot_name', 'work_sites.name AS work_site_name', 'companies.name AS company_name'])
        ->find($id);

        return $workSiteLotCompany;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function getList(array $validatedData) : Collection
    {
        $query = WorkSiteLotCompany::query()
        ->select(['work_site_lot_company.*', 'lots.name AS lot_name', 'work_sites.name AS work_site_name', 'companies.name AS company_name']);
        
        $workSiteLotCompany = self::queryFilterAndOrder($query, $validatedData, "work_site_lot_company.id")
            ->get();
        //dd($workSiteLotCompany);

        return $workSiteLotCompany;
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
        $query = WorkSiteLotCompany::query()
        ->select(['work_site_lot_company.*', 'lots.name AS lot_name', 'work_sites.name AS work_site_name', 'companies.name AS company_name']);
        
        $workSiteLotCompany = self::queryFilterAndOrder($query, $validatedData, "work_site_lot_company.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $workSiteLotCompany;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = WorkSiteLotCompany::query()
        ->select(['work_site_lot_company.*', 'lots.name AS lot_name', 'work_sites.name AS work_site_name', 'companies.name AS company_name']);

        $workSiteLotCompany = self::queryFilterAndOrder($query, $validatedData, "work_site_lot_company.id")->get();

        return $workSiteLotCompany;
    }
}
