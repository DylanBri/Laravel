<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
//use Illuminate\Support\Facades\Log;
use Modules\Right\Entities\RightAction;
use Modules\Right\Entities\RightFamily;

class UserCoordinatePolicy
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
        $isSuperAdmin = $user->coordinate->isSuperAdministrator();

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // Rights
        $isRightAllowed = $user->rights()
            ->where('action_id', RightAction::ACTION_SEE)
            ->where('family_id', RightFamily::FAMILY_USR)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        return $isSuperAdmin || ($isCategoryAllowed && $isRightAllowed)
            ? Response::allow()
            : Response::deny('You must be allowed right see.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UserCoordinate $userCoordinate)
    {
        $isSuperAdmin = $user->coordinate->isSuperAdministrator();
        $isOneSelf = $user->id === $userCoordinate->user_id;

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // Rights
        $isRightAllowed = $user->rights()
            ->where('action_id', RightAction::ACTION_SEE)
            ->where('family_id', RightFamily::FAMILY_USR)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        $allowedUser = $userCoordinate->isUser() ? true : false;

        return $isSuperAdmin || $isOneSelf || ($isCategoryAllowed && $isRightAllowed && $allowedUser)
            ? Response::allow()
            : Response::deny('You must be allowed right see this element.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $isSuperAdmin = $user->coordinate->isSuperAdministrator();

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // Rights
        $isRightAllowed = $user->rights()
            ->where('action_id', RightAction::ACTION_ADD)
            ->where('family_id', RightFamily::FAMILY_USR)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        return $isSuperAdmin || ($isCategoryAllowed && $isRightAllowed)
            ? Response::allow()
            : Response::deny('You must be allowed right create this element.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UserCoordinate $userCoordinate)
    {
        $isSuperAdmin = $user->coordinate->isSuperAdministrator();
        $isOneSelf = $user->id === $userCoordinate->user_id;

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // Rights
        $isRightAllowed = $user->rights()
            ->where('action_id', RightAction::ACTION_UPD)
            ->where('family_id', RightFamily::FAMILY_USR)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        $allowedUser = $userCoordinate->isUser() ? $userCoordinate->user_id === session('userId') : false;

        return $isSuperAdmin || $isOneSelf || ($isCategoryAllowed && $isRightAllowed && $allowedUser)
            ? Response::allow()
            : Response::deny('You must be allowed right update this element.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UserCoordinate $userCoordinate)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UserCoordinate $userCoordinate)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UserCoordinate $userCoordinate)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }
}
