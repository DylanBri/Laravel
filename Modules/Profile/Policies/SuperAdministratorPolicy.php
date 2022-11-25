<?php

namespace Modules\Profile\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Modules\Profile\Entities\SuperAdministrator;

class SuperAdministratorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the superAdministrator can view any models.
     *
     * @param  User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the superAdministrator can view the model.
     *
     * @param  User $user
     * @param  SuperAdministrator  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SuperAdministrator $model)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the superAdministrator can create models.
     *
     * @param  User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the superAdministrator can update the model.
     *
     * @param  User $user
     * @param  SuperAdministrator  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SuperAdministrator $model)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the superAdministrator can delete the model.
     *
     * @param  User $user
     * @param  SuperAdministrator  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SuperAdministrator $model)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the superAdministrator can restore the model.
     *
     * @param  User $user
     * @param  SuperAdministrator  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SuperAdministrator $model)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }

    /**
     * Determine whether the superAdministrator can permanently delete the model.
     *
     * @param  User $user
     * @param  SuperAdministrator  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SuperAdministrator $model)
    {
        return $user->coordinate->isSuperAdministrator()
            ? Response::allow()
            : Response::deny('You must be an super administrator.');
    }
}
