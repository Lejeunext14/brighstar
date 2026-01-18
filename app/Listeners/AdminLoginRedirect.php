<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class AdminLoginRedirect
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if ($event->user->role === 'admin') {
            session(['redirect_to' => route('admin.dashboard')]);
        }
    }
}
