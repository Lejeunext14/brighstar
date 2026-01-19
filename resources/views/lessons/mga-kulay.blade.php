<x-layouts::app :title="__('Mga Kulay - Interactive Filipino Colors Learning')">
    <style>
        @keyframes fade-in { 0% { opacity: 0; } 100% { opacity: 1; } }
        @keyframes slide-up { 0% { transform: translateY(20px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes confetti-fall { 0% { transform: translateY(-100px) rotate(0deg); opacity: 1; } 100% { transform: translateY(800px) rotate(360deg); opacity: 0; } }
        @keyframes point-popup { 0% { transform: translateY(0) scale(1); opacity: 1; } 100% { transform: translateY(-50px) scale(0.8); opacity: 0; } }
        @keyframes badge-unlock { 0% { transform: scale(0); opacity: 0; } 50% { transform: scale(1.2); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes streak-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        
        .fade-in { animation: fade-in 0.6s ease-in; }
        .slide-up { animation: slide-up 0.6s ease-out; }
        .pulse-animation { animation: pulse 2s infinite; }
        .bounce-animation { animation: bounce 0.6s infinite; }
        .confetti { position: fixed; pointer-events: none; font-size: 2rem; animation: confetti-fall 3s ease-in forwards; }
        .point-popup { position: fixed; font-weight: bold; color: #10b981; animation: point-popup 1s ease-out forwards; pointer-events: none; }
        .badge-unlock { animation: badge-unlock 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        .streak-highlight { animation: streak-pulse 0.5s ease-in-out; }
        
        /* Gamification UI */
        .gamification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .points-display {
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .streak-counter {
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
        
        .badge:hover {
            transform: scale(1.15);
        }
        
        .badge.locked {
            opacity: 0.5;
            filter: grayscale(100%);
        }
        
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
        
        .badge:hover .badge-tooltip {
            opacity: 1;
        }
        
        .professional-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        
        .page-section.active {
            display: block;
        }
        
        .interactive-card {
            background: white;
            border: 2px solid #e5e7eb;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .interactive-card:hover {
            border-color: #10b981;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.2);
        }
        
        .letter-display {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
            font-size: 3rem;
            font-weight: bold;
        }
        
        .example-card {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            padding: 25px 15px;
            border-radius: 10px;
            margin: 15px auto;
            border-left: 5px solid #10b981;
            max-width: 230px;
            text-align: center;
            min-height: 380px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .example-card img {
            display: block;
            margin: 0 auto 15px auto;
        }
        
        .activity-box {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #10b981;
        }
        
        .activity-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            margin: 10px 0;
            font-family: Arial, sans-serif;
            transition: all 0.3s ease;
        }
        
        .activity-input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .btn {
            background: #10b981;
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
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
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
            border-color: #10b981;
            background: #f0fdf4;
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
            background: #10b981;
            width: 30px;
            border-radius: 5px;
        }
        
        .completion-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }
        
        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 30px 0;
            gap: 15px;
        }
        
        .pagination-btn {
            background: #10b981;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover {
            background: #059669;
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
            <h1>🎨 Mga Kulay 🎨</h1>
            <p>Matuto ng Mga Kulay sa Filipino</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang pagdating sa Mga Kulay! 👋</h2>
            <p>Ang pag-unawa sa mga pangalan ng kulay ay mahalaga sa Filipino. Sa araling ito, matututunan mo ang mga pangalan ng iba't ibang kulay at kung paano ito ginagamit sa pang-araw-araw na pag-uusap.</p>
            
            <div class="letter-display">🎨</div>
            
            <div class="activity-box">
                <h3>Tungkol sa Mga Kulay:</h3>
                <ul style="margin-left: 20px;">
                    <li>Ang mga kulay ay bahagi ng ating buhay araw-araw</li>
                    <li>Bawat kulay ay may sariling pangalan sa Filipino</li>
                    <li>Mahalagang malaman ang mga pangalan para sa komunikasyon</li>
                    <li>Maraming bagay ang may iba't ibang kulay</li>
                    <li>Ginagamit sa pag-describe ng mga bagay</li>
                </ul>
            </div>

            <div class="activity-box">
                <h3>Matututunan Mo:</h3>
                <p>Sa araling ito, matututunan mo kung paano:</p>
                <ul style="margin-left: 20px;">
                    <li>Tukuyin ang iba't ibang kulay</li>
                    <li>Sabihin ang pangalan ng bawat kulay sa Filipino</li>
                    <li>Gumamit ng mga pangalan sa mga pangungusap</li>
                    <li>Magsalita tungkol sa mga kulay</li>
                </ul>
            </div>
        </div>

        <!-- Page 2: Primary Colors -->
        <div id="page-2" class="page-section">
            <h2>Pangunahing Kulay 🎯</h2>
            <p>Alamin ang mga pangunahing kulay:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #ff0000; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">🔴</span></div>
                <h3>Pula (Red)</h3>
                <p style="font-size: 1.2rem;">Kulay ng puso - "Ang pula ay isang masiglang kulay"</p>
                <button class="btn" onclick="speak('Pula')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #ffff00; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">🟡</span></div>
                <h3>Dilaw (Yellow)</h3>
                <p style="font-size: 1.2rem;">Kulay ng araw - "Ang dilaw ay kulay ng liwanag"</p>
                <button class="btn" onclick="speak('Dilaw')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #0000ff; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">🔵</span></div>
                <h3>Asul (Blue)</h3>
                <p style="font-size: 1.2rem;">Kulay ng langit at dagat - "Ang asul ay makakaaliw"</p>
                <button class="btn" onclick="speak('Asul')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 3: Secondary Colors -->
        <div id="page-3" class="page-section">
            <h2>📚 Pangalawang Kulay 🎨</h2>
            <p>Alamin ang mga pangalawang kulay:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #008000; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">💚</span></div>
                <h3>Luntian (Green)</h3>
                <p>Kulay ng mga puno at halaman</p>
                <button class="btn" onclick="speak('Luntian')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #800080; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">💜</span></div>
                <h3>Kulay-ube (Purple)</h3>
                <p>Kulay ng mga bulaklak</p>
                <button class="btn" onclick="speak('Kulay-ube')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #ff8c00; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">🧡</span></div>
                <h3>Orange (Orange)</h3>
                <p>Kulay ng prutas at araw-pagsisid</p>
                <button class="btn" onclick="speak('Orange')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 4: Neutral Colors -->
        <div id="page-4" class="page-section">
            <h2>🏠 Walang-buhay na Kulay 🖤</h2>
            <p>Alamin ang mga walang-buhay na kulay:</p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 15px 0;">
            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #ffffff; border: 2px solid #ccc; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">🤍</span></div>
                <h3>Puti (White)</h3>
                <p>Kulay ng putih at kalinis</p>
                <button class="btn" onclick="speak('Puti')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #000000; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">🖤</span></div>
                <h3>Itim (Black)</h3>
                <p>Kulay ng gabi at anino</p>
                <button class="btn" onclick="speak('Itim')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <div style="width: 200px; height: 200px; background-color: #808080; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;"><span style="font-size: 5rem;">🩶</span></div>
                <h3>Kulay-abo (Gray)</h3>
                <p>Kulay ng ulap at hangin</p>
                <button class="btn" onclick="speak('Kulay-abo')">🔊 Marinig</button>
            </div>
            </div>
        </div>

        <!-- Page 5: Quiz -->
        <div id="page-5" class="page-section">
            <h2>📝 Pagsusulit sa Kaalaman 🧠</h2>
            <p>Subukan ang iyong kaalaman tungkol sa mga kulay:</p>
            
            <div class="quiz-question">
                <h3>Tanong 1: Anong kulay ang pula?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Red
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Blue
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Yellow
                </div>
                <div id="feedback-1"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 2: Alin ang kulay ng araw?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    A) Asul
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    B) Dilaw
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Luntian
                </div>
                <div id="feedback-2"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 3: Anong kulay ang langit?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Asul
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Dilaw
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Pula
                </div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 6: Color Combinations -->
        <div id="page-6" class="page-section">
            <h2>🎨 Kombinasyon ng Kulay 🌈</h2>
            <p>Matututunan mo kung paano pinagsasama ang mga kulay:</p>
            
            <div class="activity-box">
                <h3>Halimbawa ng Kombinasyon:</h3>
                <ul style="margin-left: 20px;">
                    <li>Pula + Dilaw = Orange</li>
                    <li>Asul + Dilaw = Luntian</li>
                    <li>Pula + Asul = Purple</li>
                    <li>Lahat ng kulay + Walang kulay = Puti</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Halimbawa:</h3>
                <p>"Ang bahaghari ay may maraming kulay tulad ng pula, dilaw, luntian, asul, at iba pa."</p>
                <button class="btn" onclick="speak('Ang bahaghari ay may maraming kulay')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 7: Real-Life Examples -->
        <div id="page-7" class="page-section">
            <h2>🏠 Mga Kulay sa Araw-araw 📚</h2>
            <p>Makita kung paano ginagamit ang mga kulay sa pang-araw-araw na buhay:</p>
            
            <div class="activity-box">
                <h3>Sa Kakaibang Bagay:</h3>
                <p style="font-size: 1.1rem;">"Ang aking paboritong kulay ay luntian dahil ito ay kulay ng kalikasan."</p>
                <button class="btn" onclick="speak('Ang aking paboritong kulay ay luntian')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Sa Damit at Sapatos:</h3>
                <p style="font-size: 1.1rem;">"Ang aking damit ay pula at ang aking sapatos ay itim."</p>
                <button class="btn" onclick="speak('Ang aking damit ay pula at ang aking sapatos ay itim')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Sa Pagkain:</h3>
                <p style="font-size: 1.1rem;">"Ang mansanas ay maaaring maging pula, berde, o dilaw."</p>
                <button class="btn" onclick="speak('Ang mansanas ay maaaring maging pula berde o dilaw')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 8: Color Preferences -->
        <div id="page-8" class="page-section">
            <h2>❤️ Iyong Paboritong Kulay 💙</h2>
            <p>Malaman ang iyong paboritong kulay at bakit ito maganda:</p>
            
            <div class="activity-box">
                <h3>Paboritong Kulay:</h3>
                <ul style="margin-left: 20px;">
                    <li>Maraming tao ang may iba't ibang paboritong kulay</li>
                    <li>Ang paboritong kulay ay nagpapakita ng ating personalidad</li>
                    <li>Ang bawat kulay ay may ibang kahulugan at damdamin</li>
                    <li>Mahalaga na malaman ang iyong paboritong kulay</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Halimbawa:</h3>
                <p>"Ang aking paboritong kulay ay asul dahil ito ay nakaka-calm at maganda."</p>
                <button class="btn" onclick="speak('Ang aking paboritong kulay ay asul')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 9: Summary & Completion -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Aralin</h2>
            
            <div class="completion-badge">
                <h2>✅ Binabati Kita! 🎉</h2>
                <p>Nagtapos ka na ng "Mga Kulay" na interaktibong aral!</p>
                <p style="font-size: 1.2rem; margin-top: 15px;">Natutunan mo ang mga pangalan ng iba't ibang kulay at kung paano ito ginagamit sa pang-araw-araw na buhay sa Filipino!</p>
            </div>

            <div class="activity-box">
                <h3>Mga Pangunahing Araw-araw:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Ang mga pangunahing kulay ay pula, dilaw, at asul</li>
                    <li>✅ Ang mga pangalawang kulay ay luntian, kulay-ube, at orange</li>
                    <li>✅ Ang mga walang-buhay na kulay ay puti, itim, at kulay-abo</li>
                    <li>✅ Ang mga kulay ay mahalaga sa pag-describe ng mga bagay</li>
                    <li>✅ Bawat tao ay may iba't ibang paboritong kulay</li>
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
            <h2 style="color: #10b981; font-size: 1.8rem; margin-bottom: 20px;">🏆 Kahanga-Hangang Gawain!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 30px;">Matagumpay mong nagtapos ng "Mga Kulay" na aral. Napakaganda ng iyong progreso!</p>
            
            <!-- Gamification Stats -->
            <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 25px; border-radius: 10px; margin-bottom: 25px;">
                <h3 style="color: #10b981; margin-bottom: 15px;">📊 Iyong Performance</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; text-align: center;">
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Total Points</p>
                        <p style="color: #10b981; font-size: 1.8rem; font-weight: bold;" id="finalPoints">0</p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Best Streak</p>
                        <p style="color: #10b981; font-size: 1.8rem; font-weight: bold;" id="finalStreak">0</p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Time Spent</p>
                        <p style="color: #10b981; font-size: 1.6rem; font-weight: bold;" id="timeTaken">0:00</p>
                    </div>
                </div>
            </div>
            
            <!-- Badges Earned -->
            <div id="badgesEarned" style="display: none; background: #d1fae5; padding: 15px; border-radius: 10px; margin-bottom: 25px;">
                <p style="color: #047857; font-weight: bold; margin-bottom: 10px;">🎖️ Badges Unlocked</p>
                <div id="earnedBadgesList" style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;"></div>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button style="background: #10b981; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem;" onclick="returnToTopics()">Bumalik sa Topics</button>
            </div>
        </div>
    </div>

    <script>
        const totalPages = 9;
        let currentPage = 1;
        
        // Gamification State
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
                <div class="badge ${gameState.badges.includes('perfectScore') ? '' : 'locked'}" data-badge="perfectScore" title="Perfect Score">
                    💯
                    <div class="badge-tooltip">Perfect Score</div>
                </div>
                <div class="badge ${gameState.badges.includes('onFire') ? '' : 'locked'}" data-badge="onFire" title="On Fire">
                    🔥
                    <div class="badge-tooltip">On Fire (3 Streak)</div>
                </div>
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
                    feedback.innerHTML = '<div class="feedback success">✅ Tamang sagot! Napakaganda!</div>';
                    speak('Tamang sagot!');
                }
                
                addPoints(10);
                updateStreak(true);
                triggerConfetti(event);
                
            } else {
                element.classList.add('incorrect');
                const feedback = parent.querySelector('[id^="feedback-"]');
                if (feedback) {
                    feedback.innerHTML = '<div class="feedback error">❌ Mali ito. Subukan ulit!</div>';
                    speak('Mali ito. Subukan ulit!');
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
            
            checkAchievements();
        }
        
        function updateStreak(correct) {
            if (correct) {
                gameState.streak++;
                document.getElementById('streakDisplay').textContent = gameState.streak;
                document.getElementById('streakDisplay').classList.add('streak-highlight');
                setTimeout(() => document.getElementById('streakDisplay').classList.remove('streak-highlight'), 500);
                
                if (gameState.streak === 3) {
                    unlockBadge('onFire', '🔥', 'Napakabilis!');
                }
            } else {
                gameState.streak = 0;
                document.getElementById('streakDisplay').textContent = '0';
            }
        }
        
        function triggerConfetti(event) {
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
        
        function unlockBadge(id, emoji, name) {
            if (!gameState.badges.includes(id)) {
                gameState.badges.push(id);
                
                const badgeEl = document.querySelector(`[data-badge="${id}"]`);
                if (badgeEl) {
                    badgeEl.classList.remove('locked');
                    badgeEl.classList.add('badge-unlock');
                    
                    const notification = document.createElement('div');
                    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 20px 30px; border-radius: 10px; font-weight: bold; z-index: 9999; animation: slide-up 0.6s ease-out;';
                    notification.textContent = `🏆 ${name} Badge Unlocked! 🏆`;
                    document.body.appendChild(notification);
                    setTimeout(() => notification.remove(), 3000);
                }
            }
        }
        
        function checkAchievements() {
            if (gameState.questionsAnswered === 3 && gameState.totalPoints === 30) {
                unlockBadge('perfectScore', '💯', 'Perfect Score!');
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
                    lesson_slug: 'mga-kulay'
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const timeSpent = Math.floor((Date.now() - gameState.startTime) / 1000);
                const minutes = Math.floor(timeSpent / 60);
                const seconds = timeSpent % 60;
                const formattedTime = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                document.getElementById('finalPoints').textContent = gameState.totalPoints;
                document.getElementById('finalStreak').textContent = gameState.streak;
                document.getElementById('timeTaken').textContent = formattedTime;
                
                if (gameState.badges.length > 0) {
                    const badgesEarned = document.getElementById('badgesEarned');
                    badgesEarned.style.display = 'block';
                    const badgesList = document.getElementById('earnedBadgesList');
                    
                    const badgeMap = {
                        'perfectScore': '💯 Perfect Score',
                        'onFire': '🔥 On Fire'
                    };
                    
                    badgesList.innerHTML = gameState.badges.map(badge => 
                        `<span style="background: white; padding: 8px 12px; border-radius: 6px; font-weight: bold; color: #10b981;">${badgeMap[badge] || badge}</span>`
                    ).join('');
                }
                
                document.getElementById('completionModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking lesson as complete');
            });
        }

        function closeModal() {
            document.getElementById('completionModal').classList.add('hidden');
        }

        function returnToTopics() {
            window.location.href = '{{ route("subject.topics", ["subject" => "filipino"]) }}';
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
</x-layouts::app>
