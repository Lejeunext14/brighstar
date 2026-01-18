<x-layouts::app :title="__('Subject Games')">
    <div class="w-full">
        <!-- Header Section -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-purple-50 to-pink-50 p-8 dark:border-neutral-700 dark:from-purple-900/20 dark:to-pink-900/20 mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">
                    @if($subject === 'filipino')
                        Filipino Learning Games
                    @else
                        {{ ucfirst($subject) }} Games
                    @endif
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Learn and have fun with interactive games!</p>
            </div>
        </div>

        <!-- Games Grid -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Available Games</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @if($subject === 'filipino')
                    <!-- Game 1: Word Match -->
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer group">
                        <div class="h-40 bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-5xl group-hover:scale-110 transition-transform duration-300">
                          <img src="/image/tamangkulay.png" alt="Pag Papakilala sa Sarili" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Tamang Kulay</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Hulaan ang Tamang Kulay</p>
                            <button class="w-full bg-gradient-to-r from-pink-500 to-pink-600 text-white py-2 rounded-lg hover:shadow-lg transition-all">
                                Play Now →
                            </button>
                        </div>
                    </div>

                    <!-- Game 2: Word Builder -->
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer group">
                        <div class="h-40 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-5xl group-hover:scale-110 transition-transform duration-300">
                           <img src="/image/tamangtitik.png" alt="Pag Papakilala sa Sarili" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Tamang Titik</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Hulaan ang Tamang Titik</p>
                            <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 rounded-lg hover:shadow-lg transition-all">
                                Play Now →
                            </button>
                        </div>
                    </div>

                    <!-- Game 3: Spelling Quiz -->
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer group">
                        <div class="h-40 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-5xl group-hover:scale-110 transition-transform duration-300">
                             <img src="/image/tamanghayop.png" alt="Pag Papakilala sa Sarili" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Tamang Hayop</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Hulaan ang Tamang Hayop</p>
                            <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-2 rounded-lg hover:shadow-lg transition-all">
                                Play Now →
                            </button>
                        </div>
                    </div>
                @else
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600 dark:text-gray-400">Games coming soon for {{ ucfirst($subject) }}</p>
                    </div>
                @endif
            </div>
        </div>
        <!-- Your Stats Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Your Gaming Stats</h2>
            <div class="grid gap-6 md:grid-cols-4">
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Games Played</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">24</p>
                </div>
                <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Points</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">1,850</p>
                </div>
                <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Win Streak</p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">7</p>
                </div>
                <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Rank</p>
                    <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">#12</p>
                </div>
            </div>
        </div>

        <!-- Floating Footer Button -->
        <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 flex gap-4 z-40 mt-20">
            <!-- Book Icon Button -->
            <a href="{{ route('subject.topics', ['subject' => 'filipino']) }}" class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300" title="Learning Resources">
                <span class="text-2xl">📚</span>
            </a>
            
            <!-- Gaming Controller Icon Button -->
            <a href="{{ route('subject.games', ['subject' => 'filipino']) }}" class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300" title="Play Games">
                <span class="text-2xl">🎮</span>
            </a>
        </div>
    </div>
</x-layouts::app>
