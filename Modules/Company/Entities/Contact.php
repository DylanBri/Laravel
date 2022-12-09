<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'company_id',
        'firstname', 
        'lastname',
        'phone',
        'email',
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
        'company_id' => null,
        'firstname' => '', 
        'lastname'=> '',
        'phone'=> '',
        'email'=> '',
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
        ->join('companies', 'contacts.company_id', '=', 'companies.id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
