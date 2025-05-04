<?php

namespace App\Providers;

use App\Models\Goal;
use App\Models\Step;
use App\Models\TimelineEntry;
use App\Models\ProgressJournal;
use App\Models\SharedGoal;
use App\Models\Badge;
use App\Policies\GoalPolicy;
use App\Policies\StepPolicy;
use App\Policies\TimelineEntryPolicy;
use App\Policies\ProgressJournalPolicy;
use App\Policies\SharedGoalPolicy;
use App\Policies\BadgePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Goal::class => GoalPolicy::class,
        Step::class => StepPolicy::class,
        TimelineEntry::class => TimelineEntryPolicy::class,
        ProgressJournal::class => ProgressJournalPolicy::class,
        SharedGoal::class => SharedGoalPolicy::class,
        Badge::class => BadgePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
} 