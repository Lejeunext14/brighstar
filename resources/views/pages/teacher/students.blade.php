<x-layouts::app :title="__('All Students')">
    <div class="w-full">
        <div class="min-h-screen bg-gray-50 dark:bg-neutral-950 p-6">
            <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">All Students</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">View and manage all students</p>
                </div>
                <a href="{{ route('teacher.dashboard') }}" class="px-4 py-2 bg-gray-200 dark:bg-neutral-700 hover:bg-gray-300 dark:hover:bg-neutral-600 text-gray-900 dark:text-white font-semibold rounded-lg transition-colors">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Students Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($students as $student)
                <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900 p-6 hover:shadow-lg transition-all">
                    <!-- Avatar Section -->
                    <div class="flex items-center gap-4 mb-4">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-2xl">
                                @if ($student->avatar)
                                    <img src="{{ $student->avatar }}" alt="{{ $student->name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    👤
                                @endif
                            </div>
                            <!-- Online Status Indicator -->
                            <div class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white dark:border-neutral-900" 
                                 style="background-color: {{ $student->isOnline() ? '#10b981' : '#d1d5db' }}"></div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $student->name }}</h3>
                            <p class="text-xs {{ $student->isOnline() ? 'text-green-600 dark:text-green-400 font-semibold' : 'text-gray-600 dark:text-gray-400' }}">
                                {{ $student->onlineStatus() }}
                            </p>
                        </div>
                    </div>

                    <!-- Student Info -->
                    <div class="space-y-3 pt-4 border-t border-gray-200 dark:border-neutral-700">
                        @if ($student->student_id)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Student ID</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $student->student_id }}</span>
                            </div>
                        @endif

                        @if ($student->parent_name)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Parent</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $student->parent_name }}</span>
                            </div>
                        @endif

                        @php
                            $lessonProgress = $student->lessonProgress()->get();
                            $completed = $lessonProgress->where('completed', true)->count();
                            $total = $lessonProgress->count();
                            $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
                        @endphp

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Progress</span>
                            <span class="font-semibold text-blue-600">{{ $percentage }}%</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Lessons</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $completed }}/{{ $total }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 transition-all" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button class="w-full mt-4 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors">
                        View Details
                    </button>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="text-6xl mb-4">📭</div>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">No students found</p>
                </div>
            @endforelse
        </div>

        <!-- Stats Section -->
        @if ($students->count() > 0)
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900 p-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Students</p>
                    <p class="text-4xl font-bold text-gray-900 dark:text-white mt-2">{{ $students->count() }}</p>
                </div>

                @php
                    $avgProgress = round($students->avg(function($student) {
                        $progress = $student->lessonProgress()->get();
                        $total = $progress->count();
                        return $total > 0 ? round(($progress->where('completed', true)->count() / $total) * 100) : 0;
                    }));
                @endphp

                <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900 p-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Average Progress</p>
                    <p class="text-4xl font-bold text-blue-600 mt-2">{{ $avgProgress }}%</p>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900 p-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Active Students</p>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $students->count() }}</p>
                </div>
            </div>
        @endif
            </div>
        </div>
    </div>
</x-layouts::app>
