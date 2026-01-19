<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StudentDashboardController extends Controller
{
    /**
     * Show the student dashboard with synced data
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all lesson progress for the student
        $allLessonProgress = $user->lessonProgress()->get();
        
        // Calculate statistics
        $totalLessons = $allLessonProgress->count();
        $completedLessons = $allLessonProgress->where('completed', true)->count();
        $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        
        // Calculate Filipino subject progress
        $filipinoProgress = $this->calculateSubjectProgress($user, 'Filipino');
        
        // Calculate monitoring hours based on lesson activity
        $monitoringHours = $this->calculateMonitoringHours($user);
        
        // Get recent activities (last 4)
        $recentActivities = $allLessonProgress
            ->sortByDesc('updated_at')
            ->take(4)
            ->values();
        
        // Calculate day streak (simplified - counts days with activity)
        $dayStreak = $this->calculateDayStreak($user);
        
        // Get the user's avatar
        $avatar = $user->avatar ?? '/kidprofile/pro1.jpg';
        
        return view('dashboard', [
            'user' => $user,
            'totalLessons' => $totalLessons,
            'completedLessons' => $completedLessons,
            'progressPercentage' => $progressPercentage,
            'monitoringHours' => $monitoringHours,
            'dayStreak' => $dayStreak,
            'recentActivities' => $recentActivities,
            'avatar' => $avatar,
            'subjectCount' => 1, // Currently only Filipino is available
            'filipinoProgress' => $filipinoProgress,
        ]);
    }
    
    /**
     * Calculate progress for a specific subject
     */
    private function calculateSubjectProgress($user, $subject)
    {
        $subjectProgress = $user->lessonProgress()
            ->where('subject', $subject)
            ->get();
        
        if ($subjectProgress->isEmpty()) {
            return [
                'total' => 0,
                'completed' => 0,
                'percentage' => 0,
                'totalTopics' => 0,
                'overallProgress' => 0,
            ];
        }
        
        $total = $subjectProgress->count();
        $completed = $subjectProgress->where('completed', true)->count();
        $percentage = round(($completed / $total) * 100);
        
        // Get total unique topics (using lesson_slug as topic identifier)
        $uniqueTopics = $subjectProgress->pluck('lesson_slug')->unique()->count();
        
        // Get overall progress of student (all subjects combined)
        $allProgress = $user->lessonProgress()->get();
        $allCompleted = $allProgress->where('completed', true)->count();
        $overallProgress = $allProgress->count() > 0 ? round(($allCompleted / $allProgress->count()) * 100) : 0;
        
        return [
            'total' => $total,
            'completed' => $completed,
            'percentage' => $percentage,
            'totalTopics' => $uniqueTopics,
            'overallProgress' => $overallProgress,
        ];
    }
    
    /**
     * Calculate monitoring hours based on lesson activity
     */
    private function calculateMonitoringHours($user)
    {
        $lessonProgress = $user->lessonProgress()->get();
        
        if ($lessonProgress->isEmpty()) {
            return 0;
        }
        
        // Calculate hours based on completed lessons (estimate 30 mins per lesson)
        $completedCount = $lessonProgress->where('completed', true)->count();
        $completedHours = $completedCount * 0.5;
        
        // Calculate hours based on time span between first and last activity
        $firstActivity = $lessonProgress->min('created_at');
        $lastActivity = $lessonProgress->max('updated_at');
        
        if ($firstActivity && $lastActivity) {
            $daysDiff = $firstActivity->diffInDays($lastActivity);
            $estimatedHours = max($completedHours, $daysDiff * 0.5);
        } else {
            $estimatedHours = $completedHours;
        }
        
        return ceil($estimatedHours);
    }
    
    /**
     * Calculate day streak
     */
    private function calculateDayStreak($user)
    {
        $lessonProgress = $user->lessonProgress()
            ->orderByDesc('updated_at')
            ->get();
        
        if ($lessonProgress->isEmpty()) {
            return 0;
        }
        
        $streak = 0;
        $lastDate = null;
        
        foreach ($lessonProgress as $progress) {
            $currentDate = $progress->updated_at->toDateString();
            
            if ($lastDate === null) {
                $streak = 1;
                $lastDate = $currentDate;
            } else {
                $diff = strtotime($lastDate) - strtotime($currentDate);
                $daysDiff = floor($diff / (60 * 60 * 24));
                
                if ($daysDiff == 1) {
                    $streak++;
                    $lastDate = $currentDate;
                } else {
                    break;
                }
            }
        }
        
        return $streak;
    }
}
