<x-layouts::app.admin :title="__('Parent-Child Management')">
    <flux:main>
        <div class="w-full">
            <!-- Page Header -->
            <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-blue-50 to-cyan-50 p-8 dark:border-neutral-700 dark:from-blue-900/20 dark:to-cyan-900/20 mb-6">
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Parent-Child Management 👨‍👧‍👦</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Link parents with their children for account management</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid gap-4 md:grid-cols-3 mb-6">
                <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Parents</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $parents->count() }}</p>
                        </div>
                        <span class="text-4xl">👨‍👩‍👧</span>
                    </div>
                </div>
                <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Students</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $students->count() }}</p>
                        </div>
                        <span class="text-4xl">👶</span>
                    </div>
                </div>
                <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Linked Pairs</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $linkedPairs->count() }}</p>
                        </div>
                        <span class="text-4xl">🔗</span>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if ($message = Session::get('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-300 flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('warning'))
                <div class="mb-4 p-4 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-800 dark:bg-yellow-900/20 dark:border-yellow-800 dark:text-yellow-300 flex items-center gap-3">
                    <span class="text-2xl">⚠️</span>
                    {{ $message }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300">
                    <p class="font-semibold mb-2">⛔ Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Two Column Layout -->
            <div class="grid gap-6 lg:grid-cols-3 mb-6">
                <!-- Left Column: Linking Form -->
                <div class="lg:col-span-1">
                    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <span class="text-2xl">➕</span> New Link
                        </h3>
                        
                        <form method="POST" action="{{ route('admin.link-child') }}" class="space-y-5">
                            @csrf

                            <!-- Parent Selection -->
                            <div>
                                <label for="parent_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Parent <span class="text-red-500">*</span>
                                </label>
                                <select id="parent_id" name="parent_id" required
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">-- Select Parent --</option>
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            👨 {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Multiple Students Selection -->
                            <div>
                                <label for="child_ids" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Students <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Hold Ctrl/Cmd + Click to select multiple</p>
                                <select id="child_ids" name="child_ids[]" required multiple
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    style="min-height: 180px;">
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" {{ in_array($student->id, old('child_ids', [])) ? 'selected' : '' }}>
                                            👶 {{ $student->name }}
                                            @if ($student->parent_id)
                                                [Linked]
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('child_ids')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-sm">
                                ➕ Create Link
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Current Links & Unlinked Students -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Current Links -->
                    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <span class="text-2xl">🔗</span> Active Links
                            @if (!$linkedPairs->isEmpty())
                                <span class="ml-auto text-sm px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                                    {{ $linkedPairs->count() }}
                                </span>
                            @endif
                        </h3>
                        
                        @if ($linkedPairs->isEmpty())
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p class="text-3xl mb-2">📭</p>
                                <p>No links established yet</p>
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach ($linkedPairs as $child)
                                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-gray-900 dark:text-white">👶 {{ $child->name }}</span>
                                                <span class="text-gray-500 dark:text-gray-400">→</span>
                                                @if ($child->parent)
                                                    <span class="font-semibold text-gray-900 dark:text-white">👨 {{ $child->parent->name }}</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $child->email }}</p>
                                        </div>
                                        <form action="{{ route('admin.unlink-child', $child->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 text-xs font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition"
                                                onclick="return confirm('Unlink this child?')">
                                                ✕ Unlink
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Unlinked Students -->
                    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <span class="text-2xl">⚠️</span> Unlinked Students
                            @php
                                $unlinkedCount = $students->filter(fn($s) => !$s->parent_id)->count();
                            @endphp
                            @if ($unlinkedCount > 0)
                                <span class="ml-auto text-sm px-3 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 rounded-full">
                                    {{ $unlinkedCount }}
                                </span>
                            @endif
                        </h3>
                        
                        @php
                            $unlinkedStudents = $students->filter(fn($s) => !$s->parent_id);
                        @endphp

                        @if ($unlinkedStudents->isEmpty())
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p class="text-3xl mb-2">✅</p>
                                <p>All students are linked!</p>
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach ($unlinkedStudents as $student)
                                    <div class="flex items-center justify-between p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-100 dark:border-yellow-900/20">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">👶 {{ $student->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $student->email }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold text-yellow-700 dark:text-yellow-300 bg-yellow-200 dark:bg-yellow-900/40 rounded-full">
                                            Pending
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </flux:main>
</x-layouts::app.admin>
