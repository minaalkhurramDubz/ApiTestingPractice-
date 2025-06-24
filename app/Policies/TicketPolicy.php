<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use App\Permissions\Abilities;

class TicketPolicy
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
    public function view(User $user, Ticket $ticket): bool
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
        return $user->tokenCan(Abilities::CreateTicket) || $user->tokenCan(Abilities::CreateOwnTicket);

    }

    /**
     * Determine whether the user can update the model.
     */

    // only the user who owns that ticket can update it
    public function update(User $user, Ticket $ticket): bool
    {
        if ($user->tokenCan(Abilities::UpdateTicket)) {
            return true;
        } elseif ($user->tokenCan(Abilities::UpdateOwnTicket)) {
            return $user->id == $ticket->user_id;
        }

        return false;
    }

    public function replace(User $user, Ticket $ticket): bool
    {
        if ($user->tokenCan(Abilities::ReplaceTicket)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        if ($user->tokenCan(Abilities::DeleteTicket)) {
            return true;
        } elseif ($user->tokenCan(Abilities::DeleteOwnTicket)) {
            return $user->id == $ticket->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
