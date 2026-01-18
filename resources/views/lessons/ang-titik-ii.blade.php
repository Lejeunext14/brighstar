<x-layouts::app :title="__('Ang Titik Ii - Interactive Filipino Alphabet Learning')">
    <style>
        @keyframes fade-in { 0% { opacity: 0; } 100% { opacity: 1; } }
        @keyframes slide-up { 0% { transform: translateY(20px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        
        .fade-in { animation: fade-in 0.6s ease-in; }
        .slide-up { animation: slide-up 0.6s ease-out; }
        .pulse-animation { animation: pulse 2s infinite; }
        .bounce-animation { animation: bounce 0.6s infinite; }
        @keyframes confetti-fall { 0% { transform: translateY(-100px) rotate(0deg); opacity: 1; } 100% { transform: translateY(800px) rotate(360deg); opacity: 0; } }
        @keyframes point-popup { 0% { transform: translateY(0) scale(1); opacity: 1; } 100% { transform: translateY(-50px) scale(0.8); opacity: 0; } }
        @keyframes badge-unlock { 0% { transform: scale(0); opacity: 0; } 50% { transform: scale(1.2); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes streak-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        
        .confetti { position: fixed; pointer-events: none; font-size: 2rem; animation: confetti-fall 3s ease-in forwards; }
        .point-popup { position: fixed; font-weight: bold; color: #10b981; animation: point-popup 1s ease-out forwards; pointer-events: none; }
        .badge-unlock { animation: badge-unlock 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        .streak-highlight { animation: streak-pulse 0.5s ease-in-out; }
        
        /* Gamification UI */
        .gamification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
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
            background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
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
            border-color: #eab308;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(234, 179, 8, 0.2);
        }
        
        .letter-display {
            background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
            font-size: 5rem;
            font-weight: bold;
        }
        
        .example-card {
            background: linear-gradient(135deg, #fef08a 0%, #fef3c7 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 5px solid #eab308;
        }
        
        .activity-box {
            background: linear-gradient(135deg, #fef08a 0%, #fef3c7 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #eab308;
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
            border-color: #eab308;
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.1);
        }
        
        .btn {
            background: #eab308;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin: 10px 5px 10px 0;
        }
        
        .btn:hover {
            background: #ca8a04;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(234, 179, 8, 0.3);
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            margin: 20px 0;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #eab308 0%, #ca8a04 100%);
            width: 11%;
            transition: width 0.3s ease;
        }
        
        .page-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        
        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .dot.active {
            background: #eab308;
            width: 32px;
            border-radius: 6px;
        }
        
        .quiz-question {
            background: white;
            border: 2px solid #e5e7eb;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .quiz-option {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .quiz-option:hover {
            border-color: #eab308;
            background: #fef08a;
        }
        
        .quiz-option.correct {
            border-color: #10b981;
            background: #d1fae5;
            color: #047857;
        }
        
        .quiz-option.incorrect {
            border-color: #ef4444;
            background: #fee2e2;
            color: #dc2626;
        }
        
        .feedback {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: bold;
        }
        
        .feedback.success {
            background: #d1fae5;
            color: #047857;
            border-left: 4px solid #10b981;
        }
        
        .feedback.error {
            background: #fee2e2;
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }
        
        .completion-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
        }
        
        .pagination-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        
        .pagination-btn {
            background: #eab308;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            background: #ca8a04;
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
        <!-- Header -->
        <div class="professional-header slide-up">
            <h1>🔤 Ang Titik Ii 🔤</h1>
            <p>Matuto ng Titik Ii sa Alpabetong Filipino</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang pagdating sa Ang Titik Ii! 👋</h2>
            <p>Ang titik "Ii" ang ikatlong patinig ng alpabetong Filipino. Ito ay isang mahalagang patinig na tumutunog na /i/ gaya ng sa salitang "itlog".</p>
            
            <div class="letter-display">I</div>
            
            <div class="activity-box">
                <h3>Tungkol sa Titik Ii:</h3>
                <ul style="margin-left: 20px;">
                    <li>Ang titik "Ii" ay ikatlong patinig sa alpabeto</li>
                    <li>Ito ay isang patinig (vowel)</li>
                    <li>Tumutunog: /i/ - gaya sa "itlog", "itak", "ingay"</li>
                    <li>Malaking titik: I</li>
                    <li>Maliit na titik: i</li>
                </ul>
            </div>

            <div class="activity-box">
                <h3>Matututunan Mo:</h3>
                <p>Sa araling ito, matututunan mo kung paano:</p>
                <ul style="margin-left: 20px;">
                    <li>Tukuyin ang tunog ng titik Ii</li>
                    <li>Isulat ang titik Ii</li>
                    <li>Mahanap ang titik Ii sa mga salita</li>
                    <li>Lumikha ng sariling salita na nagsisimula ng Ii</li>
                </ul>
            </div>
        </div>

        <!-- Page 2: Sound and Pronunciation -->
        <div id="page-2" class="page-section">
            <h2>Tunog ng Titik Ii 🔊</h2>
            <p>Marinig kung paano tumutunog ang titik Ii:</p>
            
            <div class="letter-display">I</div>
            <div style="text-align: center; margin: 20px 0;">
                <button class="btn" onclick="speak('I')">🔊 Marinig ang Tunog I</button>
            </div>

            <div class="example-card">
                <h3>Mga Salitang Nagsisimula ng Ii:</h3>
                <p><strong>1. Itlog</strong> - Bunga ng ibon na malalim na kulay</p>
                <button class="btn" onclick="speak('Itlog')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>2. Itak</h3>
                <p>Isang kagamitan para sa pagsasaka</p>
                <button class="btn" onclick="speak('Itak')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>3. Ingay</h3>
                <p>Tunog na nakakagambala o malakas</p>
                <button class="btn" onclick="speak('Ingay')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>4. Ilog</h3>
                <p>Daloy ng tubig papunta sa dagat</p>
                <button class="btn" onclick="speak('Ilog')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 3: Writing Practice -->
        <div id="page-3" class="page-section">
            <h2>✍️ Pagsasanay sa Pagsulat</h2>
            <p>Magsanay sa pagsulat ng titik Ii:</p>
            
            <div class="activity-box">
                <h3>Malaking Titik I</h3>
                <p>Subukan na isulat ang malalaking titik I sa puwesto:</p>
                <div style="font-size: 2rem; text-align: center; padding: 20px; background: white; border: 2px dashed #eab308; border-radius: 8px; margin: 10px 0;">
                    ______
                </div>
                <button class="btn" onclick="speak('Malaking titik I')">🔊 Gabay</button>
            </div>

            <div class="activity-box">
                <h3>Maliit na Titik i</h3>
                <p>Subukan na isulat ang maliit na titik i sa puwesto:</p>
                <div style="font-size: 2rem; text-align: center; padding: 20px; background: white; border: 2px dashed #eab308; border-radius: 8px; margin: 10px 0;">
                    ______
                </div>
                <button class="btn" onclick="speak('Maliit na titik i')">🔊 Gabay</button>
            </div>
        </div>

        <!-- Page 4: Words with Ii -->
        <div id="page-4" class="page-section">
            <h2>📚 Mga Salita na May Titik I</h2>
            <p>Tingnan ang iba't ibang salita na may titik I:</p>
            
            <div class="activity-box">
                <h3>Salita na Nagsisimula ng I:</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="interactive-card" onclick="speak('Ibig')">
                        <strong>Ibig</strong> (nais, gusto)
                        <span style="float: right;">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speak('Ilaw')">
                        <strong>Ilaw</strong> (liwanag, buhay)
                        <span style="float: right;">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speak('Iwanan')">
                        <strong>Iwanan</strong> (mag-iwan, maglibot)
                        <span style="float: right;">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speak('Isip')">
                        <strong>Isip</strong> (pag-iisip, utak)
                        <span style="float: right;">🔊</span>
                    </div>
                </div>
            </div>

            <div class="activity-box">
                <h3>Salita na May I sa Gitna:</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="interactive-card" onclick="speak('Diwa')">
                        <strong>Diwa</strong> (kahulugan, puso)
                        <span style="float: right;">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speak('Bili')">
                        <strong>Bili</strong> (bumili, benta)
                        <span style="float: right;">🔊</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page 5: Practice Activity -->
        <div id="page-5" class="page-section">
            <h2>🎯 Pagsasanay: Hanapin ang Titik I</h2>
            <p>Magsulat ng mga salitang nagsisimula ng titik I:</p>
            
            <div class="activity-box">
                <h3>Lumikha ng Salita na Nagsisimula ng I:</h3>
                <input type="text" id="wordInput1" class="activity-input" placeholder="Halimbawa: Itlog">
                <button class="btn" onclick="speak(document.getElementById('wordInput1').value || 'Mangyaring magsulat ng salita')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Bilangin ang Titik I sa Salita:</h3>
                <p>Basahin ang salitang ito at bilangin kung gaano kamaraming "I" ang mayroon: <strong>ITLOG ITAK INGAY</strong></p>
                <input type="text" id="countInput" class="activity-input" placeholder="Bilangin ang I">
                <button class="btn" onclick="speak('Mayroon limang titik I sa tatlong salitang ito')">🔊 Tamang Sagot</button>
            </div>
        </div>

        <!-- Page 6: Quiz -->
        <div id="page-6" class="page-section">
            <h2>📝 Pagsusulit sa Kaalaman</h2>
            <p>Subukan ang iyong kaalaman tungkol sa titik Ii:</p>
            
            <div class="quiz-question">
                <h3>Tanong 1: Ilan ang titik I sa salitang "INGAY"?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) 2
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) 1
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) 3
                </div>
                <div id="feedback-1"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 2: Anong tunog ng titik I?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) /i/ - gaya sa itlog
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) /a/ - gaya sa araw
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) /e/ - gaya sa elemento
                </div>
                <div id="feedback-2"></div>
            </div>

            <div class="quiz-question">
                <h3>Tanong 3: Alin sa mga salita ang nagsisimula ng I?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Ilog
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Araw
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Oras
                </div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 7: Letter Variations -->
        <div id="page-7" class="page-section">
            <h2>🔡 Mga Paraan ng Pagsulat ng I</h2>
            <p>Alamin ang iba't ibang paraan ng pagsulat ng titik I:</p>
            
            <div class="example-card">
                <h3>Malaking Titik (Capital Letter):</h3>
                <p style="font-size: 3rem; text-align: center; font-weight: bold;">I</p>
                <p>Ginagamit sa simula ng pangungusap at sa mga pangalan</p>
                <button class="btn" onclick="speak('Malaking titik I')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Maliit na Titik (Lowercase Letter):</h3>
                <p style="font-size: 3rem; text-align: center; font-weight: bold;">i</p>
                <p>Ginagamit sa gitna at dulo ng mga salita</p>
                <button class="btn" onclick="speak('Maliit na titik i')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Halimbawa ng Paggamit:</h3>
                <p><strong>Malaking:</strong> "Ang Ilog ay may Ingay"</p>
                <p><strong>Maliit:</strong> "ang ilog ay may ingay"</p>
                <button class="btn" onclick="speak('Ang Ilog ay may Ingay')">🔊 Halimbawa</button>
            </div>
        </div>

        <!-- Page 8: Real-Life Examples -->
        <div id="page-8" class="page-section">
            <h2>🏠 Mga Halimbawa sa Araw-araw</h2>
            <p>Makita kung paano ginagamit ang titik I sa pang-araw-araw na buhay:</p>
            
            <div class="activity-box">
                <h3>Kailangang Intake:</h3>
                <p style="font-size: 1.2rem; font-weight: bold;">"Ibig ko ay kumain ng Itlog para sa almusal!"</p>
                <button class="btn" onclick="speak('Ibig ko ay kumain ng Itlog para sa almusal')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Tanong sa Kailansuran:</h3>
                <p style="font-size: 1.2rem; font-weight: bold;">"Nakikita mo ang Ilaw sa gabi?"</p>
                <button class="btn" onclick="speak('Nakikita mo ang Ilaw sa gabi')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Maikling Kwento:</h3>
                <p style="font-size: 1.1rem;">"Ang itlog ay hindi madaling palitaw. Kailangan ng ilaw at ingay. Sa ilog, maraming itlog para sa ating pagkain."</p>
                <button class="btn" onclick="speak('Ang itlog ay hindi madaling palitaw. Kailangan ng ilaw at ingay')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 9: Summary & Completion -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Aralin</h2>
            
            <div class="completion-badge">
                <h2>✅ Binabati Kita! 🎉</h2>
                <p>Nagtapos ka na ng "Ang Titik Ii" na interaktibong aral!</p>
                <p style="font-size: 1.2rem; margin-top: 15px;">Natutunan mo ang tunog, pagsulat, at paggamit ng titik Ii sa iba't ibang mga salita at konteksto!</p>
            </div>

            <div class="activity-box">
                <h3>Mga Pangunahing Aral:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Ang titik I ay ikatlong patinig sa alpabeto</li>
                    <li>✅ Ito ay isang patinig na tumutunog /i/</li>
                    <li>✅ Maraming salita ang nagsisimula ng I</li>
                    <li>✅ May malaking at maliit na paraan ng pagsulat</li>
                    <li>✅ Mahahalagang salita na may I: itlog, itak, ingay, ilog</li>
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
        <div style="background: white; border-radius: 15px; padding: 40px; max-width: 400px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <h2 style="color: #eab308; font-size: 1.8rem; margin-bottom: 20px;">🏆 Kahanga-Hangang Gawain!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 20px;">Matagumpay mong nagtapos ang "Ang Titik Ii" na aral. Napakaganda ng iyong progreso!</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="closeModal()" style="padding: 10px 20px; background: #e5e7eb; color: #374151; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Magpatuloy sa Pag-aaral</button>
                <button onclick="returnToTopics()" style="padding: 10px 20px; background: #eab308; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Bumalik sa Mga Paksa</button>
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
                const badgeMap = {'perfectScore': '💯 Perfect Score', 'onFire': '🔥 On Fire'};
                badgesList.innerHTML = gameState.badges.map(badge => `<span style="background: white; padding: 8px 12px; border-radius: 6px; font-weight: bold; color: #ec4899;">${badgeMap[badge] || badge}</span>`).join('');
            }
            
            document.getElementById('completionModal').classList.remove('hidden');
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
