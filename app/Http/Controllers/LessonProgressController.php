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
            'subject' => 'nullable|string',
            'lesson_name' => 'nullable|string',
        ]);

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Convert lesson slug to readable lesson name if not provided
        $lessonName = $validated['lesson_name'] ?? ucwords(str_replace('-', ' ', $validated['lesson_slug']));
        $subject = $validated['subject'] ?? 'Filipino'; // Default to Filipino

        $lessonProgress = LessonProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_slug' => $validated['lesson_slug'],
            ],
            [
                'completed' => true,
                'subject' => $subject,
                'lesson_name' => $lessonName,
            ]
        );

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
