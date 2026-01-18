<x-layouts::app :title="__('Dashboard')">
    <div class="w-full">
        <!-- Welcome Section -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-blue-50 to-purple-50 p-8 dark:border-neutral-700 dark:from-blue-900/20 dark:to-purple-900/20 mb-6">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Continue your learning journey with NLLC E-Learning</p>
        </div>
        
        <!-- Continue Learning Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Subject</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <!-- Course Card 1 -->
                <a href="{{ route('subject.topics', ['subject' => 'filipino']) }}" class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                    <div class="h-40 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-5xl">
                        🎨
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Filipino</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Learn the basics of Filipino</p>
                    </div>
                </a>

            </div>
        </div>
        <!-- Recent Activity -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Activity</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                    <div class="flex items-center gap-4">
                        <div class="text-2xl">✅</div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Completed "Color Theory Basics"</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">2 hours ago</p>
                        </div>
                    </div>
                    <span class="text-2xl">🏅</span>
                </div>

                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                    <div class="flex items-center gap-4">
                        <div class="text-2xl">📖</div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Started "Advanced Reading" course</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">5 hours ago</p>
                        </div>
                    </div>
                    <span class="text-2xl">🚀</span>
                </div>

                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                    <div class="flex items-center gap-4">
                        <div class="text-2xl">🏆</div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Earned "Creative Mind" badge</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">1 day ago</p>
                        </div>
                    </div>
                    <span class="text-2xl">⭐</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
