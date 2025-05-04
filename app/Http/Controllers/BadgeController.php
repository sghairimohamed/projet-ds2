<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $badges = Badge::all();
        $userBadges = $user->badges->pluck('id')->toArray();

        return view('badges.index', compact('badges', 'userBadges'));
    }

    public function checkAndAwardBadges(User $user)
    {
        $badges = Badge::all();
        $awardedBadges = [];

        foreach ($badges as $badge) {
            if ($this->checkBadgeCondition($user, $badge) && !$user->badges->contains($badge->id)) {
                $user->badges()->attach($badge->id);
                $awardedBadges[] = $badge;
            }
        }

        return $awardedBadges;
    }

    private function checkBadgeCondition(User $user, Badge $badge)
    {
        switch ($badge->condition_type) {
            case 'goals_completed':
                return $user->goals()->where('progress', 100)->count() >= $badge->condition_value;
            case 'streak_days':
                return $user->getCurrentStreak() >= $badge->condition_value;
            case 'shared_goals':
                return $user->sharedGoals()->count() >= $badge->condition_value;
            case 'journal_entries':
                return $user->progressJournals()->count() >= $badge->condition_value;
            default:
                return false;
        }
    }
} 