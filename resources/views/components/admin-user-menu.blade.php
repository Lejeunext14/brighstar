<flux:dropdown position="bottom" align="start">
    <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" type="button">
        <flux:avatar
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
            size="md"
        />
        <div class="hidden sm:block text-start">
            <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ auth()->user()->name }}</div>
            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->role }}</div>
        </div>
        <flux:icon icon="chevrons-up-down" class="w-4 h-4 text-zinc-500" />
    </button>

    <flux:menu>
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <flux:avatar
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
            />
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>
        <flux:menu.separator />
        <flux:menu.item icon="archive-box" href="{{ route('admin.archived') }}" wire:navigate>
            {{ __('Archived') }}
        </flux:menu.item>
        <flux:menu.separator />
        <flux:menu.radio.group>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
