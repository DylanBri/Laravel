<?php

namespace Modules\Profile\Policies;

use App\Models\User as UserBase;
use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;
use Modules\Profile\Entities\User;
use Modules\Right\Entities\RightAction;
use Modules\Right\Entities\RightFamily;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  UserBase  $userBase
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(UserBase $userBase)
    {
        $isSuperAdmin = $userBase->coordinate->isSuperAdministrator();

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($userBase->coordinate->category_id, $allowedCategories);

        // Right See User
        $isRightAllowed = $userBase->rights()
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
     * @param  UserBase  $userBase
     * @param  User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserBase $userBase, User $user)
    {
        $isSuperAdmin = $userBase->coordinate->isSuperAdministrator();

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($userBase->coordinate->category_id, $allowedCategories);

        // Right See User
        $isRightAllowed = $userBase->rights()
            ->where('action_id', RightAction::ACTION_SEE)
            ->where('family_id', RightFamily::FAMILY_USR)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        // User allowed
        $isUserAllowed = true;

        return $isSuperAdmin || ($isCategoryAllowed && $isRightAllowed && $isUserAllowed)
            ? Response::allow()
            : Response::deny('You must be allowed right see this element.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  UserBase  $userBase
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UserBase $userBase)
    {
        $isSuperAdmin = $userBase->coordinate->isSuperAdministrator();

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($userBase->coordinate->category_id, $allowedCategories);

        // Right Add User
        $isRightAllowed = $userBase->rights()
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
     * @param  UserBase  $userBase
     * @param  User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserBase $userBase, User $user)
    {
        $isSuperAdmin = $userBase->coordinate->isSuperAdministrator();

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_USER,
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($userBase->coordinate->category_id, $allowedCategories);

        // Right Update User
        $isRightAllowed = $userBase->rights()
            ->where('action_id', RightAction::ACTION_UPD)
            ->where('family_id', RightFamily::FAMILY_USR)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        // User allowed
        $isUserAllowed = false;
        $query = UserCoordinate::query()
            ->where('user_coordinates.user_id', $user->id)
            ->join('profiles', 'user_coordinates.user_id', '=', 'profiles.user_id');

        return $isSuperAdmin || ($isCategoryAllowed && $isRightAllowed && $isUserAllowed)
            ? Response::allow()
            : Response::deny('You must be allowed right update this element.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  UserBase  $userBase
     * @param  User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserBase $userBase, User $user)
    {
        return $userBase->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  UserBase  $userBase
     * @param  User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserBase $userBase, User $user)
    {
        return $userBase->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  UserBase  $userBase
     * @param  User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UserBase $userBase, User $user)
    {
        return $userBase->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }
}
