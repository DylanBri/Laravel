<?php

namespace App\Models;

use App\Providers\FortifyServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserCoordinateFactory;

class UserCoordinate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
    public function category()
    {
        return $this->belongsTo(UserCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions()
    {
        return $this->hasMany(UserCoordinateVersion::class, 'user_id', 'user_id');
    }

    /**
     * @return bool
     */
    public function isSuperAdministrator()
    {
        return $this->category_id === FortifyServiceProvider::CATEGORY_SUPADM;
    }

    /**
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->category_id === FortifyServiceProvider::CATEGORY_ADMIN;
    }

    /**
     * @return bool
     */
    public function isManager()
    {
        return $this->category_id === FortifyServiceProvider::CATEGORY_MANAGER;
    }

    /**
     * @return bool
     */
    public function isUser()
    {
        return $this->category_id === FortifyServiceProvider::CATEGORY_USER;
    }

    /**
     * @return bool
     */
    /*public function isViewer()
    {
        return $this->category_id === FortifyServiceProvider::CATEGORY_VIEWER;
    }*/

    /**
     * @return bool
     */
    public function isRoleSuperAdministrator()
    {
        return $this->category->role_id === FortifyServiceProvider::ROLE_SUPADM;
    }

    /**
     * @return bool
     */
    public function isRoleAdministrator()
    {
        return $this->category->role_id === FortifyServiceProvider::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isRoleManager()
    {
        return $this->category->role_id === FortifyServiceProvider::ROLE_MANAGER;
    }

    /**
     * @return bool
     */
    public function isRoleUser()
    {
        return $this->category->role_id === FortifyServiceProvider::ROLE_USER;
    }

    /**
     * @return bool
     */
    /*public function isRoleViewer()
    {
        return $this->category->role_id === FortifyServiceProvider::ROLE_VIEWER;
    }*/

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserCoordinateFactory::new();
    }
}
