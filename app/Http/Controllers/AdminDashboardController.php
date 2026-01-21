<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get user statistics
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalParents = User::where('role', 'parent')->count();
        
        // Get recent users (last 5)
        $recentUsers = User::latest()->take(5)->get();
        
        return view('pages::admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalParents' => $totalParents,
            'recentUsers' => $recentUsers,
        ]);
    }
}
