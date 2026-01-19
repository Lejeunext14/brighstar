<x-layouts::app.parent :title="__('Parent Dashboard')">
    <div class="w-full">
        <!-- Welcome Section -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-orange-50 to-pink-50 p-8 dark:border-neutral-700 dark:from-orange-900/20 dark:to-pink-900/20 mb-6">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Welcome back, {{ Auth::user()->name }}! 👨‍👩‍👧‍👦</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Monitor your child's learning progress and achievements</p>
        </div>

        <!-- Quick Stats Section -->
        <div class="grid gap-6 md:grid-cols-4 mb-6">
            <!-- Children Count -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-600 dark:text-gray-400">My Children</h3>
                    <span class="text-3xl">👶</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalChildren }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Children added</p>
            </div>

            <!-- Overall Progress -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-600 dark:text-gray-400">Progress</h3>
                    <span class="text-3xl">📈</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $overallProgressPercentage }}%</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Overall completion</p>
            </div>

            <!-- Lessons Completed -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-600 dark:text-gray-400">Lessons</h3>
                    <span class="text-3xl">✅</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalLessonsCompleted }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Completed</p>
            </div>

            <!-- Achievements -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-600 dark:text-gray-400">Monitoring Hours</h3>
                    <span class="text-3xl">⏰</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalMonitoringHours }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Total system login hours</p>
            </div>
        </div>

        <!-- Children Progress Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Children Progress</h2>
            
            @if ($children->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">No children linked yet. Contact admin to link your children.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($childrenProgress as $child)
                        @php
                            $colors = ['from-orange-400 to-orange-600', 'from-pink-400 to-pink-600', 'from-blue-400 to-blue-600', 'from-green-400 to-green-600', 'from-purple-400 to-purple-600'];
                            $colorIndex = $loop->index % count($colors);
                            $color = $colors[$colorIndex];
                            $emojis = ['👧', '👦', '👱‍♀️', '👱‍♂️', '🧒'];
                            $emoji = $emojis[$colorIndex] ?? '👧';
                        @endphp
                        <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all">
                            <div class="h-40 bg-gradient-to-br {{ $color }} flex items-center justify-center text-5xl">
                                {{ $emoji }}
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $child['name'] }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $child['email'] }}</p>
                                
                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">Overall Progress</span>
                                        <span class="text-xs font-bold text-orange-600 dark:text-orange-400">{{ $child['progressPercentage'] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-orange-600 h-2 rounded-full" style="width: {{ $child['progressPercentage'] }}%"></div>
                                    </div>
                                </div>

                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Lessons Completed</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $child['completedLessons'] }}/{{ $child['totalLessons'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Monitoring Hours</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $child['monitoringHours'] }} hrs</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Last Activity</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            @if ($child['lastActivity'])
                                                {{ $child['lastActivity']->updated_at->diffForHumans() }}
                                            @else
                                                --
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Activity</h2>
            <div class="space-y-4">
                @if ($recentActivities->isEmpty())
                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                        <div class="flex items-center gap-4">
                            <div class="text-2xl">📚</div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">No activity yet</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Your child's learning activities will appear here</p>
                            </div>
                        </div>
                        <span class="text-2xl">⏳</span>
                    </div>
                @else
                    @foreach ($recentActivities as $activity)
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                            <div class="flex items-center gap-4">
                                <div class="text-2xl">
                                    @if ($activity->completed)
                                        ✅
                                    @else
                                        📚
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        <strong>{{ $activity->user->name }}</strong> 
                                        @if ($activity->completed)
                                            completed <strong>{{ $activity->lesson_name }}</strong>
                                        @else
                                            started <strong>{{ $activity->lesson_name }}</strong>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">
                                {{ $activity->subject ?? 'Subject' }}
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-layouts::app.parent>
