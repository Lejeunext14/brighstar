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
    public string $student_id = '';
    public string $parent_name = '';
    public string $section = '';
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
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar ?? '/kidprofile/pro1.jpg';
        $this->student_id = $user->student_id ?? '';
        $this->parent_name = $user->parent_name ?? '';
        $this->section = $user->section ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));
        
        $validated['avatar'] = $this->avatar;
        
        // Add student-specific fields if user is a student
        if ($user->role === 'student') {
            $validated['student_id'] = $this->student_id;
            $validated['parent_name'] = $this->parent_name;
            $validated['section'] = $this->section;
        }

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

    <x-pages::settings.layout :heading="__('Profile')" :subheading="Auth::user()->role === 'student' ? __('Update your name, email, avatar, and student information') : __('Update your name, email address, and avatar')">
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

            <!-- Student Information (visible only for students) -->
            @if (Auth::user()->role === 'student')
                <div class="rounded-lg border border-blue-200 dark:border-blue-900/30 bg-blue-50 dark:bg-blue-900/10 p-4">
                    <flux:heading level="3" class="mb-4">{{ __('Student Information') }}</flux:heading>
                    
                    <div class="space-y-4">
                        <flux:input 
                            wire:model="student_id" 
                            :label="__('Student ID')" 
                            type="text" 
                            placeholder="Enter your student ID"
                            readonly
                            disabled
                        />

                        <flux:input 
                            wire:model="parent_name" 
                            :label="__('Parent/Guardian Name')" 
                            type="text" 
                            placeholder="Enter parent or guardian name"
                            readonly
                            disabled
                        />

                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('Section') }}</label>
                            <select wire:model="section" disabled class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 text-gray-900 cursor-not-allowed dark:border-neutral-600 dark:bg-neutral-700 dark:text-gray-400">
                                <option value="">-- Select Section --</option>
                                <option value="kinder_1">Kinder 1</option>
                                <option value="kinder_2">Kinder 2</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif

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
