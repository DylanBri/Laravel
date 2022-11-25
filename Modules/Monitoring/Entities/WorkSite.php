<?php

namespace Modules\Monitoring\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Entities\Address;

class WorkSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'customer_id',
        'address_id',
        'name',
        'notes',
        'cumul',
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
        'customer_id' => null,
        'address_id' => null,
        'name'=> '',
        'notes'=> '',
        'cumul'=> 0,
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
        ->where('work_sites.client_id', session('clientId'))
        ->join('customers', 'work_sites.customer_id', '=', 'customers.id')
        ->join('addresses', 'work_sites.address_id', '=', 'addresses.id');
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
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workSiteLotCompany()
    {
        return $this->hasMany(WorkSiteLotCompany::class);
    }
}
