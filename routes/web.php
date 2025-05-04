<?php

use Illuminate\Support\Facades\Route;
use App\Models\SharedGoal;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProgressJournalController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\GoalController;


// Accueil
Route::get('/', function () {
    return view('welcome');
});

// Routes d'
Route::resource('progress-journals', ProgressJournalController::class);
Route::post('/goals/{goal}/add-step', [GoalController::class, 'addStep'])->name('goals.addStep');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/progress-journals', [ProgressJournalController::class, 'index'])->name('progress-journals.index');
Route::get('/badges', [BadgeController::class, 'index'])->name('badges.index');
// Routes protégées
Route::middleware(['auth'])->group(function () {

    // Dashboard de l'utilisateur
    Route::get('/dashboard', function () {
        $activeGoals = Goal::where('user_id', auth()->id())->where('progress', '<', 100)->get();
        $completedGoalsCount = Goal::where('user_id', auth()->id())->where('progress', 100)->count();
        $activeGoalsCount = $activeGoals->count();
        $badgesCount = auth()->user()->badges->count();
        $recentBadges = auth()->user()->badges()->latest()->take(4)->get();
        $averageProgress = Goal::where('user_id', auth()->id())->avg('progress') ?? 0;
        $recentSharedGoals = SharedGoal::latest()->take(5)->get();

        return view('dashboard', compact(
            'activeGoals',
            'activeGoalsCount',
            'completedGoalsCount',
            'badgesCount',
            'recentBadges',
            'averageProgress',
            'recentSharedGoals'
        ));
    })->name('dashboard');

    // Afficher tous les objectifs
    Route::get('/goals', function () {
        $goals = Goal::where('user_id', auth()->id())->with('steps')->latest()->paginate(9);
        return view('goals.index', compact('goals'));
    })->name('goals.index');

    // Formulaire de création d'objectif
    Route::get('/goals/create', function () {
        return view('goals.create');
    })->name('goals.create');

    // Enregistrement d'un objectif
    Route::post('/goals', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'progress' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : null;

        Goal::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'progress' => $validated['progress'],
            'image_path' => $imagePath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('goals.index')->with('success', 'Objectif créé avec succès.');
    });

    // Voir un objectif
    Route::get('/goals/{goal}', function (Goal $goal) {
        abort_if($goal->user_id !== auth()->id(), 403);
        return view('goals.show', compact('goal'));
    })->name('goals.show');

    // Formulaire d'édition
    Route::get('/goals/{goal}/edit', function (Goal $goal) {
        abort_if($goal->user_id !== auth()->id(), 403);
        return view('goals.edit', compact('goal'));
    })->name('goals.edit');

    // Suppression d’un objectif
    Route::delete('/goals/{goal}', function (Goal $goal) {
        abort_if($goal->user_id !== auth()->id(), 403);
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Objectif supprimé.');
    })->name('goals.destroy');

    // Formulaire création objectif partagé
    Route::get('/shared-goals/create', function () {
        return view('shared-goals.create');
    })->name('shared-goals.create');

    // Enregistrement objectif partagé
    Route::post('/shared-goals', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|string|in:open,closed,completed',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : null;

        SharedGoal::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'max_participants' => $validated['max_participants'],
            'status' => $validated['status'],
            'image_path' => $imagePath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Objectif partagé créé.');
    });

    // Liste des objectifs partagés
    Route::get('/shared-goals', function () {
        $sharedGoals = SharedGoal::latest()->get();
        return view('shared-goals.index', compact('sharedGoals'));
    })->name('shared-goals.index');

    // Voir un objectif partagé
    Route::get('/shared-goals/{goal}', function (SharedGoal $goal) {
        return view('shared-goals.show', compact('goal'));
    })->name('shared-goals.show');
});

// Auth scaffolding Laravel Breeze / Jetstream
require __DIR__.'/auth.php';
