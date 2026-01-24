<x-layouts::app :title="__('Subject Topics')">
    <style>
        @keyframes slide-in-left {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slide-out-left {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(-100%);
                opacity: 0;
            }
        }

        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slide-out-right {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .topic-card {
            animation: slide-in-left 0.5s ease-in-out;
            display: grid !important;
        }

        .topic-card.hidden {
            display: none !important;
        }

        .topic-card.slide-out {
            animation: slide-out-left 0.5s ease-in-out;
        }

        .topic-card.slide-in-right {
            animation: slide-in-right 0.5s ease-in-out;
        }

        .topic-card.slide-out-right {
            animation: slide-out-right 0.5s ease-in-out;
        }

        .pagination-slider {
            position: relative;
            overflow: hidden;
        }

        .pagination-slider-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            min-height: 350px;
        }

        .slider-pagination-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .slider-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid currentColor;
            background: white;
            color: #f59e0b;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            dark:bg-neutral-900;
            dark:border-neutral-700;
        }

        .slider-btn:hover:not(:disabled) {
            background: #f59e0b;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
        }

        .slider-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .slider-counter {
            font-weight: bold;
            color: #f59e0b;
            font-size: 1rem;
            min-width: 120px;
            text-align: center;
            background: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: 2px solid #f59e0b;
            dark:bg-neutral-900;
            dark:border-neutral-700;
        }

        .slider-dots {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 20px;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            dark:bg-neutral-700;
        }

        .slider-dot:hover {
            background: #f59e0b;
            transform: scale(1.2);
        }

        .slider-dot.active {
            background: #f59e0b;
            width: 32px;
            border-radius: 6px;
            border: 2px solid #d97706;
        }
    </style>
    <div class="w-full">
        <!-- Header Section -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-blue-50 to-purple-50 p-8 dark:border-neutral-700 dark:from-blue-900/20 dark:to-purple-900/20 mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">
                    @if($subject === 'filipino')
                        Learn Filipino 
                    @else
                        {{ ucfirst($subject) }} Topics
                    @endif
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Master the fundamentals of {{ ucfirst($subject) }}</p>
            </div>
        </div>

        <!-- Topics Grid -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">1. Ang Aking Sarili</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
              
                    <!-- Topic 1: Alphabet & Vowels -->
                    <a data-lesson="pag-papakilala-sa-sarili" href="{{ route('lesson.view', ['lesson' => 'pag-papakilala-sa-sarili']) }}" class="relative overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                        <div class="h-40 bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center">
                            <img src="/image/pagpapakilala.png" alt="Pag Papakilala sa Sarili" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Pag Papakilala sa Sarili</h3>
                            <div class="topic-completed-badge hidden absolute top-3 right-3 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">Completed</div>
                            <div class="topic-lock-badge absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">🔒 Locked</div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pag Aralan kung pano Mag pakilala ng Sarili</p>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="topic-progress-fill bg-pink-500 h-2 rounded-full" style="width: 40%"></div>
                            </div>
                            <p class="topic-progress-text text-xs text-gray-500 dark:text-gray-400 mt-2">40% Complete • 5 Lessons</p>
                        </div>
                    </a>

                    <!-- Topic 2: Bahagi ng Katawan -->
                    <a data-lesson="bahagi-ng-katawan" href="{{ route('lesson.view', ['lesson' => 'bahagi-ng-katawan']) }}" class="relative overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                        <div class="h-40 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-5xl">
                            <img src="/image/katawan.png" alt="Bahagi ng Katawan" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Bahagi ng Katawan</h3>
                            <div class="topic-completed-badge hidden absolute top-3 right-3 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">Completed</div>
                            <div class="topic-lock-badge absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">🔒 Locked</div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pag Aralan ang Ibat ibang Parte ng Katawan</p>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="topic-progress-fill bg-blue-500 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                            <p class="topic-progress-text text-xs text-gray-500 dark:text-gray-400 mt-2">0% Complete • 0 Lessons</p>
                        </div>
                    </a>

                    <!-- Topic 3: Mga Kulay -->
                    <a data-lesson="mga-kulay" href="{{ route('lesson.view', ['lesson' => 'mga-kulay']) }}" class="relative overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                        <div class="h-40 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-5xl">
                           <img src="/image/kulay.png" alt="Mga Kulay" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Mga Kulay</h3>
                            <div class="topic-completed-badge hidden absolute top-3 right-3 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">Completed</div>
                            <div class="topic-lock-badge absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">🔒 Locked</div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pag Aralan ang Ibat ibang Kulay</p>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="topic-progress-fill bg-green-500 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                            <p class="topic-progress-text text-xs text-gray-500 dark:text-gray-400 mt-2">0% Complete • 0 Lessons</p>
                        </div>
                    </a>

                    <!-- Topic 4: Pag Papakilala sa ibat ibang uri ng tunog -->
                    <a data-lesson="pag-papakilala-sa-ibat-ibang-uri-ng-tunog" href="{{ route('lesson.view', ['lesson' => 'pag-papakilala-sa-ibat-ibang-uri-ng-tunog']) }}" class="relative overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                        <div class="h-40 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-5xl">
                           <img src="/image/tunog.jpg" alt="Mga Tunog" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Pag Papakilala sa ibat ibang uri ng tunog</h3>
                            <div class="topic-completed-badge hidden absolute top-3 right-3 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">Completed</div>
                            <div class="topic-lock-badge absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">🔒 Locked</div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pag Aralan ang Ibat ibang Tunog</p>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="topic-progress-fill bg-green-500 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                            <p class="topic-progress-text text-xs text-gray-500 dark:text-gray-400 mt-2">0% Complete • 0 Lessons</p>
                        </div>
                    </a>
                     <!-- Topic 5: Mga Hugis -->
                    <a data-lesson="mga-hugis" href="{{ route('lesson.view', ['lesson' => 'mga-hugis']) }}" class="relative overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block">
                        <div class="h-40 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-5xl">
                           <img src="/image/mgahugis.jpg" alt="Mga Hugis" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Mga Hugis</h3>
                            <div class="topic-completed-badge hidden absolute top-3 right-3 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">Completed</div>
                            <div class="topic-lock-badge absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">🔒 Locked</div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pag Aralan ang Ibat ibang Hugis</p>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="topic-progress-fill bg-green-500 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                            <p class="topic-progress-text text-xs text-gray-500 dark:text-gray-400 mt-2">0% Complete • 0 Lessons</p>
                        </div>
                    </a>
            
            </div>

        </div>

        <!-- Unit 2: Tungkol sa Aking Pamilya -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">2. Tungkol sa Aking Pamilya</h2>
            
            @php
                $unit2Topics = [
                    ['title' => 'Ang Aking Pamilya', 'description' => 'Pag Aralan ang Aking Pamilya', 'image' => '/image/ang_aking_pamilya.png', 'lesson' => 'ang-aking-pamilya'],
                    ['title' => 'Paggamit ng Po at Opo', 'description' => 'Pag Aralan ang Paggamit ng Po at Opo sa Pag-uusap', 'image' => '/image/po_at_opo.jpg', 'lesson' => 'paggamit-ng-po-at-opo'],
                    ['title' => 'Mga Pagbati ng Magalang', 'description' => 'Pag Aralan ang kung Ano ang Pagbati ng Magalang', 'image' => '/image/pagbati.jpg', 'lesson' => 'mga-pagbati-ng-magalang'],
                    ['title' => 'Mga Kasapi ng Aking Pamilya', 'description' => 'Pag Aralan ang Mga Kasapi ng Aking Pamilya', 'image' => '/image/kasapi.jpg', 'lesson' => 'mga-kasapi-ng-aking-pamilya'],
                    ['title' => 'Ang Alpabetong Filipino', 'description' => 'Pag Aralan ang Alpabetong Filipino', 'image' => '/image/alpabeto.jpg', 'lesson' => 'ang-alpabetong-filipino'],
                    ['title' => 'Pagkilala sa Malaki at Maliit na Titik', 'description' => 'Pag Aralan ang Malaki at Maliit na Titik', 'image' => '/image/malaki_maliit.jpg', 'lesson' => 'pagkilala-sa-malaki-maliit-titik'],
                    ['title' => 'Pag Kilala sa Patinig At Katinig', 'description' => 'Pag Aralan ang Patinig At Katinig', 'image' => '/image/katinig.jpg', 'lesson' => 'pag-kilala-sa-patinig-katinig'],
                    ['title' => 'Ang Titik Aa', 'description' => 'Pag Aralan ang Titik Aa', 'image' => '/image/titika.jpg', 'lesson' => 'ang-titik-aa'],
                    ['title' => 'Ang Titik Ee', 'description' => 'Pag Aralan ang Titik Ee', 'image' => '/image/titike.jpg', 'lesson' => 'ang-titik-ee'],
                    ['title' => 'Ang Titik Ii', 'description' => 'Pag Aralan ang Titik Ii', 'image' => '/image/titiki.jpg', 'lesson' => 'ang-titik-ii'],
                    ['title' => 'Ang Titik Oo', 'description' => 'Pag Aralan ang Titik Oo', 'image' => '/image/titiko.jpg', 'lesson' => 'ang-titik-oo'],
                    ['title' => 'Ang Titik Uu', 'description' => 'Pag Aralan ang Titik Uu', 'image' => '/image/titiku.jpg', 'lesson' => 'ang-titik-uu'],
                ];
                $topicsPerPage = 8;
                $totalPages = ceil(count($unit2Topics) / $topicsPerPage);
            @endphp
            
            <div class="pagination-slider">
                <div class="pagination-slider-grid" id="topicsGrid">
                    @foreach($unit2Topics as $index => $topic)
                    <!-- Topic: {{ $topic['title'] }} -->
                    <a data-lesson="{{ $topic['lesson'] }}" href="{{ route('lesson.view', ['lesson' => $topic['lesson']]) }}" class="topic-card relative overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-lg transition-all cursor-pointer block" data-index="{{ $index }}">
                        <div class="h-40 bg-gradient-to-br from-yellow-400 to-orange-600 flex items-center justify-center text-5xl">
                           <img src="{{ $topic['image'] }}" alt="{{ $topic['title'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $topic['title'] }}</h3>
                            <div class="topic-completed-badge hidden absolute top-3 right-3 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">Completed</div>
                            <div class="topic-lock-badge absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">🔒 Locked</div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $topic['description'] }}</p>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="topic-progress-fill bg-yellow-500 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                            <p class="topic-progress-text text-xs text-gray-500 dark:text-gray-400 mt-2">0% Complete • 0 Lessons</p>
                        </div>
                    </a>
                    @endforeach
             
            </div>
            
            <!-- Slider Pagination Controls -->
            @if($totalPages > 1)
            <div class="slider-pagination-controls">
                <button class="slider-btn" id="prevSliderBtn" onclick="slideTopics(-1)">❮</button>
                <span class="slider-counter"><span id="currentTopicsPage">1</span> / <span id="totalTopicsPages">{{ $totalPages }}</span></span>
                <button class="slider-btn" id="nextSliderBtn" onclick="slideTopics(1)">❯</button>
            </div>
            
            <!-- Slider Dots -->
            <div class="slider-dots" id="topicsSliderDots"></div>
            @endif

        </div>

        <!-- Progress Overview -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-20">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Progress</h2>
                <div class="flex gap-3">
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <button id="adminResetBtn" class="px-3 py-2 bg-gray-700 text-white rounded-lg text-sm hover:bg-gray-800" title="Admin: Reset all users' progress">Admin Reset</button>
                    @endif
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-4">
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Topics</p>
                    <p id="totalTopics" class="text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
                </div>
                <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Completed</p>
                    <p id="completedCount" class="text-3xl font-bold text-green-600 dark:text-green-400">0</p>
                </div>
                <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">In Progress</p>
                    <p id="inProgressCount" class="text-3xl font-bold text-purple-600 dark:text-purple-400">0</p>
                </div>
                <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Overall Progress</p>
                    <p id="overallProgress" class="text-3xl font-bold text-orange-600 dark:text-orange-400">0%</p>
                </div>
            </div>
        </div>

        <!-- Floating Footer Button -->
        <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 flex gap-4 z-40">
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
    <script>
        // Get current user ID from Laravel
        const CURRENT_USER_ID = {{ auth()->user()->id ?? 0 }};

        function isCompletedKeyPresent(slugToCheck) {
            try {
                // First check user-specific keys (new format)
                const userVariants = [
                    `user:${CURRENT_USER_ID}:lesson:${slugToCheck}:completed`,
                    `user:${CURRENT_USER_ID}:lesson:${slugToCheck.replace(/-/g, '')}:completed`,
                    `user:${CURRENT_USER_ID}:lesson:${slugToCheck.replace(/-/g, '_')}:completed`,
                    `user:${CURRENT_USER_ID}:lesson:${slugToCheck.toLowerCase()}:completed`
                ];
                for (const k of userVariants) {
                    const v = localStorage.getItem(k);
                    if (v === '1') return true;
                }
            } catch (e) {
                console.warn('localStorage not available when checking', slugToCheck, e);
            }
            return false;
        }

        // Clear old non-user-prefixed localStorage keys on first page load
        function clearOldLocalStorageKeys() {
            try {
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (!k) continue;
                    // Find old-format keys (lesson:...:completed) that are not user-prefixed
                    if (/^lesson:.+:completed$/.test(k) && !k.startsWith('user:')) {
                        keysToRemove.push(k);
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
                if (keysToRemove.length > 0) {
                    console.log(`Cleared ${keysToRemove.length} old localStorage keys for user isolation`);
                }
            } catch (e) {
                console.warn('Error clearing old localStorage keys', e);
            }
        }

        function computeTopicProgress() {
            const topicEls = document.querySelectorAll('[data-lesson]');
            const total = topicEls.length;
            let completed = 0;
            const firstLesson = 'pag-papakilala-sa-sarili';

            // Define lesson sequence for unlocking
            const lessonSequence = [
                'pag-papakilala-sa-sarili',           // Lesson 1
                'bahagi-ng-katawan',                   // Lesson 2
                'mga-kulay',                           // Lesson 3
                'pag-papakilala-sa-ibat-ibang-uri-ng-tunog', // Lesson 4
                'mga-hugis',                           // Lesson 5
                'mga-kasapi-ng-aking-pamilya',        // Lesson 6
            ];

            // Fetch progress from DB with cache busting
            fetch("{{ route('lesson.progress') }}?t=" + Date.now())
                .then(r => r.json())
                .then(dbProgress => {
                    console.log('Progress fetched:', dbProgress);
                    topicEls.forEach(el => {
                        const slug = el.getAttribute('data-lesson');
                        const fill = el.querySelector('.topic-progress-fill');
                        const text = el.querySelector('.topic-progress-text');
                        const badge = el.querySelector('.topic-completed-badge');
                        const lockBadge = el.querySelector('.topic-lock-badge');
                        if (!fill || !text) return;

                        // Check DB progress
                        const dbRecord = dbProgress[slug];
                        const isCompleted = dbRecord?.completed;

                        // First lesson starts unlocked
                        if (slug === firstLesson) {
                            if (isCompleted) {
                                fill.style.width = '100%';
                                text.textContent = '100% Complete • 1 Lesson';
                                if (badge) badge.classList.remove('hidden');
                                if (lockBadge) lockBadge.classList.add('hidden');
                                completed++;
                            } else {
                                fill.style.width = '0%';
                                text.textContent = '0% Complete • 0 Lessons';
                                if (badge) badge.classList.add('hidden');
                                if (lockBadge) lockBadge.classList.add('hidden');
                            }
                            el.style.pointerEvents = 'auto';
                            el.style.opacity = '1';
                            return;
                        }

                        // Check if this lesson's prerequisite is completed
                        const lessonIndex = lessonSequence.indexOf(slug);
                        let isUnlocked = false;

                        if (lessonIndex > 0) {
                            const previousLesson = lessonSequence[lessonIndex - 1];
                            const previousRecord = dbProgress[previousLesson];
                            isUnlocked = previousRecord?.completed;
                        }

                        // Apply lock state or completion state
                        if (isCompleted) {
                            fill.style.width = '100%';
                            text.textContent = '100% Complete • 1 Lesson';
                            el.classList.add('opacity-80');
                            if (badge) badge.classList.remove('hidden');
                            if (lockBadge) lockBadge.classList.add('hidden');
                            el.style.pointerEvents = 'auto';
                            el.style.opacity = '1';
                            completed++;
                        } else if (isUnlocked) {
                            // Prerequisite is completed, so this lesson is unlocked
                            fill.style.width = '0%';
                            text.textContent = '0% Complete • 0 Lessons';
                            if (badge) badge.classList.add('hidden');
                            if (lockBadge) lockBadge.classList.add('hidden');
                            el.classList.remove('opacity-80');
                            el.style.pointerEvents = 'auto';
                            el.style.opacity = '1';
                        } else {
                            // Lesson is locked
                            fill.style.width = '0%';
                            text.textContent = '0% Complete • 0 Lessons';
                            if (badge) badge.classList.add('hidden');
                            if (lockBadge) lockBadge.classList.remove('hidden');
                            el.classList.remove('opacity-80');
                            el.style.pointerEvents = 'none';
                            el.style.opacity = '0.6';
                        }
                    });

                    const inProgress = total - completed;
                    const overall = total ? Math.round((completed / total) * 100) : 0;

                    const totalEl = document.getElementById('totalTopics');
                    const completedEl = document.getElementById('completedCount');
                    const inProgressEl = document.getElementById('inProgressCount');
                    const overallEl = document.getElementById('overallProgress');

                    if (totalEl) totalEl.textContent = total;
                    if (completedEl) completedEl.textContent = completed;
                    if (inProgressEl) inProgressEl.textContent = inProgress;
                    if (overallEl) overallEl.textContent = overall + '%';
                })
                .catch(err => {
                    console.warn('Could not fetch DB progress, using localStorage:', err);
                    // Fallback: recompute with localStorage only
                    topicEls.forEach(el => {
                        const slug = el.getAttribute('data-lesson');
                        const fill = el.querySelector('.topic-progress-fill');
                        const text = el.querySelector('.topic-progress-text');
                        const badge = el.querySelector('.topic-completed-badge');
                        const lockBadge = el.querySelector('.topic-lock-badge');
                        if (!fill || !text) return;

                        // First lesson is always unlocked
                        if (slug === firstLesson) {
                            fill.style.width = '0%';
                            text.textContent = '0% Complete • 0 Lessons';
                            if (badge) badge.classList.add('hidden');
                            if (lockBadge) lockBadge.classList.add('hidden');
                            el.style.pointerEvents = 'auto';
                            el.style.opacity = '1';
                            return;
                        }

                        if (isCompletedKeyPresent(slug)) {
                            fill.style.width = '100%';
                            text.textContent = '100% Complete • 1 Lesson';
                            el.classList.add('opacity-80');
                            if (badge) badge.classList.remove('hidden');
                            if (lockBadge) lockBadge.classList.add('hidden');
                            el.style.pointerEvents = 'auto';
                            el.style.opacity = '1';
                            completed++;
                        } else {
                            fill.style.width = '0%';
                            text.textContent = '0% Complete • 0 Lessons';
                            if (badge) badge.classList.add('hidden');
                            if (lockBadge) lockBadge.classList.remove('hidden');
                            el.classList.remove('opacity-80');
                            el.style.pointerEvents = 'none';
                            el.style.opacity = '0.6';
                        }
                    });

                    const inProgress = total - completed;
                    const overall = total ? Math.round((completed / total) * 100) : 0;

                    const totalEl = document.getElementById('totalTopics');
                    const completedEl = document.getElementById('completedCount');
                    const inProgressEl = document.getElementById('inProgressCount');
                    const overallEl = document.getElementById('overallProgress');

                    if (totalEl) totalEl.textContent = total;
                    if (completedEl) completedEl.textContent = completed;
                    if (inProgressEl) inProgressEl.textContent = inProgress;
                    if (overallEl) overallEl.textContent = overall + '%';
                });
        }

        function resetAllProgress() {
            if (!confirm('Reset all local progress? This cannot be undone.')) return;
            try {
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (!k) continue;
                    if (/^lesson:.+:completed$/.test(k) || /^lesson[\w\-_:]*completed$/.test(k)) {
                        keysToRemove.push(k);
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
            } catch (e) {
                console.warn('Error clearing localStorage', e);
            }
            computeTopicProgress();
            alert('Progress reset.');
        }

        function resetAllProgressAdmin() {
            if (!confirm('Reset progress for ALL USERS? This affects the server and cannot be undone.')) return;
            fetch("{{ route('admin.reset-all-progress') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.error) {
                    alert('Admin reset failed: ' + data.error);
                } else {
                    alert('Admin reset: ' + data.message);
                    window.location.reload();
                }
            })
            .catch(err => console.error('Admin reset error:', err));
        }

        document.addEventListener('DOMContentLoaded', function () {
            computeTopicProgress();
            const btn = document.getElementById('resetProgressBtn');
            if (btn) btn.addEventListener('click', resetAllProgress);
            
            const adminBtn = document.getElementById('adminResetBtn');
            if (adminBtn) adminBtn.addEventListener('click', resetAllProgressAdmin);
            
            // Initialize topic slider
            initializeTopicSlider();
        });

        // Topic Slider Functions
        let currentTopicPage = 1;
        let totalTopicPages = {{ $totalPages }};
        let topicsPerPage = 6;
        let slideDirection = 1;

        function initializeTopicSlider() {
            const totalPages = parseInt(document.getElementById('totalTopicsPages')?.textContent || '1');
            totalTopicPages = totalPages;
            
            // Create dots
            const dotsContainer = document.getElementById('topicsSliderDots');
            if (dotsContainer) {
                dotsContainer.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'slider-dot' + (i === 1 ? ' active' : '');
                    dot.onclick = () => goToTopicPage(i);
                    dotsContainer.appendChild(dot);
                }
            }
            
            // Show only first page items initially
            displayTopicPage(1);
        }

        function slideTopics(direction) {
            const nextPage = currentTopicPage + direction;
            
            if (nextPage < 1 || nextPage > totalTopicPages) {
                return;
            }
            
            slideDirection = direction;
            const cards = document.querySelectorAll('.topic-card');
            
            // Add slide out animation
            cards.forEach(card => {
                card.classList.add(direction === 1 ? 'slide-out' : 'slide-out-right');
            });
            
            setTimeout(() => {
                currentTopicPage = nextPage;
                displayTopicPage(nextPage);
                updateTopicSliderUI();
            }, 500);
        }

        function goToTopicPage(pageNum) {
            if (pageNum === currentTopicPage) return;
            
            slideDirection = pageNum > currentTopicPage ? 1 : -1;
            const cards = document.querySelectorAll('.topic-card');
            
            // Add slide out animation
            cards.forEach(card => {
                card.classList.add(slideDirection === 1 ? 'slide-out' : 'slide-out-right');
            });
            
            setTimeout(() => {
                currentTopicPage = pageNum;
                displayTopicPage(pageNum);
                updateTopicSliderUI();
            }, 500);
        }

        function displayTopicPage(pageNum) {
            const cards = document.querySelectorAll('.topic-card');
            const startIndex = (pageNum - 1) * topicsPerPage;
            const endIndex = startIndex + topicsPerPage;
            
            cards.forEach((card, index) => {
                if (index >= startIndex && index < endIndex) {
                    card.classList.remove('hidden', 'slide-out', 'slide-out-right');
                    card.classList.add(slideDirection === 1 ? 'slide-in-left' : 'slide-in-right');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        function updateTopicSliderUI() {
            // Update counter
            const counterEl = document.getElementById('currentTopicsPage');
            if (counterEl) {
                counterEl.textContent = currentTopicPage;
            }
            
            // Update dots
            const dots = document.querySelectorAll('.slider-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentTopicPage - 1);
            });
            
            // Update button states
            const prevBtn = document.getElementById('prevSliderBtn');
            const nextBtn = document.getElementById('nextSliderBtn');
            if (prevBtn) prevBtn.disabled = currentTopicPage === 1;
            if (nextBtn) nextBtn.disabled = currentTopicPage === totalTopicPages;
        }

        // Initialize slider UI on load
        document.addEventListener('DOMContentLoaded', function() {
            clearOldLocalStorageKeys(); // Clear old non-user-prefixed keys
            currentTopicPage = 1;
            updateTopicSliderUI();
            initializeTopicSlider();
        });

        // Refresh progress when user returns to this page from a lesson
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                console.log('Page became visible, refreshing progress...');
                computeTopicProgress();
            }
        });
    </script>
</x-layouts::app>
