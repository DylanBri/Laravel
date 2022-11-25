<?php

namespace Modules\Monitoring\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'description',
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
        'name'=> '',
        'description' => '',
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
        ->where('lots.client_id', session('clientId'));
        //->join('companies', 'lots.company_id', '=', 'companies.id');
    }
}
