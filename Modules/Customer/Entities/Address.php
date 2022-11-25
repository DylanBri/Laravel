<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'address1',
        'address2',
        'zip_code',
        'city',
        'country'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'client_id' => 0,
        'address1' => '',
        'address2' => '',
        'zip_code' => '',
        'city' => '',
        'country' => 'FR'
    ];

    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        return (new static)->newQuery()
            ->where('addresses.client_id', session('clientId'));
    }

    /*protected static function newFactory()
    {
        return \Modules\Customer\Database\factories\AddressFactory::new();
    }*/
}
