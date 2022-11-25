<?php

namespace Modules\Right\Entities;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RightAction extends Model
{
    use HasFactory;

    /**
     * Consultation
     */
    const ACTION_SEE = 1;

    /**
     * Ajout
     */
    const ACTION_ADD = 2;

    /**
     * Modification
     */
    const ACTION_UPD = 3;

    /**
     * Suppression
     */
    const ACTION_DEL = 4;

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
        return $this->hasMany(Right::class, 'action_id');
    }

    /*protected static function newFactory()
    {
        return \Modules\Right\Database\factories\RightActionFactory::new();
    }*/
}
