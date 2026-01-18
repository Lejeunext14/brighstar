<?php

namespace App\Http\Controllers;

use App\Models\LessonProgress;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    public function markComplete(Request $request)
    {
        $validated = $request->validate([
            'lesson_slug' => 'required|string',
        ]);

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        LessonProgress::markLessonComplete(auth()->id(), $validated['lesson_slug']);

        return response()->json(['message' => 'Lesson marked complete'], 200);
    }

    public function resetAllUserProgress(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        LessonProgress::truncate();

        return response()->json(['message' => 'All progress reset'], 200);
    }

    public function getUserProgress()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $progress = LessonProgress::where('user_id', auth()->id())
            ->get()
            ->keyBy('lesson_slug');

        return response()->json($progress, 200);
    }
}
