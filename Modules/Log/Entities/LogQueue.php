<?php

namespace Modules\Log\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'action',
        'data',
        'log',
        'state'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'action' => '',
        'data' => '',
        'log' => '',
        'state' => 0
    ];

    /*** States  ***/
    const STATE_WAIT = 0;
    const STATE_IN_PROGRESS = 1;
    const STATE_FINISH = 2;

    /**
     * @var array $states
     */
    public static $states = [
        ["label" => "En attente", "value" => "0"],
        ["label" => "En cours", "value" => "1"],
        ["label" => "Terminé", "value" => "2"]
    ];
    
    /*protected static function newFactory()
    {
        return \Modules\Log\Database\factories\LogQueueFactory::new();
    }*/
}
