<x-layouts::app :title="__('Abakada Game')">
    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .fullscreen-game {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: url('{{ asset("/image/classroom.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            padding: 0;
            margin: 0;
        }

        .game-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .game-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            width: 100%;
            max-width: 900px;
        }

        .letter-display {
            background: linear-gradient(135deg, #fff5e6 0%, #ffe8cc 100%);
            padding: 30px 40px;
            border-radius: 25px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
        }

        .current-letter {
            font-size: clamp(60px, 15vw, 120px);
            font-weight: bold;
            color: #667eea;
            margin: 15px 0;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.1);
        }

        .letter-name {
            font-size: clamp(20px, 5vw, 32px);
            color: #764ba2;
            font-weight: bold;
        }

        .letter-label {
            font-size: clamp(12px, 3vw, 14px);
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .progress-section {
            width: 100%;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .progress-bar {
            height: 10px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4ade80 0%, #22c55e 100%);
            transition: width 0.3s ease;
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.5);
        }

        .progress-text {
            color: white;
            font-size: clamp(12px, 3vw, 14px);
            text-align: center;
            font-weight: bold;
        }

        .letter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
            gap: 8px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .letter-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 6px;
            }
        }

        @media (max-width: 480px) {
            .letter-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 4px;
            }
        }

        .letter-card {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(18px, 4vw, 32px);
            font-weight: bold;
            background: linear-gradient(135deg, #ffd89b 0%, #ffb347 100%);
            border: 2px solid transparent;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            color: #333;
            min-width: 45px;
        }

        .score-display {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.95);
            padding: 12px 24px;
            border-radius: 20px;
            font-size: clamp(18px, 4vw, 24px);
            font-weight: bold;
            color: #667eea;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            z-index: 100;
        }

        .music-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            padding: 12px 16px;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .music-btn:hover {
            transform: scale(1.1);
        }

        .letter-card:hover,
        .letter-card:active {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border-color: #667eea;
        }

        .letter-card:active {
            transform: scale(0.95);
        }

        .letter-card.correct {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            color: white;
            animation: pulse 0.6s ease;
            border-color: #15803d;
        }

        .letter-card.incorrect {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
            animation: shake 0.5s ease;
            border-color: #7f1d1d;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        .completion-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
            padding: 20px;
        }

        .completion-modal.hidden {
            display: none;
        }

        .modal-content {
            background: linear-gradient(135deg, #fff5e6 0%, #ffe8cc 100%);
            padding: clamp(30px, 8vw, 50px) clamp(20px, 5vw, 40px);
            border-radius: 25px;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
            max-width: 90vw;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-emoji {
            font-size: clamp(50px, 15vw, 80px);
            margin-bottom: 15px;
            animation: bounce 1s ease infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .modal-title {
            font-size: clamp(24px, 6vw, 36px);
            font-weight: bold;
            color: #667eea;
            margin-bottom: 12px;
        }

        .modal-text {
            font-size: clamp(14px, 4vw, 18px);
            color: #555;
            margin-bottom: 15px;
        }

        .stars {
            font-size: clamp(30px, 8vw, 50px);
            letter-spacing: 5px;
            margin: 20px 0;
        }

        .final-score {
            font-size: clamp(20px, 5vw, 32px);
            font-weight: bold;
            color: #764ba2;
            margin-bottom: 20px;
        }

        .modal-btn {
            width: 100%;
            padding: clamp(12px, 3vw, 15px);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: clamp(16px, 4vw, 18px);
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .modal-btn:hover,
        .modal-btn:active {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.6);
        }

        /* Tablet and larger */
        @media (min-width: 769px) {
            .game-header {
                padding: 20px 40px;
            }

            .game-main {
                padding: 40px;
                gap: 40px;
            }

            .letter-grid {
                grid-template-columns: repeat(8, 1fr);
                gap: 12px;
            }
        }

        /* Small phones */
        @media (max-width: 380px) {
            .game-header {
                padding: 10px 12px;
                gap: 10px;
            }

            .action-btn {
                min-width: 80px;
                padding: 8px 12px;
            }

            .letter-display {
                padding: 20px 25px;
            }
        }
    </style>

    <div class="fullscreen-game">
        <!-- Background Music -->
        <audio id="bgMusic" loop preload="auto">
            <source src="https://cdn.pixabay.com/download/audio/2022/03/10/audio_6d87df0b6d.mp3" type="audio/mpeg">
        </audio>

        <!-- Correct Answer Sound -->
        <audio id="correctSound">
            <source src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" type="audio/mpeg">
        </audio>

        <!-- Music Control Button -->
        <button class="music-btn" id="musicBtn" onclick="toggleMusic()">🔊</button>

        <!-- Score Display -->
        <div class="score-display">Score: <span id="scoreDisplay">0</span></div>

        <!-- Main Game Area -->
        <div class="game-main">

            <!--        Progress: <span id="progressText">0/16</span>
                    </div>
                </div>

                <!-- Letter Display -->
                <div class="letter-display">
                    <div class="letter-label">Find the letter:</div>
                    <div class="current-letter" id="currentLetter">A</div>
                    <div class="letter-name" id="letterName">Ay</div>
                </div>

                <!-- Letters Grid -->
                <div class="letter-grid">
                    <div class="letter-card" data-letter="A">A</div>
                    <div class="letter-card" data-letter="B">B</div>
                    <div class="letter-card" data-letter="K">K</div>
                    <div class="letter-card" data-letter="D">D</div>
                    <div class="letter-card" data-letter="E">E</div>
                    <div class="letter-card" data-letter="G">G</div>
                    <div class="letter-card" data-letter="H">H</div>
                    <div class="letter-card" data-letter="I">I</div>
                    <div class="letter-card" data-letter="L">L</div>
                    <div class="letter-card" data-letter="M">M</div>
                    <div class="letter-card" data-letter="N">N</div>
                    <div class="letter-card" data-letter="O">O</div>
                    <div class="letter-card" data-letter="P">P</div>
                    <div class="letter-card" data-letter="R">R</div>
                    <div class="letter-card" data-letter="S">S</div>
                    <div class="letter-card" data-letter="T">T</div>
                </div>
            </div>
        </div>

        <!-- Completion Modal -->
        <div id="completionModal" class="completion-modal hidden">
            <div class="modal-content">
                <div class="modal-emoji">🎉</div>
                <div class="modal-title">Excellent Work!</div>
                <div class="modal-text">You've learned all the Abakada letters!</div>
                <div class="stars" id="starDisplay">⭐⭐⭐</div>
                <div class="final-score">Final Score: <span id="finalScore">0</span></div>
                <button onclick="exitGame()" class="modal-btn">Tapos na 🎮</button>
            </div>
        </div>
    </div>

    <script>
        const abakadaLetters = [
            { letter: 'A', name: 'Ah' },
            { letter: 'B', name: 'Ba' },
            { letter: 'K', name: 'Ka' },
            { letter: 'D', name: 'Da' },
            { letter: 'E', name: 'E' },
            { letter: 'G', name: 'Ga' },
            { letter: 'H', name: 'Ha' },
            { letter: 'I', name: 'I' },
            { letter: 'L', name: 'La' },
            { letter: 'M', name: 'Ma' },
            { letter: 'N', name: 'Na' },
            { letter: 'O', name: 'O' },
            { letter: 'P', name: 'Pa' },
            { letter: 'R', name: 'Ra' },
            { letter: 'S', name: 'Sa' },
            { letter: 'T', name: 'Ta' }
        ];

        let currentIndex = 0;
        let score = 0;
        let musicPlaying = true;

        function toggleMusic() {
            const audio = document.getElementById('bgMusic');
            const btn = document.getElementById('musicBtn');
            
            if (musicPlaying) {
                audio.pause();
                btn.textContent = '🔇';
                musicPlaying = false;
            } else {
                audio.play();
                btn.textContent = '🔊';
                musicPlaying = true;
            }
        }

        function playMusic() {
            const audio = document.getElementById('bgMusic');
            audio.play().catch(err => {
                console.log('Autoplay prevented or music file not found');
            });
        }

        function shuffleLetters() {
            const cards = Array.from(document.querySelectorAll('.letter-card'));
            
            // Fisher-Yates shuffle algorithm
            for (let i = cards.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                // Swap both innerHTML and data-letter attribute
                const tempText = cards[i].innerHTML;
                const tempLetter = cards[i].dataset.letter;
                
                cards[i].innerHTML = cards[j].innerHTML;
                cards[i].dataset.letter = cards[j].dataset.letter;
                
                cards[j].innerHTML = tempText;
                cards[j].dataset.letter = tempLetter;
            }
            
            // Reattach event listeners after shuffle
            attachCardListeners();
        }

        function attachCardListeners() {
            document.querySelectorAll('.letter-card').forEach(card => {
                // Remove old listeners by cloning
                const newCard = card.cloneNode(true);
                card.parentNode.replaceChild(newCard, card);
            });

            document.querySelectorAll('.letter-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    // Prevent multiple clicks while processing
                    if (this.dataset.processing === 'true') return;
                    this.dataset.processing = 'true';

                    const selectedLetter = this.dataset.letter;
                    const correctLetter = abakadaLetters[currentIndex].letter;

                    if (selectedLetter === correctLetter) {
                        this.classList.add('correct');
                        score += 100;
                        document.getElementById('scoreDisplay').textContent = score;
                        
                        // Play correct sound
                        const correctSound = document.getElementById('correctSound');
                        correctSound.currentTime = 0;
                        correctSound.play().catch(err => console.log('Sound play error'));
                        
                        setTimeout(() => {
                            currentIndex++;
                            if (currentIndex < abakadaLetters.length) {
                                resetCardStyles();
                                updateDisplay();
                                shuffleLetters();
                            } else {
                                showCompletion();
                            }
                        }, 800);
                    } else {
                        this.classList.add('incorrect');
                        score = Math.max(0, score - 10);
                        document.getElementById('scoreDisplay').textContent = score;
                        setTimeout(() => {
                            this.classList.remove('incorrect');
                            // Re-enable clicking after animation
                            document.querySelectorAll('.letter-card').forEach(c => {
                                c.dataset.processing = 'false';
                            });
                        }, 500);
                    }
                });
            });
        }

        function updateDisplay() {
            const current = abakadaLetters[currentIndex];
            document.getElementById('currentLetter').textContent = current.letter;
            document.getElementById('letterName').textContent = current.name;
        }

        function initGame() {
            currentIndex = 0;
            score = 0;
            document.getElementById('scoreDisplay').textContent = '0';
            updateDisplay();
            resetCardStyles();
            attachCardListeners();
            shuffleLetters();
            playMusic();
        }

        function resetCardStyles() {
            document.querySelectorAll('.letter-card').forEach(card => {
                card.classList.remove('correct', 'incorrect');
                card.style.pointerEvents = 'auto';
            });
        }

        function skipLetter() {
            currentIndex++;
            if (currentIndex < abakadaLetters.length) {
                resetCardStyles();
                updateDisplay();
                shuffleLetters();
            } else {
                showCompletion();
            }
        }

        function showCompletion() {
            const modal = document.getElementById('completionModal');
            const starCount = score >= 1400 ? 3 : score >= 900 ? 2 : 1;
            document.getElementById('finalScore').textContent = score;
            document.getElementById('starDisplay').textContent = '⭐'.repeat(starCount);
            modal.classList.remove('hidden');
        }

        function resetGame() {
            document.getElementById('completionModal').classList.add('hidden');
            initGame();
        }

        function exitGame() {
            window.location.href = "{{ route('subject.games', ['subject' => 'filipino']) }}";
        }

        // Initialize game on page load
        document.addEventListener('DOMContentLoaded', initGame);
    </script>
</x-layouts::app>