<x-layouts::app :title="__('Create Assignment')">
    <div class="w-full bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <!-- Header -->
        <div class="px-6 py-8 bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-blue-700 dark:to-indigo-700">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl font-black text-white mb-2">Create Assignment</h1>
                <p class="text-blue-100">Assign tasks to your students</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg">
                <form action="{{ route('assignments.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                            Assignment Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" required value="{{ old('title') }}" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="e.g., Chapter 5 Exercise">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                            Subject
                        </label>
                        <input type="text" name="subject" value="{{ old('subject') }}" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="e.g., Mathematics, English">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="5"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Provide detailed instructions for the assignment...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                            Due Date
                        </label>
                        <input type="datetime-local" name="due_date" value="{{ old('due_date') }}" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('due_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                            Priority
                        </label>
                        <select name="priority" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="0">Low Priority</option>
                            <option value="1" {{ old('priority') == 1 ? 'selected' : '' }}>Medium Priority</option>
                            <option value="2" {{ old('priority') == 2 ? 'selected' : '' }}>High Priority</option>
                        </select>
                        @error('priority')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Students Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                            Assign to Students <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2 max-h-64 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                            @forelse($students as $student)
                                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 p-2 rounded transition-colors">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" 
                                           class="w-4 h-4 text-blue-500 rounded focus:ring-2 focus:ring-blue-500"
                                           {{ in_array($student->id, old('student_ids', [])) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $student->name }}
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $student->email }}</span>
                                    </span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">No students available</p>
                            @endforelse
                        </div>
                        @error('student_ids')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('teacher.assignments.index') }}" wire:navigate 
                           class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white font-bold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-center">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold rounded-lg hover:shadow-lg transition-all">
                            Create Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
