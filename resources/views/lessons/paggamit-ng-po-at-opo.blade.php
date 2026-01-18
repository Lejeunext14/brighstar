<x-layouts::app :title="__('Paggamit ng Po at Opo - Interactive Respectful Language')">
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
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
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
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
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
        
        .example-card {
            background: linear-gradient(135deg, #e9d5ff 0%, #e0e7ff 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 5px solid #8b5cf6;
        }
        
        .activity-box {
            background: linear-gradient(135deg, #f3e8ff 0%, #e0e7ff 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #8b5cf6;
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
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        
        .btn {
            background: #8b5cf6;
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
            background: #6d28d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 92, 246, 0.3);
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
            background: linear-gradient(90deg, #8b5cf6 0%, #6366f1 100%);
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
            border: 2px solid #8b5cf6;
            background: white;
            color: #8b5cf6;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            background: #8b5cf6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 92, 246, 0.3);
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .page-counter {
            font-weight: bold;
            color: #8b5cf6;
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
            background: #8b5cf6;
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
            border-color: #8b5cf6;
            background: #f3e8ff;
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
            <h1>🙏 Paggamit ng Po at Opo 🙏</h1>
            <p>Matuto na Gumamit ng Magalang na Particle sa Filipino</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots" id="pageDots"></div>

        <!-- Page 1: Introduction -->
        <div id="page-1" class="page-section active">
            <h2>Maligayang pagdating sa Paggamit ng Po at Opo! 👋</h2>
            <p>Isa sa pinakamahalagang aspeto ng wikang Pilipino ay ipinapakita ang paggalang sa pamamagitan ng tamang gramatika at particle. Matuto kung paano gamitin ang "Po" at "Opo" upang makipag-usap nang may paggalang.</p>
            
            <div class="activity-box">
                <h3>Ano ang Po at Opo?</h3>
                <p><strong>Po</strong> at <strong>Opo</strong> ay mga magalanng particle na idinagdag sa mga pangungusap upang ipakita ang paggalang at kabuluhan sa mga matatanda, magulang, guro, at mga taong may awtoridad.</p>
                <ul style="margin-left: 20px;">
                    <li><strong>Po</strong> - Idinagdag sa pagtatapos ng mga pahayag o katanungan</li>
                    <li><strong>Opo</strong> - Isang magalanng paraan upang sabihin ang "oo"</li>
                    <li>Pareho ay nagpapakita ng karangalan at pagiging magalang</li>
                    <li>Mahalaga sa pamilyang Pilipino at social na pakikipag-ugnayan</li>
                </ul>
            </div>
        </div>

        <!-- Page 2: Understanding Po -->
        <div id="page-2" class="page-section">
            <h2>Pag-unawa sa "Po" 🎯</h2>
            <p>Matuto kung paano gamitin ang "Po" sa iba't ibang konteksto:</p>
            
            <div class="example-card">
                <h3>Pangungusap with Po:</h3>
                <p><strong>Halimbawa:</strong> "Kumain na po ako."</p>
                <p><strong>Ingles:</strong> "I have eaten (respectfully)."</p>
                <button class="btn" onclick="speak('Kumain na po ako')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Katanungan with Po:</h3>
                <p><strong>Halimbawa:</strong> "May assignment na po ba?"</p>
                <p><strong>Ingles:</strong> "Is there an assignment (respectfully asked)?"</p>
                <button class="btn" onclick="speak('May assignment na po ba')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Hiling with Po:</h3>
                <p><strong>Halimbawa:</strong> "Makakatulong kayo po?"</p>
                <p><strong>Ingles:</strong> "Can you help (me, respectfully)?"</p>
                <button class="btn" onclick="speak('Makakatulong kayo po')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Pag-hihikayat with Po:</h3>
                <p><strong>Halimbawa:</strong> "Pasensya na po, huli po ako."</p>
                <p><strong>Ingles:</strong> "I'm sorry (respectfully), I'm late."</p>
                <button class="btn" onclick="speak('Pasensya na po, huli po ako')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 3: Understanding Opo -->
        <div id="page-3" class="page-section">
            <h2>Pag-unawa sa "Opo" ✅</h2>
            <p>Pagkuha ng kakayahan sa paggamit ng "Opo" bilang magalanng pagkakataon:</p>
            
            <div class="example-card">
                <h3>Pagsasabi ng Oo nang may Paggalang:</h3>
                <p><strong>Halimbawa:</strong> "Opo, tutulungan ko po kayo."</p>
                <p><strong>Ingles:</strong> "Yes, I will help you (respectfully)."</p>
                <button class="btn" onclick="speak('Opo, tutulungan ko po kayo')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Pag-confirm ng Pag-unawa:</h3>
                <p><strong>Halimbawa:</strong> "Opo, naiintindihan ko po."</p>
                <p><strong>Ingles:</strong> "Yes, I understand (respectfully)."</p>
                <button class="btn" onclick="speak('Opo, naiintindihan ko po')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Pagsang-ayon nang may Paggalang:</h3>
                <p><strong>Halimbawa:</strong> "Opo, tama po kayo."</p>
                <p><strong>Ingles:</strong> "Yes, you are right (respectfully)."</p>
                <button class="btn" onclick="speak('Opo, tama po kayo')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>Pagsasabi ng Hindi nang may Paggalang:</h3>
                <p><strong>Halimbawa:</strong> "Hindi po, hindi ko po kayang gawin."</p>
                <p><strong>Ingles:</strong> "No (respectfully), I cannot do it."</p>
                <button class="btn" onclick="speak('Hindi po, hindi ko po kayang gawin')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 4: When to Use Po/Opo -->
        <div id="page-4" class="page-section">
            <h2>Kailan Gamitin ang Po at Opo 🕐</h2>
            <p>Alamin ang angkop na sitwasyon para sa paggamit ng mga magalanng particle:</p>
            
            <div class="activity-box">
                <h3>Gamitin ang Po/Opo Kapag:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Nagsasalita sa mga magulang at mas matandang kaanak</li>
                    <li>✅ Nagsasalita sa mga guro at propessor</li>
                    <li>✅ Nag-aaddress sa mga boss at employer</li>
                    <li>✅ Nagsasalita sa mga matatanda sa iyong komunidad</li>
                    <li>✅ Sa mga pormal na pulong o presentasyon</li>
                    <li>✅ Kapag unang nakilala mo ang isang matandang tao</li>
                    <li>✅ Sa propesyonal at opisyal na mga setting</li>
                </ul>
            </div>

            <div class="activity-box">
                <h3>Casual na Paggamit (Walang Po/Opo):</h3>
                <p>Maaari mong alisin ang Po/Opo kapag:</p>
                <ul style="margin-left: 20px;">
                    <li>Nagsasalita sa mga kaibigan na katulad ng edad</li>
                    <li>Nakikipag-usap nang casual sa mga kapatid</li>
                    <li>Pormal na pag-usap sa mga kapantay</li>
                    <li>Ngunit palaging gamitin ito kung hindi ka sigurado!</li>
                </ul>
            </div>
        </div>

        <!-- Page 5: Practice Activity -->
        <div id="page-5" class="page-section">
            <h2>🎯 Pagsasanay: Gumawa ng Magalanng Mga Pangungusap</h2>
            <p>Lumikha ng mga pangungusap gamit ang Po at Opo, pagkatapos ay marinig ang mga ito na nagsasalita:</p>
            
            <div class="activity-box">
                <h3>Gumawa ng Pangungusap na May Po:</h3>
                <input type="text" id="statement1" class="activity-input" placeholder="Halimbawa: Kumain na po ako">
                <button class="btn" onclick="speak(document.getElementById('statement1').value || 'Mangyaring magsulat ng pangungusap')">🔊 Magsalita</button>
            </div>

            <div class="activity-box">
                <h3>Gumawa ng Katanungan na May Po:</h3>
                <input type="text" id="question1" class="activity-input" placeholder="Halimbawa: Makakatulong kayo po?">
                <button class="btn" onclick="speak(document.getElementById('question1').value || 'Mangyaring magsulat ng katanungan')">🔊 Magsalita</button>
            </div>

            <div class="activity-box">
                <h3>Gumawa ng Pagtugon na Opo:</h3>
                <input type="text" id="response1" class="activity-input" placeholder="Halimbawa: Opo, tutulungan ko po kayo">
                <button class="btn" onclick="speak(document.getElementById('response1').value || 'Mangyaring magsulat ng pagtugon')">🔊 Magsalita</button>
            </div>
        </div>

        <!-- Page 6: Quiz -->
        <div id="page-6" class="page-section">
            <h2>📝 Pagsusulit sa Kaalaman</h2>
            <p>Subukan ang iyong pag-unawa sa paggamit ng Po at Opo:</p>
            
            <div class="activity-box">
                <h3>Tanong 1: Kailan dapat gamitin ang Po/Opo?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Kapag nagsasalita sa mga magulang, guro, at matatanda
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Lamang kapag nagbabati ng mga tao sa umaga
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Kapag nagsasalita sa iyong malapit na mga kaibigan
                </div>
                <div id="feedback-1"></div>
            </div>

            <div class="activity-box">
                <h3>Tanong 2: Ano ang kahulugan ng "Opo"?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) Isang magalanng paraan upang sabihin ang "oo"
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) Isang uri ng pagkain
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Isang pag-bati
                </div>
                <div id="feedback-2"></div>
            </div>

            <div class="activity-box">
                <h3>Tanong 3: Aling pangungusap ang gumagamit ng Po nang tama?</h3>
                <div class="quiz-option" onclick="checkAnswer(this, true)">
                    A) "Makakatulong kayo po?"
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    B) "Makakatulong po kayo" (bilang isang casual na pahayag)
                </div>
                <div class="quiz-option" onclick="checkAnswer(this, false)">
                    C) Parehong ay hindi tama
                </div>
                <div id="feedback-3"></div>
            </div>
        </div>

        <!-- Page 7: Common Mistakes -->
        <div id="page-7" class="page-section">
            <h2>⚠️ Mga Karaniwang Pagkakamali na Dapat Iwasan</h2>
            <p>Matuto kung ano ang HINDI dapat gawin kapag gumagamit ng Po at Opo:</p>
            
            <div class="example-card">
                <h3>❌ Nakalimutan ang Po sa mga magulang:</h3>
                <p><strong>Mali:</strong> "Nanay, may pera ka ba?"</p>
                <p><strong>Tama:</strong> "Nanay, may pera po ba kayo?"</p>
                <button class="btn" onclick="speak('Nanay, may pera po ba kayo')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>❌ Paggamit ng Po sa mga kaibigan:</h3>
                <p><strong>Mali:</strong> "Samahan mo po kami" (sa isang malapit na kaibigan)</p>
                <p><strong>Tama:</strong> "Samahan mo kami" (casual)</p>
                <button class="btn" onclick="speak('Samahan mo kami')">🔊 Marinig</button>
            </div>

            <div class="example-card">
                <h3>❌ Maling paglalagay ng Po:</h3>
                <p><strong>Mali:</strong> "Po kumain na ako" (maling posisyon)</p>
                <p><strong>Tama:</strong> "Kumain na po ako" (tamang posisyon)</p>
                <button class="btn" onclick="speak('Kumain na po ako')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 8: Real-Life Scenarios -->
        <div id="page-8" class="page-section">
            <h2>🏠 Mga Real-Life na Pag-uusap</h2>
            <p>Tingnan ang Po at Opo sa tunay na daliyalog:</p>
            
            <div class="activity-box">
                <h3>Sitwasyon 1: Humihingi ng Pahintulot sa Magulang</h3>
                <p><strong>Bata:</strong> "Nanay, magsasaya po ba ako sa kaibigan?"</p>
                <p><strong>Magulang:</strong> "Opo, pwede mo. Bumalik lang po ng maaga."</p>
                <button class="btn" onclick="speak('Nanay, magsasaya po ba ako sa kaibigan?')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Sitwasyon 2: Nagsasalita sa Guro</h3>
                <p><strong>Estudyante:</strong> "Teacher, may tanong po ako."</p>
                <p><strong>Guro:</strong> "Opo, anong tanong mo?"</p>
                <button class="btn" onclick="speak('Teacher, may tanong po ako.')">🔊 Marinig</button>
            </div>

            <div class="activity-box">
                <h3>Sitwasyon 3: Tumutulong sa Matanda</h3>
                <p><strong>Kabataan:</strong> "Lolo, makakatulong po ako?"</p>
                <p><strong>Lolo:</strong> "Opo, salamat po."</p>
                <button class="btn" onclick="speak('Lolo, makakatulong po ako?')">🔊 Marinig</button>
            </div>
        </div>

        <!-- Page 9: Summary & Completion -->
        <div id="page-9" class="page-section">
            <h2>🎓 Buod ng Leksyon</h2>
            
            <div class="completion-badge">
                <h2>✅ Binabati! 🎉</h2>
                <p>Tapos mo na ang "Paggamit ng Po at Opo" na leksyon!</p>
                <p style="font-size: 1.2rem; margin-top: 15px;">Natuto ka na kung paano gamitin ang mga magalanng particle upang makipag-usap ng tama sa Filipino!</p>
            </div>

            <div class="activity-box">
                <h3>Mga Pangunahing Kaisipan:</h3>
                <ul style="margin-left: 20px;">
                    <li>✅ Ang Po ay idinagdag sa pagtatapos ng mga pahayag o katanungan</li>
                    <li>✅ Ang Opo ay isang magalanng paraan upang sabihin ang "oo"</li>
                    <li>✅ Gamitin ito sa mga magulang, guro, at matatanda</li>
                    <li>✅ Ang tamang paglalagay ay mahalaga</li>
                    <li>✅ Nagpapakita ito ng paggalang at magandang pagpapalaki</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <button class="btn" onclick="completeLesson()" style="font-size: 1.1rem; padding: 15px 40px;">✅ Mark as Complete</button>
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
            <h2 style="color: #8b5cf6; font-size: 1.8rem; margin-bottom: 20px;">🏆 Kamangha-manghang Gawa!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 20px;">Matagumpay mong natapos ang "Paggamit ng Po at Opo" na leksyon. Napakagaling na pag-unlad!</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="closeModal()" style="padding: 10px 20px; background: #e5e7eb; color: #374151; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Magpatuloy sa Pag-aaral</button>
                <button onclick="returnToTopics()" style="padding: 10px 20px; background: #8b5cf6; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Bumalik sa Mga Paksa</button>
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

