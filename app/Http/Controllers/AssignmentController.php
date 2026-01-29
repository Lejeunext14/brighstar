<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Auth;

class AssignmentController extends Controller
{
    /**
     * Display all assignments for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        
        $assignments = Assignment::where('user_id', $user->id)
            ->orderBy('due_date', 'asc')
            ->get();

        $pendingAssignments = $assignments->where('status', 'pending')->count();
        $completedAssignments = $assignments->where('status', 'completed')->count();
        $overdueAssignments = $assignments->where('status', 'overdue')->count();

        return view('pages.assignments.index', [
            'assignments' => $assignments,
            'pendingAssignments' => $pendingAssignments,
            'completedAssignments' => $completedAssignments,
            'overdueAssignments' => $overdueAssignments,
        ]);
    }

    /**
     * Show form to create a new assignment (for teachers)
     */
    public function create()
    {
        // Only teachers can create assignments
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized');
        }

        // Get all students (role = 'student') who don't already have an assignment from this teacher
        $teacher = Auth::user();
        $studentsWithAssignments = Assignment::where('teacher_id', $teacher->id)
            ->pluck('user_id')
            ->toArray();

        $students = User::where('role', 'student')
            ->whereNotIn('id', $studentsWithAssignments)
            ->get();

        return view('pages.assignments.create', [
            'students' => $students,
        ]);
    }

    /**
     * Store a newly created assignment (for teachers)
     */
    public function store(Request $request)
    {
        // Only teachers can create assignments
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'nullable|string|max:100',
            'due_date' => 'nullable|date',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
            'priority' => 'nullable|integer|in:0,1,2',
        ]);

        $teacher = Auth::user();
        $priority = $validated['priority'] ?? 0;

        // Create assignments for each selected student
        foreach ($validated['student_ids'] as $studentId) {
            Assignment::create([
                'user_id' => $studentId,
                'teacher_id' => $teacher->id,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'subject' => $validated['subject'],
                'due_date' => $validated['due_date'],
                'status' => 'pending',
                'priority' => $priority,
            ]);

            // Create notification for the student
            Notification::create([
                'user_id' => $studentId,
                'title' => 'New Assignment',
                'message' => $teacher->name . ' assigned you: ' . $validated['title'],
                'type' => 'info',
                'icon' => 'document',
            ]);
        }

        return redirect()->route('teacher.assignments.index')->with('success', 'Assignment created successfully for ' . count($validated['student_ids']) . ' student(s)! 🎉');
    }

    /**
     * Display all assignments created by the teacher
     */
    public function teacherIndex(Request $request)
    {
        // Only teachers can view their created assignments
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized');
        }

        $teacher = Auth::user();
        $search = $request->input('search');
        $statusFilter = $request->input('status');
        $subjectFilter = $request->input('subject');
        $priorityFilter = $request->input('priority');
        $sortBy = $request->input('sort_by', 'due_date_asc');

        $query = Assignment::where('teacher_id', $teacher->id)->where('is_archived', false)->with('user');

        // Search by student name, assignment title, or subject
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Filter by subject
        if ($subjectFilter && $subjectFilter !== 'all') {
            $query->where('subject', $subjectFilter);
        }

        // Filter by priority
        if ($priorityFilter && $priorityFilter !== 'all') {
            $query->where('priority', $priorityFilter);
        }

        $allAssignments = $query->get();

        // Apply sorting
        switch ($sortBy) {
            case 'due_date_desc':
                $query->orderBy('due_date', 'desc');
                break;
            case 'priority_desc':
                $query->orderBy('priority', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'status':
                $query->orderBy('status', 'asc');
                break;
            case 'due_date_asc':
            default:
                $query->orderBy('due_date', 'asc');
                break;
        }

        $assignments = $query->paginate(10);

        $stats = [
            'total' => $allAssignments->count(),
            'pending' => $allAssignments->where('status', 'pending')->count(),
            'completed' => $allAssignments->where('status', 'completed')->count(),
        ];

        // Get unique subjects for filter dropdown
        $subjects = Assignment::where('teacher_id', $teacher->id)
            ->whereNotNull('subject')
            ->distinct()
            ->pluck('subject')
            ->sort();

        return view('pages.assignments.teacher', [
            'assignments' => $assignments,
            'stats' => $stats,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'subjectFilter' => $subjectFilter,
            'priorityFilter' => $priorityFilter,
            'sortBy' => $sortBy,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Mark assignment as completed
     */
    public function complete(Assignment $assignment)
    {
        // Check if user owns this assignment
        if ($assignment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $assignment->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Assignment marked as completed! 🎉');
    }

    /**
     * Submit assignment
     */
    public function submit(Request $request, Assignment $assignment)
    {
        // Check if user owns this assignment
        if ($assignment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'submission_notes' => 'nullable|string|max:1000',
        ]);

        $assignment->update([
            'submitted_at' => now(),
            'submission_notes' => $validated['submission_notes'] ?? null,
        ]);

        // Create notification for teacher
        Notification::create([
            'user_id' => $assignment->teacher_id,
            'title' => 'Assignment Submitted',
            'message' => $assignment->user->name . ' submitted: ' . $assignment->title,
            'type' => 'success',
            'icon' => 'check-circle',
        ]);

        return redirect()->back()->with('success', 'Assignment submitted successfully! 🎉');
    }

    /**
     * Delete assignment (student can only delete their own, teacher can delete any)
     */
    public function destroy(Assignment $assignment)
    {
        $user = Auth::user();
        
        // Check authorization
        if ($user->role === 'student' && $assignment->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        } elseif ($user->role === 'teacher' && $assignment->teacher_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $assignment->delete();

        return redirect()->back()->with('success', 'Assignment deleted successfully!');
    }

    /**
     * Archive an assignment (teacher only)
     */
    public function archive(Assignment $assignment)
    {
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $assignment->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Assignment archived successfully! 🗂️');
    }

    /**
     * Display archived assignments created by the teacher
     */
    public function archivedIndex(Request $request)
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized');
        }

        $teacher = Auth::user();
        $search = $request->input('search');
        $statusFilter = $request->input('status');
        $subjectFilter = $request->input('subject');
        $sortBy = $request->input('sort_by', 'archived_at_desc');

        $query = Assignment::where('teacher_id', $teacher->id)
            ->where('is_archived', true)
            ->with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($subjectFilter && $subjectFilter !== 'all') {
            $query->where('subject', $subjectFilter);
        }

        $allAssignments = $query->get();

        switch ($sortBy) {
            case 'archived_at_asc':
                $query->orderBy('archived_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'status':
                $query->orderBy('status', 'asc');
                break;
            case 'archived_at_desc':
            default:
                $query->orderBy('archived_at', 'desc');
                break;
        }

        $assignments = $query->paginate(10);

        $stats = [
            'total' => $allAssignments->count(),
            'pending' => $allAssignments->where('status', 'pending')->count(),
            'completed' => $allAssignments->where('status', 'completed')->count(),
        ];

        $subjects = Assignment::where('teacher_id', $teacher->id)
            ->where('is_archived', true)
            ->whereNotNull('subject')
            ->distinct()
            ->pluck('subject')
            ->sort();

        return view('pages.assignments.archived', [
            'assignments' => $assignments,
            'stats' => $stats,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'subjectFilter' => $subjectFilter,
            'sortBy' => $sortBy,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Restore an archived assignment (teacher only)
     */
    public function restore(Assignment $assignment)
    {
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $assignment->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);

        return redirect()->back()->with('success', 'Assignment restored successfully! ✨');
    }
}
