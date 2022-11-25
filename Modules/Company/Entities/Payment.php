<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Monitoring\Entities\Monitoring;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'customer_id',
        'company_id',
        'monitoring_id',
        'name',
        'payment_request_date',
        'amount_ttc',
        'is_staged',
        'is_done',
        'payment_date',
        'payment_method',
        'bank_name',
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
        'customer_id' => 0,
        'company_id' => 0,
        'monitoring_id' => 0,
        'name' => '',
        'payment_request_date' => '2022-01-01 00:00:00',
        'amount_ttc' => '',
        'is_staged' => 0,
        'is_done' => 0,
        'payment_date' => '',
        'payment_method' => '',
        'bank_name' => '',
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
        ->where('payments.client_id', session('clientId'))
        ->join('companies', 'payments.company_id', '=', 'companies.id')
        ->join('customers', 'payments.customer_id', '=', 'customers.id')
        ->join('monitorings', 'payments.monitoring_id', '=', 'monitorings.id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
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
    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class);
    }
}
