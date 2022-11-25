<?php

namespace Modules\Right\Entities;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RightFamily extends Model
{
    use HasFactory;

    /**
     * SA - Tous
     */
    const FAMILY_SAD = 1;

    /**
     * Administrateur
     */
    const FAMILY_ADM = 4;

    /**
     * Manager
     */
    const FAMILY_MNG = 5;

    /**
     * Membre
     */
    const FAMILY_USR = 6;

    /**
     * Visiteur
     */
    const FAMILY_PBL = 7;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'name',
        'code',
        'enabled'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'client_id' => 0,
        'name' => "",
        'code' => "",
        'enabled' => true
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rights()
    {
        return $this->hasMany(Right::class, 'family_id');
    }
    
    /*protected static function newFactory()
    {
        return \Modules\Right\Database\factories\RightActionFamilyFactory::new();
    }*/
}
