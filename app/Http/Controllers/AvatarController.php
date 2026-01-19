<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AvatarController extends Controller
{
    /**
     * Show the avatar edit page
     */
    public function edit()
    {
        $user = Auth::user();
        
        // List of available avatar images
        $avatars = [
            '/kidprofile/pro1.jpg',
            '/kidprofile/pro2.jpg',
            '/kidprofile/pro3.jpg',
        ];
        
        // Get current avatar or default to first one
        $currentAvatar = $user->avatar ?? '/kidprofile/pro1.jpg';

        return view('pages.avatar.edit', [
            'user' => $user,
            'avatars' => $avatars,
            'currentAvatar' => $currentAvatar
        ]);
    }

    /**
     * Update the user's avatar
     */
    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'required|string'
        ]);

        $user = Auth::user();
        $user->avatar = $request->avatar;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Avatar updated successfully! 🎉');
    }
}
