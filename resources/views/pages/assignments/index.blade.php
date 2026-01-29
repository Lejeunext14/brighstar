<x-layouts::app :title="__('Assignments')">
    <div class="w-full bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <!-- Header with Stats -->
        <div class="px-6 py-8 bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-blue-700 dark:to-indigo-700">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-4xl font-black text-white mb-2">My Assignments</h1>
                    <p class="text-blue-100">Track and manage your learning tasks</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Pending Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">📋</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-blue-600">{{ $pendingAssignments }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Pending</p>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">✅</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-green-600">{{ $completedAssignments }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Completed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Overdue Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-3xl">⚠️</span>
                            <div class="text-right">
                                <p class="text-3xl font-black text-red-600">{{ $overdueAssignments }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Overdue</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-6 py-8">
            @if ($assignments->isEmpty())
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-12 shadow-lg text-center">
                    <span class="text-6xl mb-4 block">🎉</span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">No Assignments Yet!</h3>
                    <p class="text-gray-600 dark:text-gray-400">You're all caught up! No assignments at the moment.</p>
                </div>
            @else
                <!-- Assignments List -->
                <div class="space-y-4">
                    @foreach ($assignments as $assignment)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border-l-4" 
                             style="border-left-color: {{ $assignment->status === 'completed' ? '#10b981' : ($assignment->isOverdue() ? '#ef4444' : '#f59e0b') }}">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-black text-gray-900 dark:text-white">{{ $assignment->title }}</h3>
                                        @if ($assignment->status === 'completed')
                                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-bold rounded-full">
                                                ✓ Completed
                                            </span>
                                        @elseif ($assignment->isOverdue())
                                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 text-xs font-bold rounded-full">
                                                ⚠️ Overdue
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-bold rounded-full">
                                                📋 Pending
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if ($assignment->description)
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ $assignment->description }}</p>
                                    @endif

                                    <div class="flex flex-wrap gap-3 items-center text-sm">
                                        @if ($assignment->subject)
                                            <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                📚 {{ $assignment->subject }}
                                            </span>
                                        @endif

                                        @if ($assignment->due_date)
                                            <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                📅 {{ $assignment->due_date->format('M d, Y') }}
                                                @if ($assignment->due_date->diffInDays() === 0)
                                                    <span class="text-red-600 font-bold">- Today!</span>
                                                @elseif ($assignment->due_date->isTomorrow())
                                                    <span class="text-orange-600 font-bold">- Tomorrow!</span>
                                                @endif
                                            </span>
                                        @endif

                                        <span class="flex items-center gap-1">
                                            <span class="px-2 py-1 text-xs font-bold rounded-full" 
                                                  style="background-color: {{ match($assignment->priority) { 0 => '#e5e7eb', 1 => '#fef3c7', 2 => '#fee2e2' } }}; color: {{ match($assignment->priority) { 0 => '#6b7280', 1 => '#d97706', 2 => '#dc2626' } }}">
                                                {{ $assignment->getPriorityLabel() }} Priority
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            @if ($assignment->status !== 'completed')
                                <div class="flex gap-2">
                                    <form action="{{ route('assignments.complete', $assignment) }}" method="POST" style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-green-400 to-green-600 text-white font-bold rounded-lg hover:shadow-lg transition-all">
                                            ✓ Mark as Complete
                                        </button>
                                    </form>
                                    <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?');" style="flex: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition-all">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex gap-2">
                                    <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?');" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition-all">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
