<x-layouts::app :title="__('Verify Phone Number')">
    <div class="w-full max-w-md mx-auto px-4 py-12">
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg p-8 border border-zinc-200 dark:border-zinc-800">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Verify Phone Number</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Add and verify your phone number to enable parent-child linking via SMS.</p>

            @if (session('status'))
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-800">
                    <p class="text-blue-800 dark:text-blue-400">{{ session('status') }}</p>
                    
                    @if (session('test_code'))
                        <div class="mt-3 p-3 bg-blue-100 dark:bg-blue-900/50 rounded border border-blue-300 dark:border-blue-700">
                            <p class="text-xs text-blue-600 dark:text-blue-400 font-medium mb-1">TEST MODE - Code for development:</p>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300 font-mono">{{ session('test_code') }}</p>
                        </div>
                    @endif
                </div>
            @endif

            @if ($hasPhone && !$errors->any())
                <!-- Phone already verified -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 dark:bg-green-900/20 dark:border-green-800 mb-6">
                    <p class="text-green-800 dark:text-green-400 font-medium">
                        ✓ Phone verified: {{ $parent->phone_number }}
                    </p>
                </div>

                <a href="{{ route('parent.link-child') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200 text-center">
                    Proceed to Link Child
                </a>
            @else
                <!-- Phone verification form -->
                <form action="{{ route('phone.send-code') }}" method="POST" class="mb-6" id="phoneForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phone Number
                        </label>
                        <input 
                            type="tel" 
                            name="phone_number" 
                            id="phone_number"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="+1234567890"
                            value="{{ old('phone_number') }}"
                            required
                        >
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200"
                    >
                        Send Verification Code
                    </button>
                </form>

                <!-- Code verification form (shown after code is sent) -->
                @if (session('status'))
                    <form action="{{ route('phone.verify-code') }}" method="POST">
                        @csrf
                        
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg dark:bg-yellow-900/20 dark:border-yellow-800 mb-4">
                            <p class="text-yellow-800 dark:text-yellow-400 text-sm">
                                Enter the 6-digit code sent to your phone
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Verification Code
                            </label>
                            <input 
                                type="text" 
                                name="code" 
                                id="code"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl tracking-widest"
                                placeholder="000000"
                                maxlength="6"
                                inputmode="numeric"
                                required
                                autofocus
                            >
                            @error('code')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button 
                            type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200"
                        >
                            Verify Code
                        </button>
                    </form>
                @endif
            @endif

            <p class="text-gray-600 dark:text-gray-400 text-sm mt-6 text-center">
                We'll use SMS to securely verify your phone and enable linking with your children.
            </p>
        </div>
    </div>
</x-layouts::app>
