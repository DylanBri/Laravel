<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'address_id',
        'name',
        'gender',
        'phone',
        'fax'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'client_id' => 0,
        'address_id' => null,
        'name' => '',
        'gender' => '',
        'phone' => '',
        'fax' => ''
    ];

    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        return (new static)->newQuery()
        ->where('customers.client_id', session('clientId'))
        ->join('addresses', 'customers.address_id', '=', 'addresses.id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /*protected static function newFactory()
    {
        return \Modules\Customer\Database\factories\CustomerFactory::new();
    }*/
}
