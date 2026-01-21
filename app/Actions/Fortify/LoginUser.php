<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\LoginRateLimiter;
use Illuminate\Http\Request;

class LoginUser
{
    /**
     * Create a new action instance.
     */
    public function __construct(
        public LoginRateLimiter $limiter,
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): ?User
    {
        // Check if logging in with student_id
        $input = $request->input('email'); // The form field is named 'email' but now contains student_id
        
        // Try to find user by student_id first
        $user = User::where('student_id', $input)->first();
        
        // If not found by student_id, try by email (for backward compatibility)
        if (!$user) {
            $user = User::where('email', $input)->first();
        }

        // Check rate limiting
        if ($this->limiter->tooManyAttempts($request)) {
            $this->limiter->increment($request);
            throw ValidationException::withMessages([
                'email' => __('auth.throttle', [
                    'seconds' => $this->limiter->availableIn($request),
                ]),
            ]);
        }

        // Validate credentials
        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->limiter->increment($request);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Reset rate limiter
        $this->limiter->clear($request);

        // Return the authenticated user
        return $user;
    }
}

