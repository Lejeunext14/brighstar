<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo />

            @if(auth()->user()->role !== 'teacher')
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Home">
                    <flux:icon icon="home" class="w-5 h-5" />
                    <span class="hidden sm:inline text-sm font-medium">Home</span>
                </a>

                <a href="{{ route('assignments.index') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Assignments">
                    <flux:icon icon="document" class="w-5 h-5" />
                    <span class="hidden sm:inline text-sm font-medium">Assignments</span>
                </a>
            @elseif(auth()->user()->role === 'teacher')
                <a href="{{ route('teacher.dashboard') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Home">
                    <flux:icon icon="home" class="w-5 h-5" />
                    <span class="hidden sm:inline text-sm font-medium">Home</span>
                </a>

                <a href="{{ route('teacher.assignments.index') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Assignments">
                    <flux:icon icon="document" class="w-5 h-5" />
                    <span class="hidden sm:inline text-sm font-medium">Assignments</span>
                </a>
            @endif

            <flux:spacer />

            @if(auth()->user()->role !== 'teacher')
                <x-notification-dropdown />
            @endif

            @if(auth()->user()->role === 'admin')
                <x-admin-user-menu />
            @elseif(auth()->user()->role === 'teacher')
                <x-teacher-user-menu />
            @else
                <x-desktop-user-menu />
            @endif
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="book-open-text" href="#">
                    {{ __('My Courses') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="cog-6-tooth" href="#">
                    {{ __('Settings') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
