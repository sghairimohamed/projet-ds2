<?php

namespace App\Policies;

use App\Models\SharedGoal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SharedGoalPolicy
{
    use HandlesAuthorization;

    public function view(User $user, SharedGoal $sharedGoal)
    {
        return $sharedGoal->participants->contains($user) || $sharedGoal->created_by === $user->id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, SharedGoal $sharedGoal)
    {
        return $sharedGoal->created_by === $user->id;
    }

    public function delete(User $user, SharedGoal $sharedGoal)
    {
        return $sharedGoal->created_by === $user->id;
    }

    public function join(User $user, SharedGoal $sharedGoal)
    {
        return !$sharedGoal->participants->contains($user) && 
               $sharedGoal->status === 'active' &&
               $sharedGoal->participants->count() < $sharedGoal->max_participants;
    }

    public function leave(User $user, SharedGoal $sharedGoal)
    {
        return $sharedGoal->participants->contains($user) && 
               $sharedGoal->created_by !== $user->id;
    }

    public function addProgress(User $user, SharedGoal $sharedGoal)
    {
        return $sharedGoal->participants->contains($user);
    }
} 