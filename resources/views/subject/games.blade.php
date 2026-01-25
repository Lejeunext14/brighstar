<x-layouts::app :title="__('Subject Games')">
    <style>
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 49% {
                opacity: 1;
            }
            50%, 100% {
                opacity: 0;
            }
        }

        .typing-cursor {
            display: inline-block;
            width: 2px;
            height: 1em;
            background-color: currentColor;
            margin-left: 2px;
            animation: blink 0.7s infinite;
        }

        .typing-text {
            min-height: 1.5em;
        }
    </style>
    <script>
        function typeWriter(element, text, speed = 50) {
            if (!element) return;
            element.textContent = '';
            let index = 0;

            function type() {
                if (index < text.length) {
                    element.textContent += text.charAt(index);
                    index++;
                    setTimeout(type, speed);
                } else {
                    // Remove cursor when done
                    const cursor = element.querySelector('.typing-cursor');
                    if (cursor) cursor.remove();
                }
            }

            type();
            
            // Add cursor
            const cursor = document.createElement('span');
            cursor.className = 'typing-cursor';
            element.appendChild(cursor);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const chatText = document.querySelector('.chat-bubble-text');
            const originalText = "Welcome! Let's learn and have fun with these games! 🎮";
            
            console.log('Game page initialized. chatText element:', chatText);
            
            if (chatText) {
                typeWriter(chatText, originalText, 50);
            } else {
                console.warn('Chat text element not found');
            }

            // Coloring game hover event
            const coloringGameCard = document.querySelector('[data-game="coloring"]');
            console.log('Coloring game card:', coloringGameCard);
            
            if (coloringGameCard) {
                coloringGameCard.addEventListener('mouseenter', function() {
                    console.log('Mouse enter coloring game');
                    if (window.changeCharacterPose) {
                        window.changeCharacterPose('/character/Thinking.fbx');
                    }
                    if (chatText) {
                        typeWriter(chatText, "Do you want to play Coloring games? 🎨", 50);
                    }
                });
            }
        });
    </script>
    <div class="w-full flex gap-6">
        <!-- Main Content -->
        <div class="flex-1">
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
                    <!-- Game: Book Worm Game -->
                    <div data-game="bookworm" class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer group">
                        <div class="h-40 bg-gradient-to-br from-blue-400 to-green-600 flex items-center justify-center text-5xl group-hover:scale-110 transition-transform duration-300">
                            📚
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Human Book Game</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Find the missing letters to complete the words</p>
                            <a href="{{ route('subject.bookworm', ['subject' => $subject ?? 'filipino']) }}" class="w-full bg-gradient-to-r from-blue-500 to-green-600 text-white py-2 rounded-lg hover:shadow-lg transition-all block text-center">
                                Play Now →
                            </a>
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
    </div>
</x-layouts::app>
