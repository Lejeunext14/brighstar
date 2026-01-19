<x-layouts::app :title="__('Link to Parent')">
    <div class="w-full max-w-md mx-auto px-4 py-12">
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg p-8 border border-zinc-200 dark:border-zinc-800">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Link to Your Parent</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Enter the 6-digit code your parent sent you via SMS</p>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/20 dark:border-green-800">
                    <p class="text-green-800 dark:text-green-400">{{ session('success') }}</p>
                </div>
            @endif

            @if ($user->parent_id)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 dark:bg-green-900/20 dark:border-green-800 text-center">
                    <p class="text-green-800 dark:text-green-400 font-medium mb-4">
                        ✓ You are linked to your parent!
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200">
                        Go to Dashboard
                    </a>
                </div>
            @else
                <form action="{{ route('child.link-with-code') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="linking_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Linking Code
                        </label>
                        <input 
                            type="text" 
                            name="linking_code" 
                            id="linking_code"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-3xl tracking-widest font-mono"
                            placeholder="000000"
                            maxlength="6"
                            inputmode="numeric"
                            required
                            autofocus
                        >
                        @error('linking_code')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200"
                    >
                        Link to Parent
                    </button>
                </form>

                <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-blue-800 dark:text-blue-400 text-sm">
                        <strong>Don't have a code yet?</strong><br>
                        Ask your parent to generate a linking code and send it to your phone.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
