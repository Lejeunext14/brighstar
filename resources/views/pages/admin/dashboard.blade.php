<x-layouts::app.admin :title="__('Admin Dashboard')">
    <flux:main>
        <div class="w-full">
        <!-- Admin Welcome Section -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-purple-50 to-indigo-50 p-8 dark:border-neutral-700 dark:from-purple-900/20 dark:to-indigo-900/20 mb-6">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Admin Dashboard 🔐</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Welcome {{ Auth::user()->name }}, manage your application here</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid gap-6 md:grid-cols-4 mb-6">
            <!-- Total Users Card -->
            <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsers }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>

            <!-- Total Students Card -->
            <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Students</p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $totalStudents }}</p>
                    </div>
                    <div class="text-4xl">👨‍🎓</div>
                </div>
            </div>

            <!-- Total Teachers Card -->
            <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Teachers</p>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $totalTeachers }}</p>
                    </div>
                    <div class="text-4xl">👩‍🏫</div>
                </div>
            </div>

            <!-- Total Parents Card -->
            <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Parents</p>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $totalParents }}</p>
                    </div>
                    <div class="text-4xl">👨‍👩‍👧</div>
                </div>
            </div>
        </div>

        <!-- Admin Actions Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Admin Actions</h2>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Manage Users -->
                <a href="{{ route('users.index') }}" class="p-6 rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all text-left hover:bg-gray-50 dark:hover:bg-neutral-800">
                    <div class="text-3xl mb-2">👥</div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Manage Users</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">View and manage user accounts</p>
                </a>

                <!-- Parent-Child Management -->
                <a href="{{ route('admin.parent-child.index') }}" class="p-6 rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all text-left hover:bg-gray-50 dark:hover:bg-neutral-800">
                    <div class="text-3xl mb-2">👨‍👧‍👦</div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Parent-Child Links</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Link parents with their children</p>
                </a>

                <!-- System Settings -->
                <a href="{{ route('admin.settings') }}" class="p-6 rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all text-left hover:bg-gray-50 dark:hover:bg-neutral-800">
                    <div class="text-3xl mb-2">⚙️</div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Settings</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Configure system settings</p>
                </a>

                <!-- View Reports -->
                <a href="{{ route('admin.reports') }}" class="p-6 rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all text-left hover:bg-gray-50 dark:hover:bg-neutral-800">
                    <div class="text-3xl mb-2">📊</div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Reports</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">View system reports</p>
                </a>

                <!-- Logs -->
                <a href="{{ route('admin.logs') }}" class="p-6 rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all text-left hover:bg-gray-50 dark:hover:bg-neutral-800">
                    <div class="text-3xl mb-2">📝</div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Logs</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">View system logs</p>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Users</h2>
            <div class="space-y-4">
                @forelse ($recentUsers as $user)
                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-neutral-800">
                        <div class="flex items-center gap-4">
                            <div class="text-2xl">
                                @if ($user->role === 'student')
                                    👨‍🎓
                                @elseif ($user->role === 'teacher')
                                    👩‍🏫
                                @elseif ($user->role === 'parent')
                                    👨‍👩‍👧
                                @else
                                    👤
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }} • {{ ucfirst($user->role) }}</p>
                            </div>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 px-3 py-1 rounded-full">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center text-gray-600 dark:text-gray-400 py-8">
                        No users found
                    </div>
                @endforelse
            </div>
        </div>
        </div>
    </flux:main>
</x-layouts::app.admin>
