<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->paginate(10, ['*'], 'students_page');
        $teachers = User::where('role', 'teacher')->paginate(10, ['*'], 'teachers_page');
        $parents = User::where('role', 'parent')->paginate(10, ['*'], 'parents_page');
        
        return view('pages.admin.users', [
            'students' => $students,
            'teachers' => $teachers,
            'parents' => $parents,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,teacher,parent,student',
            'student_id' => 'nullable|string|max:255',
            'parent_name' => 'nullable|string|max:255',
        ]);

        // Set relationship_type based on role
        $relationshipType = in_array($validated['role'], ['parent', 'student']) ? $validated['role'] : 'student';

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'relationship_type' => $relationshipType,
            'email_verified_at' => now(),
            'student_id' => $validated['student_id'] ?? null,
            'parent_name' => $validated['parent_name'] ?? null,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'student_id' => 'nullable|string|max:255',
            'parent_name' => 'nullable|string|max:255',
        ]);

        // Only update password if provided
        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }}