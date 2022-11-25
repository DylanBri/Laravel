<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'profiles', 'client_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'profiles', 'client_id', 'role_id');
    }
}
