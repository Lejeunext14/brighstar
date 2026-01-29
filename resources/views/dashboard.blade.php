<x-layouts::app :title="__('Dashboard')">
    <div class="w-full bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <!-- Header with Stats -->
        <div class="px-6 py-8 bg-gradient-to-r from-purple-500 to-pink-500 dark:from-purple-700 dark:to-pink-700">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <!-- Certificates Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">🏆</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-purple-600">{{ $completedLessons }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Lessons Done</p>
                            </div>
                        </div>
                    </div>

                    <!-- Courses Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">📚</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-orange-600">{{ $subjectCount }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Subjects</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hours Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">⏱️</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-pink-600">{{ $monitoringHours }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Hours</p>
                            </div>
                        </div>
                    </div>

                    <!-- Streak Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">🔥</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-red-600">{{ $dayStreak }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Day Streak</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Welcome and Progress Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Progress Card -->
                <div class="lg:col-span-1 bg-gradient-to-br from-pink-400 to-pink-600 rounded-3xl p-8 shadow-2xl text-white relative overflow-hidden">
                    <video class="absolute inset-0 w-full h-full object-cover opacity-50" autoplay muted loop playsinline>
                        <source src="{{ asset('animation/progress.mp4') }}" type="video/mp4">
                    </video>
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold mb-4">Today's Progress</h3>
                        <p class="text-5xl font-black mb-4">{{ $progressPercentage }}%</p>
                        <div class="w-full bg-white/30 rounded-full h-4 overflow-hidden">
                            <div class="bg-white h-full rounded-full" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <p class="text-sm mt-4 text-white/80">
                            @if ($progressPercentage >= 80)
                                Excellent work! You're doing amazing! 🌟
                            @elseif ($progressPercentage >= 50)
                                Great progress! Keep going! 💪
                            @elseif ($progressPercentage > 0)
                                Good start! Keep learning! 📚
                            @else
                                Start your learning journey today! 🚀
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Calendar Card -->
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
                    <video class="absolute inset-0 w-full h-full object-cover opacity-30" autoplay muted loop playsinline>
                        <source src="{{ asset('animation/calendar.mov') }}" type="video/quicktime">
                        <source src="{{ asset('animation/calendar.mov') }}" type="video/mp4">
                    </video>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::now()->format('l') }}</p>
                            </div>
                            <span class="text-3xl">📅</span>
                        </div>
                        
                        <!-- Day Headers -->
                        <div class="grid grid-cols-7 gap-2 mb-2">
                            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                                <div class="text-center">
                                    <p class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $dayName }}</p>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Calendar Days -->
                        <div class="grid grid-cols-7 gap-2">
                            @php
                                $now = \Carbon\Carbon::now();
                                $firstDay = $now->copy()->startOfMonth();
                                $lastDay = $now->copy()->endOfMonth();
                                $startDate = $firstDay->copy()->startOfWeek();
                                $endDate = $lastDay->copy()->endOfWeek();
                                
                                $userCreatedAt = Auth::user()->created_at;
                            @endphp
                            
                            @for ($date = $startDate->copy(); $date <= $endDate; $date->addDay())
                                @php
                                    $isCurrentMonth = $date->month == $now->month;
                                    $isLearningDay = $isCurrentMonth && $date <= $now && $date >= $userCreatedAt->copy()->startOfDay();
                                @endphp
                                
                                @if ($isCurrentMonth)
                                    <div class="text-center">
                                        <div class="w-full aspect-square rounded-lg flex items-center justify-center text-sm font-bold relative group
                                            {{ $date->isToday() ? 'bg-gradient-to-br from-purple-500 to-pink-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' }}
                                            {{ $isLearningDay && !$date->isToday() ? 'bg-green-400 text-white' : '' }}
                                        ">
                                            {{ $date->day }}
                                            @if ($date->isToday())
                                                <span class="absolute -top-1 -right-1 text-xs">⭐</span>
                                            @endif
                                            @if ($isLearningDay && !$date->isToday())
                                                <span class="absolute -top-1 -right-1 text-xs">✓</span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="w-full aspect-square rounded-lg flex items-center justify-center text-sm font-bold text-gray-300 dark:text-gray-600">
                                            {{ $date->day }}
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </div>
                        
                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                <span class="inline-block w-3 h-3 rounded bg-gradient-to-br from-purple-500 to-pink-500 mr-1 align-middle"></span>
                                Today
                                <span class="mx-2">•</span>
                                <span class="inline-block w-3 h-3 rounded bg-green-400 mr-1 align-middle"></span>
                                Learning Days
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Continue Learning Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white">📚 Subjects to Learn</h2>
                        <p class="text-gray-600 dark:text-gray-400">Pick a subject and start learning!</p>
                    </div>
                </div>
                
                <div class="grid gap-6 md:grid-cols-3">
                    <!-- Filipino -->
                    <a href="{{ route('subject.topics', ['subject' => 'filipino']) }}" class="overflow-hidden rounded-3xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105 cursor-pointer block">
                        <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center overflow-hidden">
                            <video class="h-full w-full object-cover" autoplay muted loop playsinline>
                                <source src="{{ asset('animation/vecteezy_cute-boy-reading-a-book_52298024.mov') }}" type="video/quicktime">
                                <source src="{{ asset('animation/vecteezy_cute-boy-reading-a-book_52298024.mov') }}" type="video/mp4">
                                🌿
                            </video>
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-800">
                            <h3 class="font-black text-gray-900 dark:text-white text-2xl mb-2">Filipino</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Learn the beautiful Filipino language</p>
                            <!-- Topic progress removed per request -->
                        </div>
                    </a>

                    <!-- Math -->
                    <div class="overflow-hidden rounded-3xl shadow-xl cursor-not-allowed block opacity-60 relative">
                        <div class="h-48 bg-gradient-to-br from-yellow-400 to-orange-600 flex items-center justify-center text-7xl">
                            🔢
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-800">
                            <h3 class="font-black text-gray-900 dark:text-white text-2xl mb-2">Mathematics</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Master numbers and calculations</p>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                <div class="bg-yellow-500 h-full" style="width: 45%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">45% Complete</p>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 rounded-3xl backdrop-blur-sm">
                            <div class="text-center">
                                <p class="text-white font-black text-2xl mb-2">🚀 Coming Soon</p>
                                <p class="text-white/80 text-sm">Stay tuned for Math lessons!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Science -->
                    <div class="overflow-hidden rounded-3xl shadow-xl cursor-not-allowed block opacity-60 relative">
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center text-7xl">
                            🔬
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-800">
                            <h3 class="font-black text-gray-900 dark:text-white text-2xl mb-2">Science</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Explore the amazing world</p>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                <div class="bg-blue-500 h-full" style="width: 30%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">30% Complete</p>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 rounded-3xl backdrop-blur-sm">
                            <div class="text-center">
                                <p class="text-white font-black text-2xl mb-2">🚀 Coming Soon</p>
                                <p class="text-white/80 text-sm">Stay tuned for Science lessons!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div>
                <div class="mb-6">
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white">🚀 Recent Activity</h2>
                    <p class="text-gray-600 dark:text-gray-400">Your learning journey</p>
                </div>
                
                <div class="grid gap-4 md:grid-cols-2">
                    @forelse ($recentActivities as $activity)
                        <div class="bg-gradient-to-br from-{{ ['green', 'blue', 'purple', 'orange'][$loop->index] }}-50 to-{{ ['green', 'blue', 'purple', 'orange'][$loop->index] }}-100 dark:from-{{ ['green', 'blue', 'purple', 'orange'][$loop->index] }}-900/20 dark:to-{{ ['green', 'blue', 'purple', 'orange'][$loop->index] }}-800/20 rounded-2xl p-6 border-l-4 border-{{ ['green', 'blue', 'purple', 'orange'][$loop->index] }}-500">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-2xl">{{ $activity->completed ? '✅' : '📚' }}</span>
                                        <p class="font-black text-gray-900 dark:text-white">{{ $activity->completed ? 'Completed' : 'Started' }} "{{ Str::limit($activity->lesson_name, 30) }}"</p>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity->updated_at->diffForHumans() }}</p>
                                    <p class="text-xs mt-2 text-gray-600 dark:text-gray-400">{{ Str::limit($activity->lesson_name, 50) }}</p>
                                </div>
                                <span class="text-3xl">{{ $activity->completed ? '🏆' : '🚀' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-gray-50 dark:bg-gray-800 rounded-2xl p-12 text-center">
                            <p class="text-4xl mb-4">📚</p>
                            <p class="text-gray-600 dark:text-gray-400 font-bold">No activities yet. Start learning to see your progress!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
