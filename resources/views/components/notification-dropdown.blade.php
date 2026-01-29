<flux:dropdown position="bottom" align="end">
    <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors relative" type="button" title="Notifications">
        <div class="relative">
            <flux:icon icon="bell" class="w-5 h-5" />
            @php
                $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
            @endphp
            @if ($unreadCount > 0)
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
            @endif
        </div>
        <span class="hidden sm:inline text-sm font-medium">Notifications</span>
    </button>

    <flux:menu class="w-80">
        <!-- Header -->
        <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700">
            <flux:heading level="3" class="text-sm font-bold">Notifications</flux:heading>
        </div>

        <!-- Notifications List -->
        @php
            $notifications = auth()->user()->notifications()->limit(5)->get();
        @endphp

        @if ($notifications->isEmpty())
            <div class="px-4 py-6 text-center">
                <flux:icon icon="bell-slash" class="w-8 h-8 mx-auto text-zinc-400 mb-2" />
                <p class="text-sm text-zinc-500">No notifications yet</p>
            </div>
        @else
            <div class="max-h-96 overflow-y-auto">
                @foreach ($notifications as $notification)
                    <a href="#" class="block px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 border-b border-zinc-100 dark:border-zinc-700 transition-colors last:border-b-0"
                       onclick="event.preventDefault(); fetch('{{ route('notifications.read', $notification) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}}).then(() => location.reload())">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <span class="text-lg">
                                    @switch($notification->type)
                                        @case('success')
                                            ✅
                                            @break
                                        @case('warning')
                                            ⚠️
                                            @break
                                        @case('error')
                                            ❌
                                            @break
                                        @default
                                            ℹ️
                                    @endswitch
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-bold text-zinc-900 dark:text-white truncate">{{ $notification->title }}</p>
                                    @if ($notification->isUnread())
                                        <span class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>
                                @if ($notification->message)
                                    <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1 line-clamp-2">{{ $notification->message }}</p>
                                @endif
                                <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- View All Link -->
            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-center">
                <a href="{{ route('notifications.index') }}" wire:navigate class="text-sm font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    View All Notifications
                </a>
            </div>
        @endif
    </flux:menu>
</flux:dropdown>
