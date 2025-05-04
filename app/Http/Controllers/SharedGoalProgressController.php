<?php

namespace App\Http\Controllers;

use App\Models\SharedGoal;
use App\Models\SharedGoalProgressLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SharedGoalProgressController extends Controller
{
    public function store(Request $request, SharedGoal $sharedGoal)
    {
        // Vérifier si l'utilisateur est un participant
        if (!$sharedGoal->participants()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Vous devez être un participant pour ajouter une progression.');
        }

        $validated = $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'comment' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $log = new SharedGoalProgressLog([
            'shared_goal_id' => $sharedGoal->id,
            'user_id' => Auth::id(),
            'progress' => $validated['progress'],
            'comment' => $validated['comment'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('shared-goals/progress', 'public');
            $log->image_path = $path;
        }

        $log->save();

        return back()->with('success', 'Progression enregistrée avec succès!');
    }

    public function update(Request $request, SharedGoal $sharedGoal, SharedGoalProgressLog $progressLog)
    {
        // Vérifier si l'utilisateur est le propriétaire du log
        if ($progressLog->user_id !== Auth::id()) {
            return back()->with('error', 'Vous ne pouvez modifier que vos propres logs de progression.');
        }

        $validated = $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'comment' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $progressLog->update([
            'progress' => $validated['progress'],
            'comment' => $validated['comment'],
        ]);

        if ($request->hasFile('image')) {
            if ($progressLog->image_path) {
                Storage::disk('public')->delete($progressLog->image_path);
            }
            $path = $request->file('image')->store('shared-goals/progress', 'public');
            $progressLog->update(['image_path' => $path]);
        }

        return back()->with('success', 'Progression mise à jour avec succès!');
    }

    public function destroy(SharedGoal $sharedGoal, SharedGoalProgressLog $progressLog)
    {
        // Vérifier si l'utilisateur est le propriétaire du log
        if ($progressLog->user_id !== Auth::id()) {
            return back()->with('error', 'Vous ne pouvez supprimer que vos propres logs de progression.');
        }

        if ($progressLog->image_path) {
            Storage::disk('public')->delete($progressLog->image_path);
        }

        $progressLog->delete();

        return back()->with('success', 'Log de progression supprimé avec succès!');
    }
} 