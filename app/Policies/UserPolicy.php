<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use App\Permissions\Abilities;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    public function store(User $user): bool
    {
        // can a user create ticket, or create own ticket
        return $user->tokenCan(Abilities::CreateUser);

    }

    /**
     * Determine whether the user can update the model.
     */

    // only the user who owns that ticket can update it
    public function update(User $user, User $model): bool
    {

        return $user->tokenCan(Abilities::UpdateUser);

    }

    public function replace(User $user, User $model): bool
    {
        //  dd(90);

        return $user->tokenCan(Abilities::ReplaceUser);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::DeleteUser);

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
