<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoordinateVersion extends Model
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
        'user_id',
        'category_id',
        'quality',
        'address',
        'address2',
        'zip_code',
        'city',
        'region',
        'country',
        'phone',
        'mobile',
        'enabled',
        'suppressed',
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
        'suppressed' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'id' => 0,
        'user_id' => 0,
        'category_id' => 0,
        'quality' => '',
        'address' => '',
        'address2' => '',
        'zip_code' => '',
        'city' => '',
        'region' => '',
        'country' => 'France',
        'phone' => '',
        'mobile' => '',
        'enabled' => true,
        'suppressed' => false,
        'version' => 0,
        'version_created_at' => '1900-01-01 00:00:00',
        'version_created_by' => '',
        'version_comment' => '',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coordinate()
    {
        return $this->belongsTo(UserCoordinate::class);
    }
}
