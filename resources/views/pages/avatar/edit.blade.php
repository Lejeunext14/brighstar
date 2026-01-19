<x-layouts::app :title="__('Edit Avatar')">
    <div class="w-full bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto px-6 py-12">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 font-bold mb-6">
                    <span>←</span> Back to Dashboard
                </a>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Choose Your Avatar</h1>
                <p class="text-gray-600 dark:text-gray-400">Pick your favorite character to represent you! 🎨</p>
            </div>

            <!-- Current Avatar Preview -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-2xl mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Preview on Dashboard</h2>
                <!-- Character Card Preview -->
                <div id="cardPreview" class="lg:col-span-1 bg-gradient-to-br from-purple-400 to-purple-600 rounded-3xl p-8 shadow-2xl flex flex-col items-center justify-center text-white overflow-hidden relative h-80"
                    style="background-image: url('{{ asset($currentAvatar) }}'); background-size: cover; background-position: center;">
                    <div class="absolute inset-0 bg-black/40 rounded-3xl"></div>
                    <div class="relative z-10 flex flex-col items-center justify-center h-full">
                        <div class="w-32 h-32 mb-4 rounded-2xl overflow-hidden border-4 border-white shadow-lg" style="background-image: url('{{ asset($currentAvatar) }}'); background-size: cover; background-position: center;">
                        </div>
                        <h3 class="text-2xl font-black text-center mb-2">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-white/80 text-center">Level 5 • Expert Learner</p>
                        <div class="mt-4 flex gap-2">
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold">⭐⭐⭐⭐⭐</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Avatar Selection -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-2xl">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Select Your Avatar</h2>
                
                <form action="{{ route('avatar.update') }}" method="POST" id="avatarForm">
                    @csrf
                    
                    <div class="grid grid-cols-3 md:grid-cols-3 gap-6 mb-8">
                        @foreach ($avatars as $avatar)
                            <label class="cursor-pointer group">
                                <input type="radio" name="avatar" value="{{ $avatar }}" 
                                    {{ $currentAvatar === $avatar ? 'checked' : '' }}
                                    class="sr-only peer" onchange="updatePreview('{{ asset($avatar) }}')">
                                <div class="w-full aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30 flex items-center justify-center transform transition-all group-hover:scale-110 peer-checked:ring-4 peer-checked:ring-purple-500 peer-checked:scale-110 peer-checked:shadow-lg">
                                    <img src="{{ asset($avatar) }}" alt="Avatar {{ $loop->iteration }}" class="w-full h-full object-cover">
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('dashboard') }}" class="flex-1 px-6 py-4 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-2xl font-bold text-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-2xl font-bold text-lg hover:from-purple-600 hover:to-pink-600 transition-all transform hover:scale-105 shadow-lg">
                            Save Avatar 🎉
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-2xl p-6">
                <p class="text-sm text-blue-900 dark:text-blue-100">
                    💡 <strong>Tip:</strong> You can change your avatar anytime! Click on your character card in the dashboard to come back here.
                </p>
            </div>
        </div>
    </div>

    <script>
        function updatePreview(imagePath) {
            const cardPreview = document.getElementById('cardPreview');
            if (cardPreview) {
                cardPreview.style.backgroundImage = `url('${imagePath}')`;
                cardPreview.style.backgroundSize = 'cover';
                cardPreview.style.backgroundPosition = 'center';
            }
        }
        
        // Add smooth transitions to the card
        document.addEventListener('DOMContentLoaded', function() {
            const cardPreview = document.getElementById('cardPreview');
            if (cardPreview) {
                cardPreview.style.transition = 'background-image 0.5s ease-in-out';
            }
        });
    </script>
</x-layouts::app>
