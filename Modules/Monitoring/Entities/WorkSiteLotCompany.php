<?php

namespace Modules\Monitoring\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Company\Entities\Company;
use Modules\Monitoring\Entities\Lot;
use Modules\Monitoring\Entities\WorkSite;
use Modules\Monitoring\Entities\Monitoring;
//use Modules\Customer\Entities\Customer;

class WorkSiteLotCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'work_site_id',
        'lot_id',
        'company_id',
        //'customer_id',
        'monitoring_id',
        'name',
        'is_type',
        'amount_ttc',
        'cumul_monitoring',
        'cumul_payment',
        'enabled',
        'suppressed'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_site_lot_company';

    protected $attributes = [
        'client_id' => 0,
        'work_site_id' => null,
        'lot_id' => null,
        'company_id' => null,
        'monitoring_id' => null,
        //'customer_id' => '',
        'name' => '',
        'is_type' => 0,
        'amount_ttc' => 0,
        'cumul_monitoring' => 0,
        'cumul_payment' => 0,
        'enabled' => 1,
        'suppressed' => 0
    ];
    
    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        return (new static)->newQuery()
        ->where('work_site_lot_company.client_id', session('clientId'))
        ->join('companies', 'work_site_lot_company.company_id', '=', 'companies.id')
        ->join('work_sites', 'work_site_lot_company.work_site_id', '=', 'work_sites.id')
        ->join('lots', 'work_site_lot_company.lot_id', '=', 'lots.id')
        ->leftJoin('monitorings', 'work_site_lot_company.monitoring_id', '=', 'monitorings.id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workSite()
    {
        return $this->belongsTo(WorkSite::class);
    }

    /**
     * TS
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }
}
