<?php

namespace App\Http\Controllers;

use App\Models\ProgressJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgressJournalController extends Controller
{
    public function index()
    {
        $journals = Auth::user()->progressJournals()
            ->latest()
            ->paginate(10);

        return view('progress-journals.index', compact('journals'));
    }

    public function create()
    {
        return view('progress-journals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'mood' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|max:2048',
        ]);

        $journal = Auth::user()->progressJournals()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'mood' => $validated['mood'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('progress-journals', 'public');
            $journal->update(['image_path' => $path]);
        }

        return redirect()->route('progress-journals.show', $journal)
            ->with('success', 'Entrée de journal créée avec succès!');
    }

    public function show(ProgressJournal $journal)
    {
        $this->authorize('view', $journal);
        return view('progress-journals.show', compact('journal'));
    }

    public function edit(ProgressJournal $journal)
    {
        $this->authorize('update', $journal);
        return view('progress-journals.edit', compact('journal'));
    }

    public function update(Request $request, ProgressJournal $journal)
    {
        $this->authorize('update', $journal);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'mood' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|max:2048',
        ]);

        $journal->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'mood' => $validated['mood'],
        ]);

        if ($request->hasFile('image')) {
            if ($journal->image_path) {
                Storage::disk('public')->delete($journal->image_path);
            }
            $path = $request->file('image')->store('progress-journals', 'public');
            $journal->update(['image_path' => $path]);
        }

        return redirect()->route('progress-journals.show', $journal)
            ->with('success', 'Entrée de journal mise à jour avec succès!');
    }

    public function destroy(ProgressJournal $journal)
    {
        $this->authorize('delete', $journal);

        if ($journal->image_path) {
            Storage::disk('public')->delete($journal->image_path);
        }

        $journal->delete();

        return redirect()->route('progress-journals.index')
            ->with('success', 'Entrée de journal supprimée avec succès!');
    }
} 