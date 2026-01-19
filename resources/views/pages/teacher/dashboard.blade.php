<x-layouts::app :title="__('Teacher Dashboard')">
    <div class="w-full">
        <!-- Welcome Section -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-green-50 to-emerald-50 p-8 dark:border-neutral-700 dark:from-green-900/20 dark:to-emerald-900/20 mb-6">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Welcome back, {{ Auth::user()->name }}! 👨‍🏫</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Manage your classroom and track student progress</p>
        </div>

        <!-- Quick Stats Section -->
        <div class="grid gap-6 md:grid-cols-4 mb-6">
            <!-- Total Students -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-600 dark:text-gray-400">Total Students</h3>
                    <span class="text-3xl">👥</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalStudents }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">In your classes</p>
            </div>

            <!-- Active Students -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-600 dark:text-gray-400">Active Today</h3>
                    <span class="text-3xl">✅</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $activeToday }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Students active</p>
            </div>

            <!-- Assignments -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-600 dark:text-gray-400">Assignments</h3>
                    <span class="text-3xl">📝</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $pendingAssignments }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Pending reviews</p>
            </div>

            <!-- Class Average -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-600 dark:text-gray-400">Class Average</h3>
                    <span class="text-3xl">📊</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $classAverage }}%</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Overall progress</p>
            </div>
        </div>

        <!-- Classes Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">My Classes</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <!-- Class Card 1 -->
                <a href="#" class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                    <div class="h-40 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-5xl">
                        📚
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Class 1</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Grade Level - Subject</p>
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                            <span>0 Students</span>
                            <span>0% Complete</span>
                        </div>
                    </div>
                </a>

                <!-- Class Card 2 -->
                <a href="#" class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                    <div class="h-40 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-5xl">
                        🎓
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Class 2</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Grade Level - Subject</p>
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                            <span>0 Students</span>
                            <span>0% Complete</span>
                        </div>
                    </div>
                </a>

                <!-- Class Card 3 -->
                <a href="#" class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                    <div class="h-40 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-5xl">
                        ✏️
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Class 3</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Grade Level - Subject</p>
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                            <span>0 Students</span>
                            <span>0% Complete</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Student Activity -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Student Activity</h2>
            <div class="space-y-4 mb-6">
                @forelse ($recentActivities as $activity)
                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                        <div class="flex items-center gap-4">
                            <div class="text-2xl">{{ $activity['icon'] }}</div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $activity['student_name'] }} - {{ $activity['lesson_name'] }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity['status'] }} {{ $activity['time'] }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold {{ $activity['status'] === 'Completed' ? 'text-green-600' : 'text-blue-600' }}">{{ $activity['status'] }}</span>
                    </div>
                @empty
                    <div class="flex items-center justify-center p-8 rounded-lg bg-gray-50 dark:bg-neutral-800">
                        <p class="text-gray-600 dark:text-gray-400">No recent student activity</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($recentActivities->hasPages())
                <div class="flex justify-center">
                    {{ $recentActivities->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
