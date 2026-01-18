<x-layouts::app.admin :title="__('Manage Users')">
    <flux:main>
        <div class="w-full">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white">Manage Users 👥</h1>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">Add, view, and manage all users</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-900 hover:bg-gray-300 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600">← Back</a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800 dark:border-green-900/30 dark:bg-green-900/20 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add User Section -->
        <div class="mb-8 rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Add New User</h2>
            
            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Name -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white dark:placeholder-gray-400"
                            placeholder="Enter full name" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white dark:placeholder-gray-400"
                            placeholder="user@example.com" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" 
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white dark:placeholder-gray-400"
                            placeholder="Minimum 8 characters" required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white dark:placeholder-gray-400"
                            placeholder="Confirm password" required>
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select name="role" 
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white"
                            required>
                            <option value="">Select a role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="parent" {{ old('role') === 'parent' ? 'selected' : '' }}>Parent</option>
                            <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 font-medium text-white hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                    Add User
                </button>
            </form>
        </div>

        <!-- Users List -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">All Users ({{ $users->count() }})</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-neutral-700">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Role</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Joined</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                        @if ($user->role === 'admin')
                                            bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                        @elseif ($user->role === 'teacher')
                                            bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                        @elseif ($user->role === 'parent')
                                            bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                                        @else
                                            bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @endif
                                    ">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                    No users found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </flux:main>
</x-layouts::app.admin>
