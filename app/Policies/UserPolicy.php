<?php

namespace App\Policies;

use App\Models\User;
use App\Providers\FortifyServiceProvider;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
//use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
            FortifyServiceProvider::CATEGORY_SUPADM,
        ];
        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // TODO Right
        $isRightAllowed = true;

        return $isCategoryAllowed && $isRightAllowed;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
            FortifyServiceProvider::CATEGORY_SUPADM,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // TODO Right
        $isRightAllowed = true;

        return $isCategoryAllowed && $isRightAllowed;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
            FortifyServiceProvider::CATEGORY_SUPADM,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // TODO Right
        $isRightAllowed = true;

        return $isCategoryAllowed && $isRightAllowed;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
            FortifyServiceProvider::CATEGORY_SUPADM,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // TODO Right
        $isRightAllowed = true;

        return $isCategoryAllowed && $isRightAllowed;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }
}
