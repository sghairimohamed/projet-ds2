<?php

namespace App\Http\Controllers;

use App\Models\TimelineEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TimelineEntryController extends Controller
{
    public function show(TimelineEntry $timelineEntry)
    {
        $this->authorize('view', $timelineEntry->goal);
        return response()->json($timelineEntry);
    }

    public function edit(TimelineEntry $timelineEntry)
    {
        $this->authorize('update', $timelineEntry->goal);
        return response()->json($timelineEntry);
    }

    public function update(Request $request, TimelineEntry $timelineEntry)
    {
        $this->authorize('update', $timelineEntry->goal);

        $validated = $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($timelineEntry->image_path) {
                Storage::disk('public')->delete($timelineEntry->image_path);
            }
            $path = $request->file('image')->store('timeline', 'public');
            $validated['image_path'] = $path;
        }

        $timelineEntry->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(TimelineEntry $timelineEntry)
    {
        $this->authorize('update', $timelineEntry->goal);

        if ($timelineEntry->image_path) {
            Storage::disk('public')->delete($timelineEntry->image_path);
        }

        $timelineEntry->delete();
        return response()->json(['success' => true]);
    }
} 