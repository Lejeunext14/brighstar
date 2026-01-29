<?php

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';
    public string $avatar = '';
    public array $availableAvatars = [
        '/kidprofile/pro1.jpg',
        '/kidprofile/pro2.jpg',
        '/kidprofile/pro3.jpg',
    ];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->avatar = Auth::user()->avatar ?? '/kidprofile/pro1.jpg';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));
        
        $validated['avatar'] = $this->avatar;

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your name, email address, and avatar')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <!-- Avatar Selection -->
            <div class="space-y-4">
                <flux:heading level="3">{{ __('Avatar') }}</flux:heading>
                
                <div class="flex items-center gap-4">
                    <!-- Current Avatar Preview -->
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-zinc-200 dark:border-zinc-700 shadow-md" style="background-image: url('{{ asset($avatar) }}'); background-size: cover; background-position: center;"></div>
                        <flux:text class="mt-2 text-xs text-zinc-500">Current Avatar</flux:text>
                    </div>

                    <!-- Avatar Options -->
                    <div class="flex gap-3 flex-wrap">
                        @foreach ($availableAvatars as $avatarOption)
                            <label class="cursor-pointer group">
                                <input type="radio" wire:model.live="avatar" value="{{ $avatarOption }}" class="sr-only">
                                <div class="w-16 h-16 rounded-full overflow-hidden border-2 transition-all" 
                                     :class="$wire.avatar === '{{ $avatarOption }}' ? 'border-blue-500 ring-2 ring-blue-300' : 'border-zinc-300 hover:border-zinc-400'"
                                     style="background-image: url('{{ asset($avatarOption) }}'); background-size: cover; background-position: center;">
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="update-profile-button">
                        {{ __('Save') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-pages::settings.layout>
</section>
