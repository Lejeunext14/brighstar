<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalParents = User::where('role', 'parent')->count();
        
        // Users by role breakdown
        $studentsByMonth = User::where('role', 'student')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->latest('date')
            ->limit(30)
            ->get();
        
        return view('pages.admin.reports', [
            'totalUsers' => $totalUsers,
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalParents' => $totalParents,
            'studentsByMonth' => $studentsByMonth,
        ]);
    }
}
