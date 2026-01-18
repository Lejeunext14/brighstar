<x-layouts::app :title="__('Mga Pagbati ng Magalang - Interactive Respectful Greetings')">
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
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
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
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
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
        
        .greeting-card {
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin: 15px 0;
        }
        
        .greeting-card:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 35px rgba(236, 72, 153, 0.3);
        }
        
        .greeting-card h3 {
            font-size: 1.5rem;
            margin: 10px 0;
        }
        
        .greeting-card p {
            font-size: 0.95rem;
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
            color: #ec4899;
        }
        
        .activity-box {
            background: linear-gradient(135deg, #fce7f3 0%, #fed7aa 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #ec4899;
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
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
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
            margin: 10px 5px 10px 0;
        }
        
        .btn:hover {
            background: #be185d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.3);
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
            background: linear-gradient(90deg, #ec4899 0%, #f97316 100%);
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
            border: 2px solid #ec4899;
            background: white;
            color: #ec4899;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            background: #ec4899;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.3);
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .page-counter {
            font-weight: bold;
            color: #ec4899;
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
            background: #ec4899;
            width: 32px;
            border-radius: 6px;
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
            border-color: #ec4899;
            background: #fdf2f8;
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
            border-color: #ec4899;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(236, 72, 153, 0.2);
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
            <h1>🌟 Mga Pagbati ng Magalang 🌟</h1>
            <p>Learn Respectful Filipino Greetings & Expressions</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang pagdating sa Mga Pagbati ng Magalang! 👋</h2>
            <p>Sa kultura ng Pilipinas, ang pagpapakita ng paggalang sa pamamagitan ng tamang pagbati at mga expression ay napakahalagang. Matuto kung paano magbati ng mga tao nang may galang at magandang paraan gamit ang wikang Filipino.</p>
            
            <div class="activity-box">
                <h3>Ano ang Mga Pagbati?</h3>
                <p><strong>Mga Pagbati</strong> ay ang mga unang salita na ginagamit natin kapag nakakatugon ng iba. Sa kultura ng Pilipinas, ang magalang na pagbati ay nagpapakita ng:</p>
                <ul style="margin-left: 20px;">
                    <li>Paggalang sa taong ibinabagsak natin</li>
                    <li>Magandang asal at tamang pag-uugali</li>
                    <li>Pag-unawa sa mga halaga ng kultura Pilipino</li>
                    <li>Pag-aalaga at pagkakaibigan sa iba</li>
                </ul>
                <p><strong>Magalang</strong> ay nangangahulugang "may respeto" o "polite" - kaya ang magalang na pagbati ay mahalaga sa pakikipag-ugnayan sa Pilipinas!</p>
            </div>
        </div>

        <!-- Page 2: Basic Greetings -->
        <div id="page-2" class="page-section">
            <h2>Pangunahing Pagbati 👋</h2>
            <p>Pindutin ang bawat pagbati upang marinig kung paano ito binibigkas at matuto kung kailan ito ginagamit!</p>
            
            <div class="greeting-card" onclick="speak('Magandang umaga! Ito ang tamang paraan ng pagbati sa umaga.')">
                <h3>Magandang Umaga! 🌅</h3>
                <p>Magandang Umaga!</p>
                <p style="font-size: 0.85rem; margin-top: 10px;">Sinasabi mula sa umaga hanggang huli ng umaga</p>
                <button class="play-btn" onclick="event.stopPropagation(); speak('Magandang umaga')">🔊 Play</button>
            </div>

            <div class="greeting-card" onclick="speak('Magandang tanghali! Ito ay ginagamit sa araw-araw.')">
                <h3>Magandang Tanghali! ☀️</h3>
                <p>Magandang Tanghali!</p>
                <p style="font-size: 0.85rem; margin-top: 10px;">Sinasabi sa oras ng tanghali</p>
                <button class="play-btn" onclick="event.stopPropagation(); speak('Magandang tanghali')">🔊 Play</button>
            </div>

            <div class="greeting-card" onclick="speak('Magandang gabi! Ito ay ginagamit sa gabi.')">
                <h3>Magandang Gabi! 🌙</h3>
                <p>Magandang Gabi!</p>
                <p style="font-size: 0.85rem; margin-top: 10px;">Sinasabi sa gabi at habi ng gabi</p>
                <button class="play-btn" onclick="event.stopPropagation(); speak('Magandang gabi')">🔊 Play</button>
            </div>

            <div class="greeting-card" onclick="speak('Kumusta ka? Ito ay isang karaniwang pagbati.')">
                <h3>Kumusta? 😊</h3>
                <p>Paano ka naman?</p>
                <p style="font-size: 0.85rem; margin-top: 10px;">Isang casual ngunit respetosong paraan ng pagtatanong kung paano kayo</p>
                <button class="play-btn" onclick="event.stopPropagation(); speak('Kumusta ka?')">🔊 Play</button>
            </div>
        </div>

        <!-- Page 3: Respectful Expressions -->
        <div id="page-3" class="page-section">
            <h2>Magalangang Pamumuhay 🙏</h2>
            <p>Matuto ng mahahalagang magalang na mga expression na ginagamit sa pang-araw-araw na buhay ng Pilipino!</p>
            
            <div class="activity-box">
                <h3>Po at Opo</h3>
                <p>Ang mga ito ay magalangang particle na idinaragdag sa dulo ng mga pangungusap kapag nagsasalita sa matatanda o sa mga taong nais naming ipakita ang paggalang.</p>
                <button class="btn" onclick="speak('Opo. Ito ang magalang na paraan ng pagsasabing oo sa isang matanda.')">Opo</button>
                <button class="btn" onclick="speak('Opo. Ito ay isa pang paraan ng pagsasabing oo nang magalang.')">Opo na Opo</button>
                <button class="btn" onclick="speak('Hindi po. Ito ang magalang na paraan ng pagsasabing hindi sa isang matanda.')">Hindi, Po</button>
            </div>

            <div class="activity-box">
                <h3>Salamat Po! (Maraming Salamat!)</h3>
                <p>Ang pagpapahayag ng pasasalamat ay mahalaga sa kultura ng Pilipinas.</p>
                <button class="btn" onclick="speak('Salamat po! Ito ay nagpapakita ng pagpapahalaga at paggalang.')">🔊 Maraming Salamat</button>
                <button class="btn" onclick="speak('Maraming salamat po! Napakadaming pasasalamat sa inyo!')">🔊 Napakadaming Salamat</button>
            </div>

            <div class="activity-box">
                <h3>Paumanhin Po & Pasensya Na Po</h3>
                <p>Ang mga expression na ito ay tumutulong sa atin na makipag-ugnayan nang magalang sa iba.</p>
                <button class="btn" onclick="speak('Pasensya na po. Paumanhin mo kami o makipagsalita nang magalang.')">Pasensya Na Po</button>
                <button class="btn" onclick="speak('Paumanhin po ako. Ako ay nagsisisi. Isang tunay na pagpapahayag ng pagsisisi sa Filipino.')">Paumanhin Po Ako</button>
            </div>
        </div>

        <!-- Page 4: Using Po and Opo -->
        <div id="page-4" class="page-section">
            <h2>Po at Opo: Magalangang Particle 🎯</h2>
            <p>Maintindihan kung kailan at paano gamitin ang "po" at "opo" sa mga usapan:</p>
            
            <div class="activity-box">
                <h3>Kailan Gamitin ang Po/Opo:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Kapag nagsasalita sa mga magulang at matatandang kamag-anak</li>
                    <li>✅ Kapag nagsasalita sa mga guro at mga tao sa kapangyarihan</li>
                    <li>✅ Kapag nagsasalita sa mga matatanda sa komunidad</li>
                    <li>✅ Sa pormal at propesyonal na mga setting</li>
                    <li>✅ Kapag nais mong ipakita ang dagdag na paggalang</li>
                </ul>
                <button class="btn" onclick="speak('Makakatulong po ba ako? Ito ay nagpapakita ng paggalang habang nag-aalok ng tulong.')">Halimbawa 1</button>
            </div>

            <div class="activity-box">
                <h3>Mga Halimbawang Usapan:</h3>
                <p><strong>Bata sa Magulang:</strong></p>
                <p>"Magandang umaga po! May gusto po ba kayong kainan?"</p>
                <button class="btn" onclick="speak('Magandang umaga po! Ito ang paraan ng pagsalubong sa iyong mga magulang nang may paggalang.')">🔊 Marinig Ito</button>
            </div>

            <div class="activity-box">
                <p><strong>Estudyante sa Guro:</strong></p>
                <p>"Magandang umaga po, madam/sir! May tanong po ako."</p>
                <button class="btn" onclick="speak('Magandang umaga po, madam po. May tanong po ako. Ito ay respetosong wika sa paaralan.')">🔊 Marinig Ito</button>
            </div>
        </div>

        <!-- Page 5: Practice Activity -->
        <div id="page-5" class="page-section">
            <h2>🎯 Pagsasanay: Lumikha ng Iyong Sariling Pagbati</h2>
            <p>Magsulat ng magalangang pagbati at marinig ang mga ito sa wikang Filipino!</p>
            
            <div class="activity-box">
                <h3>Pagbati sa Iyong Magulang:</h3>
                <input type="text" id="greeting1" class="activity-input" placeholder="Halimbawa: Magandang umaga, nanay!">
                <button class="btn" onclick="speak(document.getElementById('greeting1').value || 'Mangyaring magsulat ng pagbati')">🔊 Salitain</button>
            </div>

            <div class="activity-box">
                <h3>Pagbati sa Iyong Guro:</h3>
                <input type="text" id="greeting2" class="activity-input" placeholder="Halimbawa: Magandang umaga po, teacher!">
                <button class="btn" onclick="speak(document.getElementById('greeting2').value || 'Mangyaring magsulat ng pagbati')">🔊 Salitain</button>
            </div>

            <div class="activity-box">
                <h3>Humiling ng Tulong nang may Galang:</h3>
                <input type="text" id="greeting3" class="activity-input" placeholder="Halimbawa: Pasensya na po, makakatulong kayo?">>
                <button class="btn" onclick="speak(document.getElementById('greeting3').value || 'Please write a greeting')">🔊 Speak</button>
            </div>
        </div>

        <!-- Page 6: Quiz -->
        <div id="page-6" class="page-section">
            <h2>📝 Knowledge Check Quiz</h2>
            <p>Test your understanding of respectful greetings!</p>
            
            <div class="activity-box">
                <h3>Tanong 1: Kailan mo sinasabi ang "Magandang Gabi"?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Sa gabi at habi ng gabi
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Sa maaga ng umaga
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Sa oras ng tanghali
                </div>
                <div id="feedback-1"></div>
            </div>

            <div class="activity-box">
                <h3>Tanong 2: Ano ang kahulugan ng "Po"?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Isang magalangang particle na ginagamit kasama ng mga matatanda
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Isang uri ng pagbati
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Umaga sa wikang Filipino
                </div>
                <div id="feedback-2"></div>
            </div>

            <div class="activity-box">
                <h3>Tanong 3: Alin ang pinaka-respetosong paraan ng pagsasabing salamat sa isang matanda?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Salamat po!
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Salamat
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Thanks
                </div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 7: Real-Life Scenarios -->
        <div id="page-7" class="page-section">
            <h2>🏠 Mga Tunay na Sitwasyon</h2>
            <p>Matuto kung paano gamitin ang magalangang pagbati sa pang-araw-araw na mga sitwasyon:</p>
            
            <div class="activity-box">
                <h3>Sitwasyon 1: Nakakatugon ng Iyong Guro</h3>
                <p>"Magandang umaga po, sir! Kumusta kayo po?"</p>
                <button class="btn" onclick="speak('Magandang umaga po, sir. Kumusta kayo po.')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Sitwasyon 2: Humihiling ng Pahintulot sa Magulang</h3>
                <p>"Nanay po, magsasaya po ba ako sa bahay ng kaibigan?"</p>
                <button class="btn" onclick="speak('Nanay po, magsasaya po ba ako sa bahay ng kaibigan?')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Sitwasyon 3: Nag-apolog sa isang Matanda</h3>
                <p>"Paumanhin po ako. Hindi na po ito mauulit."</p>
                <button class="btn" onclick="speak('Paumanhin po ako. Hindi na po ito mauulit.')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Sitwasyon 4: Pagbati sa Pamilya</h3>
                <p>"Magandang tanghali po, tita! Paano na po kayo?"</p>
                <button class="btn" onclick="speak('Magandang tanghali po, tita. Paano na po kayo.')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 8: Culture & Values -->
        <div id="page-8" class="page-section">
            <h2>🌏 Kultura at Halaga ng Pilipinas</h2>
            <p>Maunawaan ang mahalagang kultura ng magalang na pagbati sa Pilipinas:</p>
            
            <div class="activity-box">
                <h3>Bakit Mahalaga ang Paggalang</h3>
                <p>Sa kultura ng Pilipinas, ang paggalang ay pundasyon. Ang magalang na pagbati ay nagpapakita ng:</p>
                <ul style="margin-left: 20px;">
                    <li>Malasakit (pag-aalaga at alalahanin) para sa iba</li>
                    <li>Pagkilala sa kahalagahan ng mga tao sa iyong buhay</li>
                    <li>Pag-unawa sa pamilya at lipunan</li>
                    <li>Magandang pagkakaroon at wastong mga halaga</li>
                </ul>
                <button class="btn" onclick="speak('Ang paggalang ay pundasyon ng pamilya at komunidad sa Pilipinas.')">🔊 Matuto Ng Higit Pa</button>
            </div>

            <div class="activity-box">
                <h3>Paggalang sa Iba't ibang Konteksto</h3>
                <p>Ang magalang na pagbati ay nagbabago depende sa kung sino ang kausap mo at sa sitwasyon. Ang paglilikha ay nagpapakita ng kultural na kaalaman!</p>
                <button class="btn" onclick="speak('Ang pagsasalita nang may paggalang ay nangangahulugang pag-ugnay ng iyong pagbati upang ipakita ang angkop na malasakit para sa bawat tao.')">🔊 Maunawaan Ang Higit Pa</button>
            </div>
        </div>

        <!-- Page 9: Summary & Completion -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Aralin</h2>
            
            <div class="completion-badge">
                <h2>✅ Ipinagdiriwang! 🎉</h2>
                <p>Tapos mo na ang "Mga Pagbati ng Magalang" na aralin!</p>
                <p style="font-size: 1.2rem; margin-top: 15px;">Natuto ka ng magalang na pagbati, ang paggamit ng "po" at "opo", at kung paano makipag-ugnayan nang may paggalang sa kultura ng Pilipinas!</p>
            </div>

            <div class="activity-box">
                <h3>Mga Pangunahing Araw-araw:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ "Magandang umaga/tanghali/gabi" para sa iba't ibang oras ng araw</li>
                    <li>✅ "Po" and "opo" show respect to elders</li>
                    <li>✅ "Salamat po" expresses gratitude respectfully</li>
                    <li>✅ Respectful greetings are essential in Filipino culture</li>
                    <li>✅ Using proper greetings shows good character</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <button class="btn" onclick="completeLesson()" style="font-size: 1.1rem; padding: 15px 40px;">✅ Mark as Complete</button>
            </div>
        </div>

        <!-- Pagination Controls -->
        <div class="pagination-controls">
            <button class="pagination-btn" id="prevBtn" onclick="previousPage()">← Previous</button>
            <span class="page-counter"><span id="currentPage">1</span> / <span id="totalPages">9</span></span>
            <button class="pagination-btn" id="nextBtn" onclick="nextPage()">Next →</button>
        </div>
    </div>

    <!-- Completion Modal -->
    <div id="completionModal" class="fixed inset-0 hidden flex items-center justify-center bg-black/50 z-50">
        <div style="background: white; border-radius: 15px; padding: 40px; max-width: 400px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <h2 style="color: #ec4899; font-size: 1.8rem; margin-bottom: 20px;">🏆 Amazing Work!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 20px;">You have successfully completed the "Mga Pagbati ng Magalang" lesson. Great job learning about respectful greetings!</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="closeModal()" style="padding: 10px 20px; background: #e5e7eb; color: #374151; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Continue Learning</button>
                <button onclick="returnToTopics()" style="padding: 10px 20px; background: #ec4899; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Back to Topics</button>
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

        document.addEventListener('DOMContentLoaded', init);
    </script>
</x-layouts::app>
