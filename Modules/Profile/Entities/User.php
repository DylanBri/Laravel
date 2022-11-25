<?php

namespace Modules\Profile\Entities;

use \App\Models\User as UserBase;
use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends UserBase
{
    use HasFactory;

    protected $table = 'users';

    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        return (new static)->newQuery()
            ->select('*')
            ->addSelect('users.id as id')
            ->join('user_coordinates', 'user_coordinates.user_id', '=', 'users.id')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('profiles.client_id', session('clientId'))
            ->where('user_coordinates.category_id', FortifyServiceProvider::CATEGORY_USER);
    }

    /**
     * @return bool
     */
    public function isUser()
    {
        return $this->category_id === FortifyServiceProvider::CATEGORY_USER;
    }
}
