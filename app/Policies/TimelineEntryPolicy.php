<?php

namespace App\Policies;

use App\Models\TimelineEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimelineEntryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, TimelineEntry $timelineEntry)
    {
        return $user->id === $timelineEntry->goal->user_id;
    }

    public function update(User $user, TimelineEntry $timelineEntry)
    {
        return $user->id === $timelineEntry->goal->user_id;
    }

    public function delete(User $user, TimelineEntry $timelineEntry)
    {
        return $user->id === $timelineEntry->goal->user_id;
    }
} 