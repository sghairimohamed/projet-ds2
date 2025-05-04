<?php

namespace App\Http\Controllers;

use App\Models\SharedGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharedGoalController extends Controller
{
    public function index()
    {
        $sharedGoals = SharedGoal::with(['creator', 'participants'])
            ->where('status', 'active')
            ->latest()
            ->paginate(10);

        return view('shared-goals.index', compact('sharedGoals'));
    }

    public function create()
    {
        return view('shared-goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_participants' => 'required|integer|min:2',
        ]);

        $sharedGoal = SharedGoal::create([
            ...$validated,
            'created_by' => Auth::id(),
            'status' => 'active',
        ]);

        // Le créateur est automatiquement ajouté comme participant
        $sharedGoal->participants()->attach(Auth::id(), [
            'joined_at' => now(),
            'status' => 'active',
        ]);

        return redirect()->route('shared-goals.show', $sharedGoal)
            ->with('success', 'Objectif commun créé avec succès!');
    }

    public function show(SharedGoal $sharedGoal)
    {
        $sharedGoal->load(['creator', 'participants', 'progressLogs.user']);
        return view('shared-goals.show', compact('sharedGoal'));
    }

    public function join(SharedGoal $sharedGoal)
    {
        if ($sharedGoal->participants()->count() >= $sharedGoal->max_participants) {
            return back()->with('error', 'Le nombre maximum de participants a été atteint.');
        }

        if (!$sharedGoal->participants->contains(Auth::id())) {
            $sharedGoal->participants()->attach(Auth::id(), [
                'joined_at' => now(),
                'status' => 'active',
            ]);
        }

        return back()->with('success', 'Vous avez rejoint l\'objectif commun!');
    }

    public function leave(SharedGoal $sharedGoal)
    {
        $sharedGoal->participants()->detach(Auth::id());
        return back()->with('success', 'Vous avez quitté l\'objectif commun.');
    }

    public function addProgressLog(Request $request, SharedGoal $sharedGoal)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $log = $sharedGoal->progressLogs()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('shared-goal-progress', 'public');
            $log->update(['image_path' => $path]);
        }

        return back()->with('success', 'Votre progression a été enregistrée!');
    }
} 