<x-layouts::app :title="__('Archived Assignments')">
    <div class="w-full bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <!-- Header with Stats -->
        <div class="px-6 py-8 bg-gradient-to-r from-gray-600 to-gray-700 dark:from-gray-700 dark:to-gray-800">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-4xl font-black text-white mb-2">📦 Archived Assignments</h1>
                        <p class="text-gray-100">Manage your archived assignments</p>
                    </div>
                    <a href="{{ route('teacher.assignments.index') }}" wire:navigate 
                       class="px-6 py-3 bg-white text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-all">
                        ← Back to Active
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">📦</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-gray-600">{{ $stats['total'] }}</p>
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
                <form method="GET" action="{{ route('teacher.assignments.archived') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Search Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Search</label>
                            <input type="text" name="search" value="{{ $search ?? '' }}" 
                                   placeholder="Student, title, subject..."
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

                        <!-- Sort By -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Sort By</label>
                            <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="archived_at_desc" {{ ($sortBy ?? '') === 'archived_at_desc' ? 'selected' : '' }}>Recently Archived</option>
                                <option value="archived_at_asc" {{ ($sortBy ?? '') === 'archived_at_asc' ? 'selected' : '' }}>Oldest Archived</option>
                                <option value="title_asc" {{ ($sortBy ?? '') === 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                                <option value="status" {{ ($sortBy ?? '') === 'status' ? 'selected' : '' }}>Status</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2 items-end">
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors">
                                🔍 Search
                            </button>
                            <a href="{{ route('teacher.assignments.archived') }}" class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-colors text-center">
                                ✕ Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            @if ($assignments->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-12 shadow-lg text-center">
                    <span class="text-6xl mb-4 block">📦</span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">No Archived Assignments</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">You haven't archived any assignments yet.</p>
                    <a href="{{ route('teacher.assignments.index') }}" wire:navigate 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold rounded-full hover:shadow-lg transition-all">
                        ← Back to Assignments
                    </a>
                </div>
            @else
                <!-- Archived Assignments List -->
                <div class="space-y-4">
                    @foreach ($assignments as $assignment)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border-l-4 border-gray-400">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-black text-gray-900 dark:text-white">{{ $assignment->title }}</h3>
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs font-bold rounded-full">
                                            {{ $assignment->getPriorityLabel() }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            📌 <strong>{{ $assignment->user->name }}</strong>
                                        </span>
                                    </div>
                                    
                                    @if ($assignment->description)
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ $assignment->description }}</p>
                                    @endif

                                    <div class="flex flex-wrap gap-3 items-center text-sm">
                                        @if ($assignment->subject)
                                            <span class="text-gray-600 dark:text-gray-400">📚 {{ $assignment->subject }}</span>
                                        @endif

                                        @if ($assignment->due_date)
                                            <span class="text-gray-600 dark:text-gray-400">📅 {{ $assignment->due_date->format('M d, Y') }}</span>
                                        @endif

                                        <span class="px-3 py-1 text-xs font-bold rounded-full" 
                                              style="background-color: {{ match($assignment->status) { 'pending' => '#fef3c7', 'completed' => '#dcfce7', 'overdue' => '#fee2e2' } }}; color: {{ match($assignment->status) { 'pending' => '#d97706', 'completed' => '#16a34a', 'overdue' => '#dc2626' } }}">
                                            {{ ucfirst($assignment->status) }}
                                        </span>

                                        @if ($assignment->archived_at)
                                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                                🕐 {{ $assignment->archived_at->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <form action="{{ route('assignments.restore', $assignment) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg transition-all">
                                        ✨ Restore
                                    </button>
                                </form>
                                <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Delete permanently?');" class="flex-1">
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

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
