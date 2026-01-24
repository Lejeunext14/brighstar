<x-layouts::app :title="__('Mga Kasapi ng Aking Pamilya - Interactive Lesson')">
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
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
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
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        
        .page-section { display: none; animation: slide-up 0.6s ease-out; }
        .page-section.active { display: block; }
        
        .family-card {
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 5px solid #06b6d4;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .family-card:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 15px rgba(6, 182, 212, 0.2);
        }
        
        .activity-box {
            background: linear-gradient(135deg, #ecfdf5 0%, #ccfbf1 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #06b6d4;
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
            border-color: #06b6d4;
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
        }
        
        .btn {
            background: #06b6d4;
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
            background: #0891b2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(6, 182, 212, 0.3);
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
            background: linear-gradient(90deg, #06b6d4 0%, #0891b2 100%);
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
            border: 2px solid #06b6d4;
            background: white;
            color: #06b6d4;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            background: #06b6d4;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(6, 182, 212, 0.3);
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .page-counter {
            font-weight: bold;
            color: #06b6d4;
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
            background: #06b6d4;
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
            border-color: #06b6d4;
            background: #ecfdf5;
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
            <h1>👨‍👩‍👧‍👦 Mga Kasapi ng Aking Pamilya 👨‍👩‍👧‍👦</h1>
            <p>Matuto Tungkol sa Mga Kasapi ng Pamilya</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang Pagdating sa Mga Kasapi ng Pamilya! 👋</h2>
            <p>Matuto ng mga pangalan at papel ng mga miyembro ng pamilya sa Filipino. Ang pamilya ay pundasyon ng kultura ng Pilipinas, at ang pag-unawa sa mga relasyon ng pamilya ay mahalaga sa wikang Pilipino at lipunan.</p>
            
            <div class="activity-box">
                <h3>Ano ang Matututunan Mo:</h3>
                <ul style="margin-left: 20px;">
                    <li>Mga pangalan ng miyembro ng pamilya (agad at pinalawig)</li>
                    <li>Paano mag-refer sa mga miyembro ng pamilya nang may paggalang</li>
                    <li>Mga relasyon ng pamilya at kinship terms</li>
                    <li>Kahalagahan ng pamilya sa lipunang Pilipino</li>
                    <li>Tunog at wastong paggamit</li>
                </ul>
            </div>
        </div>

        <!-- Page 2: Immediate Family Members -->
        <div id="page-2" class="page-section">
            <h2>Mga Kaagad na Kasapi ng Pamilya 👨‍👩‍👧‍👦</h2>
            <p>Magsimula tayo sa mga pinakamalapit na miyembro ng pamilya:</p>
            
            <div class="family-card" onclick="speak('Tatay')">
                <h3>Tatay (Ama) 👨</h3>
                <p><strong>Ingles:</strong> Ama</p>
                <p><strong>Halimbawa:</strong> "Si Tatay ay galing sa trabaho."</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Tatay')">🔊 Marinig</button>
            </div>

            <div class="family-card" onclick="speak('Nanay')">
                <h3>Nanay (Ina) 👩</h3>
                <p><strong>Ingles:</strong> Ina</p>
                <p><strong>Halimbawa:</strong> "Ang Nanay ay nasa kusina."</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Nanay')">🔊 Marinig</button>
            </div>

            <div class="family-card" onclick="speak('Ate')">
                <h3>Ate (Mas Matandang Kapatid na Babae) 👧</h3>
                <p><strong>Ingles:</strong> Mas Matandang Kapatid na Babae</p>
                <p><strong>Halimbawa:</strong> "Ang Ate ay nag-aaral sa kolehiyo."</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Ate')">🔊 Marinig</button>
            </div>

            <div class="family-card" onclick="speak('Kuya')">
                <h3>Kuya (Mas Matandang Kapatid na Lalaki) 👦</h3>
                <p><strong>Ingles:</strong> Mas Matandang Kapatid na Lalaki</p>
                <p><strong>Halimbawa:</strong> "Si Kuya ay may trabaho na."</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Kuya')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 3: Extended Family -->
        <div id="page-3" class="page-section">
            <h2>Extended Family Members 🏠</h2>
            <p>Learn about other family members:</p>
            
            <div class="family-card" onclick="speak('Lolo')">
                <h3>Lolo (Grandfather) 👴</h3>
                <p><strong>English:</strong> Grandfather</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Lolo')">🔊 Listen</button>
            </div>

            <div class="family-card" onclick="speak('Lola')">
                <h3>Lola (Grandmother) 👵</h3>
                <p><strong>English:</strong> Grandmother</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Lola')">🔊 Listen</button>
            </div>

            <div class="family-card" onclick="speak('Tiyahin')">
                <h3>Tiyahin (Aunt) 👩</h3>
                <p><strong>English:</strong> Aunt (mother's sister)</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Tiyahin')">🔊 Listen</button>
            </div>

            <div class="family-card" onclick="speak('Tito')">
                <h3>Tito (Uncle) 👨</h3>
                <p><strong>English:</strong> Uncle (father's brother)</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Tito')">🔊 Listen</button>
            </div>

            <div class="family-card" onclick="speak('Pinsan')">
                <h3>Pinsan (Cousin) 👤</h3>
                <p><strong>English:</strong> Cousin</p>
                <button class="btn" onclick="event.stopPropagation(); speak('Pinsan')">🔊 Listen</button>
            </div>
        </div>

        <!-- Page 4: Family Relationships -->
        <div id="page-4" class="page-section">
            <h2>Pag-unawa sa Mga Relasyon ng Pamilya 💝</h2>
            <p>Matuto tungkol sa kahalagahan ng kultura ng mga relasyon ng pamilya sa lipunang Pilipino:</p>
            
            <div class="activity-box">
                <h3>Mga Pangunahing Relasyon:</h3>
                <ul style="margin-left: 20px;">
                    <li><strong>Kapwa (ibinahagi na pagkakaroon):</strong> Nag-stress sa pagkakaisa at koneksyon</li>
                    <li><strong>Pakikipagkapwa-tao:</strong> Paggalang sa lahat ng miyembro ng pamilya</li>
                    <li><strong>Bahala na (umaasa sa pamilya):</strong> Tiwala sa suporta ng pamilya</li>
                    <li><strong>Bayanihan:</strong> Komunidad at pamilya na nagtutulungan</li>
                    <li><strong>Pamilya ang puso ng Pilipinas:</strong> Ang pamilya ay ang puso ng Pilipinas</li>
                </ul>
            </div>

            <div class="activity-box">
                <h3>Mga Halaga ng Pamilya sa Kulturang Pilipino:</h3>
                <p>Kilala ang mga pamilyang Pilipino dahil sa:</p>
                <ul style="margin-left: 20px;">
                    <li>Malalim na samahan ng pamilya sa iba't ibang henerasyon</li>
                    <li>Paggalang sa mga nakatatanda at lolo-lola</li>
                    <li>Pinapalawak na pamilya na nagtutulungan sa parehong tahanan</li>
                    <li>Ipinagdiriwang ang mga mahalagang okasyon nang sama-sama</li>
                    <li>Sumusuporta sa isa't isa sa panahon ng pangangailangan</li>
                </ul>
            </div>
        </div>

        <!-- Page 5: Practice Activity -->
        <div id="page-5" class="page-section">
            <h2>🎯 Pagsasanay</h2>
            <p>Sumulat ng mga pangungusap tungkol sa iyong mga miyembro ng pamilya gamit ang natuto mo:</p>
            
            <div class="activity-box">
                <h3>Ilarawan ang Isang Miyembro ng Pamilya:</h3>
                <input type="text" id="familyDesc1" class="activity-input" placeholder="Halimbawa: Ang Tatay ay mabait.">
                <button class="btn" onclick="speak(document.getElementById('familyDesc1').value || 'Magsulat ng pangungusap tungkol sa isang miyembro ng pamilya')">🔊 Magsalita</button>
            </div>

            <div class="activity-box">
                <h3>Pag-usapan Kung Ano ang Ginagawa ng Iyong Pamilya:</h3>
                <input type="text" id="familyDesc2" class="activity-input" placeholder="Halimbawa: Ang pamilya ay kumakain ng sama-sama.">
                <button class="btn" onclick="speak(document.getElementById('familyDesc2').value || 'Magsulat ng pangungusap tungkol sa kung ano ang ginagawa ng iyong pamilya')">🔊 Magsalita</button>
            </div>

            <div class="activity-box">
                <h3>Ipahayag ang Pagmamahal sa Iyong Pamilya:</h3>
                <input type="text" id="familyDesc3" class="activity-input" placeholder="Halimbawa: Mahal ko ang aking pamilya.">
                <button class="btn" onclick="speak(document.getElementById('familyDesc3').value || 'Ipahayag ang iyong damdamin')">🔊 Magsalita</button>
            </div>
        </div>

        <!-- Page 6: Quiz -->
        <div id="page-6" class="page-section">
            <h2>📝 Pagsusulit sa Kaalaman</h2>
            
            <div class="activity-box">
                <h3>Tanong 1: Ano ang kahulugan ng "Nanay"?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">A) Ina</div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">B) Ama</div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">C) Kapatid</div>
                <div id="feedback-1"></div>
            </div>

            <div class="activity-box">
                <h3>Tanong 2: Sino ang "Kuya"?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">A) Mas matandang kapatid na lalaki</div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">B) Mas bata na kapatid na lalaki</div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">C) Pinsan</div>
                <div id="feedback-2"></div>
            </div>

            <div class="activity-box">
                <h3>Tanong 3: Alin ang HINDI agad na kasapi ng pamilya?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, false)">A) Tatay</div>
                <div class="quiz-option" onclick="checkAnswer(this, true)">B) Lolo</div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">C) Nanay</div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 7: Family Activities -->
        <div id="page-7" class="page-section">
            <h2>🏡 Mga Tradisyon ng Pamilyang Pilipino</h2>
            <p>Mga karaniwang aktibidad at tradisyon sa mga pamilyang Pilipino:</p>
            
            <div class="family-card">
                <h3>Fiesta 🎉</h3>
                <p>Mga pagdiriwang sa komunidad kung saan nagtitipun ang mga pamilya, ipinagdiriwang ang mga pista ng mga santo, at naglalasap ng pagkain nang sama-sama</p>
            </div>

            <div class="family-card">
                <h3>Araw ng Pamilya (Family Day) 💑</h3>
                <p>Pagdiriwang ng pagkakaisa nang may mga aktibidad sa pagsasama ng pamilya at ibinahaging mga hapag</p>
            </div>

            <div class="family-card">
                <h3>Bayanihan 🤝</h3>
                <p>Diwa ng komunidad kung saan tumutulong ang mga pamilya sa isa't isa sa panahon ng pangangailangan, tulad ng pagbuo ng mga tahanan o pag-ani ng ani</p>
            </div>

            <div class="family-card">
                <h3>Hapag-Kainan (Family Meals) 🍜</h3>
                <p>Pagbabahagi ng mga pagkain nang sama-sama ay isang mahalagang aktibidad sa pagsasama ng pamilya sa kulturang Pilipino</p>
            </div>
        </div>

        <!-- Page 8: Real-Life Conversations -->
        <div id="page-8" class="page-section">
            <h2>👥 Mga Pag-uusap sa Pamilya</h2>
            
            <div class="activity-box">
                <h3>Pagpapakilala sa Iyong Pamilya:</h3>
                <p><strong>Nagsasalita:</strong> "Ito ang aking pamilya. Ito si Tatay, Nanay, at ang aming Kuya."</p>
                <p><strong>Ingles:</strong> "Ito ang aking pamilya. Ito si Ama, Ina, at ang aming mas matandang kapatid na lalaki."</p>
                <button class="btn" onclick="speak('Ito ang aking pamilya. Ito si Tatay, Nanay, at ang aming Kuya.')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Nagtatanong tungkol sa Pamilya ng Iba:</h3>
                <p><strong>Nagsasalita:</strong> "Ilang kasapi ang iyong pamilya?"</p>
                <p><strong>Ingles:</strong> "Ilang miyembro ang mayroon ang iyong pamilya?"</p>
                <button class="btn" onclick="speak('Ilang kasapi ang iyong pamilya?')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Pagbabahagi ng Pagmamahal para sa Pamilya:</h3>
                <p><strong>Nagsasalita:</strong> "Mahal ko ang aking pamilya ng buong puso."</p>
                <p><strong>Ingles:</strong> "Mahal ko ang aking pamilya nang buong puso."</p>
                <button class="btn" onclick="speak('Mahal ko ang aking pamilya ng buong puso.')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 9: Summary -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Leksyon</h2>
            
            <div class="completion-badge">
                <h2>✅ Binabati! 🎉</h2>
                <p>Tapos mo na ang "Mga Kasapi ng Pamilya" na leksyon!</p>
                <p style="font-size: 1.1rem;">Alam mo na kung paano tukuyin at lagyan ng pangalan ang lahat ng miyembro ng pamilya!</p>
            </div>

            <div class="activity-box">
                <h3>Pangunahing Bokabularyo na Natuto:</h3>
                <ul style="margin-left: 20px;">
                    <li>Tatay (Ama), Nanay (Ina)</li>
                    <li>Kuya (Mas Matandang Kapatid na Lalaki), Ate (Mas Matandang Kapatid na Babae)</li>
                    <li>Lolo (Lolo), Lola (Lola)</li>
                    <li>Tito (Tito), Tiyahin (Tiyahin)</li>
                    <li>Pinsan (Pinsan)</li>
                </ul>
            </div>

            <div class="activity-box">
                <h3>Ano ang Natuto Mo:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Mga pangalan ng mga agad na miyembro ng pamilya</li>
                    <li>✅ Mga relasyon ng pinapalawak na pamilya</li>
                    <li>✅ Kahalagahan ng kultura ng pamilya</li>
                    <li>✅ Mga tradisyon ng pamilyang Pilipino</li>
                    <li>✅ Paano ipapakita ang mga miyembro ng pamilya</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <button class="btn" onclick="completeLesson()" style="font-size: 1.1rem; padding: 15px 40px;">✅ Markahan bilang Tapos</button>
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
            <h2 style="color: #06b6d4; font-size: 1.8rem; margin-bottom: 20px;">🏆 Kamangha-manghang Gawa!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 20px;">Matagumpay mong natapos ang leksyon!</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="closeModal()" style="padding: 10px 20px; background: #e5e7eb; color: #374151; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Magpatuloy</button>
                <button onclick="returnToTopics()" style="padding: 10px 20px; background: #06b6d4; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Bumalik sa Mga Paksa</button>
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
                    speak('Mali ito!');
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
                    lesson_slug: 'mga-kasapi-ng-aking-pamilya'
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
            // Add delay to ensure database is updated
            setTimeout(() => {
                window.location.href = '{{ route("subject.topics", ["subject" => "finnish"]) }}';
            }, 500);
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
</x-layouts::app>
