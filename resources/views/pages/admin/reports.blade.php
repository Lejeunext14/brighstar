<x-layouts::app.admin :title="__('Admin Reports')">
    <flux:main>
        <div class="w-full">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white">Reports 📊</h1>
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">System statistics and analytics</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-900 hover:bg-gray-300 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600">← Back</a>
            </div>

            <!-- Quick Stats -->
            <div class="grid gap-6 md:grid-cols-4 mb-6">
                <!-- Total Users -->
                <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsers }}</p>
                        </div>
                        <div class="text-4xl">👥</div>
                    </div>
                </div>

                <!-- Total Students -->
                <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Students</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $totalStudents }}</p>
                        </div>
                        <div class="text-4xl">👨‍🎓</div>
                    </div>
                </div>

                <!-- Total Teachers -->
                <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Teachers</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $totalTeachers }}</p>
                        </div>
                        <div class="text-4xl">👩‍🏫</div>
                    </div>
                </div>

                <!-- Total Parents -->
                <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Parents</p>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $totalParents }}</p>
                        </div>
                        <div class="text-4xl">👨‍👩‍👧</div>
                    </div>
                </div>
            </div>

            <!-- Detailed Reports -->
            <div class="grid gap-6 md:grid-cols-2 mb-6">
                <!-- Users by Role -->
                <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Users by Role</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">👨‍🎓</span>
                                <span class="font-medium text-gray-900 dark:text-white">Students</span>
                            </div>
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalStudents }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">👩‍🏫</span>
                                <span class="font-medium text-gray-900 dark:text-white">Teachers</span>
                            </div>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalTeachers }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">👨‍👩‍👧</span>
                                <span class="font-medium text-gray-900 dark:text-white">Parents</span>
                            </div>
                            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $totalParents }}</span>
                        </div>
                    </div>
                </div>

                <!-- System Health -->
                <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">System Health</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                            <span class="font-medium text-gray-900 dark:text-white">Database Status</span>
                            <span class="text-sm bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 px-3 py-1 rounded-full">✓ Healthy</span>
                        </div>
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                            <span class="font-medium text-gray-900 dark:text-white">Server Status</span>
                            <span class="text-sm bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 px-3 py-1 rounded-full">✓ Online</span>
                        </div>
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                            <span class="font-medium text-gray-900 dark:text-white">Cache Status</span>
                            <span class="text-sm bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 px-3 py-1 rounded-full">✓ Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </flux:main>
</x-layouts::app.admin>
