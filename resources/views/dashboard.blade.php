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

                <!-- Character Card -->
                <a href="{{ route('avatar.edit') }}" class="lg:col-span-1 bg-gradient-to-br from-purple-400 to-purple-600 rounded-3xl p-8 shadow-2xl flex flex-col items-center justify-center text-white hover:shadow-2xl transition-all transform hover:scale-105 cursor-pointer overflow-hidden relative"
                    style="background-image: url('{{ asset($avatar) }}'); background-size: cover; background-position: center;">
                    <div class="absolute inset-0 bg-black/40 rounded-3xl"></div>
                    <div class="relative z-10 flex flex-col items-center justify-center h-full">
                        <div class="w-32 h-32 mb-4 rounded-2xl overflow-hidden border-4 border-white shadow-lg" style="background-image: url('{{ asset($avatar) }}'); background-size: cover; background-position: center;">
                        </div>
                        <h3 class="text-2xl font-black text-center mb-2">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-white/80 text-center">Level {{ ceil($progressPercentage / 20) }} • {{ $completedLessons > 0 ? 'Learning Expert' : 'Ready to Learn' }}</p>
                        <div class="mt-4 flex gap-2">
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold">
                                @for ($i = 0; $i < min(5, ceil($progressPercentage / 20)); $i++)
                                    ⭐
                                @endfor
                            </span>
                        </div>
                        <p class="text-xs text-white/60 mt-4 text-center">Click to edit avatar</p>
                    </div>
                </a>

                <!-- Calendar Card -->
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
                    <video class="absolute inset-0 w-full h-full object-cover opacity-30" autoplay muted loop playsinline>
                        <source src="{{ asset('animation/calendar.mov') }}" type="video/quicktime">
                        <source src="{{ asset('animation/calendar.mov') }}" type="video/mp4">
                    </video>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">This Week</h3>
                            <span class="text-2xl">📅</span>
                        </div>
                        <div class="grid grid-cols-7 gap-2">
                            @php
                                $days = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];
                                $colors = ['bg-yellow-400', 'bg-blue-400', 'bg-purple-400', 'bg-pink-400', 'bg-green-400', 'bg-red-400', 'bg-orange-400'];
                            @endphp
                            @foreach ($days as $i => $day)
                                <div class="text-center">
                                    <p class="text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">{{ $day }}</p>
                                    <div class="w-full aspect-square rounded-lg {{ $colors[$i] }} flex items-center justify-center text-white font-bold text-sm">
                                        {{ $i + 14 }}
                                    </div>
                                </div>
                            @endforeach
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
                            <div class="mb-3">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">Topics</span>
                                    <span class="text-sm font-black text-green-600">{{ $filipinoProgress['totalTopics'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                    <div class="bg-green-500 h-full" style="width: {{ $filipinoProgress['percentage'] }}%"></div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $filipinoProgress['percentage'] }}% Complete</p>
                            <p class="text-xs text-purple-600 dark:text-purple-400 font-bold mt-2">Overall Progress: {{ $filipinoProgress['overallProgress'] }}%</p>
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
