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

        // Totalistion du Chantier : Somme des montants des lots (wslc)
        $ws = $workSiteLotCompany->workSite;
        $query = $workSiteLotCompany
                ->selectRaw("SUM(work_site_lot_company.amount_ttc) as sum_amount")
                ->where('work_site_id', $workSiteLotCompany->work_site_id)
                ->where("work_site_lot_company.is_type", "=", 0)
                ->groupBy('work_site_id');
        $wslc = $query->get();
        if (!$wslc->isEmpty()) {
            $cumul = $wslc[0]->sum_amount;
            $ws->cumul = $cumul;
            $ws->saveQuietly();
        } else{
            $ws->cumul = 0;
            $ws->saveQuietly();
        }

        // Remplissage du champs cumul_work_sit_lot_company : Somme des montants des travaux supplémentairs (wslc.is_type=1)
        $monitoring = $workSiteLotCompany->monitoring;
        $amount_ts = WorkSiteLotCompany::query()
                    ->selectRaw("SUM(work_site_lot_company.amount_ttc) as amount_ts")
                    ->where('monitorings.id', $workSiteLotCompany->monitoring_id)
                    ->where("work_site_lot_company.is_type", "=", 1)
                    ->whereNotNull("monitorings.id")
                    ->groupBy('monitorings.id');
        $cumul_ts = $amount_ts->get();
        if (!$cumul_ts->isEmpty()) {
            $cumul_work_sit_lot_company = $cumul_ts[0]->amount_ts;
            $monitoring->cumul_work_sit_lot_company = $cumul_work_sit_lot_company;
            $monitoring->saveQuietly();
        }else if(($monitoring != null) && ($monitoring != '')) {
            $cumul_work_sit_lot_company = 0;
            $monitoring->cumul_work_sit_lot_company = $cumul_work_sit_lot_company;
            $monitoring->saveQuietly();
        }

        // Remplissage du champs cumul_work_sit_lot_company_previous
        $monitoring = $workSiteLotCompany->monitoring;
        if ($monitoring != null) {
            $cumul_ts_previous = $monitoring
                                ->selectRaw("monitorings.cumul_work_sit_lot_company")
                                ->where("monitorings.id", "=", $monitoring->parent_id);
            $test = $cumul_ts_previous->get();
            if (!$test->isEmpty()) {
                $cumul_previous_ts = $test[0]->cumul_work_sit_lot_company; 
                $monitoring->cumul_work_sit_lot_company_previous = $cumul_previous_ts;
                $monitoring->saveQuietly();
            } else {
                $cumul_previous_ts = 0; 
                $monitoring->cumul_work_sit_lot_company_previous = $cumul_previous_ts;
                $monitoring->saveQuietly();
            }
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

        // Totalistion du Chantier : Somme des montants des lots (wslc)
        $ws = $workSiteLotCompany->workSite;
        $query = $workSiteLotCompany
                ->selectRaw("SUM(work_site_lot_company.amount_ttc) as sum_amount")
                ->where('work_site_id', $workSiteLotCompany->work_site_id)
                ->where("work_site_lot_company.is_type", "=", 0)
                ->groupBy('work_site_id');
        $wslc = $query->get();
        if (!$wslc->isEmpty()) {
            $cumul = $wslc[0]->sum_amount;
            $ws->cumul = $cumul;
            $ws->saveQuietly();
        } else{
            $ws->cumul = 0;
            $ws->saveQuietly();
        }

        // Remplissage du champs cumul_work_sit_lot_company : Somme des montants des travaux supplémentairs (wslc.is_type=1)
        $monitoring = $workSiteLotCompany->monitoring;
        $amount_ts = WorkSiteLotCompany::query()
                ->selectRaw("SUM(work_site_lot_company.amount_ttc) as amount_ts")
                ->where('monitorings.id', $workSiteLotCompany->monitoring_id)
                ->where("work_site_lot_company.is_type", "=", 1)
                ->whereNotNull("monitorings.id")
                ->groupBy('monitorings.id');
        $cumul_ts = $amount_ts->get();
        if (!$cumul_ts->isEmpty()) {
            $cumul_work_sit_lot_company = $cumul_ts[0]->amount_ts;
            $monitoring->cumul_work_sit_lot_company = $cumul_work_sit_lot_company;
            $monitoring->saveQuietly();
        }else if(($monitoring != null) && ($monitoring != '')) {
            $cumul_work_sit_lot_company = 0;
            $monitoring->cumul_work_sit_lot_company = $cumul_work_sit_lot_company;
            $monitoring->saveQuietly();
        }

        // Remplissage du champs cumul_work_sit_lot_company_previous
        $monitoring = $workSiteLotCompany->monitoring;
        if ($monitoring != null) {
            $cumul_ts_previous = $monitoring
                                ->selectRaw("monitorings.cumul_work_sit_lot_company")
                                ->where("monitorings.id", "=", $monitoring->parent_id);
            $test = $cumul_ts_previous->get();
            if (!$test->isEmpty()) {
                $cumul_previous_ts = $test[0]->cumul_work_sit_lot_company; 
                $monitoring->cumul_work_sit_lot_company_previous = $cumul_previous_ts;
                $monitoring->saveQuietly();
            } else {
                $cumul_previous_ts = 0; 
                $monitoring->cumul_work_sit_lot_company_previous = $cumul_previous_ts;
                $monitoring->saveQuietly();
            }
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

        if (!$workSiteLotCompany->is_type) {
            $workSiteLotCompany->monitorings()->delete();
        }

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
