<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Step;
use App\Models\TimelineEntry;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class GoalController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $goals = Auth::user()->goals()->latest()->paginate(10);
        return view('goals.index', compact('goals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('goals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
            'image' => 'nullable|image|max:2048',
        ]);

        $goal = Auth::user()->goals()->create($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('goals', 'public');
            $goal->update(['image_path' => $path]);
        }

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Goal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal): View
    {
        $this->authorize('view', $goal);
        
        $goal->load(['steps', 'timelineEntries.user']);
        return view('goals.show', compact('goal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal): View
    {
        $this->authorize('update', $goal);
        return view('goals.edit', compact('goal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goal $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
            'image' => 'nullable|image|max:2048',
        ]);

        $goal->update($validated);

        if ($request->hasFile('image')) {
            if ($goal->image_path) {
                Storage::disk('public')->delete($goal->image_path);
            }
            $path = $request->file('image')->store('goals', 'public');
            $goal->update(['image_path' => $path]);
        }

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Goal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal): RedirectResponse
    {
        $this->authorize('delete', $goal);

        if ($goal->image_path) {
            Storage::disk('public')->delete($goal->image_path);
        }

        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Goal deleted successfully.');
    }

    /**
     * Add a step to the goal.
     */
    public function addStep(Request $request, Goal $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
        ]);

        $goal->steps()->create($validated);

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Step added successfully.');
    }

    /**
     * Update the progress of a step.
     */
    public function updateProgress(Request $request, Goal $goal, Step $step): RedirectResponse
    {
        $this->authorize('update', $goal);

        $validated = $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $step->update($validated);

        // Update goal progress
        $totalProgress = $goal->steps()->avg('progress');
        $goal->update(['progress' => $totalProgress]);

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Progress updated successfully.');
    }

    /**
     * Add a timeline entry to the goal.
     */
    public function addTimelineEntry(Request $request, Goal $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        $validated = $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $entry = $goal->timelineEntries()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('timeline', 'public');
            $entry->update(['image_path' => $path]);
        }

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Timeline entry added successfully.');
    }
         public function addStep(Request $request, $goalId)
    {
    // Tu peux adapter selon ta base de données
    $goal = Goal::findOrFail($goalId);

    // Exemple : enregistrer une étape depuis un champ "step_description"
    $goal->steps()->create([
        'description' => $request->input('step_description'),
    ]);

    return redirect()->back()->with('success', 'Étape ajoutée avec succès !');
    }
     
public function show($id)
{
    $goal = Goal::findOrFail($id);
    $steps = $goal->steps()->paginate(5); // pagination correcte

    return view('goals.show', compact('goal', 'steps'));
}

    
} 