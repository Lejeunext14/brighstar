<x-layouts::app :title="__('Bahagi ng Katawan - Interactive Filipino Body Parts Learning')">
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            border-color: #f59e0b;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.2);
        }
        
        .letter-display {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
            font-size: 3rem;
            font-weight: bold;
        }
        
        .example-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fcd34d 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 5px solid #f59e0b;
        }
        
        .activity-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fcd34d 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #f59e0b;
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
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }
        
        .btn {
            background: #f59e0b;
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
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
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
            border-color: #f59e0b;
            background: #fffbeb;
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
            background: #f59e0b;
            width: 30px;
            border-radius: 5px;
        }
        
        .completion-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
        }
        
        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 30px 0;
            gap: 15px;
        }
        
        .pagination-btn {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover {
            background: #d97706;
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
            <h1>🫀 Bahagi ng Katawan 🫀</h1>
            <p>Matuto ng Mga Bahagi ng Katawan sa Filipino</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang pagdating sa Bahagi ng Katawan! 👋</h2>
            <p>Ang pag-unawa sa mga pangalan ng bahagi ng katawan ay mahalaga sa Filipino. Sa araling ito, matututunan mo ang mga pangalan ng iba't ibang bahagi ng katawan at kung paano ito ginagamit sa pang-araw-araw na pag-uusap.</p>
            
            <div class="letter-display">👤</div>
            
            <div class="activity-box">
                <h3>Tungkol sa Bahagi ng Katawan:</h3>
                <ul style="margin-left: 20px;">
                    <li>Ang katawan ay binubuo ng iba't ibang bahagi</li>
                    <li>Bawat bahagi ay may sariling pangalan sa Filipino</li>
                    <li>Mahalagang malaman ang mga pangalan para sa komunikasyon at kalusugan</li>
                    <li>Maraming salita para sa bawat bahagi (formal at colloquial)</li>
                    <li>Ginagamit sa pang-araw-araw na pakikipag-ugnayan</li>
                </ul>
            </div>

            <div class="activity-box">
                <h3>Matututunan Mo:</h3>
                <p>Sa araling ito, matututunan mo kung paano:</p>
                <ul style="margin-left: 20px;">
                    <li>Tukuyin ang mga pangunahing bahagi ng katawan</li>
                    <li>Sabihin ang pangalan ng bawat bahagi sa Filipino</li>
                    <li>Gumamit ng mga pangalan sa mga pangungusap</li>
                    <li>Magsalita tungkol sa katawan at kalusugan</li>
                </ul>
            </div>
        </div>

        <!-- Page 2: Head and Face -->
        <div id="page-2" class="page-section">
            <h2>Ang Ulo at Mukha 🗣️</h2>
            <p>Alamin ang mga bahagi ng ulo at mukha:</p>
            
            <div class="example-card">
                <img src="/image/ulo.jpg" alt="Head" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Ulo (Head)</h3>
                <p style="font-size: 1.2rem;">Ang bahagi ng katawan na nasa itaas ng leher</p>
                <button class="btn" onclick="speak('Ulo')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <img src="/image/mata.jpg" alt="Eyes" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Mga Mata (Eyes)</h3>
                <p style="font-size: 1.2rem;">Para makita - "Ang aking mga mata ay berde"</p>
                <button class="btn" onclick="speak('Mga mata')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <img src="/image/nose.jpg" alt="Nose" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Ilong (Nose)</h3>
                <p style="font-size: 1.2rem;">Para huminga - "Mahalaga ang ilong para huminga"</p>
                <button class="btn" onclick="speak('Ilong')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <img src="/image/mouth.jpg" alt="Mouth" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Bibig (Mouth)</h3>
                <p style="font-size: 1.2rem;">Para kumain at magsalita - "Ang bibig ay ginagamit para kumain"</p>
                <button class="btn" onclick="speak('Bibig')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <img src="/image/earsh.jpg" alt="Ears" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Tenga (Ears)</h3>
                <p style="font-size: 1.2rem;">Para marinig - "Ang tenga ay nakakarinig ng tunog"</p>
                <button class="btn" onclick="speak('Tenga')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 3: Upper Body -->
        <div id="page-3" class="page-section">
            <h2>Ang Itaas ng Katawan 💪</h2>
            <p>Alamin ang mga bahagi ng itaas ng katawan:</p>
            
            <div class="example-card">
                <h3>Balikat (Shoulder)</h3>
                <p>Ang bahagi sa pagitan ng leher at braso</p>
                <button class="btn" onclick="speak('Balikat')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Braso (Arm)</h3>
                <p>Mula sa balikat hanggang siko</p>
                <button class="btn" onclick="speak('Braso')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Kamay (Hand)</h3>
                <p>May lima na daliri - "Ang kamay ay may limang daliri"</p>
                <button class="btn" onclick="speak('Kamay')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Dibdib (Chest)</h3>
                <p>Ang bahagi sa loob ng puso at baga</p>
                <button class="btn" onclick="speak('Dibdib')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Tiyan (Stomach/Belly)</h3>
                <p>Ang bahagi sa gitna ng katawan</p>
                <button class="btn" onclick="speak('Tiyan')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 4: Lower Body -->
        <div id="page-4" class="page-section">
            <h2>📚 Ang Ibaba ng Katawan 🦵</h2>
            <p>Alamin ang mga bahagi ng ibaba ng katawan:</p>
            
            <div class="example-card">
                <h3>Hita (Hip/Thigh)</h3>
                <p>Ang bahagi sa pagitan ng baywang at tuhod</p>
                <button class="btn" onclick="speak('Hita')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Binti (Leg)</h3>
                <p>Mula sa hita hanggang paa - "Ang binti ay ginagamit para maglakad"</p>
                <button class="btn" onclick="speak('Binti')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Tuhod (Knee)</h3>
                <p>Ang kasangkapan sa pagitan ng paha at binti</p>
                <button class="btn" onclick="speak('Tuhod')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Paa (Foot)</h3>
                <p>May limang daliri - "Ang paa ay may limang daliri sa paa"</p>
                <button class="btn" onclick="speak('Paa')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Likod (Back)</h3>
                <p>Ang bahagi sa likod ng katawan</p>
                <button class="btn" onclick="speak('Likod')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 5: Internal Organs -->
        <div id="page-5" class="page-section">
            <h2>🫀 Panloob na Bahagi ng Katawan 🧠</h2>
            <p>Alamin ang mga panloob na bahagi ng katawan:</p>
            
            <div class="example-card">
                <h3>Puso (Heart)</h3>
                <p>Nagpapalakas ng dugo sa katawan - "Ang puso ay mahalaga para sa buhay"</p>
                <button class="btn" onclick="speak('Puso')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Baga (Lungs)</h3>
                <p>Para sa paghihinga - "Ang baga ay tumutulong na huminga"</p>
                <button class="btn" onclick="speak('Baga')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Utak (Brain)</h3>
                <p>Ang sentro ng ating kaisipan at damdaman</p>
                <button class="btn" onclick="speak('Utak')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Bituka (Intestines)</h3>
                <p>Tumutulong sa pagsisiguro ng pagkain</p>
                <button class="btn" onclick="speak('Bituka')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Dugo (Blood)</h3>
                <p>Nagdadala ng oxygen sa katawan</p>
                <button class="btn" onclick="speak('Dugo')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 6: Quiz -->
        <div id="page-6" class="page-section">
            <h2>📝 Pagsusulit sa Kaalaman 🧠</h2>
            <p>Subukan ang iyong kaalaman tungkol sa bahagi ng katawan:</p>
            
            <div class="quiz-question">
                <h3>Tanong 1: Anong bahagi ng katawan ang ginagamit para makita?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Mga Mata
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Ilong
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Tenga
                </div>
                <div id="feedback-1"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 2: Alin ang bahagi ng katawan na may limang daliri?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Kamay
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Paa
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Braso
                </div>
                <div id="feedback-2"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 3: Anong bahagi ng katawan ang tumutulong sa paghihinga?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Baga
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Puso
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Utak
                </div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 7: Health and Care -->
        <div id="page-7" class="page-section">
            <h2>🏥 Pag-aalaga ng Katawan 💊</h2>
            <p>Matututunan mo kung paano alagaan ang iyong katawan:</p>
            
            <div class="activity-box">
                <h3>Mga Paraan para Pangalagaan ang Katawan:</h3>
                <ul style="margin-left: 20px;">
                    <li>Kainin ang malusog na pagkain para sa buong katawan</li>
                    <li>Magsugal at maglaro para sa malakas na binti at katawan</li>
                    <li>Tulog ng sapat para sa malusog na utak at katawan</li>
                    <li>Minumin ang tubig para sa sehat ng lahat ng bahagi</li>
                    <li>Maghugas ng mga kamay para sa kalinisan</li>
                </ul>
            </div>

            <div class="example-card">
                <h3>Halimbawa:</h3>
                <p>"Kailangan nating pangalagaan ang ating katawan sa pamamagitan ng malusog na pagkain, ehersisyo, at tulog."</p>
                <button class="btn" onclick="speak('Kailangan nating pangalagaan ang ating katawan')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 8: Real-Life Examples -->
        <div id="page-8" class="page-section">
            <h2>🏠 Mga Halimbawa sa Araw-araw 📚</h2>
            <p>Makita kung paano ginagamit ang mga bahagi ng katawan sa pang-araw-araw na buhay:</p>
            
            <div class="activity-box">
                <h3>Pagkain at Pag-inom:</h3>
                <p style="font-size: 1.1rem;">"Gumagamit kami ng bibig at dilim para kumain at uminom ng tubig."</p>
                <button class="btn" onclick="speak('Gumagamit kami ng bibig at dilim para kumain at uminom ng tubig')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Pag-aaral at Pakikinig:</h3>
                <p style="font-size: 1.1rem;">"Gumagamit kami ng mga mata para basahin at tenga para makinig sa guro."</p>
                <button class="btn" onclick="speak('Gumagamit kami ng mga mata para basahin at tenga para makinig')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Paglalakad at Paglaro:</h3>
                <p style="font-size: 1.1rem;">"Ang ating mga binti at paa ay tumutulong sa atin na maglakad at maglaro."</p>
                <button class="btn" onclick="speak('Ang ating mga binti at paa ay tumutulong sa atin na maglakad')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Pagsusulat at Paggawa:</h3>
                <p style="font-size: 1.1rem;">"Ang ating mga kamay at daliri ay ginagamit para magsulat at gumawa ng mga bagay."</p>
                <button class="btn" onclick="speak('Ang ating mga kamay ay ginagamit para magsulat')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 9: Summary & Completion -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Aralin</h2>
            
            <div class="completion-badge">
                <h2>✅ Binabati Kita! 🎉</h2>
                <p>Nagtapos ka na ng "Bahagi ng Katawan" na interaktibong aral!</p>
                <p style="font-size: 1.2rem; margin-top: 15px;">Natutunan mo ang mga pangalan ng iba't ibang bahagi ng katawan at kung paano ito ginagamit sa pang-araw-araw na buhay sa Filipino!</p>
            </div>

            <div class="activity-box">
                <h3>Mga Pangunahing Araw-araw:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Ang katawan ay binubuo ng maraming bahagi</li>
                    <li>✅ Bawat bahagi ay may mahalagang papel sa ating buhay</li>
                    <li>✅ Mahalaga itong malaman ang mga pangalan para sa komunikasyon</li>
                    <li>✅ Ang pag-aalaga ng katawan ay mahalaga para sa kalusugan</li>
                    <li>✅ Ginagamit natin ang iba't ibang bahagi para sa iba't ibang gawain</li>
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
            <h2 style="color: #f59e0b; font-size: 1.8rem; margin-bottom: 20px;">🏆 Kahanga-Hangang Gawain!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 30px;">Matagumpay mong nagtapos ng "Bahagi ng Katawan" na aral. Napakaganda ng iyong progreso!</p>
            
            <!-- Gamification Stats -->
            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fcd34d 100%); padding: 25px; border-radius: 10px; margin-bottom: 25px;">
                <h3 style="color: #f59e0b; margin-bottom: 15px;">📊 Iyong Performance</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; text-align: center;">
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Total Points</p>
                        <p style="color: #f59e0b; font-size: 1.8rem; font-weight: bold;" id="finalPoints">0</p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Best Streak</p>
                        <p style="color: #f59e0b; font-size: 1.8rem; font-weight: bold;" id="finalStreak">0</p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 5px;">Time Spent</p>
                        <p style="color: #f59e0b; font-size: 1.6rem; font-weight: bold;" id="timeTaken">0:00</p>
                    </div>
                </div>
            </div>
            
            <!-- Badges Earned -->
            <div id="badgesEarned" style="display: none; background: #fef3c7; padding: 15px; border-radius: 10px; margin-bottom: 25px;">
                <p style="color: #92400e; font-weight: bold; margin-bottom: 10px;">🎖️ Badges Unlocked</p>
                <div id="earnedBadgesList" style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;"></div>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button style="background: #f59e0b; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem;" onclick="returnToTopics()">Bumalik sa Topics</button>
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
                
                // Add points and update streak
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
            
            // Show point popup
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
                    
                    // Show unlock animation
                    const notification = document.createElement('div');
                    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 20px 30px; border-radius: 10px; font-weight: bold; z-index: 9999; animation: slide-up 0.6s ease-out;';
                    notification.textContent = `🏆 ${name} Badge Unlocked! 🏆`;
                    document.body.appendChild(notification);
                    setTimeout(() => notification.remove(), 3000);
                }
            }
        }
        
        function checkAchievements() {
            // Perfect Score badge (all 3 questions correct)
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
                    lesson_slug: 'bahagi-ng-katawan'
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Calculate time spent
                const timeSpent = Math.floor((Date.now() - gameState.startTime) / 1000);
                const minutes = Math.floor(timeSpent / 60);
                const seconds = timeSpent % 60;
                const formattedTime = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                // Update modal with stats
                document.getElementById('finalPoints').textContent = gameState.totalPoints;
                document.getElementById('finalStreak').textContent = gameState.streak;
                document.getElementById('timeTaken').textContent = formattedTime;
                
                // Show badges if earned
                if (gameState.badges.length > 0) {
                    const badgesEarned = document.getElementById('badgesEarned');
                    badgesEarned.style.display = 'block';
                    const badgesList = document.getElementById('earnedBadgesList');
                    
                    const badgeMap = {
                        'perfectScore': '💯 Perfect Score',
                        'onFire': '🔥 On Fire'
                    };
                    
                    badgesList.innerHTML = gameState.badges.map(badge => 
                        `<span style="background: white; padding: 8px 12px; border-radius: 6px; font-weight: bold; color: #f59e0b;">${badgeMap[badge] || badge}</span>`
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
