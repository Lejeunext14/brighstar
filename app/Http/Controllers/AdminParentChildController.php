<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminParentChildController extends Controller
{
    /**
     * Show admin parent-child management interface
     */
    public function index()
    {
        $parents = User::where('relationship_type', 'parent')
            ->where('role', 'parent')
            ->get();
        $students = User::where('relationship_type', 'student')
            ->where('role', 'student')
            ->get();
        $linkedPairs = User::whereNotNull('parent_id')->with('parent')->get();

        return view('pages.admin.parent-child-management', [
            'parents' => $parents,
            'students' => $students,
            'linkedPairs' => $linkedPairs,
        ]);
    }

    /**
     * Link children to a parent
     */
    public function linkChild(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:users,id',
            'child_ids' => 'required|array|min:1',
            'child_ids.*' => 'exists:users,id|different:parent_id',
        ]);

        $parent = User::findOrFail($request->parent_id);
        $childIds = $request->child_ids;

        // Verify parent is actually a parent
        if ($parent->relationship_type !== 'parent') {
            throw ValidationException::withMessages([
                'parent_id' => 'Selected user is not a parent account.',
            ]);
        }

        $linkedCount = 0;
        $skippedCount = 0;
        $errors = [];

        foreach ($childIds as $childId) {
            $child = User::findOrFail($childId);

            // Verify child is actually a student
            if ($child->relationship_type !== 'student') {
                $errors[] = "{$child->name} is not a student account.";
                $skippedCount++;
                continue;
            }

            // Check if child is already linked to this parent
            if ($child->parent_id === $parent->id) {
                $errors[] = "{$child->name} is already linked to {$parent->name}";
                $skippedCount++;
                continue;
            }

            // Check if child is already linked to another parent
            if ($child->parent_id && $child->parent_id !== $parent->id) {
                $oldParent = $child->parent;
                $errors[] = "{$child->name} is already linked to {$oldParent->name}. Unlink first to link to a different parent.";
                $skippedCount++;
                continue;
            }

            // Link the child to the parent
            $child->update(['parent_id' => $parent->id]);
            $linkedCount++;
        }

        $message = "Successfully linked {$linkedCount} " . ($linkedCount === 1 ? 'child' : 'children') . " to parent {$parent->name}";
        
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} skipped)";
        }

        if (!empty($errors)) {
            return back()->with('warning', $message . '. Issues: ' . implode('; ', $errors));
        }

        return back()->with('success', $message);
    }

    /**
     * Unlink a child from their parent
     */
    public function unlinkChild(Request $request, User $child)
    {
        $request->validate([]);

        if (!$child->parent_id) {
            return back()->with('warning', "{$child->name} is not linked to any parent");
        }

        $parent = $child->parent;
        $child->update(['parent_id' => null]);

        return back()->with('success', "Unlinked {$child->name} from parent {$parent->name}");
    }

    /**
     * Get unlinked students (AJAX)
     */
    public function getUnlinkedStudents()
    {
        $students = User::where('relationship_type', 'student')
            ->whereNull('parent_id')
            ->select('id', 'name', 'email')
            ->get();

        return response()->json($students);
    }

    /**
     * Get parent's children (AJAX)
     */
    public function getParentChildren($parentId)
    {
        $parent = User::findOrFail($parentId);

        if ($parent->relationship_type !== 'parent') {
            return response()->json(['error' => 'User is not a parent'], 422);
        }

        $children = $parent->children()->select('id', 'name', 'email')->get();

        return response()->json($children);
    }
}
