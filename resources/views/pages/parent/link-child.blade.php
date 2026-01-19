<x-layouts::app :title="__('Link Child via SMS')">
    <div class="w-full max-w-2xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Link Your Child</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-8">Generate a linking code to send to your child via SMS.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left: Generate Code -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg p-6 border border-zinc-200 dark:border-zinc-800">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Generate Linking Code</h2>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/20 dark:border-green-800">
                        <p class="text-green-800 dark:text-green-400">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('parent.generate-code') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="child_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Child's Phone Number
                        </label>
                        <input 
                            type="tel" 
                            name="child_phone" 
                            id="child_phone"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="+1234567890"
                            required
                        >
                        @error('child_phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200"
                    >
                        Send Linking Code
                    </button>
                </form>

                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-blue-800 dark:text-blue-400 text-sm">
                        <strong>How it works:</strong><br>
                        1. Enter your child's phone number<br>
                        2. We'll send them a 6-digit code<br>
                        3. They enter the code in their account<br>
                        4. You'll be automatically linked!
                    </p>
                </div>
            </div>

            <!-- Right: Current Links -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg p-6 border border-zinc-200 dark:border-zinc-800">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Linked Children</h2>

                @if ($children->count() > 0)
                    <div class="space-y-4">
                        @foreach ($children as $child)
                            <div class="p-4 bg-gray-50 dark:bg-zinc-800/50 rounded-lg border border-gray-200 dark:border-zinc-700">
                                <h3 class="font-bold text-gray-900 dark:text-white mb-1">{{ $child->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $child->email }}</p>
                                @if ($child->phone_number)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $child->phone_number }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center border-2 border-dashed border-gray-300 dark:border-zinc-700 rounded-lg">
                        <p class="text-gray-600 dark:text-gray-400">
                            No children linked yet
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts::app>
