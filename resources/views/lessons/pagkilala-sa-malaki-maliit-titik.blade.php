<x-layouts::app :title="__('Pagkilala sa Malaki at Maliit na Titik - Interactive Lesson')">
    <style>
        @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slide-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        @keyframes confetti-fall { 0% { opacity: 1; transform: translateY(0) rotateZ(0deg); } 100% { opacity: 0; transform: translateY(300px) rotateZ(360deg); } }
        @keyframes point-popup { 0% { opacity: 1; transform: translateY(0); } 100% { opacity: 0; transform: translateY(-50px); } }
        @keyframes badge-unlock { 0% { transform: scale(0); } 50% { transform: scale(1.2); } 100% { transform: scale(1); } }
        @keyframes streak-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }

        .fade-in { animation: fade-in 0.5s ease-in; }
        .slide-up { animation: slide-up 0.5s ease-out; }
        .pulse { animation: pulse 1s infinite; }
        .confetti { animation: confetti-fall 3s ease-out forwards; position: fixed; font-size: 2rem; pointer-events: none; }
        .point-popup { animation: point-popup 1s ease-out forwards; position: fixed; font-weight: bold; color: #10b981; pointer-events: none; }
        .badge-unlock { animation: badge-unlock 0.6s ease-out; }
        .streak-pulse { animation: streak-pulse 0.3s ease-out; }

        .page { display: none; }
        .page.active { display: block; animation: slide-up 0.5s ease-out; }
        .correct { background-color: #dcfce7 !important; }
        .incorrect { background-color: #fee2e2 !important; }
        .example-card { background: linear-gradient(135deg, #f3f4f6, #e5e7eb); padding: 20px; border-radius: 12px; min-height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; max-width: 280px; cursor: pointer; transition: all 0.3s ease; }
        .example-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .badge { padding: 10px 15px; border-radius: 8px; background: #f0f9ff; border: 2px solid #0284c7; text-align: center; font-size: 2rem; position: relative; }
        .badge.locked { opacity: 0.4; filter: grayscale(1); }
        .badge.unlocked { animation: badge-unlock 0.6s ease-out; background: #ecfdf5; border-color: #10b981; }
        .badge-label { font-size: 0.75rem; font-weight: bold; color: #0284c7; margin-top: 5px; }
        .badge.unlocked .badge-label { color: #059669; }
        .quiz-option { cursor: pointer; padding: 12px; margin: 8px 0; border: 2px solid #e5e7eb; border-radius: 8px; transition: all 0.3s ease; }
        .quiz-option:hover { border-color: #3b82f6; background-color: #eff6ff; }
        .quiz-option.correct { background-color: #dcfce7; border-color: #16a34a; }
        .quiz-option.incorrect { background-color: #fee2e2; border-color: #dc2626; }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4); animation: fade-in 0.3s ease; }
        .modal.active { display: flex; justify-content: center; align-items: center; }
        .modal-content { background-color: white; padding: 40px; border-radius: 16px; text-align: center; max-width: 500px; animation: slide-up 0.5s ease-out; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .modal-content h2 { font-size: 2.5rem; margin-bottom: 20px; }
        .modal-stats { margin: 20px 0; font-size: 1.1rem; }
        .progress-bar { width: 100%; height: 8px; background-color: #e5e7eb; border-radius: 10px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #f59e0b, #d97706); transition: width 0.3s ease; }
        .page-dots { display: flex; justify-content: center; gap: 8px; margin: 20px 0; }
        .dot { width: 12px; height: 12px; border-radius: 50%; background-color: #d1d5db; cursor: pointer; transition: all 0.3s ease; }
        .dot.active { background-color: #f59e0b; transform: scale(1.3); }
        .flex-container { display: flex; gap: 20px; flex-wrap: nowrap; overflow-x: auto; padding: 10px 0; }
        .gamification-header { display: flex; justify-content: space-around; align-items: center; margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; color: white; }
        .stat-box { text-align: center; }
        .stat-number { font-size: 2rem; font-weight: bold; }
        .stat-label { font-size: 0.9rem; opacity: 0.9; margin-top: 5px; }
    </style>

    <div class="w-full px-4 py-8 max-w-4xl mx-auto">
        <!-- Gamification Header -->
        <div class="gamification-header">
            <div class="stat-box">
                <div class="stat-number" id="pointsDisplay">0</div>
                <div class="stat-label">Puntos</div>
            </div>
            <div class="stat-box">
                <div class="stat-number" id="streakDisplay">0</div>
                <div class="stat-label">Streak 🔥</div>
            </div>
            <div id="badgeDisplay" style="display: flex; gap: 10px; flex-direction: column;"></div>
        </div>

        <!-- Page Dots -->
        <div class="page-dots">
            <span class="dot active" onclick="goToPage(0)"></span>
            <span class="dot" onclick="goToPage(1)"></span>
            <span class="dot" onclick="goToPage(2)"></span>
            <span class="dot" onclick="goToPage(3)"></span>
            <span class="dot" onclick="goToPage(4)"></span>
            <span class="dot" onclick="goToPage(5)"></span>
            <span class="dot" onclick="goToPage(6)"></span>
            <span class="dot" onclick="goToPage(7)"></span>
            <span class="dot" onclick="goToPage(8)"></span>
        </div>

        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill" style="width: 0%;"></div>
        </div>

        <!-- Pages -->
        <!-- Page 1: Introduction -->
        <div class="page active">
            <div style="background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; padding: 40px 20px; text-align: center; color: white;">
                <h1 class="text-4xl font-bold mb-4">📝 Pagkilala sa Malaki at Maliit na Titik 📝</h1>
                <p class="text-xl mb-6">Matuto ng Malaki (Uppercase) at Maliit (Lowercase) na titik!</p>
                <p class="text-lg opacity-90">A (Malaki) vs a (Maliit) - Mayroon silang parehong tunog pero iba ang sulat!</p>
                <button onclick="goToPage(1)" class="mt-8 px-8 py-3 bg-white text-amber-700 rounded-lg font-bold text-lg hover:bg-gray-100 transition">Magsimula Ngayon! ➜</button>
            </div>
        </div>

        <!-- Page 2: Vowels Comparison -->
        <div class="page">
            <h2 class="text-3xl font-bold mb-6">Patinig: Malaki vs Maliit (Vowels)</h2>
            <div class="flex-container">
                <div class="example-card" onclick="speak('A - Malaking A')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅰️</div>
                    <h3 class="text-2xl font-bold">A</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('A - Malaking A')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('a - Maliit na a')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅰️</div>
                    <h3 class="text-2xl font-bold">a</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('a - Maliit na a')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('E - Malaking E')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅴</div>
                    <h3 class="text-2xl font-bold">E</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('E - Malaking E')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('e - Maliit na e')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅰️</div>
                    <h3 class="text-2xl font-bold">e</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('e - Maliit na e')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('I - Malaking I')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">ℹ️</div>
                    <h3 class="text-2xl font-bold">I</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('I - Malaking I')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
            </div>
        </div>

        <!-- Page 3: More Vowels -->
        <div class="page">
            <h2 class="text-3xl font-bold mb-6">Patinig Kahulihan: O at U (Vowels)</h2>
            <div class="flex-container">
                <div class="example-card" onclick="speak('i - Maliit na i')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">ℹ️</div>
                    <h3 class="text-2xl font-bold">i</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('i - Maliit na i')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('O - Malaking O')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">⭕</div>
                    <h3 class="text-2xl font-bold">O</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('O - Malaking O')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('o - Maliit na o')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">⭕</div>
                    <h3 class="text-2xl font-bold">o</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('o - Maliit na o')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('U - Malaking U')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🆄</div>
                    <h3 class="text-2xl font-bold">U</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('U - Malaking U')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('u - Maliit na u')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🆄</div>
                    <h3 class="text-2xl font-bold">u</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('u - Maliit na u')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
            </div>
        </div>

        <!-- Page 4: Consonants B-D -->
        <div class="page">
            <h2 class="text-3xl font-bold mb-6">Katinig: Malaki vs Maliit (Consonants B-D)</h2>
            <div class="flex-container">
                <div class="example-card" onclick="speak('B - Malaking Ba')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅱️</div>
                    <h3 class="text-2xl font-bold">B</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('B - Malaking Ba')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('b - Maliit na ba')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅱️</div>
                    <h3 class="text-2xl font-bold">b</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('b - Maliit na ba')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('C - Malaking Ca')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">ℭ</div>
                    <h3 class="text-2xl font-bold">C</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('C - Malaking Ca')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('c - Maliit na ca')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">ℭ</div>
                    <h3 class="text-2xl font-bold">c</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('c - Maliit na ca')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('D - Malaking Da')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅳</div>
                    <h3 class="text-2xl font-bold">D</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('D - Malaking Da')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
            </div>
        </div>

        <!-- Page 5: More Consonants -->
        <div class="page">
            <h2 class="text-3xl font-bold mb-6">Katinig: D-F (Malaki at Maliit)</h2>
            <div class="flex-container">
                <div class="example-card" onclick="speak('d - Maliit na da')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅳</div>
                    <h3 class="text-2xl font-bold">d</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('d - Maliit na da')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('E - Malaking E')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅴</div>
                    <h3 class="text-2xl font-bold">E</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('E - Malaking E')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('F - Malaking Fa')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅵</div>
                    <h3 class="text-2xl font-bold">F</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('F - Malaking Fa')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('f - Maliit na fa')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅵</div>
                    <h3 class="text-2xl font-bold">f</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('f - Maliit na fa')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('G - Malaking Ga')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅶</div>
                    <h3 class="text-2xl font-bold">G</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('G - Malaking Ga')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
            </div>
        </div>

        <!-- Page 6: Consonants G-L -->
        <div class="page">
            <h2 class="text-3xl font-bold mb-6">Katinig: G-L (Malaki at Maliit)</h2>
            <div class="flex-container">
                <div class="example-card" onclick="speak('g - Maliit na ga')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅶</div>
                    <h3 class="text-2xl font-bold">g</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('g - Maliit na ga')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('H - Malaking Ha')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">ℍ</div>
                    <h3 class="text-2xl font-bold">H</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('H - Malaking Ha')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('h - Maliit na ha')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">ℍ</div>
                    <h3 class="text-2xl font-bold">h</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('h - Maliit na ha')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('L - Malaking La')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅻</div>
                    <h3 class="text-2xl font-bold">L</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('L - Malaking La')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('l - Maliit na la')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅻</div>
                    <h3 class="text-2xl font-bold">l</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('l - Maliit na la')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
            </div>
        </div>

        <!-- Page 7: More Consonants -->
        <div class="page">
            <h2 class="text-3xl font-bold mb-6">Katinig: M-P (Malaki at Maliit)</h2>
            <div class="flex-container">
                <div class="example-card" onclick="speak('M - Malaking Ma')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">Ⓜ️</div>
                    <h3 class="text-2xl font-bold">M</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('M - Malaking Ma')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('m - Maliit na ma')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">Ⓜ️</div>
                    <h3 class="text-2xl font-bold">m</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('m - Maliit na ma')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('P - Malaking Pa')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅿️</div>
                    <h3 class="text-2xl font-bold">P</h3>
                    <p class="text-sm text-gray-600 mt-2">Malaking Titik</p>
                    <button onclick="event.stopPropagation(); speak('P - Malaking Pa')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
                <div class="example-card" onclick="speak('p - Maliit na pa')">
                    <div style="font-size: 4rem; margin-bottom: 10px;">🅿️</div>
                    <h3 class="text-2xl font-bold">p</h3>
                    <p class="text-sm text-gray-600 mt-2">Maliit na Titik</p>
                    <button onclick="event.stopPropagation(); speak('p - Maliit na pa')" class="mt-4 px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">🔊 Marinig</button>
                </div>
            </div>
            <p class="text-center text-gray-600 mt-8 text-lg">🎉 Mahusay ang pag-aaral ng Malaki at Maliit na Titik!</p>
        </div>

        <!-- Page 8: Quiz -->
        <div class="page">
            <h2 class="text-3xl font-bold mb-6">📝 Pagsusulit: Tukuyin ang Tama</h2>
            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                <!-- Question 1 -->
                <div class="quiz-question mb-6" id="question1">
                    <h3 class="text-lg font-bold mb-4">Tanong 1: Alin ang Malaking titik?</h3>
                    <div class="quiz-option" onclick="checkAnswer(this, true)" data-question="1">
                        <strong>A</strong> - Malaking titik
                    </div>
                    <div class="quiz-option" onclick="checkAnswer(this, false)" data-question="1">
                        <strong>a</strong> - Maliit na titik
                    </div>
                    <div class="quiz-option" onclick="checkAnswer(this, false)" data-question="1">
                        <strong>á</strong> - May accent
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="quiz-question mb-6" id="question2">
                    <h3 class="text-lg font-bold mb-4">Tanong 2: Paano spelling ng malaki na B?</h3>
                    <div class="quiz-option" onclick="checkAnswer(this, false)" data-question="2">
                        <strong>b</strong> - Maliit
                    </div>
                    <div class="quiz-option" onclick="checkAnswer(this, true)" data-question="2">
                        <strong>B</strong> - Malaki
                    </div>
                    <div class="quiz-option" onclick="checkAnswer(this, false)" data-question="2">
                        <strong>bb</strong> - Double B
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="quiz-question" id="question3">
                    <h3 class="text-lg font-bold mb-4">Tanong 3: Pareho ba ang tunog ng Malaki at Maliit na titik?</h3>
                    <div class="quiz-option" onclick="checkAnswer(this, true)" data-question="3">
                        <strong>Oo</strong> - Pareho ang tunog
                    </div>
                    <div class="quiz-option" onclick="checkAnswer(this, false)" data-question="3">
                        <strong>Hindi</strong> - Iba ang tunog
                    </div>
                    <div class="quiz-option" onclick="checkAnswer(this, false)" data-question="3">
                        <strong>Siguro</strong> - Di sigurado
                    </div>
                </div>
            </div>
        </div>

        <!-- Page 9: Summary -->
        <div class="page">
            <div style="background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; padding: 40px 20px; text-align: center; color: white;">
                <h1 class="text-4xl font-bold mb-6">🏆 Mahusay! Tapos na!</h1>
                <p class="text-xl mb-6">Natuto ka na ng Malaki at Maliit na Titik!</p>
                <p class="text-lg mb-8 opacity-90">Uppercase at Lowercase - Pareho ang tunog, iba ang hitsura!</p>
                <div class="mt-8 p-4 bg-white text-amber-700 rounded-lg">
                    <p class="text-xl font-bold">Sana ay nag-enjoy ka sa paglalaro!</p>
                    <p class="text-lg mt-2">Bumalik at subukan ang ibang lessons!</p>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div style="display: flex; justify-content: space-between; margin-top: 30px; gap: 10px;">
            <button onclick="previousPage()" class="flex-1 px-6 py-3 bg-gray-500 text-white rounded-lg font-bold hover:bg-gray-600 transition" id="prevBtn">⬅️ Nakaraang</button>
            <button onclick="nextPage()" class="flex-1 px-6 py-3 bg-amber-600 text-white rounded-lg font-bold hover:bg-amber-700 transition" id="nextBtn">Susunod ➜</button>
        </div>

        <!-- Completion Modal -->
        <div id="completionModal" class="modal">
            <div class="modal-content">
                <h2>🎉 Tapos na ang Araw!</h2>
                <div class="modal-stats">
                    <p>💰 Puntos: <strong id="finalPoints">0</strong></p>
                    <p>🔥 Streak: <strong id="finalStreak">0</strong></p>
                    <p>⏱️ Oras: <strong id="finalTime">0 segundo</strong></p>
                </div>
                <div style="display:flex; gap:12px; justify-content:center; margin-top:18px;">
                    <button onclick="markAsCompleted()" id="markDoneBtn" class="px-6 py-3 bg-amber-500 text-white rounded-lg font-bold hover:bg-amber-600">Markahan bilang tapos na</button>
                    <button onclick="closeModal()" class="px-6 py-3 bg-amber-600 text-white rounded-lg font-bold hover:bg-amber-700">Sarado</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 0;
        const totalPages = 9;
        let gameState = {
            totalPoints: 0,
            streak: 0,
            questionsAnswered: 0,
            badges: [],
            startTime: Date.now()
        };

        function showPage(pageNum) {
            const pages = document.querySelectorAll('.page');
            pages.forEach(p => p.classList.remove('active'));
            pages[pageNum].classList.add('active');
            
            const dots = document.querySelectorAll('.dot');
            dots.forEach(d => d.classList.remove('active'));
            dots[pageNum].classList.add('active');
            
            const progress = (pageNum / (totalPages - 1)) * 100;
            document.getElementById('progressFill').style.width = progress + '%';
            
            document.getElementById('prevBtn').disabled = pageNum === 0;
            document.getElementById('nextBtn').disabled = pageNum === totalPages - 1;
        }

        function nextPage() {
            if (currentPage < totalPages - 1) {
                currentPage++;
                showPage(currentPage);
            }
        }

        function previousPage() {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        }

        function goToPage(pageNum) {
            currentPage = pageNum;
            showPage(currentPage);
        }

        function speak(text) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'fil-PH';
            utterance.rate = 0.85;
            utterance.pitch = 1.0;
            utterance.volume = 1.0;
            window.speechSynthesis.speak(utterance);
        }

        function addPoints(points) {
            gameState.totalPoints += points;
            document.getElementById('pointsDisplay').textContent = gameState.totalPoints;
            
            const pointPopup = document.createElement('div');
            pointPopup.className = 'point-popup';
            pointPopup.textContent = '+' + points;
            pointPopup.style.left = (Math.random() * window.innerWidth) + 'px';
            pointPopup.style.top = (Math.random() * window.innerHeight / 2) + 'px';
            document.body.appendChild(pointPopup);
            
            setTimeout(() => pointPopup.remove(), 1000);
            checkAchievements();
        }

        function updateStreak(correct) {
            if (correct) {
                gameState.streak++;
                document.getElementById('streakDisplay').classList.add('streak-pulse');
                setTimeout(() => document.getElementById('streakDisplay').classList.remove('streak-pulse'), 300);
            } else {
                gameState.streak = 0;
            }
            document.getElementById('streakDisplay').textContent = gameState.streak;
        }

        function triggerConfetti() {
            const emojis = ['🎉', '⭐', '🌟', '💫', '✨', '🎊', '🎈', '🏆'];
            for (let i = 0; i < 15; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.textContent = emojis[Math.floor(Math.random() * emojis.length)];
                    confetti.style.left = Math.random() * window.innerWidth + 'px';
                    confetti.style.top = '0px';
                    document.body.appendChild(confetti);
                    setTimeout(() => confetti.remove(), 3000);
                }, i * 50);
            }
        }

        function checkAchievements() {
            if (gameState.totalPoints >= 30 && !gameState.badges.includes('Perfect Score')) {
                gameState.badges.push('Perfect Score');
                renderBadges();
            }
            if (gameState.streak >= 3 && !gameState.badges.includes('On Fire')) {
                gameState.badges.push('On Fire');
                renderBadges();
            }
        }

        function renderBadges() {
            const badgeDisplay = document.getElementById('badgeDisplay');
            badgeDisplay.innerHTML = '';
            
            const allBadges = ['Perfect Score', 'On Fire'];
            const badgeEmojis = { 'Perfect Score': '💯', 'On Fire': '🔥' };
            
            allBadges.forEach(badge => {
                const badgeDiv = document.createElement('div');
                badgeDiv.className = 'badge ' + (gameState.badges.includes(badge) ? 'unlocked' : 'locked');
                badgeDiv.innerHTML = `<div>${badgeEmojis[badge]}</div><div class="badge-label">${badge}</div>`;
                badgeDisplay.appendChild(badgeDiv);
            });
        }

        function checkAnswer(element, isCorrect) {
            const buttons = element.parentElement.querySelectorAll('.quiz-option');
            buttons.forEach(btn => btn.style.pointerEvents = 'none');
            
            if (isCorrect) {
                element.classList.add('correct');
                addPoints(10);
                updateStreak(true);
                triggerConfetti();
                speak('Tama! Maganda!');
            } else {
                element.classList.add('incorrect');
                updateStreak(false);
                speak('Mali. Subukan ulit.');
            }
            
            gameState.questionsAnswered++;
            if (gameState.questionsAnswered === 3) {
                completeLesson();
            }
        }

        function completeLesson() {
            setTimeout(() => {
                document.getElementById('completionModal').classList.add('active');
                const endTime = Date.now();
                const timeElapsed = Math.floor((endTime - gameState.startTime) / 1000);
                document.getElementById('finalPoints').textContent = gameState.totalPoints;
                document.getElementById('finalStreak').textContent = gameState.streak;
                document.getElementById('finalTime').textContent = timeElapsed + ' segundo';
            }, 500);
        }

        function closeModal() {
            document.getElementById('completionModal').classList.remove('active');
            currentPage = 0;
            showPage(0);
        }

        function markAsCompleted() {
            try {
                localStorage.setItem('lesson:pagkilala-sa-malaki-maliit-titik:completed', '1');
            } catch (e) {
                console.warn('localStorage not available', e);
            }
            const progressFill = document.getElementById('progressFill');
            if (progressFill) progressFill.style.width = '100%';

            const popup = document.createElement('div');
            popup.className = 'point-popup';
            popup.textContent = 'Markado bilang tapos na ✓';
            popup.style.left = (window.innerWidth / 2 - 80) + 'px';
            popup.style.top = (window.innerHeight / 2) + 'px';
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 900);

            speak('Markado bilang tapos na');

            setTimeout(() => {
                document.getElementById('completionModal').classList.remove('active');
                window.location.href = "{{ route('subject.topics', ['subject' => 'filipino']) }}";
            }, 700);
        }

        renderBadges();
        showPage(0);
    </script>
</x-layouts::app>
