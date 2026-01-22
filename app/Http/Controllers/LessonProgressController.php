<?php

namespace App\Http\Controllers;

use App\Models\LessonProgress;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    public function markComplete(Request $request)
    {
        try {
            $validated = $request->validate([
                'lesson_slug' => 'required|string',
                'subject' => 'nullable|string',
                'lesson_name' => 'nullable|string',
                'points' => 'nullable|integer|min:0',
            ]);

            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Convert lesson slug to readable lesson name if not provided
            $lessonName = $validated['lesson_name'] ?? ucwords(str_replace('-', ' ', $validated['lesson_slug']));
            $subject = $validated['subject'] ?? 'Filipino'; // Default to Filipino
            $points = $validated['points'] ?? 10; // Default 10 points per lesson

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

            // Check if daily progress needs reset and add points
            $lessonProgress->refresh(); // Refresh to get the latest data
            $lessonProgress->checkAndResetDaily();
            $lessonProgress->addDailyPoints($points);
            $lessonProgress->increment('points', $points);
            $lessonProgress->refresh();

            return response()->json([
                'message' => 'Lesson marked complete',
                'daily_progress' => $lessonProgress->getDailyProgress(),
                'total_points' => $lessonProgress->points,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error marking lesson as complete',
                'message' => $e->getMessage(),
            ], 500);
        }
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
            ->map(function ($item) {
                // Check and reset daily progress for each item
                $item->checkAndResetDaily();
                return $item;
            })
            ->keyBy('lesson_slug');

        return response()->json($progress, 200);
    }

    /**
     * Get daily progress summary for the current user
     */
    public function getDailyProgress()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userProgress = LessonProgress::where('user_id', auth()->id())
            ->get()
            ->map(function ($item) {
                $item->checkAndResetDaily();
                return $item->getDailyProgress();
            });

        $totalDailyPoints = $userProgress->sum('daily_points');
        $totalDailyStreak = $userProgress->sum('daily_streak');

        return response()->json([
            'total_daily_points' => $totalDailyPoints,
            'total_daily_streak' => $totalDailyStreak,
            'lessons_completed_today' => $userProgress->count(),
        ], 200);
    }
}
