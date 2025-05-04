<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StepController extends Controller
{
    public function show(Step $step)
    {
        $this->authorize('view', $step->goal);
        return response()->json($step);
    }

    public function edit(Step $step)
    {
        $this->authorize('update', $step->goal);
        return response()->json($step);
    }

    public function update(Request $request, Step $step)
    {
        $this->authorize('update', $step->goal);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'completed' => 'boolean',
        ]);

        $step->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Step $step)
    {
        $this->authorize('update', $step->goal);
        $step->delete();
        return response()->json(['success' => true]);
    }

    public function toggle(Step $step)
    {
        $this->authorize('update', $step->goal);
        
        $step->update([
            'completed' => !$step->completed
        ]);

        return response()->json(['success' => true]);
    }
    public function index($goalId)
{
    $goal = Goal::findOrFail($goalId);
    $steps = $goal->steps()->paginate(5); // <-- parenthèses et paginate

    return view('steps.index', compact('goal', 'steps'));
}

} 