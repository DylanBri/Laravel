<?php

namespace Modules\Monitoring\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Monitoring\Entities\Monitoring;
use Modules\Company\Entities\Payment;

class MonitoringRepository extends Repository
{
    /**
     * @param array $datas
     * @return Monitoring
     */
    public static function create(array $datas)
    {
        // Generate Monitoring
        $datas['client_id'] = session('clientId');
        $monitoring = new Monitoring();
        $monitoring->fill($datas);
        $monitoring->save();

        $query = $monitoring->workSiteLotCompany()
                ->selectRaw("SUM(monitorings.amount_to_pay) as sum_amount_to_pay")
                ->join('monitorings', 'work_site_lot_company.id', '=', 'monitorings.work_site_lot_company_id')
                ->groupBy('work_site_lot_company_id');
        $test = $query->get();

        if (!$test->isEmpty()) {
            $cumul = $test[0]->sum_amount_to_pay;
            $wslc = $monitoring->workSiteLotCompany;
            $wslc->cumul_monitoring = $cumul;
            $wslc->save();
        }

        $test = Monitoring::query()
                ->selectRaw("SUM(monitorings.amount_to_pay) as cumul_monitoring_previous")
                ->where('work_site_lot_company_id', $monitoring->work_site_lot_company_id)
                ->where('monitorings.date', '<=', $monitoring->date)
                ->groupBy('work_site_lot_company_id');
        $sum1 = $test->get();
        
        if(!$sum1->isEmpty()) {
            $cumul1 = $sum1[0]->cumul_monitoring_previous;
            $mo = $monitoring->cumul_monitoring_previous;
            $mo = $cumul1;
            $monitoring->save();
        }

        return $monitoring;
    }

     /**
     * @param Monitoring $monitoring
     * @param array $datas
     * @return Monitoring
     */
    public static function update(Monitoring &$monitoring, array $datas)
    {
        //dd($monitoring, $datas);
        $monitoring->update($datas);

        // Somme des paiements par lot
        $query = $monitoring->workSiteLotCompany()
                ->selectRaw("SUM(monitorings.amount_to_pay) as sum_amount_to_pay")
                ->join('monitorings', 'work_site_lot_company.id', '=', 'monitorings.work_site_lot_company_id')
                ->groupBy('work_site_lot_company_id');
        $sum_amount = $query->get();

        if (!$sum_amount->isEmpty()) {
            $cumul_to_pay = $sum_amount[0]->sum_amount_to_pay;
            $m = $monitoring->workSiteLotCompany;
            $m->cumul_monitoring = $cumul_to_pay;
            $m->save();
        }

        // Somme des paiements précèdent le suivi
        $req = Monitoring::query()
                ->selectRaw("SUM(monitorings.amount_to_pay) as cumul_monitoring_previous")
                ->where('work_site_lot_company_id', $monitoring->work_site_lot_company_id)
                ->where('monitorings.date', '<=', $monitoring->date)
                ->groupBy('work_site_lot_company_id');
        $sum1 = $req->get();
        
        if(!$sum1->isEmpty()) {
            $cumul1 = $sum1[0]->cumul_monitoring_previous;
            $mo = $monitoring;
            $mo->cumul_monitoring_previous = $cumul1;
            $mo->save();
        }

        return $monitoring;
    }

    /**
     * Update the specified resource in storage.
     * @param Monitoring $monitoring
     */
    public static function delete(Monitoring $monitoring)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $monitoring->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Monitoring
     */
    public static function getById(int $id)
    {
        $monitoring = Monitoring::query()
        ->select(['monitorings.*', 'work_site_lot_company.name AS work_site_lot_company_name'])
        ->find($id);

        return $monitoring;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function getList(array $validatedData) : Collection
    {
        $query = Monitoring::query()
        ->select(['monitorings.*', 'work_site_lot_company.name AS work_site_lot_company_name']);

        $monitorings = self::queryFilterAndOrder($query, $validatedData, "monitorings.id", "monitorings.name")
            ->get();

        return $monitorings;
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
        $query = Monitoring::query()
        ->select(['monitorings.*', 'work_site_lot_company.name AS work_site_lot_company_name']);

        $monitorings = self::queryFilterAndOrder($query, $validatedData, "monitorings.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $monitorings;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = Monitoring::query()
            ->select(['monitoring.*', 'work_site_lot_company.name AS work_site_lot_company_name']);

        $monitorings = self::queryFilterAndOrder($query, $validatedData, "monitorings.id")->get();

        return $monitorings;
    }
}
