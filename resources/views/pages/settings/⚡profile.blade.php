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
        [
            'path' => '/kidprofile/pro1.jpg',
            'name' => 'Alex',
            'description' => 'A cheerful learner ready to explore!',
        ],
        [
            'path' => '/kidprofile/pro2.jpg',
            'name' => 'Maya',
            'description' => 'Smart and adventurous!',
        ],
        [
            'path' => '/kidprofile/pro3.jpg',
            'name' => 'Jordan',
            'description' => 'Creative and fun-loving!',
        ],
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

    <div class="w-full bg-gray-50 dark:bg-gray-900/50 px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Form - Takes up 3 columns -->
                <div class="lg:col-span-3">
                    <form wire:submit="updateProfileInformation" class="space-y-8">
            
            <!-- Hero Section with Avatar -->
            <div class="rounded-3xl bg-gradient-to-br from-purple-500 via-pink-500 to-red-500 p-8 shadow-2xl text-white overflow-hidden relative">
                <div class="absolute top-0 right-0 opacity-10 text-9xl">🎨</div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-black mb-6">{{ __('Your Profile') }}</h2>
                    
                    <!-- Avatar With Badge -->
                    <div class="flex items-end gap-6">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-3xl overflow-hidden border-4 border-white shadow-2xl" style="background-image: url('{{ asset($avatar) }}'); background-size: cover; background-position: center;"></div>
                            <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-3 shadow-lg">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-white/90 text-sm font-semibold mb-2">Welcome back!</p>
                            <h3 class="text-2xl font-black">{{ Auth::user()->name }}</h3>
                            <p class="text-white/80 text-sm mt-1">{{ Auth::user()->email }}</p>
                            @if(Auth::user()->role === 'student' && Auth::user()->section)
                                <div class="mt-3 inline-block bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold">
                                    {{ str_replace('_', ' ', Auth::user()->section) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Avatar Selection Section -->
            <div class="rounded-3xl bg-white dark:bg-gray-800 shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-700 px-8 py-6 border-b border-gray-200 dark:border-gray-700">
                    <flux:heading level="2" class="text-2xl">
                        <span class="mr-2">🎨</span>{{ __('Choose Your Avatar') }}
                    </flux:heading>
                    <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">Pick your favorite character to represent you in the classroom</p>
                </div>
                
                <div class="p-8">
                    <!-- Avatar Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                        @foreach ($availableAvatars as $avatarOption)
                            <label class="cursor-pointer group">
                                <input type="radio" wire:model.live="avatar" value="{{ $avatarOption['path'] }}" class="sr-only">
                                <div class="relative rounded-2xl aspect-square overflow-hidden border-3 transition-all duration-300"
                                     :class="$wire.avatar === '{{ $avatarOption['path'] }}' ? 'border-purple-500 ring-4 ring-purple-300 scale-110 shadow-2xl' : 'border-gray-300 hover:border-purple-400 group-hover:scale-105'"
                                     style="background-image: linear-gradient(135deg, rgba(147, 51, 234, 0.1), rgba(236, 72, 153, 0.1)), url('{{ asset($avatarOption['path']) }}'); background-size: cover; background-position: center;">
                                    @if($avatar === $avatarOption['path'])
                                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                                            <div class="bg-purple-500 text-white rounded-full p-3 animate-bounce">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-3 text-center">
                                    <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $avatarOption['name'] }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $avatarOption['description'] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Account Information Section -->
            <div class="rounded-3xl bg-white dark:bg-gray-800 shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-gray-700 dark:to-gray-700 px-8 py-6 border-b border-gray-200 dark:border-gray-700">
                    <flux:heading level="2" class="text-2xl">
                        <span class="mr-2">📋</span>{{ __('Account Information') }}
                    </flux:heading>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">{{ __('Full Name') }} <span class="text-red-500">*</span></label>
                            <flux:input 
                                wire:model="name" 
                                type="text" 
                                required 
                                autofocus 
                                autocomplete="name"
                                class="border-2 border-gray-200 dark:border-gray-600 focus:border-purple-500"
                                placeholder="Enter your full name"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">{{ __('Email Address') }} <span class="text-red-500">*</span></label>
                            <flux:input 
                                wire:model="email" 
                                type="email" 
                                required 
                                autocomplete="email"
                                placeholder="your@email.com"
                            />
                        </div>
                    </div>

                    @if ($this->hasUnverifiedEmail)
                        <div class="rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-200 dark:border-yellow-700 p-4">
                            <div class="flex gap-4">
                                <div class="text-2xl">⚠️</div>
                                <div>
                                    <p class="font-semibold text-yellow-900 dark:text-yellow-200">{{ __('Email Not Verified') }}</p>
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300 mt-1">{{ __('Your email address is unverified.') }}</p>
                                    <flux:link class="text-sm font-semibold text-yellow-900 dark:text-yellow-200 cursor-pointer hover:underline" wire:click.prevent="resendVerificationNotification">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </flux:link>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="text-sm font-medium text-green-600 dark:text-green-400 mt-2">✅ {{ __('A new verification link has been sent to your email address.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Student Information (visible only for students) -->
            @if (Auth::user()->role === 'student')
                <div class="rounded-3xl bg-white dark:bg-gray-800 shadow-xl overflow-hidden border-2 border-green-200 dark:border-green-800">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-700 px-8 py-6 border-b border-green-200 dark:border-gray-700">
                        <flux:heading level="2" class="text-2xl">
                            <span class="mr-2">🎓</span>{{ __('Student Information') }}
                        </flux:heading>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">Your enrollment details and class information</p>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        <div class="grid md:grid-cols-3 gap-6">
                            <!-- Student ID Card -->
                            <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 p-6 border-2 border-blue-200 dark:border-blue-700">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-2xl">🆔</span>
                                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ __('Student ID') }}</p>
                                </div>
                                <p class="text-2xl font-black text-blue-600 dark:text-blue-400">
                                    {{ Auth::user()->student_id ?? '—' }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">Assigned by school</p>
                            </div>

                            <!-- Section Card -->
                            <div class="rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 p-6 border-2 border-purple-200 dark:border-purple-700">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-2xl">📚</span>
                                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ __('Section') }}</p>
                                </div>
                                <p class="text-2xl font-black text-purple-600 dark:text-purple-400">
                                    {{ Auth::user()->section ? str_replace('_', ' ', Auth::user()->section) : '—' }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">Your class group</p>
                            </div>

                            <!-- Parent Card -->
                            <div class="rounded-2xl bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 p-6 border-2 border-orange-200 dark:border-orange-700">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-2xl">👨‍👩‍👧</span>
                                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ __('Parent/Guardian') }}</p>
                                </div>
                                <p class="text-lg font-black text-orange-600 dark:text-orange-400 line-clamp-2">
                                    {{ Auth::user()->parent_name ?? '—' }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">Contact person</p>
                            </div>
                        </div>

                        <!-- Read-only Details -->
                        <div class="rounded-2xl bg-gray-50 dark:bg-gray-700/50 p-6 space-y-4">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">📝 {{ __('Account Details') }}</p>
                            <div class="grid md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400 font-medium">Member Since</p>
                                    <p class="text-gray-900 dark:text-white font-bold mt-1">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400 font-medium">Last Updated</p>
                                    <p class="text-gray-900 dark:text-white font-bold mt-1">{{ Auth::user()->updated_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400 font-medium">Account Status</p>
                                    <p class="text-green-600 dark:text-green-400 font-bold mt-1">✅ Active</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Save Button Section -->
            <div class="flex items-center justify-between gap-4 pt-6">
                <x-action-message class="me-3" on="profile-updated">
                    <div class="flex items-center gap-2 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl font-semibold">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Profile saved successfully!') }}
                    </div>
                </x-action-message>
                <flux:button variant="primary" type="submit" class="px-8 py-3 text-base font-semibold">
                    <span class="mr-2">💾</span>{{ __('Save Changes') }}
                </flux:button>
            </div>
                    </form>
                </div>

                <!-- Right Sidebar - Tips & Stats -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Profile Stats Card -->
                    <div class="rounded-3xl bg-white dark:bg-gray-800 border-2 border-purple-200 dark:border-purple-700 p-6 shadow-lg sticky top-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-2xl">📊</span>
                            <h3 class="font-bold text-gray-900 dark:text-white">Profile Status</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                <span class="text-sm font-semibold text-green-700 dark:text-green-400">Account Active</span>
                                <span class="text-2xl">✅</span>
                            </div>
                            @if($this->hasUnverifiedEmail)
                                <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                                    <span class="text-sm font-semibold text-yellow-700 dark:text-yellow-400">Email Verification</span>
                                    <span class="text-2xl">⏳</span>
                                </div>
                            @else
                                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                    <span class="text-sm font-semibold text-green-700 dark:text-green-400">Email Verified</span>
                                    <span class="text-2xl">✅</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                <span class="text-sm font-semibold text-blue-700 dark:text-blue-400">Avatar Selected</span>
                                <span class="text-2xl">🎨</span>
                            </div>
                        </div>
                    </div>

                    <!-- Need Help Card -->
                    <div class="rounded-3xl bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-2 border-orange-200 dark:border-orange-700 p-6 shadow-lg">
                        <div class="flex items-start gap-3 mb-4">
                            <span class="text-3xl">🆘</span>
                            <h3 class="font-bold text-orange-900 dark:text-orange-200 text-lg">Need Help?</h3>
                        </div>
                        <p class="text-sm text-orange-800 dark:text-orange-300 mb-4">
                            Having trouble updating your profile?
                        </p>
                        <a href="#" class="inline-block w-full text-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-semibold transition-colors">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
