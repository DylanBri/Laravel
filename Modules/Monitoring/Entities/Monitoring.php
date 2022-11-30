<?php

namespace Modules\Monitoring\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Company\Entities\Payment;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'parent_id',
        'work_site_lot_company_id',
        'name',
        'date',
        'total_market_amount',
        'total_modify_market_amount',
        'market_amount',
        'modify_market_amount',
        'rate_vat',
        'deposit',
        'account_percent',
        'account_management_percent',
        'bank_guarantee',
        'retention_money_percent',
        'doc_penality_percent',
        'work_penality',
        'payment_amount_ttc',
        'deduction_previous_payment',
        'amount_to_pay',
        'cumul_work_sit_lot_company',
        'cumul_monitoring_previous',
        'progress',
        'enabled',
        'suppressed'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'client_id' => 0,
        'parent_id' => null,
        'work_site_lot_company_id' => null,
        'name'=> '',
        'date'=> '2022-01-01 00:00:00',
        'total_market_amount'=> 0,
        'total_modify_market_amount'=> 0,
        'market_amount'=> 0,
        'modify_market_amount'=> 0,
        'rate_vat'=> 0,
        'deposit'=> 0,
        'account_percent'=> 0,
        'account_management_percent'=> 0,
        'bank_guarantee'=> 0,
        'retention_money_percent'=> 0,
        'doc_penality_percent'=> 0,
        'work_penality'=> 0,
        'payment_amount_ttc'=> 0,
        'deduction_previous_payment'=> 0,
        'amount_to_pay'=> 0,
        'cumul_work_sit_lot_company'=> 0,
        'cumul_monitoring_previous'=> 0,
        'progress'=> 0,
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
        ->where('monitorings.client_id', session('clientId'))
        ->join('work_site_lot_company', 'work_site_lot_company.id', '=', 'monitorings.work_site_lot_company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workSiteLotCompany()
    {
        return $this->belongsTo(WorkSiteLotCompany::class);
    }
}
