<x-layouts::app :title="__('Notifications')">
    <div class="w-full bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <!-- Header -->
        <div class="px-6 py-8 bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-700 dark:to-cyan-700">
            <div class="max-w-4xl mx-auto">
                <div class="mb-6">
                    <h1 class="text-4xl font-black text-white mb-2">Notifications</h1>
                    <p class="text-blue-100">Stay updated with your activities</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-bold rounded-lg transition-all">
                            ✓ Mark All as Read
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-6 py-8">
            @if ($notifications->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-12 shadow-lg text-center">
                    <span class="text-6xl mb-4 block">🔔</span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">No Notifications</h3>
                    <p class="text-gray-600 dark:text-gray-400">You're all caught up! Check back later.</p>
                </div>
            @else
                <!-- Notifications List -->
                <div class="space-y-3">
                    @foreach ($notifications as $notification)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg hover:shadow-xl transition-all border-l-4"
                             style="border-left-color: {{ $notification->type === 'success' ? '#10b981' : ($notification->type === 'error' ? '#ef4444' : ($notification->type === 'warning' ? '#f59e0b' : '#3b82f6')) }}">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-3 flex-1">
                                    <div class="flex-shrink-0 text-2xl mt-1">
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
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $notification->title }}</h3>
                                            @if ($notification->isUnread())
                                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-bold rounded-full">
                                                    New
                                                </span>
                                            @endif
                                        </div>

                                        @if ($notification->message)
                                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">{{ $notification->message }}</p>
                                        @endif

                                        <p class="text-xs text-gray-500 dark:text-gray-500">
                                            {{ $notification->created_at->format('M d, Y \a\t h:i A') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Delete this notification?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex-shrink-0 px-3 py-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
