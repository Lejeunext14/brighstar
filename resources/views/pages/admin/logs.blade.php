<x-layouts::app.admin :title="__('Admin Logs')">
    <flux:main>
        <div class="w-full">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white">System Logs 📝</h1>
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">View application logs and events</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-900 hover:bg-gray-300 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600">← Back</a>
            </div>

            <!-- Logs Display -->
            <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Logs</h2>
                <div class="bg-gray-50 dark:bg-neutral-800 p-4 rounded-lg max-h-96 overflow-y-auto font-mono text-sm">
                    @forelse ($logs as $log)
                        <div class="text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-neutral-700 pb-2 mb-2">
                            {!! nl2br(e($log)) !!}
                        </div>
                    @empty
                        <div class="text-gray-600 dark:text-gray-400 text-center py-8">
                            No logs available
                        </div>
                    @endforelse
                </div>
                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                    Showing latest {{ count($logs) }} log entries
                </div>
            </div>

            <!-- Log Statistics -->
            <div class="grid gap-6 md:grid-cols-3 mt-6">
                <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Log Entries</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ count($logs) }}</p>
                        </div>
                        <div class="text-4xl">📊</div>
                    </div>
                </div>

                <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Log File Size</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">--</p>
                        </div>
                        <div class="text-4xl">📁</div>
                    </div>
                </div>

                <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Last Updated</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white mt-2">Just now</p>
                        </div>
                        <div class="text-4xl">🕐</div>
                    </div>
                </div>
            </div>
        </div>
    </flux:main>
</x-layouts::app.admin>
