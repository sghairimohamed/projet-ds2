<?php

namespace App\Policies;

use App\Models\ProgressJournal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgressJournalPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ProgressJournal $journal)
    {
        return $user->id === $journal->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, ProgressJournal $journal)
    {
        return $user->id === $journal->user_id;
    }

    public function delete(User $user, ProgressJournal $journal)
    {
        return $user->id === $journal->user_id;
    }
} 