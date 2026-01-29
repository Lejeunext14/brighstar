<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LessonProgress;
use App\Models\ClassRoom;
use App\Models\Assignment;
use Auth;

class TeacherDashboardController extends Controller
{
    /**
     * Show the teacher dashboard with synced data
     */
    public function index()
    {
        $teacher = Auth::user();
        
        // Get all students (users with role 'student')
        $students = User::where('role', 'student')->get();
        
        // Get teacher's classes
        $classes = ClassRoom::where('teacher_id', $teacher->id)->get();
        
        // Get teacher's assignments
        $assignments = Assignment::where('teacher_id', $teacher->id)->where('is_archived', false)->get();
        $pendingAssignments = $assignments->where('status', 'pending')->count();
        $completedAssignments = $assignments->where('status', 'completed')->count();
        $totalAssignments = $assignments->count();
        
        // Calculate statistics
        $totalStudents = $students->count();
        $activeToday = $this->getStudentsActiveToday();
        $classAverage = $this->calculateClassAverage();
        
        // Get recent student activity
        $recentActivities = $this->getRecentActivities();
        
        // Get student progress data
        $studentProgress = $this->getStudentProgress($students);
        
        return view('pages.teacher.dashboard', [
            'teacher' => $teacher,
            'totalStudents' => $totalStudents,
            'activeToday' => $activeToday,
            'classAverage' => $classAverage,
            'pendingAssignments' => $pendingAssignments,
            'completedAssignments' => $completedAssignments,
            'totalAssignments' => $totalAssignments,
            'assignments' => $assignments,
            'recentActivities' => $recentActivities,
            'studentProgress' => $studentProgress,
            'students' => $students,
            'classes' => $classes,
        ]);
    }

    /**
     * Show all students
     */
    public function showAllStudents()
    {
        $teacher = Auth::user();
        $students = User::where('role', 'student')->get();

        return view('pages.teacher.students', [
            'teacher' => $teacher,
            'students' => $students,
        ]);
    }
    
    /**
     * Get students active today
     */
    private function getStudentsActiveToday()
    {
        $today = now()->toDateString();
        
        return LessonProgress::whereDate('updated_at', $today)
            ->distinct('user_id')
            ->count('user_id');
    }
    
    /**
     * Calculate class average progress
     */
    private function calculateClassAverage()
    {
        $allProgress = LessonProgress::get();
        
        if ($allProgress->isEmpty()) {
            return 0;
        }
        
        $completedCount = $allProgress->where('completed', true)->count();
        $totalCount = $allProgress->count();
        
        return round(($completedCount / $totalCount) * 100);
    }
    
    /**
     * Get recent student activities with pagination
     */
    private function getRecentActivities()
    {
        $activities = LessonProgress::with('user')
            ->orderByDesc('updated_at')
            ->paginate(10);
        
        // Map the paginated items
        $activities->setCollection(
            $activities->getCollection()->map(function($activity) {
                return [
                    'student_name' => $activity->user->name ?? 'Unknown',
                    'lesson_name' => $activity->lesson_name ?? $activity->lesson_slug,
                    'status' => $activity->completed ? 'Completed' : 'In Progress',
                    'time' => $activity->updated_at->diffForHumans(),
                    'icon' => $activity->completed ? '✅' : '📚',
                ];
            })
        );
        
        return $activities;
    }
    
    /**
     * Get all student progress data
     */
    private function getStudentProgress($students)
    {
        return $students->map(function($student) {
            $studentProgress = $student->lessonProgress()->get();
            $completed = $studentProgress->where('completed', true)->count();
            $total = $studentProgress->count();
            $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
            
            return [
                'id' => $student->id,
                'name' => $student->name,
                'total_lessons' => $total,
                'completed_lessons' => $completed,
                'progress_percentage' => $percentage,
            ];
        })->sortByDesc('progress_percentage');
    }
}
