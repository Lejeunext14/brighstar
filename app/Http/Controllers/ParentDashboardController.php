<?php

namespace App\Http\Controllers;

use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $parent = Auth::user();
        
        // Get all children linked to this parent
        $children = $parent->children()->get();
        
        // Get all lesson progress for all children
        $childrenProgress = [];
        $totalLessonsCompleted = 0;
        $totalChildren = $children->count();
        $totalMonitoringHours = 0;
        
        foreach ($children as $child) {
            $completedLessons = $child->lessonProgress()
                ->where('completed', true)
                ->count();
            
            $totalLessonsCompleted += $completedLessons;
            
            // Get the child's overall progress percentage
            $allLessons = $child->lessonProgress()->count();
            $progressPercentage = $allLessons > 0 ? round(($completedLessons / $allLessons) * 100) : 0;
            
            // Get last activity
            $lastActivity = $child->lessonProgress()
                ->latest('updated_at')
                ->first();
            
            // Calculate monitoring hours based on lesson activity
            $firstActivity = $child->lessonProgress()
                ->oldest('created_at')
                ->first();
            
            $monitoringHours = 0;
            if ($firstActivity && $lastActivity) {
                // Calculate hours between first and last activity
                $hoursSpan = $firstActivity->created_at->diffInHours($lastActivity->updated_at);
                // Estimate monitoring hours as a percentage of the span (assume 2 hours per activity)
                $monitoringHours = max($hoursSpan, $completedLessons * 2);
            } elseif ($completedLessons > 0) {
                // Estimate 2 hours per completed lesson if no time data
                $monitoringHours = $completedLessons * 2;
            }
            
            $totalMonitoringHours += $monitoringHours;
            
            $childrenProgress[] = [
                'id' => $child->id,
                'name' => $child->name,
                'email' => $child->email,
                'completedLessons' => $completedLessons,
                'totalLessons' => $allLessons,
                'progressPercentage' => $progressPercentage,
                'lastActivity' => $lastActivity,
                'monitoringHours' => round($monitoringHours),
            ];
        }
        
        // Calculate overall progress across all children
        $allChildrenProgress = LessonProgress::whereIn('user_id', $children->pluck('id'))
            ->where('completed', true)
            ->count();
        
        $totalProgressRecords = LessonProgress::whereIn('user_id', $children->pluck('id'))
            ->count();
        
        $overallProgressPercentage = $totalProgressRecords > 0 
            ? round(($allChildrenProgress / $totalProgressRecords) * 100) 
            : 0;
        
        // Get recent activities from all children
        $recentActivities = LessonProgress::whereIn('user_id', $children->pluck('id'))
            ->with('user')
            ->latest('updated_at')
            ->limit(10)
            ->get();

        return view('pages.parent.dashboard', [
            'parent' => $parent,
            'children' => $children,
            'childrenProgress' => $childrenProgress,
            'totalChildren' => $totalChildren,
            'totalLessonsCompleted' => $totalLessonsCompleted,
            'overallProgressPercentage' => $overallProgressPercentage,
            'totalMonitoringHours' => round($totalMonitoringHours),
            'recentActivities' => $recentActivities,
        ]);
    }
}
