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
        
        // List of available avatar images with metadata
        $avatars = [
            [
                'path' => '/kidprofile/pro1.jpg',
                'name' => 'Alex',
                'description' => 'A cheerful learner ready to explore!',
                'emoji' => '👦',
                'color' => 'from-blue-400 to-cyan-400'
            ],
            [
                'path' => '/kidprofile/pro2.jpg',
                'name' => 'Maya',
                'description' => 'Smart and adventurous!',
                'emoji' => '👧',
                'color' => 'from-pink-400 to-red-400'
            ],
            [
                'path' => '/kidprofile/pro3.jpg',
                'name' => 'Jordan',
                'description' => 'Creative and fun-loving!',
                'emoji' => '🧒',
                'color' => 'from-purple-400 to-indigo-400'
            ],
        ];
        
        // Get current avatar or default to first one
        $currentAvatar = $user->avatar ?? '/kidprofile/pro1.jpg';
        
        // Get metadata for current avatar
        $currentAvatarMeta = collect($avatars)->firstWhere('path', $currentAvatar) ?? $avatars[0];

        return view('pages.avatar.edit', [
            'user' => $user,
            'avatars' => $avatars,
            'currentAvatar' => $currentAvatar,
            'currentAvatarMeta' => $currentAvatarMeta
        ]);
    }

    /**
     * Update the user's avatar
     */
    public function update(Request $request)
    {
        $validAvatars = [
            '/kidprofile/pro1.jpg',
            '/kidprofile/pro2.jpg',
            '/kidprofile/pro3.jpg',
        ];

        $request->validate([
            'avatar' => ['required', 'string', 'in:' . implode(',', $validAvatars)]
        ]);

        $user = Auth::user();
        $user->avatar = $request->avatar;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Avatar updated successfully! 🎉');
    }
}
