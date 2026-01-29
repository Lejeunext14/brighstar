<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
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
     * Delete assignment
     */
    public function destroy(Assignment $assignment)
    {
        // Check if user owns this assignment
        if ($assignment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $assignment->delete();

        return redirect()->back()->with('success', 'Assignment deleted successfully!');
    }
}
