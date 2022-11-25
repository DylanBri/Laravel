<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientVersion extends Model
{
    use HasFactory;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'folder',
        'address',
        'address2',
        'zip_code',
        'city',
        'country',
        'email',
        'phone',
        'licence',
        'licence_expired_at',
        'socket_host',
        'socket_port',
        'enabled',
        'version',
        'version_created_at',
        'version_created_by',
        'version_comment',
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
        'id' => 0,
        'name' => '',
        'folder' => '',
        'address' => '',
        'address2' => '',
        'zip_code' => '',
        'city' => '',
        'country' => 'France',
        'email' => '',
        'phone' => '',
        'licence' => '',
        'licence_expired_at' => '1900-01-01 00:00:00',
        'socket_host' => '',
        'socket_port' => '',
        'enabled' => true,
        'version' => 0,
        'version_created_at' => '1900-01-01 00:00:00',
        'version_created_by' => '',
        'version_comment' => '',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'id', 'id');
    }
}
