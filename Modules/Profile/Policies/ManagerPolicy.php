<?php

namespace Modules\Profile\Policies;

use App\Providers\FortifyServiceProvider;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Modules\Profile\Entities\Manager;
use Modules\Right\Entities\RightAction;
use Modules\Right\Entities\RightFamily;

class ManagerPolicy
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
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // Right See Manager
        $isRightAllowed = $user->rights()
            ->where('action_id', RightAction::ACTION_SEE)
            ->where('family_id', RightFamily::FAMILY_MNG)
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
     * @param  Manager $manager
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Manager $manager)
    {
        $isSuperAdmin = $user->coordinate->isSuperAdministrator();

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // Right See Manager
        $isRightAllowed = $user->rights()
            ->where('action_id', RightAction::ACTION_SEE)
            ->where('family_id', RightFamily::FAMILY_MNG)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        $allowedManager = ($manager->isManager())? Manager::query()->where('company_id', session('companyId'))->exists() : true;

        return $isSuperAdmin || ($isCategoryAllowed && $isRightAllowed && $allowedManager)
            ? Response::allow()
            : Response::deny('You must be allowed right see.');
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

        // Right Add Manager
        $isRightAllowed = $user->rights()
            ->where('action_id', RightAction::ACTION_ADD)
            ->where('family_id', RightFamily::FAMILY_MNG)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        return $isSuperAdmin || ($isCategoryAllowed && $isRightAllowed)
            ? Response::allow()
            : Response::deny('You must be allowed right create.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  Manager $manager
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Manager $manager)
    {
        $isSuperAdmin = $user->coordinate->isSuperAdministrator();

        $allowedCategories = [
            FortifyServiceProvider::CATEGORY_MANAGER,
            FortifyServiceProvider::CATEGORY_ADMIN,
        ];

        $isCategoryAllowed = in_array($user->coordinate->category_id, $allowedCategories);

        // Right Update Manager
        $isRightAllowed = $user->rights()
            ->where('action_id', RightAction::ACTION_UPD)
            ->where('family_id', RightFamily::FAMILY_MNG)
            ->where('right_and_profile.enabled', 1)
            ->exists();

        $allowedManager = ($manager->isManager())? Manager::query()->where('company_id', session('companyId'))->exists() : true;

        return $isSuperAdmin || ($isCategoryAllowed && $isRightAllowed && $allowedManager)
            ? Response::allow()
            : Response::deny('You must be allowed right update.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Manager $manager
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Manager $manager)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Manager $manager
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Manager $manager)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Manager $manager
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Manager $manager)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }
}
