<x-layouts::app :title="__('Pag Papakilala sa Ibat Ibang Uri ng Tunog - Interactive Filipino Sounds Learning')">
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
            background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
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
            background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
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
            background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
            font-size: 3rem;
            font-weight: bold;
        }
        
        .example-card {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            padding: 25px 15px;
            border-radius: 10px;
            margin: 15px auto;
            border-left: 5px solid #a78bfa;
            max-width: 280px;
            text-align: center;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .activity-box {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #a78bfa;
        }
        
        .btn {
            background: #a78bfa;
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
            background: #7c3aed;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(167, 139, 250, 0.3);
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
            border-color: #a78bfa;
            background: #faf5ff;
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
            background: #a78bfa;
            width: 30px;
            border-radius: 5px;
        }
        
        .completion-badge {
            background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(167, 139, 250, 0.3);
        }
        
        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 30px 0;
            gap: 15px;
        }
        
        .pagination-btn {
            background: #a78bfa;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover {
            background: #7c3aed;
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
            <h1>🔊 Pag Papakilala sa Ibat Ibang Uri ng Tunog 🔊</h1>
            <p>Matuto ng Iba't Ibang Uri ng Tunog sa Filipino</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang pagdating sa Mga Tunog! 👋</h2>
            <p>Ang pag-unawa sa iba't ibang uri ng tunog ay mahalaga sa pag-develop ng wika. Sa araling ito, matututunan mo ang mga pangalan ng iba't ibang tunog at kung paano ito sinasabi sa Filipino.</p>
            
            <div class="letter-display">🔊</div>
            
            <div class="activity-box">
                <h3>Tungkol sa Mga Tunog:</h3>
                <ul style="margin-left: 20px;">
                    <li>Ang tunog ay bahagi ng pang-araw-araw na buhay</li>
                    <li>May iba't ibang uri ng tunog sa paligid natin</li>
                    <li>Ang bawat tunog ay may sariling kahulugan</li>
                    <li>Mahalaga ang pag-recognize ng mga tunog</li>
                    <li>Tumutulong ito sa komunikasyon</li>
                </ul>
            </div>

            <div class="activity-box">
                <h3>Matututunan Mo:</h3>
                <p>Sa araling ito, matututunan mo:</p>
                <ul style="margin-left: 20px;">
                    <li>Tukuyin ang iba't ibang uri ng tunog</li>
                    <li>Sabihin ang pangalan sa Filipino</li>
                    <li>Maintindihan ang bawat tunog</li>
                    <li>Magsalita tungkol sa mga tunog</li>
                </ul>
            </div>
        </div>

        <!-- Page 2: Animal Sounds -->
        <div id="page-2" class="page-section">
            <h2>Mga Tunog ng Hayop 🐶</h2>
            <p>Alamin ang mga tunog ng hayop:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <h3>Ang Aso ay Tumutunog: Aw-aw! 🐕</h3>
                <p style="font-size: 1.2rem;">"Ang aso ay tumutunog na aw-aw"</p>
                <button class="btn" onclick="speak('Ang aso ay tumutunog na aw aw')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Ang Pusa ay Tumutunog: Meow! 🐱</h3>
                <p style="font-size: 1.2rem;">"Ang pusa ay tumutunog na meow"</p>
                <button class="btn" onclick="speak('Ang pusa ay tumutunog na meow')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Ang Ibon ay Tumutunog: Chirp! 🐦</h3>
                <p style="font-size: 1.2rem;">"Ang ibon ay tumutunog na chirp"</p>
                <button class="btn" onclick="speak('Ang ibon ay tumutunog na chirp')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 3: Nature Sounds -->
        <div id="page-3" class="page-section">
            <h2>📚 Mga Tunog ng Kalikasan 🌊</h2>
            <p>Alamin ang mga tunog ng kalikasan:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <h3>Ulan: Pitter-patter ☔</h3>
                <p>"Ang ulan ay tumutunog na pitter-patter"</p>
                <button class="btn" onclick="speak('Ang ulan ay tumutunog na pitter patter')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Kidlat: Boom! ⚡</h3>
                <p>"Ang kidlat ay tumutunog na boom"</p>
                <button class="btn" onclick="speak('Ang kidlat ay tumutunog na boom')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Hangin: Whoosh! 💨</h3>
                <p>"Ang hangin ay tumutunog na whoosh"</p>
                <button class="btn" onclick="speak('Ang hangin ay tumutunog na whoosh')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 4: Musical Sounds -->
        <div id="page-4" class="page-section">
            <h2>🎵 Mga Tunog ng Musika 🎶</h2>
            <p>Alamin ang mga tunog ng musika:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <h3>Piano: Ding Dong 🎹</h3>
                <p>"Ang piano ay tumutunog na ding dong"</p>
                <button class="btn" onclick="speak('Ang piano ay tumutunog')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Gitara: Twang 🎸</h3>
                <p>"Ang gitara ay tumutunog na twang"</p>
                <button class="btn" onclick="speak('Ang gitara ay tumutunog')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Kampana: Ring 🔔</h3>
                <p>"Ang kampana ay tumutunog na ring"</p>
                <button class="btn" onclick="speak('Ang kampana ay tumutunog na ring')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 5: Quiz -->
        <div id="page-5" class="page-section">
            <h2>📝 Pagsusulit sa Kaalaman 🧠</h2>
            <p>Subukan ang iyong kaalaman tungkol sa mga tunog:</p>
            
            <div class="quiz-question">
                <h3>Tanong 1: Paano tumutunog ang aso?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Aw-aw
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Meow
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Chirp
                </div>
                <div id="feedback-1"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 2: Paano tumutunog ang ulan?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    A) Boom
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    B) Pitter-patter
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Whoosh
                </div>
                <div id="feedback-2"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 3: Paano tumutunog ang pusa?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    A) Aw-aw
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    B) Meow
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Chirp
                </div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 6: Daily Sounds -->
        <div id="page-6" class="page-section">
            <h2>⏰ Mga Tunog sa Pang-araw-araw 📢</h2>
            <p>Matututunan mo ang mga tunog na maririnig mo araw-araw:</p>
            
            <div class="activity-box">
                <h3>Mga Halimbawa:</h3>
                <ul style="margin-left: 20px;">
                    <li>Doorbell: Ding dong (kampana sa pintuan)</li>
                    <li>Clock: Tick-tock (tunog ng orasan)</li>
                    <li>Car horn: Beep beep (tunog ng sasakyan)</li>
                    <li>Phone: Ring ring (tunog ng telepono)</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Halimbawa:</h3>
                <p>"Sa umaga, maririnig ko ang titilaok ng manok na kikirikik!"</p>
                <button class="btn" onclick="speak('Sa umaga maririnig ko ang titilaok ng manok')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 7: Human Sounds -->
        <div id="page-7" class="page-section">
            <h2>😆 Mga Tunog ng Tao 👥</h2>
            <p>Matututunan mo ang mga tunog na ginagawa ng tao:</p>
            
            <div class="activity-box">
                <h3>Mga Halimbawa:</h3>
                <ul style="margin-left: 20px;">
                    <li>Ngiti: Haha (tunog ng tawa)</li>
                    <li>Ubo: Cough cough (tunog ng ubo)</li>
                    <li>Bahing: Achoo (tunog ng bahin)</li>
                    <li>Pagsigaw: Ahh (tunog ng sigaw)</li>
                    <li>Pag-ihip: Psst (tunog ng ihip)</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Halimbawa:</h3>
                <p>"Ang masayang tao ay nakakatawa na haha!"</p>
                <button class="btn" onclick="speak('Ang masayang tao ay nakakatawa')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 8: Sound Importance -->
        <div id="page-8" class="page-section">
            <h2>❤️ Ang Kahalagahan ng Mga Tunog 💭</h2>
            <p>Malaman kung bakit mahalaga ang mga tunog:</p>
            
            <div class="activity-box">
                <h3>Bakit Mahalaga ang Mga Tunog:</h3>
                <ul style="margin-left: 20px;">
                    <li>Tumutulong ito sa atin na makipag-ugnayan</li>
                    <li>Ginagamit natin ito para mag-warning ng danger</li>
                    <li>Nagbibigay ito ng saya at kasiyahan</li>
                    <li>Bahagi ito ng ating karanasan sa mundo</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Reflection:</h3>
                <p>"Makinig nang mabuti sa mga tunog sa iyong paligid. Marami kang matututunan!"</p>
                <button class="btn" onclick="speak('Makinig nang mabuti sa mga tunog')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 9: Summary & Completion -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Aralin</h2>
            
            <div class="completion-badge">
                <h2>✅ Binabati Kita! 🎉</h2>
                <p>Nagtapos ka na ng "Pag Papakilala sa Ibat Ibang Uri ng Tunog" na interaktibong aral!</p>
                <p style="font-size: 1.2rem; margin-top: 15px;">Natutunan mo ang mga pangalan ng iba't ibang tunog at kung paano ito ginagamit sa pang-araw-araw na buhay sa Filipino!</p>
            </div>

            <div class="activity-box">
                <h3>Mga Pangunahing Araw-araw:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Ang aso ay tumutunog na aw-aw</li>
                    <li>✅ Ang kalikasan ay may magagandang tunog</li>
                    <li>✅ Ang musika ay lumilikha ng masasayang tunog</li>
                    <li>✅ May mga tunog sa pang-araw-araw</li>
                    <li>✅ Ang mga tunog ay bahagi ng komunikasyon</li>
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
            <h2 style="color: #a78bfa; font-size: 1.8rem; margin-bottom: 20px;">🏆 Kahanga-Hangang Gawain!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 30px;">Matagumpay mong nagtapos ng aral. Napakaganda ng iyong progreso!</p>
            
            <!-- Gamification Stats -->
            <div style="background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%); padding: 25px; border-radius: 10px; margin-bottom: 25px;">
                <h3 style="color: #a78bfa; margin-bottom: 15px;">📊 Iyong Performance</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; text-align: center;">
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Total Points</p>
                        <p style="color: #a78bfa; font-size: 1.8rem; font-weight: bold;" id="finalPoints">0</p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Best Streak</p>
                        <p style="color: #a78bfa; font-size: 1.8rem; font-weight: bold;" id="finalStreak">0</p>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button style="background: #a78bfa; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem;" onclick="returnToTopics()">Bumalik sa Topics</button>
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
