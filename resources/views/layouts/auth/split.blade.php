<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:px-0" style="grid-template-columns: 0.8fr 1fr;">
            <div class="bg-white relative hidden h-full flex-col p-10 text-neutral-900 lg:flex dark:border-e dark:border-neutral-800 overflow-hidden">
                <div class="absolute inset-0 bg-white">
                    <video autoplay muted loop playsinline class="w-full h-full object-cover">
                        <source src="{{ asset('animation/logi1.mp4') }}" type="video/mp4">
                    </video>
                </div>

                <div class="relative z-20 mt-auto">
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium" wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                        </span>

                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
