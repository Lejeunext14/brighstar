<x-layouts::app.admin :title="__('Archived')">
    <flux:main>
        <div class="w-full">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white">🗂️ Archived</h1>
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">Manage archived items in the system</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-900 hover:bg-gray-300 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600">← Back</a>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-6 flex gap-2 border-b border-gray-200 dark:border-neutral-700">
                <button onclick="showTab('users')" class="tab-btn active px-4 py-3 font-semibold text-blue-600 border-b-2 border-blue-600">
                    👥 Archived Users
                </button>
                <button onclick="showTab('assignments')" class="tab-btn px-4 py-3 font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    📋 Archived Assignments
                </button>
            </div>

            <!-- Archived Users Section -->
            <div id="users-tab" class="tab-content">
                <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Archived Users</h2>
                    
                    @if($archivedUsers->isEmpty())
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4">📭</div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Archived Users</h3>
                            <p class="text-gray-600 dark:text-gray-400">All users are currently active</p>
                        </div>
                    @else
                        <!-- Users Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-gray-600 dark:text-gray-400">
                                <thead class="border-b border-gray-200 dark:border-neutral-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">Name</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">Email</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">Role</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">Archived Date</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($archivedUsers as $user)
                                        <tr class="border-b border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                                            <td class="px-4 py-4">{{ $user->name }}</td>
                                            <td class="px-4 py-4">{{ $user->email }}</td>
                                            <td class="px-4 py-4">
                                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full"
                                                    style="background-color: {{ match($user->role) { 'admin' => '#fee2e2', 'teacher' => '#dbeafe', 'parent' => '#fef3c7', 'student' => '#d1fae5' } }}; color: {{ match($user->role) { 'admin' => '#dc2626', 'teacher' => '#0369a1', 'parent' => '#d97706', 'student' => '#047857' } }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                                                {{ $user->deleted_at ? $user->deleted_at->format('M d, Y h:i A') : 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="flex gap-2">
                                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                                            ↩️ Restore
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('users.force-delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('This action cannot be undone. Permanently delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                                            🗑️ Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 flex justify-center">
                            {{ $archivedUsers->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Archived Assignments Section -->
            <div id="assignments-tab" class="tab-content hidden">
                <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Archived Assignments</h2>
                    
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">📭</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Archived Assignments</h3>
                        <p class="text-gray-600 dark:text-gray-400">Completed assignments will appear here after 30 days</p>
                    </div>
                </div>
            </div>
        </div>
    </flux:main>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
                btn.classList.add('text-gray-600', 'dark:text-gray-400');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Add active class to clicked button
            event.target.classList.add('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
            event.target.classList.remove('text-gray-600', 'dark:text-gray-400');
        }
    </script>
</x-layouts::app.admin>
