<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Badge;
use App\Models\SharedGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistiques avec valeurs par défaut
        $activeGoalsCount = 0;
        $completedGoalsCount = 0;
        $badgesCount = 0;
        $averageProgress = 0;
        $activeGoals = collect();
        $recentSharedGoals = collect();
        $recentBadges = collect();

        // Vérifier si la table goals existe avant d'effectuer les requêtes
        try {
            $activeGoalsCount = Goal::where('user_id', $user->id)
                ->where('progress', '<', 100)
                ->count();

            $completedGoalsCount = Goal::where('user_id', $user->id)
                ->where('progress', 100)
                ->count();

            $badgesCount = $user->badges()->count();

            $averageProgress = Goal::where('user_id', $user->id)
                ->avg('progress') ?? 0;

            // Objectifs en cours
            $activeGoals = Goal::where('user_id', $user->id)
                ->where('progress', '<', 100)
                ->orderBy('deadline', 'asc')
                ->take(5)
                ->get();

            // Objectifs partagés récents
            $recentSharedGoals = SharedGoal::whereHas('participants', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

            // Badges récents
            $recentBadges = $user->badges()
                ->orderBy('pivot_created_at', 'desc')
                ->take(4)
                ->get();
        } catch (\Exception $e) {
            // En cas d'erreur, on continue avec les valeurs par défaut
        }
        $steps = Step::where('goal_id', $goalId)->paginate(5); // ✅ paginé


        return view('dashboard', compact(
            'activeGoalsCount',
            'completedGoalsCount',
            'badgesCount',
            'averageProgress',
            'activeGoals',
            'recentSharedGoals',
            'recentBadges'
        ));
    }
} 