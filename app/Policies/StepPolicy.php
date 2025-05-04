<?php

namespace App\Policies;

use App\Models\Step;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StepPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Step $step)
    {
        return $user->id === $step->goal->user_id;
    }

    public function update(User $user, Step $step)
    {
        return $user->id === $step->goal->user_id;
    }

    public function delete(User $user, Step $step)
    {
        return $user->id === $step->goal->user_id;
    }
} 