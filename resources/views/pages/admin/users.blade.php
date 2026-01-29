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

        <!-- Add User Buttons -->
        <div class="mb-8 grid gap-4 md:grid-cols-3">
            <button onclick="openModal('student')" class="rounded-xl border-2 border-green-300 bg-green-50 p-6 hover:bg-green-100 dark:border-green-700 dark:bg-green-900/20 dark:hover:bg-green-900/30 transition-all">
                <div class="text-4xl mb-2">👨‍🎓</div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Add Student</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Create new student account</p>
            </button>

            <button onclick="openModal('teacher')" class="rounded-xl border-2 border-blue-300 bg-blue-50 p-6 hover:bg-blue-100 dark:border-blue-700 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 transition-all">
                <div class="text-4xl mb-2">👩‍🏫</div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Add Teacher</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Create new teacher account</p>
            </button>

            <button onclick="openModal('parent')" class="rounded-xl border-2 border-purple-300 bg-purple-50 p-6 hover:bg-purple-100 dark:border-purple-700 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 transition-all">
                <div class="text-4xl mb-2">👨‍👩‍👧</div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Add Parent</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Create new parent account</p>
            </button>
        </div>

        <!-- Add User Modal -->
        <div id="addUserModal" class="fixed inset-0 z-50 hidden">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 dark:bg-black/70 z-40" onclick="closeModal(event)"></div>
            
            <!-- Modal Content -->
            <div class="fixed inset-0 flex items-center justify-center p-4 z-50 overflow-y-auto">
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-2xl w-full" onclick="event.stopPropagation()">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between border-b border-gray-200 dark:border-neutral-700 p-6">
                        <div>
                            <h2 id="modalTitle" class="text-2xl font-bold text-gray-900 dark:text-white">Add New User</h2>
                            <p id="modalSubtitle" class="text-sm text-gray-600 dark:text-gray-400 mt-1">Enter the details to create a new account</p>
                        </div>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 text-2xl">
                            ✕
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="p-6">
                            <input type="hidden" id="roleInput" name="role" value="student">
                            
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

                                <!-- ID Field -->
                                <div id="idField">
                                    <label id="idLabel" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">ID</label>
                                    <input type="text" name="student_id" value="{{ old('student_id') }}" 
                                        class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white dark:placeholder-gray-400"
                                        id="idInput" placeholder="Enter ID">
                                    @error('student_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Parent Name (visible only for student role) -->
                                <div id="parentNameField" class="hidden">
                                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Parent Name</label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}"
                                        class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Enter parent/guardian name">
                                    @error('parent_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end gap-4 border-t border-gray-200 dark:border-neutral-700 px-6 py-4">
                            <button type="button" onclick="closeModal()" class="rounded-lg bg-gray-200 px-6 py-2 font-medium text-gray-900 hover:bg-gray-300 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtn" class="rounded-lg bg-blue-600 px-6 py-2 font-medium text-white hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                                Add User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            const roleConfig = {
                student: {
                    title: '👨‍🎓 Add New Student',
                    subtitle: 'Enter the details to create a new student account',
                    idLabel: 'Student ID',
                    idPlaceholder: 'Enter student ID',
                    buttonText: 'Add Student',
                    buttonColor: 'bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800'
                },
                teacher: {
                    title: '👩‍🏫 Add New Teacher',
                    subtitle: 'Enter the details to create a new teacher account',
                    idLabel: 'Teacher ID',
                    idPlaceholder: 'Enter teacher ID',
                    buttonText: 'Add Teacher',
                    buttonColor: 'bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800'
                },
                parent: {
                    title: '👨‍👩‍👧 Add New Parent',
                    subtitle: 'Enter the details to create a new parent account',
                    idLabel: 'Parent ID',
                    idPlaceholder: 'Enter parent ID',
                    buttonText: 'Add Parent',
                    buttonColor: 'bg-purple-600 hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800'
                }
            };

            function openModal(role) {
                const modal = document.getElementById('addUserModal');
                const roleInput = document.getElementById('roleInput');
                const modalTitle = document.getElementById('modalTitle');
                const modalSubtitle = document.getElementById('modalSubtitle');
                const idLabel = document.getElementById('idLabel');
                const idInput = document.getElementById('idInput');
                const submitBtn = document.getElementById('submitBtn');
                
                // Reset form
                document.querySelector('form').reset();
                document.querySelector('form').action = "{{ route('users.store') }}";
                document.querySelector('form').method = "POST";
                
                const config = roleConfig[role];
                roleInput.value = role;
                modalTitle.textContent = config.title;
                modalSubtitle.textContent = config.subtitle;
                idLabel.textContent = config.idLabel;
                idInput.placeholder = config.idPlaceholder;
                submitBtn.textContent = config.buttonText;
                submitBtn.className = 'rounded-lg px-6 py-2 font-medium text-white ' + config.buttonColor;
                    // Show/hide parent name field for students
                    const parentNameField = document.getElementById('parentNameField');
                    if (role === 'student') {
                        parentNameField.classList.remove('hidden');
                    } else {
                        parentNameField.classList.add('hidden');
                    }

                    // Hide ID field for parents (no Parent ID)
                    const idField = document.getElementById('idField');
                    if (role === 'parent') {
                        idField.classList.add('hidden');
                    } else {
                        idField.classList.remove('hidden');
                    }
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function openEditModal(userId, name, email, studentId, parentName, role) {
                const modal = document.getElementById('addUserModal');
                const roleInput = document.getElementById('roleInput');
                const form = document.querySelector('form');
                const modalTitle = document.getElementById('modalTitle');
                const modalSubtitle = document.getElementById('modalSubtitle');
                const submitBtn = document.getElementById('submitBtn');
                
                // Populate form with user data
                document.querySelector('input[name="name"]').value = name;
                document.querySelector('input[name="email"]').value = email;
                document.querySelector('input[name="student_id"]').value = studentId;
                document.querySelector('input[name="parent_name"]').value = parentName;
                document.querySelector('input[name="password"]').value = '';
                document.querySelector('input[name="password_confirmation"]').value = '';
                
                // Update form action to edit route
                form.action = "{{ route('users.update', ':userId') }}".replace(':userId', userId);
                form.method = "POST";
                
                // Add PUT method
                let methodInput = form.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    form.appendChild(methodInput);
                }
                methodInput.value = 'PUT';
                
                modalTitle.textContent = '✏️ Edit User';
                modalSubtitle.textContent = 'Update user information (leave password empty to keep current)';
                submitBtn.textContent = 'Update User';
                submitBtn.className = 'rounded-lg px-6 py-2 font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800';
                
                // Set and lock role input, hide parent name field as needed
                roleInput.value = role;
                document.getElementById('roleInput').disabled = true;
                const parentNameField = document.getElementById('parentNameField');
                parentNameField.classList.add('hidden');

                // Hide ID field when editing a parent
                const idField = document.getElementById('idField');
                if (role === 'parent') {
                    idField.classList.add('hidden');
                } else {
                    idField.classList.remove('hidden');
                }
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeModal(event) {
                // Only close if clicking the backdrop (outside the modal)
                if (event && event.target.id !== 'addUserModal') {
                    return;
                }
                
                const modal = document.getElementById('addUserModal');
                const form = document.querySelector('form');
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }
                document.getElementById('roleInput').disabled = false;
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('addUserModal');
                    if (!modal.classList.contains('hidden')) {
                        closeModal();
                    }
                }
            });
        </script>

        <!-- All Users Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">All Users</h2>
            
            <!-- Tabs -->
            <div class="mb-6 flex gap-2 border-b border-gray-200 dark:border-neutral-700">
                <button onclick="showTab('students')" class="tab-btn active px-4 py-2 font-medium text-gray-700 dark:text-gray-300 border-b-2 border-green-600">👨‍🎓 Students ({{ $students->total() }})</button>
                <button onclick="showTab('teachers')" class="tab-btn px-4 py-2 font-medium text-gray-700 dark:text-gray-300 border-b-2 border-transparent hover:border-blue-600">👩‍🏫 Teachers ({{ $teachers->total() }})</button>
                <button onclick="showTab('parents')" class="tab-btn px-4 py-2 font-medium text-gray-700 dark:text-gray-300 border-b-2 border-transparent hover:border-purple-600">👨‍👩‍👧 Parents ({{ $parents->total() }})</button>
            </div>

            <!-- Tab Content -->
            <div class="overflow-x-auto">
                <!-- Students Tab -->
                <div id="students" class="tab-content">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-neutral-700">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Student ID</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Parents Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Joined</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $user)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->student_id ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->parent_name ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($user->id !== auth()->id())
                                            <div class="flex gap-2">
                                                <button type="button" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ addslashes($user->student_id ?? '') }}', '{{ addslashes($user->parent_name ?? '') }}', '{{ $user->role }}')" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    Edit
                                                </button>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                        No students found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Students Pagination -->
                    <div class="mt-6">
                        {{ $students->links() }}
                    </div>
                </div>

                <!-- Teachers Tab -->
                <div id="teachers" class="tab-content hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-neutral-700">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Teacher ID</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Joined</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teachers as $user)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->student_id ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($user->id !== auth()->id())
                                            <div class="flex gap-2">
                                                <button type="button" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ addslashes($user->student_id ?? '') }}', '', '{{ $user->role }}')" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    Edit
                                                </button>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                        No teachers found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Teachers Pagination -->
                    <div class="mt-6">
                        {{ $teachers->links() }}
                    </div>
                </div>

                <!-- Parents Tab -->
                <div id="parents" class="tab-content hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-neutral-700">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Parent ID</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Joined</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($parents as $user)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->student_id ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($user->id !== auth()->id())
                                            <div class="flex gap-2">
                                                <button type="button" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ addslashes($user->student_id ?? '') }}', '', '{{ $user->role }}')" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    Edit
                                                </button>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                        No parents found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Parents Pagination -->
                    <div class="mt-6">
                        {{ $parents->links() }}
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showTab(tabName) {
                // Hide all tabs
                const tabs = document.querySelectorAll('.tab-content');
                tabs.forEach(tab => tab.classList.add('hidden'));
                
                // Remove active state from all buttons
                const buttons = document.querySelectorAll('.tab-btn');
                buttons.forEach(btn => {
                    btn.classList.remove('border-green-600', 'border-blue-600', 'border-purple-600', 'border-red-600');
                    btn.classList.add('border-transparent');
                });
                
                // Show selected tab
                document.getElementById(tabName).classList.remove('hidden');
                
                // Activate selected button
                event.target.classList.remove('border-transparent');
                if (tabName === 'students') event.target.classList.add('border-green-600');
                else if (tabName === 'teachers') event.target.classList.add('border-blue-600');
                else if (tabName === 'parents') event.target.classList.add('border-purple-600');
                else if (tabName === 'admins') event.target.classList.add('border-red-600');
            }
        </script>
        </div>
    </flux:main>
</x-layouts::app.admin>
