<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminLogsController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];
        
        if (file_exists($logFile)) {
            $content = file_get_contents($logFile);
            // Parse logs - simple approach, split by new lines and take last 50
            $logLines = array_reverse(explode("\n", $content));
            $logs = array_filter(array_slice($logLines, 0, 100), fn($line) => !empty(trim($line)));
        }
        
        return view('pages.admin.logs', ['logs' => $logs]);
    }
}
