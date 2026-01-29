<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the user
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(15);

        return view('pages.notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function read(Notification $notification)
    {
        // Check if user owns this notification
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'All notifications marked as read!');
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification)
    {
        // Check if user owns this notification
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted!');
    }
}
