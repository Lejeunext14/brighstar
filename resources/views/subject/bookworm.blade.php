<x-layouts::app :title="__('Human Book Game')">
    <div class="w-full">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-blue-50 to-green-50 p-4 md:p-8 dark:border-neutral-700 dark:from-blue-900/20 dark:to-green-900/20 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-4xl font-black text-gray-900 dark:text-white mb-2">
                    Human Book Game
                </h1>
                <p class="text-sm md:text-lg text-gray-600 dark:text-gray-300">Help the Human defeat enemies by completing words!</p>
            </div>
        </div>

        <!-- Game Arena -->
        <div class="rounded-xl border border-neutral-200 bg-white p-0 dark:border-neutral-700 dark:bg-neutral-900 mb-6 overflow-hidden">
            <!-- Game Background -->
            <div id="gameArena" style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)), url('/image/pixel.jpg'); background-size: cover; background-position: center 85%; background-attachment: scroll; min-height: 500px; height: 100vh; max-height: 900px; position: relative; overflow: hidden;" class="responsive-game-arena">

                <!-- Start Screen -->
                <div id="startScreen" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: rgba(0, 0, 0, 0.8); z-index: 100;">
                    <div style="text-align: center; padding: clamp(15px, 5vw, 20px); max-width: 90vw;">
                        <h2 style="font-size: clamp(28px, 8vw, 60px); font-weight: bold; color: #22c55e; margin-bottom: 20px;">Human Book Game</h2>
                        <p style="font-size: clamp(14px, 4vw, 24px); color: white; margin-bottom: 40px;">Complete words to defeat enemies and save the library!</p>
                        <button id="startBtn" style="padding: clamp(12px, 3vw, 20px) clamp(30px, 8vw, 60px); background: #22c55e; color: black; border: none; border-radius: 12px; font-size: clamp(14px, 4vw, 24px); font-weight: bold; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                             Start Game
                        </button>
                    </div>
                </div>

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

                <!-- Mute Button -->
                <button id="muteButton" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); z-index: 11; background: rgba(0, 0, 0, 0.3); color: white; border: none; border-radius: 8px; font-size: 28px; padding: 10px 12px; cursor: pointer; transition: all 0.2s; backdrop-filter: blur(5px);">
                    🔊
                </button>

                <!-- Fireball Effect -->
                <div id="fireball">🔥</div>
                <div id="enemyFireball">🔥</div>

                <!-- Character Name and Health (Upper Left) -->
                <div style="position: absolute; left: 20px; top: 20px; z-index: 10;" class="character-health">
                    <div style="padding: 8px 16px; background: rgba(16, 185, 129, 0.9); border-radius: 20px; border: 2px solid white; color: white; font-weight: bold; font-size: 14px; box-shadow: 0 4px 8px rgba(0,0,0,0.3); text-align: center; margin-bottom: 10px;">{{ auth()->user()->name }}</div>
                    <div style="width: 150px; height: 28px; background: #1f2937; border-radius: 14px; overflow: hidden; border: 3px solid white; box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);" class="character-health-bar">
                        <div id="playerHealth" style="width: 100%; height: 100%; background: linear-gradient(90deg, #10b981 0%, #34d399 100%); transition: width 0.4s ease; box-shadow: inset 0 0 8px rgba(255,255,255,0.4);"></div>
                    </div>
                    <div style="text-align: center; color: white; font-weight: bold; margin-top: 8px; font-size: 12px;" class="character-health-text">HP: <span id="playerHealthText">100</span>/100</div>
                </div>

                <!-- Character Container (Image) -->
                <div style="position: absolute; left: 250px; top: 25%; z-index: 10; width: 250px;" class="character-container">
                    <div style="text-align: center; position: relative;">
                        <img id="characterImage" src="/character/bookcharacter.png" alt="Human Hero" style="width: 250px; height: auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); transition: all 0.3s ease;" />
                    </div>
                </div>

                <!-- Enemy Name and Health (Upper Right) -->
                <div style="position: absolute; right: 20px; top: 20px; z-index: 10; text-align: right;" class="enemy-health">
                    <div style="padding: 8px 16px; background: rgba(239, 68, 68, 0.9); border-radius: 20px; border: 2px solid white; color: white; font-weight: bold; font-size: 14px; box-shadow: 0 4px 8px rgba(0,0,0,0.3); text-align: center; margin-bottom: 10px;" id="enemyName">Word Bug</div>
                    <div style="width: 150px; height: 28px; background: #1f2937; border-radius: 14px; overflow: hidden; border: 3px solid white; box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);" class="enemy-health-bar">
                        <div id="enemyHealth" style="width: 100%; height: 100%; background: linear-gradient(90deg, #ef4444 0%, #f87171 100%); transition: width 0.4s ease; box-shadow: inset 0 0 8px rgba(255,255,255,0.4);"></div>
                    </div>
                    <div style="text-align: center; color: white; font-weight: bold; margin-top: 8px; font-size: 12px;" class="enemy-health-text">HP: <span id="enemyHealthText">100</span>/100</div>
                </div>

                <!-- Enemy Container -->
                <div style="position: absolute; right: 250px; top: 25%; z-index: 10; width: 250px;" class="enemy-container">
                    <div style="text-align: center; position: relative;">
                        <img id="enemyDisplay" src="/character/enemybook.png" alt="Enemy" style="width: 250px; height: auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); transition: all 0.3s ease;" />
                    </div>
                </div>

                <!-- Game Info Display -->
                <div style="position: absolute; top: 20px; left: 50%; transform: translateX(-50%); display: flex; justify-content: center; gap: 10px; z-index: 5; flex-direction: row;" class="game-info">
                    <div style="background: rgba(0, 0, 0, 0.7); color: white; padding: 10px 15px; border-radius: 8px; font-weight: bold; font-size: 14px;">
                        Round: <span id="roundDisplay">1</span>/5
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.7); color: white; padding: 10px 15px; border-radius: 8px; font-weight: bold; font-size: 14px;">
                        Score: <span id="scoreDisplay">0</span>
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.7); color: white; padding: 10px 15px; border-radius: 8px; font-weight: bold; font-size: 14px;">
                        Combo: <span id="comboDisplay">0</span>
                    </div>
                </div>

                <!-- Game Controls Section (Centered in Arena) -->
                <div id="gameController" style="position: absolute; top: 85%; left: 50%; transform: translate(-50%, -50%); z-index: 8; max-width: 600px; width: 90%;">
                    <!-- Word Display -->
                    <div style="text-align: center; margin-bottom: 15px;">
                        <p style="color: white; margin-bottom: 8px; font-size: clamp(12px, 2.5vw, 16px); font-weight: bold; text-shadow: 0 2px 4px rgba(0,0,0,0.5);" id="hintText">Complete the word</p>
                        <div class="word-display" id="wordDisplay" style="justify-content: center;">
                            <!-- Word boxes will be generated here -->
                        </div>
                    </div>

                    <!-- Letter Options -->
                    <div class="letter-options" id="letterOptions" style="justify-content: center; margin-bottom: 25px;">
                        <!-- Letter buttons will be generated here -->
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 8px; justify-content: center; margin-bottom: 10px; flex-wrap: wrap;">
                        <button id="resetBtn" style="padding: 8px 16px; background: rgba(59, 130, 246, 0.9); color: white; border: 2px solid white; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 8px rgba(0,0,0,0.3); font-size: clamp(11px, 2vw, 14px);">
                            🔄 Reset
                        </button>
                        <button id="hintBtn" style="padding: 8px 16px; background: rgba(234, 179, 8, 0.9); color: #000; border: 2px solid white; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 8px rgba(0,0,0,0.3); font-size: clamp(11px, 2vw, 14px);">
                            💡 Hint (<span id="hintCount">3</span>)
                        </button>
                    </div>

                    <!-- Message Display -->
                    <div id="message" style="text-align: center; font-size: clamp(14px, 3vw, 18px); font-weight: bold; min-height: 30px; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></div>
                </div>
            </div>
        </div>

        <!-- Game Stats -->
        <div class="rounded-xl border border-neutral-200 bg-blue-50 dark:bg-blue-900/20 p-4 md:p-6 dark:border-neutral-700">
            <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-3">Game Info:</h3>
            <ul class="list-disc list-inside text-sm md:text-base text-gray-700 dark:text-gray-300 space-y-2">
                <li>Complete each word to damage the enemy and reduce their health</li>
                <li>Defeat all 5 enemies to win the game!</li>
                <li>Get hints to help you find the right letters</li>
                <li>Build your combo by completing words correctly in a row</li>
                <li>Each correct word grants you bonus points!</li>
            </ul>
        </div>
    </div>

    <style>
        /* Responsive Game Arena */
        .responsive-game-arena {
            overflow-x: hidden;
        }

        @media (max-width: 768px) {
            .responsive-game-arena {
                height: auto !important;
                min-height: 1200px !important;
                max-height: none !important;
                background-attachment: scroll !important;
            }
        }

        @media (max-width: 480px) {
            .responsive-game-arena {
                min-height: 1400px !important;
            }
        }

        /* Responsive Character Health Bar */
        @media (max-width: 768px) {
            .character-health {
                left: 10px !important;
                top: 10px !important;
                width: 100px !important;
            }
            
            .character-health-bar {
                width: 100px !important;
                height: 20px !important;
            }
            
            .character-health-text {
                font-size: 10px !important;
            }
        }

        @media (max-width: 480px) {
            .character-health {
                left: 5px !important;
                top: 8px !important;
                z-index: 15 !important;
            }
            
            .character-health > div:first-child {
                padding: 4px 10px !important;
                font-size: 11px !important;
            }
            
            .character-health-bar {
                width: 75px !important;
                height: 14px !important;
            }
            
            .character-health-text {
                font-size: 8px !important;
                margin-top: 2px !important;
            }
        }

        /* Responsive Character Image */
        @media (max-width: 768px) {
            .character-container {
                left: 5% !important;
                top: 30% !important;
                width: 120px !important;
            }
            
            .character-container img {
                width: 120px !important;
            }
        }

        @media (max-width: 480px) {
            .character-container {
                left: 50% !important;
                transform: translateX(-65%) !important;
                top: 35% !important;
                width: 80px !important;
            }
            
            .character-container img {
                width: 80px !important;
            }
        }

        /* Responsive Enemy Health Bar */
        @media (max-width: 768px) {
            .enemy-health {
                right: 10px !important;
                top: 10px !important;
                width: 100px !important;
            }
            
            .enemy-health-bar {
                width: 100px !important;
                height: 20px !important;
            }
            
            .enemy-health-text {
                font-size: 10px !important;
            }
        }

        @media (max-width: 480px) {
            .enemy-health {
                right: 5px !important;
                top: 8px !important;
                z-index: 15 !important;
            }
            
            .enemy-health > div:first-child {
                padding: 4px 10px !important;
                font-size: 11px !important;
            }
            
            .enemy-health-bar {
                width: 75px !important;
                height: 14px !important;
            }
            
            .enemy-health-text {
                font-size: 8px !important;
                margin-top: 2px !important;
            }
        }

        /* Responsive Enemy Image */
        @media (max-width: 768px) {
            .enemy-container {
                right: 5% !important;
                top: 30% !important;
                width: 120px !important;
            }
            
            .enemy-container img {
                width: 120px !important;
            }
        }

        @media (max-width: 480px) {
            .enemy-container {
                right: 50% !important;
                transform: translateX(65%) !important;
                top: 35% !important;
                width: 80px !important;
            }
            
            .enemy-container img {
                width: 80px !important;
            }
        }

        /* Responsive Game Info */
        @media (max-width: 768px) {
            .game-info {
                flex-direction: row !important;
                gap: 4px !important;
                top: 70px !important;
                flex-wrap: wrap;
                padding: 0 5px;
                width: 95%;
                left: 50% !important;
                transform: translateX(-50%) !important;
            }
            
            .game-info div {
                padding: 5px 8px !important;
                font-size: 10px !important;
                border-radius: 6px;
            }
        }

        @media (max-width: 480px) {
            .game-info {
                flex-direction: row !important;
                gap: 3px !important;
                top: 65px !important;
                width: 100%;
                left: 0 !important;
                right: 0 !important;
                transform: none !important;
                padding: 0 5px;
                justify-content: center !important;
            }
            
            .game-info div {
                padding: 4px 6px !important;
                font-size: 9px !important;
                border-radius: 4px;
            }
        }

        /* Responsive Game Controller */
        @media (max-width: 768px) {
            #gameController {
                top: auto !important;
                bottom: 10px !important;
                transform: translate(-50%, 0) !important;
                width: 95% !important;
            }
        }

        @media (max-width: 480px) {
            #gameController {
                top: 65% !important;
                bottom: auto !important;
                transform: translate(-50%, 0) !important;
                width: 95% !important;
                max-width: 95vw !important;
                padding: 8px !important;
            }
        }

        /* Responsive Mute Button */
        @media (max-width: 768px) {
            #muteButton {
                font-size: 20px !important;
                padding: 8px 10px !important;
                left: 10px !important;
                top: 50% !important;
            }
        }

        @media (max-width: 480px) {
            #muteButton {
                font-size: 18px !important;
                padding: 6px 8px !important;
                left: 8px !important;
            }
        }

        .word-display {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .word-display {
                gap: 4px !important;
                margin-bottom: 12px !important;
            }
        }

        @media (max-width: 480px) {
            .word-display {
                gap: 2px !important;
                margin-bottom: 8px !important;
            }
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

        @media (max-width: 768px) {
            .letter-box {
                width: 40px !important;
                height: 40px !important;
                font-size: 18px !important;
                border: 1.5px solid #ccc;
            }
        }

        @media (max-width: 480px) {
            .letter-box {
                width: 30px !important;
                height: 30px !important;
                font-size: 14px !important;
                border: 1px solid #ccc;
            }
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

        @media (max-width: 768px) {
            .letter-options {
                gap: 4px !important;
                margin-bottom: 10px !important;
            }
        }

        @media (max-width: 480px) {
            .letter-options {
                gap: 2px !important;
                margin-bottom: 8px !important;
            }
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

        @media (max-width: 768px) {
            .letter-btn {
                width: 36px !important;
                height: 36px !important;
                font-size: 13px !important;
                border: 1.5px solid #cbd5e1;
            }
        }

        @media (max-width: 480px) {
            .letter-btn {
                width: 28px !important;
                height: 28px !important;
                font-size: 10px !important;
                border: 1px solid #cbd5e1;
            }
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
            20% { transform: translateX(30px) scale(1.1); }
            40% { transform: translateX(30px) scale(1.1); }
            60% { transform: translateX(0) scale(1); }
            100% { transform: translateX(0) scale(1); }
        }

        @media (max-width: 768px) {
            @keyframes bounce-attack {
                0% { transform: translateX(0) scale(1); }
                20% { transform: translateX(15px) scale(1.05); }
                40% { transform: translateX(15px) scale(1.05); }
                60% { transform: translateX(0) scale(1); }
                100% { transform: translateX(0) scale(1); }
            }
        }

        @keyframes enemy-bounce-attack {
            0% { transform: translateX(0) scaleX(-1) scale(1); }
            20% { transform: translateX(-30px) scaleX(-1) scale(1.1); }
            40% { transform: translateX(-30px) scaleX(-1) scale(1.1); }
            60% { transform: translateX(0) scaleX(-1) scale(1); }
            100% { transform: translateX(0) scaleX(-1) scale(1); }
        }

        @media (max-width: 768px) {
            @keyframes enemy-bounce-attack {
                0% { transform: translateX(0) scaleX(-1) scale(1); }
                20% { transform: translateX(-15px) scaleX(-1) scale(1.05); }
                40% { transform: translateX(-15px) scaleX(-1) scale(1.05); }
                60% { transform: translateX(0) scaleX(-1) scale(1); }
                100% { transform: translateX(0) scaleX(-1) scale(1); }
            }
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
            animation: bounce-attack 0.6s ease-in-out !important;
        }

        #characterImage.attacking.float {
            animation: bounce-attack 0.6s ease-in-out, float 3s ease-in-out infinite !important;
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
            animation: enemy-bounce-attack 0.6s ease-in-out !important;
        }

        #enemyDisplay.damaged {
            animation: character-shake 0.4s ease-in-out;
        }

        /* Dying Animation */
        @keyframes character-dying {
            0% {
                opacity: 1;
                transform: translateY(0) rotateZ(0deg);
                filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
            }
            50% {
                opacity: 0.5;
                transform: translateY(20px) rotateZ(5deg);
                filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)) grayscale(50%);
            }
            100% {
                opacity: 0;
                transform: translateY(80px) rotateZ(15deg);
                filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)) grayscale(100%);
            }
        }

        #characterImage.dying {
            animation: character-dying 1.2s ease-in-out forwards;
        }

        #enemyDisplay.dying {
            animation: character-dying 1.2s ease-in-out forwards;
        }

        /* Enemy Entrance Animation */
        @keyframes enemy-entrance {
            0% {
                opacity: 0;
                transform: translateX(100px) scale(0.8);
            }
            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        #enemyDisplay.entering {
            animation: enemy-entrance 0.8s ease-out forwards;
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

        @media (max-width: 768px) {
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
                    transform: translateX(200px) translateY(-20px) scale(1);
                    filter: drop-shadow(0 0 20px #ff3300) drop-shadow(0 0 40px #ff0000);
                }
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

        @media (max-width: 768px) {
            #fireball {
                left: 120px !important;
                font-size: 30px !important;
                width: 30px !important;
                height: 30px !important;
            }
        }

        @media (max-width: 480px) {
            #fireball {
                left: 50% !important;
                font-size: 24px !important;
                width: 24px !important;
                height: 24px !important;
            }
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

        @media (max-width: 768px) {
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
                    transform: translateX(-200px) translateY(-20px) scale(1);
                    filter: drop-shadow(0 0 20px #ff3300) drop-shadow(0 0 40px #ff0000);
                }
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

        @media (max-width: 768px) {
            #enemyFireball {
                right: 120px !important;
                font-size: 30px !important;
                width: 30px !important;
                height: 30px !important;
            }
        }

        @media (max-width: 480px) {
            #enemyFireball {
                right: 50% !important;
                font-size: 24px !important;
                width: 24px !important;
                height: 24px !important;
            }
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
                let musicScheduleId = null;
                
                // Store the schedule ID globally for muting
                window.musicScheduleId = null;
                
                // Bass line
                function playBass(startTime) {
                    if (!window.isMusicPlaying) return;
                    
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
                    if (!window.isMusicPlaying) return;
                    
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
                window.isMusicPlaying = true;
                
                function scheduleMusic() {
                    if (!window.isMusicPlaying) {
                        return;
                    }
                    
                    playBass(currentTime);
                    playMelody(currentTime);
                    currentTime += loopDuration;
                    
                    // Schedule next loop
                    window.musicScheduleId = setTimeout(scheduleMusic, (loopDuration * 1000) - 50);
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

        function playDyingAnimation(isPlayer) {
            const target = isPlayer ? document.getElementById('characterImage') : document.getElementById('enemyDisplay');
            if (target) {
                target.classList.remove('dying');
                void target.offsetWidth; // Trigger reflow
                target.classList.add('dying');
            }
        }

        // Enemy image mapping
        const enemyImages = {
            'HammerMan': '/character/enemybook.png',
            'Grammar Goblin': '/character/goblin.png',
            'Spelling Sprite': '/character/tree.png',
            'Story Demon': '/character/demon.png',
            'Library Lord': '/character/boos2.png'
        };

        function updateEnemyImage() {
            const enemy = getCurrentEnemy();
            const enemyDisplay = document.getElementById('enemyDisplay');
            const imageSrc = enemyImages[enemy.name] || '/character/enemybook.png';
            
            enemyDisplay.src = imageSrc;
            enemyDisplay.classList.remove('entering');
            void enemyDisplay.offsetWidth; // Trigger reflow
            enemyDisplay.classList.add('entering');
        }

        // Game data with enemies
        const enemies = [
            { name: 'HammerMan', health: 100, words: [
                { word: 'LIBRO', hint: 'Isang bagay na binabasa mo', emoji: '📕' },
                { word: 'SULAT', hint: 'Bahagi ng alpabeto', emoji: '📄' }
            ]},
            { name: 'Grammar Goblin', health: 100, words: [
                { word: 'PANGUNGUSAP', hint: 'Pangkat ng mga salita na may kahulugan', emoji: '📝' },
                { word: 'TALATA', hint: 'Ilang pangungusap na magkasama', emoji: '📖' }
            ]},
            { name: 'Spelling Sprite', health: 100, words: [
                { word: 'PAGBABASA', hint: 'Ang kilos ng pagbabasa ng mga salita', emoji: '👀' },
                { word: 'PAGSUSULAT', hint: 'Pagsusulat ng mga salita sa papel', emoji: '✏️' }
            ]},
            { name: 'Story Demon', health: 100, words: [
                { word: 'KARAKTER', hint: 'Taong nasa kuwento', emoji: '👤' },
                { word: 'KUWENTO', hint: 'Pangunahing kaganapan ng kuwento', emoji: '🎬' }
            ]},
            { name: 'Library Lord', health: 100, words: [
                { word: 'FIKSIYON', hint: 'Mga kuwentong gawa-gawa', emoji: '📚' },
                { word: 'KAALAMAN', hint: 'Impormasyon at pag-aaral', emoji: '🧠' }
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
                playDyingAnimation(true);
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

            // Update enemy image and entrance animation
            updateEnemyImage();

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
                        // Enemy defeated - play dying animation
                        playDyingAnimation(false);
                        
                        setTimeout(() => {
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
                        }, 1200);
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
            
            // Hide characters and game arena content
            const characterContainer = document.querySelector('[style*="left: 250px"]');
            const enemyContainer = document.querySelector('[style*="right: 250px"]');
            const healthBars = document.querySelectorAll('[style*="top: 20px"]');
            const gameInfo = document.querySelector('[style*="top: 20px"][style*="left: 50%"]');
            
            if (characterContainer) characterContainer.style.display = 'none';
            if (enemyContainer) enemyContainer.style.display = 'none';
            healthBars.forEach(bar => bar.style.display = 'none');
            if (gameInfo) gameInfo.style.display = 'none';
            
            wordDisplay.innerHTML = `
                <div style="text-align: center; padding: 40px; width: 100%;">
                    <h2 style="font-size: 40px; font-weight: bold; color: #22c55e; margin-bottom: 20px;">YOU WON!</h2>
                    <p style="font-size: 24px; color: #fff; margin-bottom: 30px;">Defeated all enemies and saved the library!</p>
                </div>
            `;
            
            letterOptions.innerHTML = `
                <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 20; display: flex; flex-direction: column; gap: 20px; justify-content: center; align-items: center;">
                    <div style="background: rgba(0, 0, 0, 0.5); padding: 30px; border-radius: 10px; font-size: 20px; color: white; text-align: center;">
                        <p style="margin: 10px 0;"><strong>Final Score:</strong> ${score}</p>
                        <p style="margin: 10px 0;"><strong>Combo Streak:</strong> ${combo}</p>
                        <p style="margin: 10px 0;"><strong>Player Health:</strong> ${playerHealth}%</p>
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <button onclick="location.reload()" style="padding: 15px 40px; background: #22c55e; color: white; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                            🔄 Play Again
                        </button>
                        <button onclick="window.location.href='/games'" style="padding: 15px 40px; background: #ef4444; color: white; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                            ❌ Quit
                        </button>
                    </div>
                </div>
            `;
            messageDisplay.innerHTML = '';
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

        // Mute button functionality
        let isMuted = false;
        const muteButton = document.getElementById('muteButton');
        
        muteButton.addEventListener('click', function() {
            isMuted = !isMuted;
            
            if (isMuted) {
                window.isMusicPlaying = false;
                muteButton.textContent = '🔇';
                muteButton.style.background = 'rgba(0, 0, 0, 0.5)';
            } else {
                window.isMusicPlaying = true;
                muteButton.textContent = '🔊';
                muteButton.style.background = 'rgba(0, 0, 0, 0.3)';
            }
        });

        // Initialize game
        const startBtn = document.getElementById('startBtn');
        const startScreen = document.getElementById('startScreen');
        
        startBtn.addEventListener('click', function() {
            startScreen.style.display = 'none';
            renderWord();
            playBackgroundMusic();
        });
    </script>
</x-layouts::app>
