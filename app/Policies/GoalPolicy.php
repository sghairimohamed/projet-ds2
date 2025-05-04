<?php

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GoalPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Goal $goal)
    {
        if ($goal->visibility === 'public') {
            return true;
        }

        if ($goal->visibility === 'friends') {
            // TODO: Implémenter la logique des amis
            return $user->id === $goal->user_id;
        }

        return $user->id === $goal->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Goal $goal)
    {
        return $user->id === $goal->user_id;
    }

    public function delete(User $user, Goal $goal)
    {
        return $user->id === $goal->user_id;
    }
} 