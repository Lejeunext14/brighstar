<x-layouts::app :title="__('My Assignments')">
    <div class="w-full bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <!-- Header with Stats -->
        <div class="px-6 py-8 bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-blue-700 dark:to-indigo-700">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-4xl font-black text-white mb-2">My Assignments</h1>
                        <p class="text-blue-100">Manage assignments you've created</p>
                    </div>
                    <a href="{{ route('assignments.create') }}" wire:navigate 
                       class="px-6 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition-all">
                        + Create Assignment
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">📝</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-blue-600">{{ $stats['total'] }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Total</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">📋</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-yellow-600">{{ $stats['pending'] }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Pending</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">✅</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-green-600">{{ $stats['completed'] }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Search and Filter Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 mb-8 shadow-lg">
                <form method="GET" action="{{ route('teacher.assignments.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                        <!-- Search Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Search</label>
                            <input type="text" name="search" value="{{ $search ?? '' }}" 
                                   placeholder="Student name, title, subject..."
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Status</option>
                                <option value="pending" {{ ($statusFilter ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ ($statusFilter ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="overdue" {{ ($statusFilter ?? '') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>

                        <!-- Subject Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Subject</label>
                            <select name="subject" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}" {{ ($subjectFilter ?? '') === $subject ? 'selected' : '' }}>{{ $subject }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Priority Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Priority</label>
                            <select name="priority" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Priorities</option>
                                <option value="0" {{ ($priorityFilter ?? '') === '0' ? 'selected' : '' }}>Low Priority</option>
                                <option value="1" {{ ($priorityFilter ?? '') === '1' ? 'selected' : '' }}>Medium Priority</option>
                                <option value="2" {{ ($priorityFilter ?? '') === '2' ? 'selected' : '' }}>High Priority</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Sort By</label>
                            <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="due_date_asc" {{ ($sortBy ?? '') === 'due_date_asc' ? 'selected' : '' }}>📅 Due Date (Earliest)</option>
                                <option value="due_date_desc" {{ ($sortBy ?? '') === 'due_date_desc' ? 'selected' : '' }}>📅 Due Date (Latest)</option>
                                <option value="priority_desc" {{ ($sortBy ?? '') === 'priority_desc' ? 'selected' : '' }}>⚡ Priority (High to Low)</option>
                                <option value="title_asc" {{ ($sortBy ?? '') === 'title_asc' ? 'selected' : '' }}>📝 Title (A-Z)</option>
                                <option value="status" {{ ($sortBy ?? '') === 'status' ? 'selected' : '' }}>✓ Status</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2 items-end">
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors">
                                🔍 Search
                            </button>
                            <a href="{{ route('teacher.assignments.index') }}" class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-colors text-center">
                                ✕ Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            @if ($assignments->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-12 shadow-lg text-center">
                    <span class="text-6xl mb-4 block">📚</span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">No Assignments Yet!</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Start by creating your first assignment for students.</p>
                    <a href="{{ route('assignments.create') }}" wire:navigate 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold rounded-full hover:shadow-lg transition-all">
                        + Create First Assignment
                    </a>
                </div>
            @else
                <!-- Pending Assignments Section -->
                @php
                    $pendingAssignments = $assignments->items();
                    $completedAssignments = collect($pendingAssignments)->where('status', 'completed');
                    $pendingOnly = collect($pendingAssignments)->where('status', '!=', 'completed');
                @endphp

                @if ($pendingOnly->isNotEmpty())
                    <div class="mb-12">
                        <div class="flex items-center gap-3 mb-6">
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white">📋 Pending & Overdue</h2>
                            <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-sm font-bold rounded-full">
                                {{ $pendingOnly->count() }}
                            </span>
                        </div>
                        <div class="space-y-4">
                            @foreach ($pendingOnly as $assignment)
                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border-l-4"
                                     style="border-left-color: {{ $assignment->getPriorityColor() === 'red' ? '#ef4444' : '#f59e0b' }}">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h3 class="text-xl font-black text-gray-900 dark:text-white">{{ $assignment->title }}</h3>
                                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs font-bold rounded-full">
                                                    {{ $assignment->getPriorityLabel() }} Priority
                                                </span>
                                            </div>

                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    📌 Assigned to: <strong>{{ $assignment->user->name }}</strong>
                                                </span>
                                            </div>
                                            
                                            @if ($assignment->description)
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ $assignment->description }}</p>
                                            @endif

                                            <div class="flex flex-wrap gap-3 items-center text-sm">
                                                @if ($assignment->subject)
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        📚 {{ $assignment->subject }}
                                                    </span>
                                                @endif

                                                @if ($assignment->due_date)
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        📅 {{ $assignment->due_date->format('M d, Y \a\t h:i A') }}
                                                    </span>
                                                @endif

                                                <span class="px-3 py-1 text-xs font-bold rounded-full" 
                                                      style="background-color: {{ match($assignment->status) { 'pending' => '#fef3c7', 'overdue' => '#fee2e2' } }}; color: {{ match($assignment->status) { 'pending' => '#d97706', 'overdue' => '#dc2626' } }}">
                                                    {{ ucfirst($assignment->status) }}
                                                </span>

                                                @if ($assignment->isSubmitted())
                                                    <span class="text-xs text-green-600 dark:text-green-400">
                                                        Submitted: {{ $assignment->submitted_at->format('M d, Y h:i A') }}
                                                    </span>
                                                @endif
                                            </div>

                                            @if ($assignment->submission_notes)
                                                <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-700">
                                                    <p class="text-xs font-semibold text-blue-900 dark:text-blue-100 mb-1">📝 Submission Notes:</p>
                                                    <p class="text-sm text-blue-800 dark:text-blue-200">{{ $assignment->submission_notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2">
                                        <form action="{{ route('assignments.archive', $assignment) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg transition-all">
                                                🗂️ Archive
                                            </button>
                                        </form>
                                        <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?');" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition-all">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Completed Assignments Section -->
                @if ($completedAssignments->isNotEmpty())
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white">✅ Completed</h2>
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-sm font-bold rounded-full">
                                {{ $completedAssignments->count() }}
                            </span>
                        </div>
                        <div class="space-y-4">
                            @foreach ($completedAssignments as $assignment)
                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border-l-4 border-green-500 opacity-75">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h3 class="text-xl font-black text-gray-900 dark:text-white">{{ $assignment->title }}</h3>
                                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs font-bold rounded-full">
                                                    {{ $assignment->getPriorityLabel() }} Priority
                                                </span>
                                            </div>

                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    📌 Assigned to: <strong>{{ $assignment->user->name }}</strong>
                                                </span>
                                            </div>
                                            
                                            @if ($assignment->description)
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ $assignment->description }}</p>
                                            @endif

                                            <div class="flex flex-wrap gap-3 items-center text-sm">
                                                @if ($assignment->subject)
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        📚 {{ $assignment->subject }}
                                                    </span>
                                                @endif

                                                @if ($assignment->due_date)
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        📅 {{ $assignment->due_date->format('M d, Y \a\t h:i A') }}
                                                    </span>
                                                @endif

                                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300">
                                                    ✓ Completed
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2">
                                        <form action="{{ route('assignments.archive', $assignment) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg transition-all">
                                                🗂️ Archive
                                            </button>
                                        </form>
                                        <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?');" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition-all">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
