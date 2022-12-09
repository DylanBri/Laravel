<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Entities\Address;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'title', 
        'name',
        'address_id',
        'phone',
        'supervisor',
        'siret',
        'classification',
        'code_ape',
        'email',
        'insurance',
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
        'address_id' => null,
        'title' => '', 
        'name'=> '',
        'phone'=> '',
        'supervisor'=> '',
        'siret'=> '',
        'classification'=> '',
        'code_ape'=> '',
        'email'=> '',
        'insurance'=> '',
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
        ->where('companies.client_id', session('clientId'))
        ->join('addresses', 'companies.address_id', '=', 'addresses.id');
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
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
