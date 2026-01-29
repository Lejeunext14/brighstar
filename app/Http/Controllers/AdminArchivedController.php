<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminArchivedController extends Controller
{
    public function index()
    {
        $archivedUsers = User::onlyTrashed()->paginate(10);
        
        return view('pages.admin.archived', [
            'archivedUsers' => $archivedUsers,
        ]);
    }
}
