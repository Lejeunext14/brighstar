<x-layouts::app :title="__('Ang Aking Pamilya - Interactive Filipino Family Learning')">
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }
        
        /* Slider Animation Styles */
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
        
        .slider-container {
            position: relative;
            overflow: hidden;
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px 20px;
        }
        
        .family-grid {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
            margin: 20px 0;
            position: relative;
            min-height: 320px;
        }
        
        .family-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            flex: 0 0 100%;
            min-width: 300px;
            animation: slide-in-left 0.5s ease-in-out;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .family-card:first-child {
            display: flex;
        }
        
        .family-card.slide-out {
            animation: slide-out-left 0.5s ease-in-out;
        }
        
        .family-card.slide-in-right {
            animation: slide-in-right 0.5s ease-in-out;
        }
        
        .family-card.slide-out-right {
            animation: slide-out-right 0.5s ease-in-out;
        }
        
        .family-card:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }
        
        .family-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        
        .family-card h3 {
            font-size: 1.5rem;
            margin: 10px 0;
        }
        
        .family-card p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .play-btn {
            background: rgba(255,255,255,0.3);
            padding: 8px 12px;
            border-radius: 8px;
            border: 2px solid white;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .play-btn:hover {
            background: white;
            color: #667eea;
        }
        
        .slider-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .slider-btn {
            background: #667eea;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .slider-btn:hover:not(:disabled) {
            background: #764ba2;
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .slider-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .slider-counter {
            font-weight: bold;
            color: #667eea;
            font-size: 1rem;
            min-width: 120px;
            text-align: center;
            background: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: 2px solid #667eea;
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
        }
        
        .slider-dot:hover {
            background: #667eea;
            transform: scale(1.2);
        }
        
        .slider-dot.active {
            background: #667eea;
            width: 32px;
            border-radius: 6px;
            border: 2px solid #764ba2;
        }
        
        .activity-box {

            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #667eea;
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
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn {
            background: #667eea;
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
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: #6b7280;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
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
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            width: 11%;
            transition: width 0.3s ease;
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
            padding: 12px 25px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .page-counter {
            font-weight: bold;
            color: #667eea;
            font-size: 1.1rem;
            min-width: 100px;
            text-align: center;
        }
        
        .page-dots {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 20px 0;
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
            background: #667eea;
            width: 32px;
            border-radius: 6px;
        }
        
        .quiz-question {
            background: white;
            border: 2px solid #e5e7eb;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
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
            border-color: #667eea;
            background: #f0f4ff;
        }
        
        .quiz-option.selected {
            border-color: #667eea;
            background: #dbeafe;
            font-weight: bold;
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
        
        .sound-icon {
            display: inline-block;
            cursor: pointer;
            font-size: 1.5rem;
            margin-left: 10px;
            transition: all 0.3s ease;
        }
        
        .sound-icon:hover {
            transform: scale(1.2);
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
        
        h1, h2, h3, h4, h5, h6 {
            color: #1f2937;
        }
        
        p {
            color: #555;
            line-height: 1.8;
        }
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
            <h1>🏠 Ang Aking Pamilya 🏠</h1>
            <p>Interaktibong Karanasan sa Pamilyang Pilipino</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang pagdating sa Ang Aking Pamilya! 👨‍👩‍👧‍👦</h2>
            <p>Matuto tungkol sa pamilya sa kultura ng Pilipinas sa pamamagitan ng interaktibong aktibidad at nakaengganyo na mga aral. Tuklasin ang mga papel, halaga, at kahalagahan ng pamilya sa lipunan ng Pilipinas.</p>
            
            <div class="activity-box">
                <h3>Ano ang Pamilya?</h3>
                <p>Sa kultura ng Pilipinas, ang <strong>pamilya</strong> ay ang pundasyon ng lipunan. Hindi lamang ito ang iyong mga malapit na kamag-anak, kundi pati na rin ang iyong mga palawaang miyembro ng pamilya na may mahalagang papel sa iyong buhay.</p>
                <p><strong>Mga Pangunahing Punto:</strong></p>
                <ul style="margin-left: 20px;">
                    <li>Ang pamilya ay nangangahulugang higit pa sa mga magulang at kapatid</li>
                    <li>Ang palawaang pamilya (lolo, lola, tita, tito) ay pantay na mahalaga</li>
                    <li>Ang mga halaga ng pamilya ay gumagabay kung paano nakikipag-ugnayan ang mga Pilipino sa isa't isa</li>
                    <li>Ang paggalang ay sentro ng kultura ng pamilyang Pilipino</li>
                </ul>
            </div>
        </div>

        <!-- Page 2: Family Members -->
        <div id="page-2" class="page-section">
            <h2>Mga Miyembro ng Pamilya 👨‍👩‍👧‍👦</h2>
            <p>I-click ang bawat miyembro ng pamilya upang malaman ang kanilang papel at marinig sila na inilarawan sa Filipino!</p>
            
            <div class="slider-container">
                <div class="family-grid" id="familySlider">
                    <div class="family-card" onclick="speakFamily('Nanay', 'Ina. Sa mga pamilyang Pilipino, ang ina ay ang emosyonal na sentro at tagapag-alaga ng tahanan.')">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=200&fit=crop" alt="Nanay - Ina">
                        <h3>👩 Nanay</h3>
                        <p>Ina</p>
                        <button class="play-btn" onclick="event.stopPropagation(); speakFamily('Nanay', 'Ina')">🔊 Marinig</button>
                    </div>

                    <div class="family-card" onclick="speakFamily('Tatay', 'Ama. Ang ama ay tradisyonal na ang nagbibigay at proteksyon ng pamilya.')">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=200&fit=crop" alt="Tatay - Ama">
                        <h3>👨 Tatay</h3>
                        <p>Ama</p>
                        <button class="play-btn" onclick="event.stopPropagation(); speakFamily('Tatay', 'Ama')">🔊 Marinig</button>
                    </div>

                    <div class="family-card" onclick="speakFamily('Ate', 'Mas Matandang Kapatid na Babae. Ang Ate ay tumutulong mag-alaga ng mas batang kapatid at nagbibigay ng gabay at suporta.')">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=200&fit=crop" alt="Ate - Mas Matandang Kapatid na Babae">
                        <h3>👧 Ate</h3>
                        <p>Mas Matandang Kapatid na Babae</p>
                        <button class="play-btn" onclick="event.stopPropagation(); speakFamily('Ate', 'Mas Matandang Kapatid na Babae')">🔊 Marinig</button>
                    </div>

                    <div class="family-card" onclick="speakFamily('Kuya', 'Mas Matandang Kapatid na Lalaki. Ang Kuya ay isang proteksyon at modelo ng papel para sa mas batang kapatid.')">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=200&fit=crop" alt="Kuya - Mas Matandang Kapatid na Lalaki">
                        <h3>👦 Kuya</h3>
                        <p>Mas Matandang Kapatid na Lalaki</p>
                        <button class="play-btn" onclick="event.stopPropagation(); speakFamily('Kuya', 'Mas Matandang Kapatid na Lalaki')">🔊 Marinig</button>
                    </div>
                </div>
                
                <!-- Slider Navigation -->
                <div class="slider-nav">
                    <button class="slider-btn" id="prevBtn" onclick="slideFamily(-1)">❮</button>
                    <span class="slider-counter"><span id="currentSlide">1</span> / <span id="totalSlides">4</span></span>
                    <button class="slider-btn" id="nextBtn" onclick="slideFamily(1)">❯</button>
                </div>
                
                <!-- Slider Dots -->
                <div class="slider-dots" id="sliderDots"></div>
            </div>
        </div>

        <!-- Page 3: Interactive Activity -->
        <div id="page-3" class="page-section">
            <h2>🎯 Aktibidad 1: Ilarawan Ang Iyong Pamilya</h2>
            <p>Isulat ang tungkol sa iyong mga miyembro ng pamilya at i-click ang pindutan upang marinig ito sa Filipino!</p>
            
            <div class="activity-box">
                <h3>Sabihin Sa Amin Ang Tungkol Sa Iyong Pamilya</h3>
                <input type="text" id="familyInput" class="activity-input" placeholder="Halimbawa: Ang aking pamilya ay maliit ngunit puno ng pag-ibig. Ang aking ina ay guro...">
                <button class="btn" onclick="speakCustomText()">🔊 Marinig sa Filipino</button>
                <button class="btn btn-secondary" onclick="clearInput()">I-Likas</button>
            </div>

            <div class="activity-box">
                <h3>Interaktibong Ehersisyo</h3>
                <p>Kumpletuhin ang mga pangungusap tungkol sa iyong pamilya:</p>
                <input type="text" id="sentence1" class="activity-input" placeholder="Ang aming pamilya ay...">
                <button class="btn" onclick="speak(document.getElementById('sentence1').value)">🔊 Magsalita</button>
                <br>
                <input type="text" id="sentence2" class="activity-input" placeholder="Mahal ko ang aking...">
                <button class="btn" onclick="speak(document.getElementById('sentence2').value)">🔊 Magsalita</button>
            </div>
        </div>

        <!-- Page 4: Family Values Quiz -->
        <div id="page-4" class="page-section">
            <h2>📖 Pagsusulit sa Mga Halaga ng Pamilya</h2>
            <p>Subukan ang iyong kaalaman tungkol sa mga halaga ng pamilyang Pilipino!</p>
            
            <div class="quiz-question">
                <h3>Ano ang kahulugan ng "Paggalang"?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Respeto sa mga matatanda at magulang
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Paglalaro nang magkasama bilang pamilya
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Pagkain ng hapag-kainan nang magkasama
                </div>
                <div id="feedback-1"></div>
            </div>

            <div class="quiz-question">
                <h3>Aling termino ang ginagamit para sa mas matandang kapatid na babae?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Ate
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Kuya
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Nanay
                </div>
                <div id="feedback-2"></div>
            </div>

            <div class="quiz-question">
                <h3>Ano ang "Pagkakaisa"?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Pagkakaisa ng pamilya at pagiging magkasama
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Pera na naimpok ng pamilya
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Edad ng mga miyembro ng pamilya
                </div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 5: Vocabulary Game -->
        <div id="page-5" class="page-section">
            <h2>🎮 I-Tugma ang Mga Termino ng Pamilya</h2>
            <p>I-click upang malaman ang mahalaging bokabularyo ng pamilyang Pilipino!</p>
            
            <div class="activity-box">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="interactive-card" onclick="speakTerm('Pamilya', 'Pamilya - Ang grupo ng mga taong may relasyon sa pamamagitan ng dugo, kasal, o pagpapaanak')">
                        <strong>Pamilya</strong> - Pamilya
                        <span class="sound-icon">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speakTerm('Nanay', 'Nanay - Ang kababaihan na magulang')">
                        <strong>Nanay</strong> - Ina
                        <span class="sound-icon">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speakTerm('Tatay', 'Tatay - Ang kalalakiang magulang')">
                        <strong>Tatay</strong> - Ama
                        <span class="sound-icon">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speakTerm('Kapatid', 'Kapatid - Isang kapatid na lalaki o babae')">
                        <strong>Kapatid</strong> - Kapatid
                        <span class="sound-icon">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speakTerm('Lolo', 'Lolo - Ama ng iyong magulang')">
                        <strong>Lolo</strong> - Lolo
                        <span class="sound-icon">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speakTerm('Lola', 'Lola - Ina ng iyong magulang')">
                        <strong>Lola</strong> - Lola
                        <span class="sound-icon">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speakTerm('Pagmamahal', 'Pagmamahal - Malalim na pagmamahal at pag-aalaga sa pamilya')">
                        <strong>Pagmamahal</strong> - Pagmamahal
                        <span class="sound-icon">🔊</span>
                    </div>
                    <div class="interactive-card" onclick="speakTerm('Paggalang', 'Paggalang - Pagkilala sa iyong mga matatanda at magulang')">
                        <strong>Paggalang</strong> - Paggalang
                        <span class="sound-icon">🔊</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page 6: Role Activity -->
        <div id="page-6" class="page-section">
            <h2>👥 Pag-unawa sa Mga Papel ng Pamilya</h2>
            <p>Matuto tungkol sa iba't ibang papel na ginagampanan ng bawat miyembro ng pamilya sa mga tahanan ng Pilipinas.</p>
            
            <div class="activity-box">
                <h3>Anong papel ang mayroon ang bawat miyembro ng pamilya?</h3>
                <p><strong>Nanay (Ina):</strong> Tagapag-alaga, emosyonal na suporta, tagapamahala ng tahanan</p>
                <button class="btn" onclick="speak('Ang ina sa mga pamilyang Pilipino ay ang emosyonal na sentro, nag-aalaga ng mga bata at namamahala sa mga gawain ng tahanan.')">🔊 Matuto Ng Higit Pa</button>
            </div>

            <div class="activity-box">
                <p><strong>Tatay (Ama):</strong> Nagbibigay, proteksyon, gabay</p>
                <button class="btn" onclick="speak('Ang ama ay tradisyonal na naglilingkod bilang nagbibigay at proteksyon, ngunit ang modernong mga papel ay mas flexible.')">🔊 Matuto Ng Higit Pa</button>
            </div>

            <div class="activity-box">
                <p><strong>Ate (Mas Matandang Kapatid na Babae):</strong> Tumutulong, mentor, modelo</p>
                <button class="btn" onclick="speak('Ang mas matandang kapatid na babae ay tumutulong na mag-alaga ng mas batang kapatid at nagbibigay ng gabay at suporta.')">🔊 Matuto Ng Higit Pa</button>
            </div>

            <div class="activity-box">
                <p><strong>Kuya (Mas Matandang Kapatid na Lalaki):</strong> Proteksyon, modelo, mentor</p>
                <button class="btn" onclick="speak('Ang mas matandang kapatid na lalaki ay inaasahang maging proteksyon at positibong impluwensya para sa mas batang kapatid.')">🔊 Matuto Ng Higit Pa</button>
            </div>
        </div>

        <!-- Page 7: Values Discussion -->
        <div id="page-7" class="page-section">
            <h2>💭 Mga Halaga ng Pamilyang Pilipino</h2>
            <p>Tuklasin ang mga pangunahing halaga na gumagabay sa mga pamilyang Pilipino:</p>
            
            <div class="activity-box">
                <h3>Pagkakaisa (Pagkakaisa)</h3>
                <p>Ang mga miyembro ng pamilya ay nanatili nang magkasama at sumusuporta sa isa't isa sa magandang panahon at hamon.</p>
                <button class="btn" onclick="speak('Ang pagkakaisa ay nangangahulugang pagkakaisa ng pamilya. Ang mga Pilipino ay pinahahalagahan ang interes ng pamilya at nanatili nang magkasama.')">🔊 Marinig Ito</button>
            </div>

            <div class="activity-box">
                <h3>Paggalang (Respeto)</h3>
                <p>Ang mga bata ay gumagalang sa kanilang mga magulang at matatanda. Ang mga salitang tulad ng "po" at "opo" ay nagpapakita ng respetong ito.</p>
                <button class="btn" onclick="speak('Ang paggalang ay nangangahulugang respeto. Ang respeto sa mga magulang at matatanda ay mahalaga sa kultura ng Pilipinas.')">🔊 Marinig Ito</button>
            </div>

            <div class="activity-box">
                <h3>Malasakit (Pag-iingat at Alalahanin)</h3>
                <p>Ang mga Pilipino ay tunay na nag-aalaga sa kanilang mga miyembro ng pamilya at nag-aalok ng tulong sa mga kamag-anak.</p>
                <button class="btn" onclick="speak('Ang malasakit ay nangangahulugang pag-iingat at alalahanin. Kilala ang mga Pilipino sa kanilang malakas na pakiramdam ng pag-aalaga sa pamilya.')">🔊 Marinig Ito</button>
            </div>

            <div class="activity-box">
                <h3>Responsibilidad (Responsibilidad)</h3>
                <p>Ang bawat miyembro ng pamilya ay nag-aambag ayon sa kanilang kakayahan.</p>
                <button class="btn" onclick="speak('Ang responsibilidad ay nangangahulugang responsibilidad. Ang bawat miyembro ng pamilya ay inaasahang mag-ambag.')">🔊 Marinig Ito</button>
            </div>
        </div>

        <!-- Page 8: Reflection Activity -->
        <div id="page-8" class="page-section">
            <h2>✍️ Pagmamuni-Muni</h2>
            <p>Isipan ang iyong sariling pamilya at sagutin ang mga katanungang ito:</p>
            
            <div class="activity-box">
                <h3>Tanong 1: Ano ang ginagawang natatangi ang iyong pamilya?</h3>
                <input type="text" id="reflection1" class="activity-input" placeholder="Ang iyong sagot dito...">
                <button class="btn" onclick="speak(document.getElementById('reflection1').value || 'Mangyaring isulat ang iyong sagot muna')">🔊 Ibahagi</button>
            </div>

            <div class="activity-box">
                <h3>Tanong 2: Aling halaga ng pamilya ang pinakamahalagang sa iyo?</h3>
                <input type="text" id="reflection2" class="activity-input" placeholder="Ang iyong sagot dito...">
                <button class="btn" onclick="speak(document.getElementById('reflection2').value || 'Mangyaring isulat ang iyong sagot muna')">🔊 Ibahagi</button>
            </div>

            <div class="activity-box">
                <h3>Tanong 3: Paano mo ipinapakita ang paggalang (respeto) sa iyong mga magulang?</h3>
                <input type="text" id="reflection3" class="activity-input" placeholder="Ang iyong sagot dito...">
                <button class="btn" onclick="speak(document.getElementById('reflection3').value || 'Mangyaring isulat ang iyong sagot muna')">🔊 Ibahagi</button>
            </div>
        </div>

        <!-- Page 9: Summary & Completion -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Aralin</h2>
            
            <div class="completion-badge">
                <h2>✅ Binabati Kita! 🎉</h2>
                <p>Nagtapos ka na ng "Ang Aking Pamilya" na interaktibong aral!</p>
                <p style="font-size: 1.2rem; margin-top: 15px;">Natutunan mo ang tungkol sa istraktura ng pamilya, mga papel, at halaga sa kultura ng Pilipinas. Nagsanay ka rin ng interaktibong ehersisyo at nagmuni-muni sa iyong sariling pamilya.</p>
            </div>

            <div class="activity-box">
                <h3>Mga Pangunahing Araw-araw:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Ang pamilya ay pundasyon ng lipunang Pilipino</li>
                    <li>✅ Ang bawat miyembro ng pamilya ay may mahalagang papel na ginagampanan</li>
                    <li>✅ Ang mga halaga ng pamilya ay gumagabay sa pang-araw-araw na pakikipag-ugnayan</li>
                    <li>✅ Ang paggalang, pagkakaisa, malasakit, at responsibilidad ay mahalaga</li>
                    <li>✅ Ang pag-unawa sa kultura ng pamilya ay nagpapalakas ng mga relasyon</li>
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
            <h2 style="color: #667eea; font-size: 1.8rem; margin-bottom: 20px;">🏆 Kahanga-Hangang Gawain!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 20px;">Matagumpay mong nagtapos ang "Ang Aking Pamilya" na aral. Nakamit mo ang mahalagang kaalaman tungkol sa kultura at kasanayan ng pamilyang Pilipino!</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="closeModal()" style="padding: 10px 20px; background: #e5e7eb; color: #374151; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Magpatuloy sa Pag-aaral</button>
                <button onclick="returnToTopics()" style="padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Bumalik sa Mga Paksa</button>
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

        // Initialize
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

        // Speech synthesis
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

        function speakFamily(name, description) {
            const text = `${name}. ${description}`;
            speak(text);
        }

        function speakTerm(term, definition) {
            const text = `${term}. ${definition}`;
            speak(text);
        }

        function speakCustomText() {
            const text = document.getElementById('familyInput').value;
            if (text.trim()) {
                speak(text);
            }
        }

        function clearInput() {
            document.getElementById('familyInput').value = '';
        }

        // Slider for Family Members
        let currentSlide = 0;
        let slideDirection = 1; // 1 for next, -1 for previous

        function initializeSlider() {
            const slider = document.getElementById('familySlider');
            const cards = slider?.querySelectorAll('.family-card') || [];
            const totalSlides = cards.length;
            
            // Update total slides
            if (document.getElementById('totalSlides')) {
                document.getElementById('totalSlides').textContent = totalSlides;
            }
            
            // Create dots
            const dotsContainer = document.getElementById('sliderDots');
            if (dotsContainer) {
                dotsContainer.innerHTML = '';
                for (let i = 0; i < totalSlides; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
                    dot.onclick = () => goToSlide(i);
                    dotsContainer.appendChild(dot);
                }
            }
        }

        function slideFamily(direction) {
            const slider = document.getElementById('familySlider');
            const cards = slider?.querySelectorAll('.family-card') || [];
            const totalSlides = cards.length;
            
            if (totalSlides === 0) return;
            
            slideDirection = direction;
            const nextSlide = (currentSlide + direction + totalSlides) % totalSlides;
            
            // Add animation classes
            cards[currentSlide].classList.add(direction === 1 ? 'slide-out' : 'slide-out-right');
            
            setTimeout(() => {
                cards[currentSlide].classList.remove('slide-out', 'slide-out-right');
                cards[currentSlide].style.display = 'none';
                
                currentSlide = nextSlide;
                
                cards[currentSlide].style.display = 'flex';
                cards[currentSlide].classList.add(direction === 1 ? 'slide-in-left' : 'slide-in-right');
                
                setTimeout(() => {
                    cards[currentSlide].classList.remove('slide-in-left', 'slide-in-right');
                }, 500);
                
                updateSliderUI();
            }, 500);
        }

        function goToSlide(slideIndex) {
            const slider = document.getElementById('familySlider');
            const cards = slider?.querySelectorAll('.family-card') || [];
            const totalSlides = cards.length;
            
            if (slideIndex === currentSlide) return;
            
            const direction = slideIndex > currentSlide ? 1 : -1;
            slideDirection = direction;
            
            // Add animation classes
            cards[currentSlide].classList.add(direction === 1 ? 'slide-out' : 'slide-out-right');
            
            setTimeout(() => {
                cards[currentSlide].classList.remove('slide-out', 'slide-out-right');
                cards[currentSlide].style.display = 'none';
                
                currentSlide = slideIndex;
                
                cards[currentSlide].style.display = 'flex';
                cards[currentSlide].classList.add(direction === 1 ? 'slide-in-left' : 'slide-in-right');
                
                setTimeout(() => {
                    cards[currentSlide].classList.remove('slide-in-left', 'slide-in-right');
                }, 500);
                
                updateSliderUI();
            }, 500);
        }

        function updateSliderUI() {
            const slider = document.getElementById('familySlider');
            const cards = slider?.querySelectorAll('.family-card') || [];
            const totalSlides = cards.length;
            
            // Hide all cards first
            cards.forEach(card => card.style.display = 'none');
            // Show current card
            if (cards[currentSlide]) cards[currentSlide].style.display = 'flex';
            
            // Update counter
            if (document.getElementById('currentSlide')) {
                document.getElementById('currentSlide').textContent = currentSlide + 1;
            }
            
            // Update dots
            const dots = document.querySelectorAll('.slider-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
            
            // Update button states
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            if (prevBtn) prevBtn.disabled = currentSlide === 0;
            if (nextBtn) nextBtn.disabled = currentSlide === totalSlides - 1;
        }

        // Initialize slider on page load
        document.addEventListener('DOMContentLoaded', initializeSlider);

        // Quiz

        function checkAnswer(element, isCorrect) {
            const parent = element.parentElement;
            const options = parent.querySelectorAll('.quiz-option');
            
            // Disable all options
            options.forEach(opt => opt.style.pointerEvents = 'none');

            // Show result
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

        // Pagination
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
            // Hide all pages
            for (let i = 1; i <= totalPages; i++) {
                const page = document.getElementById(`page-${i}`);
                if (page) page.classList.remove('active');
            }

            // Show current page
            const currentPageEl = document.getElementById(`page-${currentPage}`);
            if (currentPageEl) currentPageEl.classList.add('active');

            // Update counter
            document.getElementById('currentPage').textContent = currentPage;

            // Update buttons
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages;

            // Update progress bar
            const progress = (currentPage / totalPages) * 100;
            document.getElementById('progressFill').style.width = progress + '%';

            // Update dots
            renderPageDots();

            // Scroll to top
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
                    lesson_slug: 'ang-aking-pamilya'
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
                    const badgeMap = {'perfectScore': '💯 Perfect Score', 'onFire': '🔥 On Fire'};
                    badgesList.innerHTML = gameState.badges.map(badge => `<span style="background: white; padding: 8px 12px; border-radius: 6px; font-weight: bold; color: #ec4899;">${badgeMap[badge] || badge}</span>`).join('');
                }
                
                document.getElementById('completionModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking lesson as complete');
            });
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
                    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: linear-gradient(135deg, #ec4899 0%, #d946a6 100%); color: white; padding: 20px 30px; border-radius: 10px; font-weight: bold; z-index: 9999; animation: slide-up 0.6s ease-out;';
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

        function closeModal() {
            document.getElementById('completionModal').classList.add('hidden');
        }

        function returnToTopics() {
            window.location.href = '{{ route("subject.topics", ["subject" => "filipino"]) }}';
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', init);
    </script>
</x-layouts::app>