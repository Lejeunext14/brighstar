<x-layouts::app :title="__('Pag Papakilala sa Sarili - Interactive Lesson')">
    <style>
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .bounce-animation {
            animation: bounce 0.6s infinite;
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
            /* gentle floating for speech bubbles */
            .bubble-float {
                animation: float 3.2s ease-in-out infinite;
            }
            .bubble-float.delay {
                animation-delay: 0.45s;
            }
        .interactive-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .interactive-card:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        }
        .star-rating {
            font-size: 2rem;
        }
    </style>

    <div class="w-full">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-pink-50 via-purple-50 to-blue-50 p-8 dark:border-neutral-700 dark:from-pink-900/20 dark:via-purple-900/20 dark:to-blue-900/20 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2 float-animation">
                        🌟 Pag Papakilala sa Sarili 🌟
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300">Learn about yourself and have fun! Let's introduce yourself to the world!</p>
                </div>
                <div class="text-6xl float-animation">👋</div>
            </div>
        </div>

        <!-- Interactive Introduction Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-0 dark:border-neutral-700 dark:bg-neutral-900 mb-6 overflow-hidden flex items-center justify-center relative" id="introSection">
            <img src="/image/paguusap.png" alt="Pag Papakilala sa Sarili" class="w-full h-auto object-contain">
            <!-- Speech Bubble Right -->
                <div class="absolute right-4 top-1/6 transform -translate-y-1/2 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/40 rounded-2xl shadow-lg p-5 max-w-xs border-3 border-blue-500 bubble-float delay">
                <p class="text-blue-900 dark:text-blue-200 font-bold text-lg mb-2 rightBubbleTitle">Kumusta, kaibigan! 👋</p>
                <p class="text-blue-700 dark:text-blue-300 text-sm rightBubbleText">Ako si Lejeune Darry! Samahan mo akong matutunan kung paano magpakilala ng sarili. Excited ka na ba? 🌟</p>
            </div>
            <!-- Speech Bubble Left -->
                <div class="absolute left-4 top-1/6 transform -translate-y-1/2 bg-gradient-to-br from-pink-100 to-pink-200 dark:from-pink-900/40 dark:to-pink-800/40 rounded-2xl shadow-lg p-5 max-w-xs border-3 border-pink-500 bubble-float">
                <p class="text-pink-900 dark:text-pink-200 font-bold text-lg mb-2 leftBubbleTitle">Halo! 😊</p>
                <p class="text-pink-700 dark:text-pink-300 text-sm leftBubbleText">Ako naman si Eka! Masaya akong makilahok sa araling ito kasama ninyo lahat! 💕</p>
            </div>
            <!-- Navigation Buttons -->
            <div class="absolute bottom-4 left-0 right-0 flex justify-between px-4">
                <button id="prevBtn" onclick="previousSlide()" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg font-bold transition-all">
                    ← Previous
                </button>
                <div class="flex gap-2">
                    <button id="nextBtn" onclick="nextSlide()" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-bold transition-all">
                        Next →
                    </button>
                    <button id="finishBtn" onclick="completeLesson()" class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-bold transition-all hidden">
                        ✅ Finish
                    </button>
                </div>
            </div>
        </div>

        <!-- Interactive Activities Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6" id="activitiesSection">
            <div class="flex justify-center">
                <!-- Activity 1: Name Game -->
                <div class="interactive-card rounded-lg border-2 border-blue-400 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-8 w-full max-w-md">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white activityTitle">Ang Iyong Pangalan 📝</h3>
                        <span class="text-4xl activityEmoji">✨</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 activityDescription">Isulat ang iyong pangalan at marinig kung paano ito nauusap!</p>
                    <input type="text" placeholder="Isulat ang iyong pangalan..." class="w-full px-4 py-2 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:outline-none mb-3 activityInput" id="nameInput">
                    <button onclick="handleActivityAction()" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 rounded-lg font-bold hover:shadow-lg transition-all pulse-animation activityButton">
                        🔊 Marinig ang Iyong Pangalan!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Finish Modal (hidden by default) -->
    <div id="finishModal" class="fixed inset-0 hidden flex items-center justify-center bg-black/50 z-50">
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 max-w-md w-full text-center shadow-lg border-2 border-yellow-300">
            <div class="text-6xl mb-4">⭐</div>
            <h3 class="text-2xl font-bold mb-2">Mahusay! 🎉</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Napakagaling mo! Natapos mo na ang aralan at nakakuha ka ng +50 puntos at 1 badge.</p>
            <div class="flex justify-center gap-4">
                <button onclick="closeFinishModal()" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg font-bold">Cancel</button>
                <button onclick="finishConfirm()" class="px-6 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-lg font-bold">OK</button>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slides = [
            {
                leftTitle: 'Halo! 😊',
                leftText: 'Ako naman si Eka! Masaya akong makilahok sa araling ito kasama ninyo lahat! 💕',
                rightTitle: 'Kumusta, kaibigan! 👋',
                rightText: 'Ako si Lejeune Darry! Samahan mo akong matutunan kung paano magpakilala ng sarili. Excited ka na ba? 🌟',
                activityTitle: 'Ang Iyong Pangalan 📝',
                activityEmoji: '✨',
                activityDescription: 'Isulat ang iyong pangalan at marinig kung paano ito nauusap!',
                activityPlaceholder: 'Isulat ang iyong pangalan...',
                activityButtonText: '🔊 Marinig ang Iyong Pangalan!'
            },
            {
                leftTitle: 'Ako ay si Eka! 👧',
                leftText: 'Ako ay 6 taong gulang. Mahal ko ang pagbabasa at paglalaro! 📚🎮',
                rightTitle: 'At ako ay si Lejeune Darry! 👦',
                rightText: 'Ako ay 7 taong gulang. Mahal ko ang paglalaro at ang sports! ⚽🏃',
                activityTitle: 'Ang Iyong Edad 🎂',
                activityEmoji: '🎉',
                activityDescription: 'Isulat ang iyong edad at sabihin kung gaano kalaki ka na!',
                activityPlaceholder: 'Isulat ang iyong edad...',
                activityButtonText: '🔊 Marinig ang Iyong Edad!'
            },
            {
                leftTitle: 'Nakatira ako sa Maynila! 🏠',
                leftText: 'Ang aking tahanan ay napakaganda! May malaking hardin at masayang mga kaibigan sa aming barangay! 🌳👨‍👩‍👧‍👦',
                rightTitle: 'Ako naman ay nakatira sa Quezon City! 🏘️',
                rightText: 'Ang aming lugar ay puno ng mga puno at napakagandang parks kung saan ako naglalaro! 🌲🎪',
                activityTitle: 'Ang Iyong Tirahan 🏡',
                activityEmoji: '🌍',
                activityDescription: 'Sabihin kung saan ka nakatira at ano ang maganda sa iyong lugar!',
                activityPlaceholder: 'Sabihin kung saan ka nakatira...',
                activityButtonText: '🔊 Marinig kung saan ka nakatira!'
            }
        ];

        function nextSlide() {
            if (currentSlide < slides.length - 1) {
                currentSlide++;
                updateSlide();
            }
        }

        function previousSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlide();
            }
        }

        function updateSlide() {
            const slide = slides[currentSlide];
            document.querySelector('.leftBubbleTitle').textContent = slide.leftTitle;
            document.querySelector('.leftBubbleText').textContent = slide.leftText;
            document.querySelector('.rightBubbleTitle').textContent = slide.rightTitle;
            document.querySelector('.rightBubbleText').textContent = slide.rightText;
            document.querySelector('.activityTitle').textContent = slide.activityTitle;
            document.querySelector('.activityEmoji').textContent = slide.activityEmoji;
            document.querySelector('.activityDescription').textContent = slide.activityDescription;
            document.querySelector('.activityInput').placeholder = slide.activityPlaceholder;
            document.querySelector('.activityButton').textContent = slide.activityButtonText;
            document.getElementById('nameInput').value = '';

            // toggle navigation controls
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const finishBtn = document.getElementById('finishBtn');

            if (currentSlide === 0) {
                prevBtn.classList.add('opacity-50');
                prevBtn.disabled = true;
            } else {
                prevBtn.classList.remove('opacity-50');
                prevBtn.disabled = false;
            }

            if (currentSlide === slides.length - 1) {
                nextBtn.classList.add('hidden');
                finishBtn.classList.remove('hidden');
            } else {
                nextBtn.classList.remove('hidden');
                finishBtn.classList.add('hidden');
            }
        }

        function handleActivityAction() {
            if (currentSlide === 0) {
                playName();
            } else if (currentSlide === 1) {
                playAge();
            } else if (currentSlide === 2) {
                playLocation();
            }
        }

        function playName() {
            const nameInput = document.getElementById('nameInput');
            const name = nameInput.value || 'Kaibigan';
            const utterance = new SpeechSynthesisUtterance(`ako si ${name}!`);
            utterance.lang = 'fil-PH';
            window.speechSynthesis.speak(utterance);
        }

        function playAge() {
            const ageInput = document.getElementById('nameInput');
            const age = ageInput.value || '5';
            const utterance = new SpeechSynthesisUtterance(`I am ${age} years old!`);
            utterance.lang = 'fil-PH';
            window.speechSynthesis.speak(utterance);
        }

        function playLocation() {
            const locationInput = document.getElementById('nameInput');
            const location = locationInput.value || 'sa aking tahanan';
            const utterance = new SpeechSynthesisUtterance(`I live in ${location}!`);
            utterance.lang = 'fil-PH';
            window.speechSynthesis.speak(utterance);
        }

        function completeLesson() {
            // Get CSRF token safely
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            
            // Mark lesson as complete via API
            fetch('{{ route("lesson.mark-complete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    lesson_slug: 'pag-papakilala-sa-sarili'
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // show modal instead of alert
                const modal = document.getElementById('finishModal');
                if (modal) modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking lesson as complete: ' + error.message);
            });
        }

        function closeFinishModal() {
            const modal = document.getElementById('finishModal');
            if (modal) modal.classList.add('hidden');
        }

        function finishConfirm() {
            closeFinishModal();
            // redirect after brief pause to let user see the modal closing
            setTimeout(() => {
                window.location.href = '{{ route("subject.topics", ["subject" => "filipino"]) }}';
            }, 300);
        }

        // initialize
        document.addEventListener('DOMContentLoaded', () => {
            updateSlide();
        });
    </script>
</x-layouts::app>
