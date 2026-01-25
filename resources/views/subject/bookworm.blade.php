<x-layouts::app :title="__('Book Worm Game')">
    <div class="w-full">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-blue-50 to-green-50 p-8 dark:border-neutral-700 dark:from-blue-900/20 dark:to-green-900/20 mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">
                    📚 Book Worm Game
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Help the worm defeat enemies by completing words!</p>
            </div>
        </div>

        <!-- Game Arena -->
        <div class="rounded-xl border border-neutral-200 bg-white p-0 dark:border-neutral-700 dark:bg-neutral-900 mb-6 overflow-hidden">
            <!-- Game Background -->
            <div id="gameArena" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-image: url('/image/classroom.jpg'); background-size: cover; background-position: center 85%; min-height: 700px; position: relative; overflow: hidden;">

                <!-- Audio Effects -->
                <audio id="fireballThrowSound" preload="auto">
                    <source src="data:audio/wav;base64,UklGRiYAAABXQVZFZm10IBAAAAABAAEAQB8AAAB9AAACABAAZGF0YQIAAAAAAA==" type="audio/wav">
                </audio>
                <audio id="fireballImpactSound" preload="auto">
                    <source src="data:audio/wav;base64,UklGRiYAAABXQVZFZm10IBAAAAABAAEAQB8AAAB9AAACABAAZGF0YQIAAAAAAA==" type="audio/wav">
                </audio>
                <audio id="backgroundMusic" preload="auto" loop volume="0.3">
                    <source src="/sounds/background-music.mp3" type="audio/mpeg">
                </audio>

                <!-- Fireball Effect -->
                <div id="fireball">🔥</div>
                <div id="enemyFireball">🔥</div>

                <!-- Character Name and Health (Upper Left) -->
                <div style="position: absolute; left: 20px; top: 20px; z-index: 10;">
                    <div style="padding: 8px 16px; background: rgba(16, 185, 129, 0.9); border-radius: 20px; border: 2px solid white; color: white; font-weight: bold; font-size: 14px; box-shadow: 0 4px 8px rgba(0,0,0,0.3); text-align: center; margin-bottom: 10px;">{{ auth()->user()->name }}</div>
                    <div style="width: 150px; height: 28px; background: #1f2937; border-radius: 14px; overflow: hidden; border: 3px solid white; box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);">
                        <div id="playerHealth" style="width: 100%; height: 100%; background: linear-gradient(90deg, #10b981 0%, #34d399 100%); transition: width 0.4s ease; box-shadow: inset 0 0 8px rgba(255,255,255,0.4);"></div>
                    </div>
                    <div style="text-align: center; color: white; font-weight: bold; margin-top: 8px; font-size: 12px;">HP: <span id="playerHealthText">100</span>/100</div>
                </div>

                <!-- Character Container (Image) -->
                <div style="position: absolute; left: 250px; top: 25%; z-index: 10; width: 250px;">
                    <div style="text-align: center; position: relative;">
                        <img id="characterImage" src="/character/bookcharacter.png" alt="BookWorm Hero" style="width: 250px; height: auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); transition: all 0.3s ease;" />
                    </div>
                </div>

                <!-- Enemy Name and Health (Upper Right) -->
                <div style="position: absolute; right: 20px; top: 20px; z-index: 10; text-align: right;">
                    <div style="padding: 8px 16px; background: rgba(239, 68, 68, 0.9); border-radius: 20px; border: 2px solid white; color: white; font-weight: bold; font-size: 14px; box-shadow: 0 4px 8px rgba(0,0,0,0.3); text-align: center; margin-bottom: 10px;" id="enemyName">Word Bug</div>
                    <div style="width: 150px; height: 28px; background: #1f2937; border-radius: 14px; overflow: hidden; border: 3px solid white; box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);">
                        <div id="enemyHealth" style="width: 100%; height: 100%; background: linear-gradient(90deg, #ef4444 0%, #f87171 100%); transition: width 0.4s ease; box-shadow: inset 0 0 8px rgba(255,255,255,0.4);"></div>
                    </div>
                    <div style="text-align: center; color: white; font-weight: bold; margin-top: 8px; font-size: 12px;">HP: <span id="enemyHealthText">100</span>/100</div>
                </div>

                <!-- Enemy Container -->
                <div style="position: absolute; right: 250px; top: 25%; z-index: 10; width: 250px;">
                    <div style="text-align: center; position: relative;">
                        <img id="enemyDisplay" src="/character/enemybook.png" alt="Enemy" style="width: 250px; height: auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); transition: all 0.3s ease;" />
                    </div>
                </div>

                <!-- Game Info Display -->
                <div style="position: absolute; top: 20px; left: 50%; transform: translateX(-50%); display: flex; justify-content: center; gap: 15px; z-index: 5;">
                    <div style="background: rgba(0, 0, 0, 0.6); color: white; padding: 15px 25px; border-radius: 10px; font-weight: bold;">
                        Round: <span id="roundDisplay">1</span>/5
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.6); color: white; padding: 15px 25px; border-radius: 10px; font-weight: bold;">
                        Score: <span id="scoreDisplay">0</span>
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.6); color: white; padding: 15px 25px; border-radius: 10px; font-weight: bold;">
                        Combo: <span id="comboDisplay">0</span>
                    </div>
                </div>

                <!-- Game Controls Section (Centered in Arena) -->
                <div id="gameController" style="position: absolute; top: 85%; left: 50%; transform: translate(-50%, -50%); z-index: 8; max-width: 600px; width: 90%;">
                    <!-- Word Display -->
                    <div style="text-align: center; margin-bottom: 25px;">
                        <p style="color: white; margin-bottom: 15px; font-size: 18px; font-weight: bold; text-shadow: 0 2px 4px rgba(0,0,0,0.5);" id="hintText">Complete the word</p>
                        <div class="word-display" id="wordDisplay" style="justify-content: center;">
                            <!-- Word boxes will be generated here -->
                        </div>
                    </div>

                    <!-- Letter Options -->
                    <div class="letter-options" id="letterOptions" style="justify-content: center; margin-bottom: 25px;">
                        <!-- Letter buttons will be generated here -->
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 12px; justify-content: center; margin-bottom: 20px; flex-wrap: wrap;">
                        <button id="resetBtn" style="padding: 10px 20px; background: rgba(59, 130, 246, 0.9); color: white; border: 2px solid white; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                            🔄 Reset Word
                        </button>
                        <button id="hintBtn" style="padding: 10px 20px; background: rgba(234, 179, 8, 0.9); color: #000; border: 2px solid white; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                            💡 Hint (<span id="hintCount">3</span>)
                        </button>
                    </div>

                    <!-- Message Display -->
                    <div id="message" style="text-align: center; font-size: 18px; font-weight: bold; min-height: 30px; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></div>
                </div>
            </div>
        </div>

        <!-- Game Stats -->
        <div class="rounded-xl border border-neutral-200 bg-blue-50 dark:bg-blue-900/20 p-6 dark:border-neutral-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Game Info:</h3>
            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
                <li>Complete each word to damage the enemy and reduce their health</li>
                <li>Defeat all 5 enemies to win the game!</li>
                <li>Get hints to help you find the right letters</li>
                <li>Build your combo by completing words correctly in a row</li>
                <li>Each correct word grants you bonus points!</li>
            </ul>
        </div>
    </div>

    <style>
        .word-display {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .letter-box {
            width: 50px;
            height: 50px;
            border: 2px solid #ccc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            background-color: #f0f0f0;
            dark-mode: background-color: #1f2937;
        }

        .letter-box.filled {
            background-color: #3b82f6;
            color: white;
            border-color: #2563eb;
        }

        .letter-options {
            display: flex;
            justify-content: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .letter-btn {
            width: 45px;
            height: 45px;
            padding: 0;
            border: 2px solid #cbd5e1;
            border-radius: 6px;
            background-color: #f1f5f9;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.2s;
        }

        .letter-btn:hover {
            background-color: #e2e8f0;
            border-color: #94a3b8;
        }

        .letter-btn.used {
            background-color: #cbd5e1;
            color: #64748b;
            cursor: not-allowed;
        }

        .letter-btn.correct {
            background-color: #22c55e;
            color: white;
            border-color: #16a34a;
        }

        .correct-message {
            color: #22c55e;
        }

        .incorrect-message {
            color: #ef4444;
        }

        @keyframes character-attack {
            0% { transform: translateX(0) scale(1); }
            50% { transform: translateX(30px) scale(1.1); }
            100% { transform: translateX(0) scale(1); }
        }

        @keyframes enemy-attack {
            0% { transform: translateX(0) scaleX(-1); }
            50% { transform: translateX(-30px) scaleX(-1) scale(1.1); }
            100% { transform: translateX(0) scaleX(-1); }
        }

        @keyframes take-damage {
            0%, 100% { filter: drop-shadow(0 0 10px rgba(239, 68, 68, 0)); }
            50% { filter: drop-shadow(0 0 20px rgba(239, 68, 68, 0.8)); }
        }

        @keyframes heal-glow {
            0%, 100% { filter: drop-shadow(0 0 10px rgba(16, 185, 129, 0)); }
            50% { filter: drop-shadow(0 0 25px rgba(16, 185, 129, 0.9)); }
        }

        .character-attack {
            animation: character-attack 0.5s ease-in-out;
        }

        .enemy-attack {
            animation: enemy-attack 0.5s ease-in-out;
        }

        .take-damage {
            animation: take-damage 0.5s ease-in-out;
        }

        .heal-glow {
            animation: heal-glow 0.6s ease-in-out;
        }

        /* Character Image Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes bounce-attack {
            0% { transform: translateX(0) scale(1); }
            25% { transform: translateX(20px) scale(1.05); }
            50% { transform: translateX(0) scale(1); }
            100% { transform: translateX(0) scale(1); }
        }

        @keyframes character-shake {
            0%, 100% { transform: translateX(0) rotate(0deg); }
            25% { transform: translateX(-5px) rotate(-1deg); }
            75% { transform: translateX(5px) rotate(1deg); }
        }

        @keyframes character-glow {
            0%, 100% { filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); }
            50% { filter: drop-shadow(0 4px 15px rgba(16, 185, 129, 0.6)); }
        }

        @keyframes character-damage-glow {
            0%, 100% { filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); }
            50% { filter: drop-shadow(0 4px 15px rgba(239, 68, 68, 0.6)); }
        }

        #characterImage {
            animation: float 3s ease-in-out infinite;
        }

        #characterImage.attacking {
            animation: bounce-attack 0.6s ease-in-out;
        }

        #characterImage.damaged {
            animation: character-shake 0.4s ease-in-out;
        }

        #characterImage.victory {
            animation: character-glow 1s ease-in-out;
        }

        #enemyDisplay {
            animation: float 3s ease-in-out infinite;
        }

        #enemyDisplay.attacking {
            animation: bounce-attack 0.6s ease-in-out;
        }

        #enemyDisplay.damaged {
            animation: character-shake 0.4s ease-in-out;
        }

        /* Fireball Animation */
        @keyframes fireball-throw {
            0% {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1);
                filter: drop-shadow(0 0 10px #ff6b00);
            }
            50% {
                opacity: 1;
                filter: drop-shadow(0 0 20px #ff6b00) drop-shadow(0 0 30px #ff3300);
            }
            100% {
                opacity: 1;
                transform: translateX(500px) translateY(-30px) scale(1);
                filter: drop-shadow(0 0 20px #ff3300) drop-shadow(0 0 40px #ff0000);
            }
        }

        @keyframes fireball-impact {
            0% {
                opacity: 1;
                transform: scale(1);
                filter: drop-shadow(0 0 20px #ff6b00);
            }
            100% {
                opacity: 0;
                transform: scale(1.5);
                filter: drop-shadow(0 0 40px #ff3300) drop-shadow(0 0 60px #ff0000);
            }
        }

        #fireball {
            position: absolute;
            width: 40px;
            height: 40px;
            left: 280px;
            top: 38%;
            font-size: 40px;
            z-index: 9;
            pointer-events: none;
            display: none;
        }

        #fireball.throwing {
            display: block;
            animation: fireball-throw 0.6s ease-in-out forwards;
        }

        #fireball.impact {
            display: block;
            animation: fireball-impact 0.4s ease-out forwards;
        }

        /* Enemy Fireball Animation */
        @keyframes enemy-fireball-throw {
            0% {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1);
                filter: drop-shadow(0 0 10px #ff6b00);
            }
            50% {
                opacity: 1;
                filter: drop-shadow(0 0 20px #ff6b00) drop-shadow(0 0 30px #ff3300);
            }
            100% {
                opacity: 1;
                transform: translateX(-500px) translateY(-30px) scale(1);
                filter: drop-shadow(0 0 20px #ff3300) drop-shadow(0 0 40px #ff0000);
            }
        }

        @keyframes enemy-fireball-impact {
            0% {
                opacity: 1;
                transform: scale(1);
                filter: drop-shadow(0 0 20px #ff6b00);
            }
            100% {
                opacity: 0;
                transform: scale(1.5);
                filter: drop-shadow(0 0 40px #ff3300) drop-shadow(0 0 60px #ff0000);
            }
        }

        #enemyFireball {
            position: absolute;
            width: 40px;
            height: 40px;
            right: 280px;
            top: 38%;
            font-size: 40px;
            z-index: 9;
            pointer-events: none;
            display: none;
        }

        #enemyFireball.throwing {
            display: block;
            animation: enemy-fireball-throw 0.6s ease-in-out forwards;
        }

        #enemyFireball.impact {
            display: block;
            animation: enemy-fireball-impact 0.4s ease-out forwards;
        }

        /* Game Controller Hide Animation */
        @keyframes hide-controller {
            0% { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(0.8); }
        }

        @keyframes show-controller {
            0% { opacity: 0; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }

        #gameController {
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        #gameController.hiding {
            animation: hide-controller 0.4s ease-in-out forwards;
        }

        #gameController.showing {
            animation: show-controller 0.4s ease-in-out forwards;
        }
    </style>

    <script>
        // Sound effect generation using Web Audio API
        function playFireballThrowSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const now = audioContext.currentTime;
                
                // Create a whoosh sound with frequency sweep
                const osc = audioContext.createOscillator();
                const gain = audioContext.createGain();
                
                osc.type = 'sine';
                osc.frequency.setValueAtTime(800, now);
                osc.frequency.exponentialRampToValueAtTime(300, now + 0.15);
                
                gain.gain.setValueAtTime(0.3, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.15);
                
                osc.connect(gain);
                gain.connect(audioContext.destination);
                
                osc.start(now);
                osc.stop(now + 0.15);
            } catch(e) {
                console.log('Sound not available:', e);
            }
        }
        
        function playFireballImpactSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const now = audioContext.currentTime;
                
                // Create an impact/explosion sound
                const osc = audioContext.createOscillator();
                const gain = audioContext.createGain();
                
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(400, now);
                osc.frequency.exponentialRampToValueAtTime(50, now + 0.3);
                
                gain.gain.setValueAtTime(0.4, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.3);
                
                osc.connect(gain);
                gain.connect(audioContext.destination);
                
                osc.start(now);
                osc.stop(now + 0.3);
            } catch(e) {
                console.log('Sound not available:', e);
            }
        }

        function playBackgroundMusic() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                
                // Create a looping background music generator
                const tempo = 1.5; // beats per second
                
                // Bass line
                function playBass(startTime) {
                    const bass = audioContext.createOscillator();
                    const bassGain = audioContext.createGain();
                    
                    bass.type = 'sine';
                    bass.frequency.setValueAtTime(55, startTime); // Low E
                    bass.frequency.setValueAtTime(82, startTime + 1 / tempo);
                    bass.frequency.setValueAtTime(110, startTime + 2 / tempo);
                    bass.frequency.setValueAtTime(55, startTime + 3 / tempo);
                    
                    bassGain.gain.setValueAtTime(0.2, startTime);
                    bassGain.gain.setValueAtTime(0.2, startTime + 4 / tempo);
                    
                    bass.connect(bassGain);
                    bassGain.connect(audioContext.destination);
                    
                    bass.start(startTime);
                    bass.stop(startTime + 4 / tempo);
                }
                
                // Melody line
                function playMelody(startTime) {
                    const melody = audioContext.createOscillator();
                    const melodyGain = audioContext.createGain();
                    const filter = audioContext.createBiquadFilter();
                    
                    melody.type = 'triangle';
                    // Play a simple melody
                    const notes = [262, 294, 330, 262, 294, 330, 294, 262]; // C D E pattern
                    const noteDuration = 0.5 / tempo;
                    
                    notes.forEach((note, idx) => {
                        melody.frequency.setValueAtTime(note, startTime + idx * noteDuration);
                    });
                    
                    filter.type = 'lowpass';
                    filter.frequency.setValueAtTime(1000, startTime);
                    
                    melodyGain.gain.setValueAtTime(0.1, startTime);
                    melodyGain.gain.setValueAtTime(0.1, startTime + notes.length * noteDuration);
                    
                    melody.connect(filter);
                    filter.connect(melodyGain);
                    melodyGain.connect(audioContext.destination);
                    
                    melody.start(startTime);
                    melody.stop(startTime + notes.length * noteDuration);
                }
                
                // Start background music loop
                let currentTime = audioContext.currentTime;
                const loopDuration = 4 / tempo; // 4 beats
                
                function scheduleMusic() {
                    playBass(currentTime);
                    playMelody(currentTime);
                    currentTime += loopDuration;
                    
                    // Schedule next loop
                    setTimeout(scheduleMusic, (loopDuration * 1000) - 50);
                }
                
                scheduleMusic();
                
            } catch(e) {
                console.log('Background music generation failed:', e);
            }
        }

        function stopBackgroundMusic() {
            const bgMusic = document.getElementById('backgroundMusic');
            if (bgMusic) {
                bgMusic.pause();
                bgMusic.currentTime = 0;
            }
        }
        
        function hideGameController() {
            const controller = document.getElementById('gameController');
            if (controller) {
                controller.classList.remove('showing');
                controller.classList.add('hiding');
                
                setTimeout(() => {
                    // Reset to center of arena - top: 50%
                    controller.style.position = 'absolute';
                    controller.style.top = '50%';
                    controller.style.left = '50%';
                    controller.style.transform = 'translate(-50%, -50%)';
                    controller.style.zIndex = '8';
                    
                    controller.classList.remove('hiding');
                    controller.classList.add('showing');
                }, 2000);
            }
        }

        function playCharacterAttackAnimation() {
            const char = document.getElementById('characterImage');
            if (char) {
                char.classList.remove('attacking');
                void char.offsetWidth; // Trigger reflow
                char.classList.add('attacking');
            }
            
            // Trigger fireball effect
            const fireball = document.getElementById('fireball');
            if (fireball) {
                fireball.classList.remove('throwing', 'impact');
                void fireball.offsetWidth; // Trigger reflow
                fireball.classList.add('throwing');
                
                // Play throw sound
                playFireballThrowSound();
                
                // Play impact animation when fireball reaches enemy
                setTimeout(() => {
                    fireball.classList.remove('throwing');
                    void fireball.offsetWidth; // Trigger reflow
                    fireball.classList.add('impact');
                    
                    // Play impact sound
                    playFireballImpactSound();
                    
                    // Trigger enemy damage animation on impact
                    const enemy = document.getElementById('enemyDisplay');
                    if (enemy) {
                        enemy.classList.remove('damaged');
                        void enemy.offsetWidth; // Trigger reflow
                        enemy.classList.add('damaged');
                    }
                }, 600);
            }
        }

        function playEnemyAttackAnimation() {
            const enemy = document.getElementById('enemyDisplay');
            if (enemy) {
                enemy.classList.remove('attacking');
                void enemy.offsetWidth; // Trigger reflow
                enemy.classList.add('attacking');
            }
            
            // Trigger enemy fireball effect
            const enemyFireball = document.getElementById('enemyFireball');
            if (enemyFireball) {
                enemyFireball.classList.remove('throwing', 'impact');
                void enemyFireball.offsetWidth; // Trigger reflow
                enemyFireball.classList.add('throwing');
                
                // Play throw sound
                playFireballThrowSound();
                
                // Play impact animation when fireball reaches player
                setTimeout(() => {
                    enemyFireball.classList.remove('throwing');
                    void enemyFireball.offsetWidth; // Trigger reflow
                    enemyFireball.classList.add('impact');
                    
                    // Play impact sound
                    playFireballImpactSound();
                    
                    // Trigger player damage animation on impact
                    const character = document.getElementById('characterImage');
                    if (character) {
                        character.classList.remove('damaged');
                        void character.offsetWidth; // Trigger reflow
                        character.classList.add('damaged');
                    }
                }, 600);
            }
        }

        function playDamageAnimation(isPlayer) {
            if (isPlayer) {
                const char = document.getElementById('characterImage');
                if (char) {
                    char.classList.remove('damaged');
                    void char.offsetWidth; // Trigger reflow
                    char.classList.add('damaged');
                }
            } else {
                const enemy = document.getElementById('enemyDisplay');
                if (enemy) {
                    enemy.classList.remove('take-damage');
                    void enemy.offsetWidth; // Trigger reflow
                    enemy.classList.add('take-damage');
                }
            }
        }

        function playHealAnimation(isPlayer) {
            const target = isPlayer ? document.getElementById('characterImage') : document.getElementById('enemyDisplay');
            if (target) {
                target.classList.remove('victory');
                void target.offsetWidth; // Trigger reflow
                target.classList.add('victory');
            }
        }

        // Game data with enemies
        const enemies = [
            { name: 'HammerMan', health: 100, words: [
                { word: 'BOOK', hint: 'Something you read', emoji: '📕' },
                { word: 'LETTER', hint: 'Part of an alphabet', emoji: '📄' }
            ]},
            { name: 'Grammar Goblin', health: 100, words: [
                { word: 'SENTENCE', hint: 'Group of words with meaning', emoji: '📝' },
                { word: 'PARAGRAPH', hint: 'Several sentences together', emoji: '📖' }
            ]},
            { name: 'Spelling Sprite', health: 100, words: [
                { word: 'READING', hint: 'The act of looking at words', emoji: '👀' },
                { word: 'WRITING', hint: 'Putting words on paper', emoji: '✏️' }
            ]},
            { name: 'Story Demon', health: 100, words: [
                { word: 'CHARACTER', hint: 'Person in a story', emoji: '👤' },
                { word: 'PLOT', hint: 'Main story events', emoji: '🎬' }
            ]},
            { name: 'Library Lord', health: 100, words: [
                { word: 'FICTION', hint: 'Made-up stories', emoji: '📚' },
                { word: 'KNOWLEDGE', hint: 'Information and learning', emoji: '🧠' }
            ]}
        ];

        // Game state
        let currentEnemyIndex = 0;
        let currentWordInEnemyIndex = 0;
        let score = 0;
        let hints = 3;
        let combo = 0;
        let playerHealth = 100;
        let selectedLetters = [];
        let gameOver = false;

        // DOM elements
        const wordDisplay = document.getElementById('wordDisplay');
        const letterOptions = document.getElementById('letterOptions');
        const messageDisplay = document.getElementById('message');
        const resetBtn = document.getElementById('resetBtn');
        const hintBtn = document.getElementById('hintBtn');
        const hintCountDisplay = document.getElementById('hintCount');
        const scoreDisplay = document.getElementById('scoreDisplay');
        const roundDisplay = document.getElementById('roundDisplay');
        const comboDisplay = document.getElementById('comboDisplay');
        const playerHealthDisplay = document.getElementById('playerHealth');
        const enemyHealthDisplay = document.getElementById('enemyHealth');
        const enemyNameDisplay = document.getElementById('enemyName');

        function getCurrentEnemy() {
            return enemies[currentEnemyIndex];
        }

        function getCurrentWord() {
            const enemy = getCurrentEnemy();
            return enemy.words[currentWordInEnemyIndex];
        }

        function updateUI() {
            const enemy = getCurrentEnemy();
            const word = getCurrentWord();
            
            scoreDisplay.textContent = score;
            roundDisplay.textContent = currentEnemyIndex + 1;
            comboDisplay.textContent = combo;
            playerHealthDisplay.style.width = playerHealth + '%';
            document.getElementById('playerHealthText').textContent = Math.max(0, playerHealth);
            enemyHealthDisplay.style.width = enemy.health + '%';
            document.getElementById('enemyHealthText').textContent = Math.max(0, Math.round(enemy.health));
            enemyNameDisplay.textContent = enemy.name;
            hintCountDisplay.textContent = hints;

            if (playerHealth <= 0) {
                messageDisplay.textContent = '💀 Game Over! You were defeated!';
                messageDisplay.style.color = '#ef4444';
                gameOver = true;
                resetBtn.textContent = '🔄 Play Again';
                resetBtn.addEventListener('click', () => location.reload());
            }
        }

        function renderWord() {
            const currentWord = getCurrentWord();
            selectedLetters = [];
            messageDisplay.textContent = '';

            // Word display boxes
            const wordHTML = currentWord.word.split('').map((letter, index) => 
                `<div class="letter-box" id="box-${index}">_</div>`
            ).join('');

            // Letter option buttons
            const letters = shuffleArray([...currentWord.word, ...getRandomLetters(currentWord.word)]);
            const lettersHTML = letters.map((letter, index) => 
                `<button class="letter-btn" onclick="selectLetter('${letter}', this)">${letter}</button>`
            ).join('');

            wordDisplay.innerHTML = wordHTML;
            letterOptions.innerHTML = lettersHTML;

            // Add click handlers to letter boxes for undoing
            const boxes = document.querySelectorAll('.letter-box');
            boxes.forEach((box, index) => {
                box.addEventListener('click', () => {
                    if (box.classList.contains('filled')) {
                        undoLetter(index);
                    }
                });
                box.style.cursor = 'pointer';
            });

            // Update hint text
            document.getElementById('hintText').textContent = `${currentWord.emoji} Hint: ${currentWord.hint}`;

            updateUI();
        }

        function shuffleArray(array) {
            const shuffled = [...array];
            for (let i = shuffled.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
            }
            return shuffled;
        }

        function getRandomLetters(word) {
            const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
            const letters = word.split('');
            const randomLetters = [];
            
            while (randomLetters.length < 5) {
                const randomLetter = alphabet[Math.floor(Math.random() * alphabet.length)];
                if (!letters.includes(randomLetter) && !randomLetters.includes(randomLetter)) {
                    randomLetters.push(randomLetter);
                }
            }
            return randomLetters;
        }

        function selectLetter(letter, button) {
            if (gameOver || button.classList.contains('used')) return;

            const currentWord = getCurrentWord();
            const boxes = document.querySelectorAll('.letter-box');
            
            let foundEmpty = false;
            for (let i = 0; i < boxes.length; i++) {
                if (boxes[i].textContent === '_') {
                    selectedLetters.push({ letter, index: i });
                    boxes[i].textContent = letter;
                    boxes[i].classList.add('filled');
                    button.classList.add('used');
                    foundEmpty = true;
                    break;
                }
            }

            if (foundEmpty && selectedLetters.length === currentWord.word.length) {
                checkWord();
            }
        }

        function undoLetter(index) {
            const boxes = document.querySelectorAll('.letter-box');
            const box = boxes[index];
            
            if (box.classList.contains('filled')) {
                const letter = box.textContent;
                
                // Find and remove from selectedLetters
                selectedLetters = selectedLetters.filter(item => item.index !== index);
                
                // Reset the box
                box.textContent = '_';
                box.classList.remove('filled');
                
                // Re-enable the button for this letter
                const buttons = document.querySelectorAll('.letter-btn');
                buttons.forEach(btn => {
                    if (btn.textContent === letter && btn.classList.contains('used')) {
                        btn.classList.remove('used');
                    }
                });
                
                // Clear any messages
                messageDisplay.textContent = '';
            }
        }

        function checkWord() {
            if (gameOver) return;
            
            const currentWord = getCurrentWord();
            const filledWord = selectedLetters.map(s => s.letter).join('');
            
            if (filledWord === currentWord.word) {
                // Correct answer
                combo++;
                const damage = 20 + (combo * 5); // Damage increases with combo
                const bonusScore = 10 + (combo * 5);
                score += bonusScore;

                const enemy = getCurrentEnemy();
                enemy.health -= damage;

                messageDisplay.textContent = `✨ Correct! +${bonusScore} pts | Enemy takes ${damage} damage!`;
                messageDisplay.style.color = '#22c55e';
                
                // Play attack animation and enemy damage animation
                playCharacterAttackAnimation();
                setTimeout(() => {
                    playDamageAnimation(false);
                }, 250);

                document.querySelectorAll('.letter-btn').forEach(btn => btn.disabled = true);

                setTimeout(() => {
                    if (enemy.health <= 0) {
                        // Enemy defeated
                        if (currentEnemyIndex < enemies.length - 1) {
                            currentEnemyIndex++;
                            currentWordInEnemyIndex = 0;
                            messageDisplay.textContent = `🎉 Enemy Defeated! Next: ${enemies[currentEnemyIndex].name}`;
                            messageDisplay.style.color = '#eab308';
                            setTimeout(() => renderWord(), 2000);
                        } else {
                            // Game won
                            showGameWon();
                        }
                    } else {
                        currentWordInEnemyIndex++;
                        if (currentWordInEnemyIndex >= getCurrentEnemy().words.length) {
                            currentWordInEnemyIndex = 0;
                        }
                        renderWord();
                    }
                }, 1500);
            } else {
                // Wrong answer
                combo = 0;
                playerHealth -= 10;
                messageDisplay.textContent = '❌ Wrong! Enemy attacks! -10 HP';
                messageDisplay.style.color = '#ef4444';
                
                // Play enemy attack and player damage animations
                playEnemyAttackAnimation();
                setTimeout(() => {
                    playDamageAnimation(true);
                }, 250);

                setTimeout(() => {
                    updateUI();
                    if (playerHealth <= 0) {
                        updateUI();
                    } else {
                        renderWord();
                    }
                }, 1500);
            }

            updateUI();
        }

        function showGameWon() {
            gameOver = true;
            wordDisplay.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <p style="font-size: 80px; margin-bottom: 20px;">🏆</p>
                    <h2 style="font-size: 40px; font-weight: bold; color: #22c55e; margin-bottom: 20px;">YOU WON!</h2>
                    <p style="font-size: 24px; color: #666; margin-bottom: 30px;">Defeated all enemies and saved the library!</p>
                    <div style="background: #f0f0f0; padding: 20px; border-radius: 10px; margin-bottom: 30px; font-size: 20px;">
                        <p><strong>Final Score:</strong> ${score}</p>
                        <p><strong>Combo Streak:</strong> ${combo}</p>
                        <p><strong>Player Health:</strong> ${playerHealth}%</p>
                    </div>
                    <button onclick="location.reload()" style="padding: 15px 40px; background: #22c55e; color: white; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer;">
                        🔄 Play Again
                    </button>
                </div>
            `;
            letterOptions.innerHTML = '';
        }

        function resetWord() {
            messageDisplay.textContent = '';
            renderWord();
        }

        function showHint() {
            if (gameOver) return;
            
            if (hints <= 0) {
                messageDisplay.textContent = '💡 No more hints!';
                messageDisplay.style.color = '#ef4444';
                return;
            }

            const currentWord = getCurrentWord();
            const filledCount = selectedLetters.length;
            
            if (filledCount < currentWord.word.length) {
                const boxes = document.querySelectorAll('.letter-box');
                for (let i = 0; i < boxes.length; i++) {
                    if (boxes[i].textContent === '_') {
                        const correctLetter = currentWord.word[i];
                        boxes[i].textContent = correctLetter;
                        boxes[i].classList.add('filled');
                        
                        document.querySelectorAll('.letter-btn').forEach(btn => {
                            if (btn.textContent === correctLetter) {
                                btn.classList.add('used');
                            }
                        });
                        
                        selectedLetters.push({ letter: correctLetter, index: i });
                        hints--;
                        messageDisplay.textContent = `💡 Letter revealed! (${hints} hints left)`;
                        messageDisplay.style.color = '#3b82f6';
                        break;
                    }
                }

                if (selectedLetters.length === currentWord.word.length) {
                    checkWord();
                }

                updateUI();
            }
        }

        resetBtn.addEventListener('click', resetWord);
        hintBtn.addEventListener('click', showHint);

        // Initialize game
        renderWord();
        playBackgroundMusic();
    </script>
</x-layouts::app>
