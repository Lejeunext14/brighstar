<x-layouts::app :title="__('Mga Hugis - Interactive Filipino Shapes Learning')">
    <style>
        @keyframes fade-in { 0% { opacity: 0; } 100% { opacity: 1; } }
        @keyframes slide-up { 0% { transform: translateY(20px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        @keyframes confetti-fall { 0% { transform: translateY(-100px) rotate(0deg); opacity: 1; } 100% { transform: translateY(800px) rotate(360deg); opacity: 0; } }
        @keyframes point-popup { 0% { transform: translateY(0) scale(1); opacity: 1; } 100% { transform: translateY(-50px) scale(0.8); opacity: 0; } }
        @keyframes badge-unlock { 0% { transform: scale(0); opacity: 0; } 50% { transform: scale(1.2); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes streak-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        
        .fade-in { animation: fade-in 0.6s ease-in; }
        .slide-up { animation: slide-up 0.6s ease-out; }
        .pulse-animation { animation: pulse 2s infinite; }
        .confetti { position: fixed; pointer-events: none; font-size: 2rem; animation: confetti-fall 3s ease-in forwards; }
        .point-popup { position: fixed; font-weight: bold; color: #10b981; animation: point-popup 1s ease-out forwards; pointer-events: none; }
        .badge-unlock { animation: badge-unlock 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        .streak-highlight { animation: streak-pulse 0.5s ease-in-out; }
        
        /* Gamification UI */
        .gamification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .points-display, .streak-counter {
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .badge-display {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .badge {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.5);
            cursor: help;
            position: relative;
            transition: transform 0.3s ease;
        }
        
        .badge:hover { transform: scale(1.15); }
        .badge.locked { opacity: 0.5; filter: grayscale(100%); }
        
        .badge-tooltip {
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        
        .badge:hover .badge-tooltip { opacity: 1; }
        
        .professional-header {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        
        .page-section {
            display: none;
            animation: slide-up 0.6s ease-out;
        }
        
        .page-section.active { display: block; }
        
        .letter-display {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
            font-size: 3rem;
            font-weight: bold;
        }
        
        .example-card {
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
            padding: 25px 15px;
            border-radius: 10px;
            margin: 15px auto;
            border-left: 5px solid #ec4899;
            max-width: 280px;
            text-align: center;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .activity-box {
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #ec4899;
        }
        
        .btn {
            background: #ec4899;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: #db2777;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.3);
        }
        
        .quiz-option {
            background: white;
            border: 2px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .quiz-option:hover {
            border-color: #ec4899;
            background: #fdf2f8;
        }
        
        .quiz-option.correct {
            background: #dcfce7;
            border-color: #22c55e;
            color: #166534;
        }
        
        .quiz-option.incorrect {
            background: #fee2e2;
            border-color: #ef4444;
            color: #991b1b;
        }
        
        .feedback {
            margin-top: 10px;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
        }
        
        .feedback.success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }
        
        .feedback.error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .quiz-question {
            background: white;
            border: 2px solid #e5e7eb;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
            margin-top: 15px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: white;
            border-radius: 10px;
            width: 11%;
            transition: width 0.3s ease;
        }
        
        .page-dots {
            text-align: center;
            margin: 30px 0;
        }
        
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ddd;
            display: inline-block;
            margin: 0 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .dot.active {
            background: #ec4899;
            width: 30px;
            border-radius: 5px;
        }
        
        .completion-badge {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(236, 72, 153, 0.3);
        }
        
        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 30px 0;
            gap: 15px;
        }
        
        .pagination-btn {
            background: #ec4899;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover {
            background: #db2777;
            transform: translateY(-2px);
        }
        
        .pagination-btn:disabled {
            background: #d1d5db;
            cursor: not-allowed;
        }
        
        .page-counter {
            font-weight: bold;
            color: #555;
            min-width: 60px;
            text-align: center;
        }

        h1, h2, h3, h4, h5, h6 { color: #1f2937; }
        p { color: #555; line-height: 1.8; }
    </style>

    <div class="w-full max-w-5xl mx-auto px-4 py-8">
        <!-- Gamification Header -->
        <div class="gamification-header">
            <div class="points-display">
                ⭐ Points: <span id="pointsDisplay">0</span>
            </div>
            <div class="streak-counter">
                🔥 Streak: <span id="streakDisplay">0</span>
            </div>
            <div class="badge-display" id="badgeDisplay"></div>
        </div>

        <!-- Header -->
        <div class="professional-header slide-up">
            <h1>🔷 Mga Hugis 🔶</h1>
            <p>Matuto ng Mga Hugis sa Filipino</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang pagdating sa Mga Hugis! 👋</h2>
            <p>Ang pag-unawa sa mga hugis ay mahalagang bahagi ng edukasyon. Sa araling ito, matututunan mo ang mga pangalan ng iba't ibang hugis at kung paano ito makikita sa mundo.</p>
            
            <div class="letter-display">🔷</div>
            
            <div class="activity-box">
                <h3>Tungkol sa Mga Hugis:</h3>
                <ul style="margin-left: 20px;">
                    <li>Ang mga hugis ay makikita sa lahat ng bagay</li>
                    <li>Bawat hugis ay may sariling pangalan</li>
                    <li>Mahalagang malaman ang mga pangalan para sa geometriya</li>
                    <li>Maraming bagay ang may iba't ibang hugis</li>
                    <li>Ginagamit sa sining at disenyo</li>
                </ul>
            </div>

            <div class="activity-box">
                <h3>Matututunan Mo:</h3>
                <p>Sa araling ito, matututunan mo:</p>
                <ul style="margin-left: 20px;">
                    <li>Tukuyin ang mga pangunahing hugis</li>
                    <li>Sabihin ang pangalan sa Filipino</li>
                    <li>Malaman kung saan makikita ang bawat hugis</li>
                    <li>Magsalita tungkol sa mga hugis</li>
                </ul>
            </div>
        </div>

        <!-- Page 2: Basic Shapes -->
        <div id="page-2" class="page-section">
            <h2>Pangunahing Hugis 🔷</h2>
            <p>Alamin ang mga pangunahing hugis:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #ff0000; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;"><span style="font-size: 5rem;">🔴</span></div>
                <h3>Bilog (Circle)</h3>
                <p style="font-size: 1.2rem;">"Ang bilog ay walang sulok"</p>
                <button class="btn" onclick="speak('Bilog')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #00ff00; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;"><span style="font-size: 5rem;">🟩</span></div>
                <h3>Parisukat (Square)</h3>
                <p style="font-size: 1.2rem;">"Ang parisukat ay may apat na sulok"</p>
                <button class="btn" onclick="speak('Parisukat')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 100px; background-color: #0000ff; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;"><span style="font-size: 5rem;">📦</span></div>
                <h3>Rektanggulo (Rectangle)</h3>
                <p style="font-size: 1.2rem;">"Ang rektanggulo ay mas mahabang parisukat"</p>
                <button class="btn" onclick="speak('Rektanggulo')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 3: More Shapes -->
        <div id="page-3" class="page-section">
            <h2>📚 Iba Pang Hugis 🔺</h2>
            <p>Alamin ang iba pang mga hugis:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #ffff00; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;"><span style="font-size: 5rem;">🔺</span></div>
                <h3>Tatsulok (Triangle)</h3>
                <p>"Ang tatsulok ay may tatlong sulok at tatlong panig"</p>
                <button class="btn" onclick="speak('Tatsulok')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #ff00ff; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;"><span style="font-size: 5rem;">🔷</span></div>
                <h3>Diamante (Diamond)</h3>
                <p>"Ang diamante ay parang parisukat na umiikot"</p>
                <button class="btn" onclick="speak('Diamante')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #ff8800; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;"><span style="font-size: 5rem;">⭐</span></div>
                <h3>Bituin (Star)</h3>
                <p>"Ang bituin ay may maraming sulok"</p>
                <button class="btn" onclick="speak('Bituin')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 4: 3D Shapes -->
        <div id="page-4" class="page-section">
            <h2>🏰 3D na Hugis 🔶</h2>
            <p>Alamin ang tatlong dimensional na hugis:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <h3>Kubo (Cube)</h3>
                <p style="font-size: 1.2rem;">Tatlong dimensional na parisukat 🎲</p>
                <button class="btn" onclick="speak('Kubo')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Bola (Sphere)</h3>
                <p style="font-size: 1.2rem;">Tatlong dimensional na bilog ⚽</p>
                <button class="btn" onclick="speak('Bola')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Sylindar (Cylinder)</h3>
                <p style="font-size: 1.2rem;">Parang tubo o lata 🥫</p>
                <button class="btn" onclick="speak('Sylindar')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 5: Quiz -->
        <div id="page-5" class="page-section">
            <h2>📝 Pagsusulit sa Kaalaman 🧠</h2>
            <p>Subukan ang iyong kaalaman tungkol sa mga hugis:</p>
            
            <div class="quiz-question">
                <h3>Tanong 1: Ilang sulok ang may parisukat?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Apat
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Tatlo
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Dalawa
                </div>
                <div id="feedback-1"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 2: Ilang sulok ang may tatsulok?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    A) Apat
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    B) Tatlo
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Limang sulok
                </div>
                <div id="feedback-2"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 3: Ilang sulok ang may bilog?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Walang sulok
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Apat
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Tatlo
                </div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 6: Shapes Around Us -->
        <div id="page-6" class="page-section">
            <h2>⏰ Mga Hugis sa Paligid Natin 🏠</h2>
            <p>Makita kung saan makikita ang mga hugis:</p>
            
            <div class="activity-box">
                <h3>Mga Halimbawa:</h3>
                <ul style="margin-left: 20px;">
                    <li>Bilog: Buwan, bilog ng pera, plato</li>
                    <li>Parisukat: Kahon, bintana, tile</li>
                    <li>Rektanggulo: Pintuan, libro, mesa</li>
                    <li>Tatsulok: Bubong, bituin, tore</li>
                    <li>Bola: Bola sa sports, kinang ng puso</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Halimbawa:</h3>
                <p>"Sa kakaibang bagay sa bahay, may iba't ibang hugis!"</p>
                <button class="btn" onclick="speak('Sa kakaibang bagay sa bahay may ibat ibang hugis')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 7: Shape Combinations -->
        <div id="page-7" class="page-section">
            <h2>🎨 Kombinasyon ng Mga Hugis 🖼️</h2>
            <p>Matututunan mo kung paano pinagsasama ang mga hugis:</p>
            
            <div class="activity-box">
                <h3>Mga Halimbawa ng Kombinasyon:</h3>
                <ul style="margin-left: 20px;">
                    <li>Bahay = Parisukat + Tatsulok</li>
                    <li>Snowman = Tatlong bilog</li>
                    <li>Roboto = Mga parisukat at rektanggulo</li>
                    <li>Flores = Bilog + Tatsulok</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Sining at Disenyo:</h3>
                <p>"Ang maraming sining ay gawa mula sa pinag-ugnay na mga hugis!"</p>
                <button class="btn" onclick="speak('Ang maraming sining ay gawa mula sa mga hugis')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 8: Real-Life Applications -->
        <div id="page-8" class="page-section">
            <h2>❤️ Mga Hugis sa Negosyo at Sining 💼</h2>
            <p>Malaman kung bakit mahalaga ang mga hugis:</p>
            
            <div class="activity-box">
                <h3>Bakit Mahalaga ang Mga Hugis:</h3>
                <ul style="margin-left: 20px;">
                    <li>Ginagamit sa arkitektura para sa mga gusali</li>
                    <li>Ginagamit sa disenyo ng mga produkto</li>
                    <li>Ginagamit sa matematika at geometriya</li>
                    <li>Mahalaga sa sining at kreatibidad</li>
                    <li>Tumutulong sa ating pag-unawa ng mundo</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Reflection:</h3>
                <p>"Tignan ang paligid mo at makita ang lahat ng magagandang hugis!"</p>
                <button class="btn" onclick="speak('Tignan ang paligid mo at makita ang lahat ng hugis')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 9: Summary & Completion -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Aralin</h2>
            
            <div class="completion-badge">
                <h2>✅ Binabati Kita! 🎉</h2>
                <p>Nagtapos ka na ng "Mga Hugis" na interaktibong aral!</p>
                <p style="font-size: 1.2rem; margin-top: 15px;">Natutunan mo ang mga pangalan ng iba't ibang hugis at makikita mo ito kahit saan!</p>
            </div>

            <div class="activity-box">
                <h3>Mga Pangunahing Araw-araw:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Ang bilog ay walang sulok</li>
                    <li>✅ Ang parisukat ay may apat na sulok</li>
                    <li>✅ Ang tatsulok ay may tatlong sulok</li>
                    <li>✅ Ang mga hugis ay makikita sa lahat ng bagay</li>
                    <li>✅ Maaaring pagsamahin ang mga hugis para gumawa ng magagandang disenyo</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <button class="btn" onclick="completeLesson()" style="font-size: 1.1rem; padding: 15px 40px;">✅ Markahan Bilang Tapos Na</button>
            </div>
        </div>

        <!-- Pagination Controls -->
        <div class="pagination-controls">
            <button class="pagination-btn" id="prevBtn" onclick="previousPage()">← Nakaraang</button>
            <span class="page-counter"><span id="currentPage">1</span> / <span id="totalPages">9</span></span>
            <button class="pagination-btn" id="nextBtn" onclick="nextPage()">Susunod →</button>
        </div>
    </div>

    <!-- Completion Modal -->
    <div id="completionModal" class="fixed inset-0 hidden flex items-center justify-center bg-black/50 z-50">
        <div style="background: white; border-radius: 15px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <h2 style="color: #ec4899; font-size: 1.8rem; margin-bottom: 20px;">🏆 Kahanga-Hangang Gawain!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 30px;">Matagumpay mong nagtapos ng "Mga Hugis" na aral. Napakaganda ng iyong progreso!</p>
            
            <!-- Gamification Stats -->
            <div style="background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); padding: 25px; border-radius: 10px; margin-bottom: 25px;">
                <h3 style="color: #ec4899; margin-bottom: 15px;">📊 Iyong Performance</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; text-align: center;">
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Total Points</p>
                        <p style="color: #ec4899; font-size: 1.8rem; font-weight: bold;" id="finalPoints">0</p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Best Streak</p>
                        <p style="color: #ec4899; font-size: 1.8rem; font-weight: bold;" id="finalStreak">0</p>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button style="background: #ec4899; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem;" onclick="returnToTopics()">Bumalik sa Topics</button>
            </div>
        </div>
    </div>

    <script>
        const totalPages = 9;
        let currentPage = 1;
        
        let gameState = {
            totalPoints: 0,
            streak: 0,
            questionsAnswered: 0,
            badges: [],
            startTime: null
        };

        function init() {
            gameState.startTime = Date.now();
            renderPageDots();
            updatePageDisplay();
            renderBadges();
        }
        
        function renderBadges() {
            const badgeDisplay = document.getElementById('badgeDisplay');
            badgeDisplay.innerHTML = `
                <div class="badge ${gameState.badges.includes('perfectScore') ? '' : 'locked'}" data-badge="perfectScore">💯</div>
                <div class="badge ${gameState.badges.includes('onFire') ? '' : 'locked'}" data-badge="onFire">🔥</div>
            `;
        }

        function speak(text) {
            if (!text || text.trim() === '') return;
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'fil-PH';
            utterance.rate = 0.85;
            utterance.pitch = 1.0;
            utterance.volume = 1.0;
            window.speechSynthesis.speak(utterance);
        }

        function checkAnswer(element, isCorrect) {
            const parent = element.parentElement;
            const options = parent.querySelectorAll('.quiz-option');
            
            options.forEach(opt => opt.style.pointerEvents = 'none');

            if (isCorrect) {
                element.classList.add('correct');
                const feedback = parent.querySelector('[id^="feedback-"]');
                if (feedback) {
                    feedback.innerHTML = '<div class="feedback success">✅ Tamang sagot!</div>';
                    speak('Tamang sagot!');
                }
                
                addPoints(10);
                updateStreak(true);
                triggerConfetti();
                
            } else {
                element.classList.add('incorrect');
                const feedback = parent.querySelector('[id^="feedback-"]');
                if (feedback) {
                    feedback.innerHTML = '<div class="feedback error">❌ Mali ito!</div>';
                    speak('Mali ito!');
                }
                updateStreak(false);
            }
        }
        
        function addPoints(points) {
            gameState.totalPoints += points;
            gameState.questionsAnswered++;
            document.getElementById('pointsDisplay').textContent = gameState.totalPoints;
            
            const popup = document.createElement('div');
            popup.className = 'point-popup';
            popup.textContent = '+' + points;
            popup.style.left = (Math.random() * 100) + '%';
            popup.style.top = '50%';
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 1000);
        }
        
        function updateStreak(correct) {
            if (correct) {
                gameState.streak++;
                document.getElementById('streakDisplay').textContent = gameState.streak;
            } else {
                gameState.streak = 0;
                document.getElementById('streakDisplay').textContent = '0';
            }
        }
        
        function triggerConfetti() {
            const colors = ['🎉', '✨', '⭐', '🎊', '💫'];
            for (let i = 0; i < 15; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.textContent = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.top = '0px';
                    document.body.appendChild(confetti);
                    setTimeout(() => confetti.remove(), 3000);
                }, i * 50);
            }
        }

        function renderPageDots() {
            const container = document.getElementById('pageDots');
            container.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const dot = document.createElement('div');
                dot.className = 'dot' + (i === currentPage ? ' active' : '');
                dot.onclick = () => goToPage(i);
                container.appendChild(dot);
            }
        }

        function updatePageDisplay() {
            for (let i = 1; i <= totalPages; i++) {
                const page = document.getElementById(`page-${i}`);
                if (page) page.classList.remove('active');
            }

            const currentPageEl = document.getElementById(`page-${currentPage}`);
            if (currentPageEl) currentPageEl.classList.add('active');

            document.getElementById('currentPage').textContent = currentPage;
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages;

            const progress = (currentPage / totalPages) * 100;
            document.getElementById('progressFill').style.width = progress + '%';

            renderPageDots();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function previousPage() {
            if (currentPage > 1) {
                currentPage--;
                updatePageDisplay();
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                updatePageDisplay();
            }
        }

        function goToPage(page) {
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                updatePageDisplay();
            }
        }

        function completeLesson() {
            document.getElementById('finalPoints').textContent = gameState.totalPoints;
            document.getElementById('finalStreak').textContent = gameState.streak;
            document.getElementById('completionModal').classList.remove('hidden');
        }

        function returnToTopics() {
            window.location.href = '{{ route("subject.topics", ["subject" => "filipino"]) }}';
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
</x-layouts::app>
