<x-layouts::app :title="__('Coloring Game')">
    <style>
        .design-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .design-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .design-card:hover::before {
            left: 100%;
        }

        .design-card:hover {
            transform: translateY(-12px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .design-card.selected {
            transform: scale(1.08);
        }

        .design-emoji {
            font-size: 4rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .design-card:hover .design-emoji {
            animation-duration: 0.6s;
        }

        .checkmark-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            transform: rotate(-15deg);
        }
    </style>

    <div class="w-full min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8">
        <!-- Header -->
        <div class="px-6 mb-12">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4 animate-bounce">🎨</div>
                    <h1 class="text-5xl font-black text-gray-900 dark:text-white mb-3">
                        Creative Coloring Game
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Choose your favorite design and let your creativity shine! 🌈 Pick a design below and start coloring with amazing colors.
                    </p>
                </div>
            </div>
        </div>

        <!-- Selection Screen -->
        <div id="selectionScreen" class="px-6 pb-12">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                    ✨ Choose Your Design ✨
                </h2>
                
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-5">
                    <!-- Design A - Flower -->
                    <div data-design="A" class="design-card rounded-3xl p-6 cursor-pointer group bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 shadow-lg" onclick="selectDesign('A')" role="button" aria-pressed="false" tabindex="0">
                        <div class="relative mb-4">
                            <span class="checkmark-badge hidden">✓</span>
                            <div class="w-full aspect-square bg-gradient-to-br from-pink-100 to-rose-100 dark:from-pink-900/30 dark:to-rose-900/30 rounded-2xl flex items-center justify-center relative">
                                <div class="design-emoji">🌸</div>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-center text-gray-900 dark:text-white mb-2">Flower</h3>
                        <p class="text-sm text-center text-gray-600 dark:text-gray-400 mb-4">A beautiful blooming flower</p>
                        <div class="w-full h-1 bg-gradient-to-r from-pink-300 to-rose-300 rounded-full"></div>
                    </div>

                    <!-- Design B - Butterfly -->
                    <div data-design="B" class="design-card rounded-3xl p-6 cursor-pointer group bg-white dark:bg-gray-800 border-2 border-purple-200 dark:border-purple-700 shadow-lg" onclick="selectDesign('B')" role="button" aria-pressed="false" tabindex="0">
                        <div class="relative mb-4">
                            <span class="checkmark-badge hidden">✓</span>
                            <div class="w-full aspect-square bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 rounded-2xl flex items-center justify-center relative">
                                <div class="design-emoji">🦋</div>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-center text-gray-900 dark:text-white mb-2">Butterfly</h3>
                        <p class="text-sm text-center text-gray-600 dark:text-gray-400 mb-4">A graceful flying butterfly</p>
                        <div class="w-full h-1 bg-gradient-to-r from-purple-300 to-indigo-300 rounded-full"></div>
                    </div>

                    <!-- Design C - Rainbow -->
                    <div data-design="C" class="design-card rounded-3xl p-6 cursor-pointer group bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-700 shadow-lg" onclick="selectDesign('C')" role="button" aria-pressed="false" tabindex="0">
                        <div class="relative mb-4">
                            <span class="checkmark-badge hidden">✓</span>
                            <div class="w-full aspect-square bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-2xl flex items-center justify-center relative">
                                <div class="design-emoji">🌈</div>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-center text-gray-900 dark:text-white mb-2">Rainbow</h3>
                        <p class="text-sm text-center text-gray-600 dark:text-gray-400 mb-4">Colorful rainbow arcs</p>
                        <div class="w-full h-1 bg-gradient-to-r from-blue-300 to-cyan-300 rounded-full"></div>
                    </div>

                    <!-- Design D - Stars -->
                    <div data-design="D" class="design-card rounded-3xl p-6 cursor-pointer group bg-white dark:bg-gray-800 border-2 border-yellow-200 dark:border-yellow-700 shadow-lg" onclick="selectDesign('D')" role="button" aria-pressed="false" tabindex="0">
                        <div class="relative mb-4">
                            <span class="checkmark-badge hidden">✓</span>
                            <div class="w-full aspect-square bg-gradient-to-br from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 rounded-2xl flex items-center justify-center relative">
                                <div class="design-emoji">⭐</div>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-center text-gray-900 dark:text-white mb-2">Stars</h3>
                        <p class="text-sm text-center text-gray-600 dark:text-gray-400 mb-4">Shining star collection</p>
                        <div class="w-full h-1 bg-gradient-to-r from-yellow-300 to-amber-300 rounded-full"></div>
                    </div>

                    <!-- Design E - Lion -->
                    <div data-design="E" class="design-card rounded-3xl p-6 cursor-pointer group bg-white dark:bg-gray-800 border-2 border-orange-200 dark:border-orange-700 shadow-lg" onclick="selectDesign('E')" role="button" aria-pressed="false" tabindex="0">
                        <div class="relative mb-4">
                            <span class="checkmark-badge hidden">✓</span>
                            <div class="w-full aspect-square bg-gradient-to-br from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 rounded-2xl flex items-center justify-center relative">
                                <div class="design-emoji">🦁</div>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-center text-gray-900 dark:text-white mb-2">Lion</h3>
                        <p class="text-sm text-center text-gray-600 dark:text-gray-400 mb-4">Majestic lion king</p>
                        <div class="w-full h-1 bg-gradient-to-r from-orange-300 to-red-300 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Canvas and Tools (Hidden until design selected) -->
        <div id="canvasScreen" class="hidden px-6 pb-8">
            <div class="max-w-7xl mx-auto">
                <!-- Canvas Header -->
                <div class="rounded-3xl bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-2 border-blue-200 dark:border-blue-700 p-8 mb-8 shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-4xl font-black text-gray-900 dark:text-white mb-2">
                                🎨 Design <span id="selectedDesign" class="text-blue-600 dark:text-blue-400">A</span>
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300">Express your creativity! Select colors and paint the design</p>
                        </div>
                        <button onclick="backToSelection()" class="px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-2xl font-bold transition-all transform hover:scale-105 shadow-lg">
                            ← Back to Designs
                        </button>
                    </div>
                </div>

                <!-- Tools and Canvas Container -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <!-- Tools Panel -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Color Palette Card -->
                        <div class="rounded-3xl bg-white dark:bg-gray-800 border-2 border-purple-200 dark:border-purple-700 p-6 shadow-xl">
                            <h3 class="text-lg font-black mb-4 text-gray-900 dark:text-white flex items-center gap-2">
                                🎨 Colors
                            </h3>
                            <div class="space-y-3">
                                <div class="grid grid-cols-5 gap-2">
                                    <button onclick="setColor('#FF0000')" class="w-full aspect-square rounded-xl bg-red-500 hover:scale-110 transition-transform border-2 border-red-600 shadow-md hover:shadow-lg" title="Red"></button>
                                    <button onclick="setColor('#00FF00')" class="w-full aspect-square rounded-xl bg-green-500 hover:scale-110 transition-transform border-2 border-green-600 shadow-md hover:shadow-lg" title="Green"></button>
                                    <button onclick="setColor('#0000FF')" class="w-full aspect-square rounded-xl bg-blue-500 hover:scale-110 transition-transform border-2 border-blue-600 shadow-md hover:shadow-lg" title="Blue"></button>
                                    <button onclick="setColor('#FFFF00')" class="w-full aspect-square rounded-xl bg-yellow-400 hover:scale-110 transition-transform border-2 border-yellow-500 shadow-md hover:shadow-lg" title="Yellow"></button>
                                    <button onclick="setColor('#FFA500')" class="w-full aspect-square rounded-xl bg-orange-500 hover:scale-110 transition-transform border-2 border-orange-600 shadow-md hover:shadow-lg" title="Orange"></button>
                                </div>
                                <div class="grid grid-cols-5 gap-2">
                                    <button onclick="setColor('#800080')" class="w-full aspect-square rounded-xl bg-purple-500 hover:scale-110 transition-transform border-2 border-purple-600 shadow-md hover:shadow-lg" title="Purple"></button>
                                    <button onclick="setColor('#FFC0CB')" class="w-full aspect-square rounded-xl bg-pink-400 hover:scale-110 transition-transform border-2 border-pink-500 shadow-md hover:shadow-lg" title="Pink"></button>
                                    <button onclick="setColor('#000000')" class="w-full aspect-square rounded-xl bg-black hover:scale-110 transition-transform border-2 border-gray-700 shadow-md hover:shadow-lg" title="Black"></button>
                                    <button onclick="setColor('#FFFFFF')" class="w-full aspect-square rounded-xl bg-white hover:scale-110 transition-transform border-2 border-gray-300 shadow-md hover:shadow-lg" title="White"></button>
                                    <input type="color" id="colorPicker" onchange="setColor(this.value)" class="w-full aspect-square rounded-xl cursor-pointer border-2 border-gray-300 shadow-md hover:shadow-lg" title="Custom Color">
                                </div>
                            </div>
                        </div>

                        <!-- Tools Card -->
                        <div class="rounded-3xl bg-white dark:bg-gray-800 border-2 border-green-200 dark:border-green-700 p-6 shadow-xl">
                            <h3 class="text-lg font-black mb-4 text-gray-900 dark:text-white flex items-center gap-2">
                                🛠️ Tools
                            </h3>
                            <div class="space-y-3">
                                <div class="flex gap-2">
                                    <button onclick="setTool('pen')" id="penTool" class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-all transform hover:scale-105 shadow-md">✏️</button>
                                    <button onclick="setTool('eraser')" id="eraserTool" class="flex-1 px-3 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-xl font-bold transition-all transform hover:scale-105 shadow-md">🧹</button>
                                </div>
                                <div>
                                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 block">Brush Size</label>
                                    <input type="range" id="brushSize" min="1" max="50" value="5" class="w-full" title="Brush Size">
                                    <div class="text-xs text-gray-500 mt-1 text-center" id="brushSizeDisplay">Size: 5</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="rounded-3xl bg-white dark:bg-gray-800 border-2 border-red-200 dark:border-red-700 p-6 shadow-xl space-y-3">
                            <div class="grid grid-cols-3 gap-3">
                                <button onclick="undo()" id="undoBtn" aria-label="Undo (Z)" disabled class="px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg font-semibold transition">↶ Undo</button>
                                <button onclick="redo()" id="redoBtn" aria-label="Redo (Y)" disabled class="px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg font-semibold transition">↷ Redo</button>
                                <button onclick="toggleGrid()" id="gridBtn" aria-label="Toggle grid (G)" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg font-semibold transition">🔳 Grid</button>
                            </div>
                            <div class="mt-3">
                                <label for="gridSize" class="text-xs font-medium text-gray-600 dark:text-gray-300">Grid size</label>
                                <input id="gridSize" type="range" min="8" max="64" value="20" class="w-full mt-1" title="Grid size">
                                <div id="gridSizeDisplay" class="text-xs text-gray-500 text-center mt-1">20px</div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <button onclick="toggleFullScreen()" id="fullscreenBtn" class="w-full px-4 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-xl font-bold transition-all transform hover:scale-105 shadow-md">
                                    ⛶ Fullscreen
                                </button>
                                <button onclick="clearCanvas()" class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl font-bold transition-all transform hover:scale-105 shadow-md">
                                    🗑️ Clear
                                </button>
                            </div>
                            <button onclick="downloadCanvas()" class="w-full px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl font-bold transition-all transform hover:scale-105 shadow-md">
                                ⬇️ Download
                            </button>
                        </div>
                    </div>

                    <!-- Canvas Area -->
                    <div class="lg:col-span-4">
                        <div id="canvasWrapper" class="relative rounded-3xl border-4 border-dashed border-gray-300 dark:border-gray-600 overflow-hidden bg-white dark:bg-neutral-800 shadow-2xl" style="min-height: 600px;">
                            <div id="canvasGrid" class="pointer-events-none absolute inset-0 hidden" style="background-image: linear-gradient(rgba(0,0,0,0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.06) 1px, transparent 1px); background-size: 20px 20px; opacity: 0.6;"></div>
                            <canvas id="coloringCanvas" class="block mx-auto w-full max-w-full" width="800" height="600" style="cursor: crosshair; display: block; background: white;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('coloringCanvas');
        const ctx = canvas.getContext('2d');
        const wrapper = document.getElementById('canvasWrapper');
        const gridOverlay = document.getElementById('canvasGrid');

        let isDrawing = false;
        let currentColor = '#000000';
        let currentTool = 'pen';
        let brushSize = 5;
        let selectedDesign = 'A';

        // History stacks for undo/redo (store dataURLs)
        const undoStack = [];
        const redoStack = [];
        const maxHistory = 30;

        function updateHistoryButtons() {
            const undoBtn = document.getElementById('undoBtn');
            const redoBtn = document.getElementById('redoBtn');
            if (undoBtn) undoBtn.disabled = undoStack.length === 0;
            if (redoBtn) redoBtn.disabled = redoStack.length === 0;
        }

        function pushState() {
            try {
                undoStack.push(canvas.toDataURL());
                if (undoStack.length > maxHistory) undoStack.shift();
                // clear redo on new action
                redoStack.length = 0;
            } catch (e) {
                console.warn('Unable to push state for undo:', e);
            }
            updateHistoryButtons();
        }

        function undo() {
            if (!undoStack.length) return;
            try {
                redoStack.push(canvas.toDataURL());
                const data = undoStack.pop();
                const img = new Image();
                img.onload = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                };
                img.src = data;
            } catch (e) { console.error(e); }
            updateHistoryButtons();
        }

        function redo() {
            if (!redoStack.length) return;
            try {
                undoStack.push(canvas.toDataURL());
                const data = redoStack.pop();
                const img = new Image();
                img.onload = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                };
                img.src = data;
            } catch (e) { console.error(e); }
            updateHistoryButtons();
        }

        function resizeCanvas() {
            try {
                const data = canvas.toDataURL();
                const rect = wrapper.getBoundingClientRect();
                const targetWidth = Math.max(400, Math.min(1200, Math.round(rect.width || 800)));
                const targetHeight = Math.round(targetWidth * 3 / 4);

                if (targetWidth > 0 && targetHeight > 0) {
                    canvas.width = targetWidth;
                    canvas.height = targetHeight;
                    console.debug('Canvas resized to', targetWidth, 'x', targetHeight);

                    const img = new Image();
                    img.onload = () => {
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    };
                    img.onerror = () => {
                        console.warn('Failed to restore canvas image on resize');
                    };
                    img.src = data;
                } else {
                    console.warn('Invalid canvas dimensions:', targetWidth, targetHeight);
                }
            } catch (err) {
                console.error('Error in resizeCanvas:', err);
            }
        }

        window.addEventListener('resize', () => {
            resizeCanvas();
        });

        function selectDesign(design) {
            selectedDesign = design;
            console.debug('Selected design:', design);
            document.getElementById('selectedDesign').textContent = design;
            highlightSelectedDesign(design);
            document.getElementById('selectionScreen').classList.add('hidden');
            document.getElementById('canvasScreen').classList.remove('hidden');
            
            // Ensure canvas matches wrapper then draw (with defensive retry)
            const attemptDraw = (tries = 0) => {
                try {
                    if (!canvas || !ctx) {
                        console.error('Canvas or context missing', { canvas, ctx });
                        throw new Error('canvas-context-missing');
                    }
                    if (canvas.width <= 0 || canvas.height <= 0) {
                        console.warn('Canvas has invalid dimensions:', canvas.width, canvas.height);
                        throw new Error('invalid-canvas-dimensions');
                    }
                    resizeCanvas();
                    // Force a small delay to ensure render context is ready
                    setTimeout(() => {
                        ctx.save();
                        ctx.fillStyle = '#FFFFFF';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        ctx.strokeStyle = '#333333';
                        ctx.lineWidth = 3;
                        drawDesign(design);
                        ctx.restore();
                        // record the starting design so it can be undone
                        pushState();
                        console.debug('Design drawn successfully:', design, 'canvas:', canvas.width, 'x', canvas.height);
                    }, 10);
                } catch (err) {
                    console.warn('Draw attempt', tries, 'failed:', err.message);
                    if (tries < 3) {
                        setTimeout(() => attemptDraw(tries + 1), 200 + tries * 200);
                    } else {
                        console.error('Failed to draw design after retries:', err);
                        // Last-ditch attempt: simple placeholder
                        try {
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            ctx.fillStyle = '#fff';
                            ctx.fillRect(0, 0, canvas.width, canvas.height);
                            ctx.fillStyle = '#e74c3c';
                            ctx.font = 'bold 24px sans-serif';
                            ctx.textAlign = 'center';
                            ctx.fillText('Design Failed to Load', canvas.width / 2, canvas.height / 2);
                            ctx.font = '16px sans-serif';
                            ctx.fillText('Please try refreshing', canvas.width / 2, canvas.height / 2 + 40);
                        } catch (e) {
                            console.error('Failed to show error message:', e);
                        }
                    }
                }
            };
            setTimeout(() => attemptDraw(0), 100);
        }

        function backToSelection() {
            document.getElementById('selectionScreen').classList.remove('hidden');
            document.getElementById('canvasScreen').classList.add('hidden');
        }

        function drawDesign(design) {
            ctx.save();
            ctx.strokeStyle = '#333333';
            ctx.lineWidth = 3;
            ctx.fillStyle = '#FFFFFF';

            if (design === 'A') drawFlower();
            else if (design === 'B') drawButterfly();
            else if (design === 'C') drawRainbow();
            else if (design === 'D') drawStars();
            else if (design === 'E') drawLion();

            ctx.restore();
        }

        // Drawing primitives (coordinates are relative to the canvas size)
        function drawFlower() {
            const w = canvas.width, h = canvas.height;
            const cx = Math.round(w * 0.5), cy = Math.round(h * 0.48);
            const scale = Math.min(w, h) / 800;
            ctx.beginPath(); ctx.arc(cx, cy, 50 * scale, 0, Math.PI * 2); ctx.stroke();
            for (let i = 0; i < 5; i++) {
                const angle = (i * Math.PI * 2) / 5 - Math.PI / 2;
                const x = cx + Math.cos(angle) * 120 * scale;
                const y = cy + Math.sin(angle) * 120 * scale;
                ctx.beginPath(); ctx.arc(x, y, 40 * scale, 0, Math.PI * 2); ctx.stroke();
            }
            ctx.beginPath(); ctx.moveTo(cx, cy + 50 * scale); ctx.lineTo(cx, cy + 250 * scale); ctx.stroke();
        }

        function drawButterfly() {
            const w = canvas.width, h = canvas.height;
            const cx = Math.round(w * 0.5), cy = Math.round(h * 0.48);
            const scale = Math.min(w, h) / 800;
            ctx.beginPath(); ctx.ellipse(cx, cy, 15 * scale, 80 * scale, 0, 0, Math.PI * 2); ctx.stroke();
            ctx.beginPath(); ctx.ellipse(cx - 50 * scale, cy - 50 * scale, 60 * scale, 70 * scale, -0.3, 0, Math.PI * 2); ctx.stroke();
            ctx.beginPath(); ctx.ellipse(cx + 50 * scale, cy - 50 * scale, 60 * scale, 70 * scale, 0.3, 0, Math.PI * 2); ctx.stroke();
        }

        function drawRainbow() {
            const w = canvas.width, h = canvas.height;
            const centerX = Math.round(w * 0.5), centerY = Math.round(h * 0.6);
            const colors = ['#FF0000', '#FFA500', '#FFFF00', '#00FF00', '#0000FF', '#4B0082', '#9400D3'];
            const scale = Math.min(w, h) / 800;
            for (let i = 0; i < colors.length; i++) {
                ctx.strokeStyle = colors[i]; ctx.lineWidth = 8 * scale;
                ctx.beginPath(); ctx.arc(centerX, centerY, (200 - (i * 25)) * scale, 0, Math.PI, false); ctx.stroke();
            }
        }

        function drawStars() {
            const w = canvas.width, h = canvas.height; const scale = Math.min(w, h) / 800;
            function drawStar(cx, cy, size) {
                ctx.beginPath();
                for (let i = 0; i < 5; i++) {
                    const angle = (i * 4 * Math.PI) / 5 - Math.PI / 2;
                    const x = cx + size * Math.cos(angle);
                    const y = cy + size * Math.sin(angle);
                    if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
                }
                ctx.closePath(); ctx.stroke();
            }
            drawStar(Math.round(w * 0.5), Math.round(h * 0.25), 50 * scale);
            drawStar(Math.round(w * 0.37), Math.round(h * 0.4), 40 * scale);
            drawStar(Math.round(w * 0.63), Math.round(h * 0.4), 40 * scale);
        }

        function drawLion() {
            const w = canvas.width, h = canvas.height;
            const cx = Math.round(w * 0.5), cy = Math.round(h * 0.48);
            const scale = Math.min(w, h) / 800;
            // Mane (larger circle)
            ctx.beginPath();
            ctx.arc(cx, cy, 140 * scale, 0, Math.PI * 2);
            ctx.stroke();
            // Head (circle)
            ctx.beginPath();
            ctx.arc(cx, cy, 85 * scale, 0, Math.PI * 2);
            ctx.stroke();
            // Left eye
            ctx.beginPath();
            ctx.arc(cx - 25 * scale, cy - 20 * scale, 8 * scale, 0, Math.PI * 2);
            ctx.stroke();
            // Right eye
            ctx.beginPath();
            ctx.arc(cx + 25 * scale, cy - 20 * scale, 8 * scale, 0, Math.PI * 2);
            ctx.stroke();
            // Nose
            ctx.beginPath();
            ctx.ellipse(cx, cy + 10 * scale, 12 * scale, 15 * scale, 0, 0, Math.PI * 2);
            ctx.stroke();
            // Mouth left
            ctx.beginPath();
            ctx.moveTo(cx, cy + 10 * scale);
            ctx.lineTo(cx - 20 * scale, cy + 30 * scale);
            ctx.stroke();
            // Mouth right
            ctx.beginPath();
            ctx.moveTo(cx, cy + 10 * scale);
            ctx.lineTo(cx + 20 * scale, cy + 30 * scale);
            ctx.stroke();
            // Body
            ctx.beginPath();
            ctx.ellipse(cx, cy + 120 * scale, 70 * scale, 110 * scale, 0, 0, Math.PI * 2);
            ctx.stroke();
            // Tail
            ctx.beginPath();
            ctx.moveTo(cx + 70 * scale, cy + 150 * scale);
            ctx.quadraticCurveTo(cx + 120 * scale, cy + 170 * scale, cx + 130 * scale, cy + 100 * scale);
            ctx.stroke();
        }

        function getPosFromEvent(e) {
            const rect = canvas.getBoundingClientRect();
            const clientX = (e.touches && e.touches[0]) ? e.touches[0].clientX : e.clientX;
            const clientY = (e.touches && e.touches[0]) ? e.touches[0].clientY : e.clientY;
            return { x: clientX - rect.left, y: clientY - rect.top };
        }

        function startDrawing(e) {
            e.preventDefault();
            pushState();
            isDrawing = true;
            const p = getPosFromEvent(e);
            ctx.beginPath(); ctx.moveTo(p.x, p.y);
        }

        function draw(e) {
            if (!isDrawing) return;
            const p = getPosFromEvent(e);
            brushSize = document.getElementById('brushSize').value;
            ctx.lineWidth = brushSize; ctx.lineCap = 'round'; ctx.lineJoin = 'round';
            if (currentTool === 'pen') {
                ctx.globalCompositeOperation = 'source-over'; ctx.strokeStyle = currentColor;
                ctx.lineTo(p.x, p.y); ctx.stroke();
            } else if (currentTool === 'eraser') {
                ctx.globalCompositeOperation = 'destination-out';
                ctx.clearRect(p.x - brushSize / 2, p.y - brushSize / 2, brushSize, brushSize);
            }
        }

        function stopDrawing() {
            if (!isDrawing) return;
            isDrawing = false; ctx.closePath(); updateHistoryButtons();
        }

        // Touch support mapping to mouse-like events
        canvas.addEventListener('touchstart', (e) => { startDrawing(e); });
        canvas.addEventListener('touchmove', (e) => { draw(e); });
        canvas.addEventListener('touchend', (e) => { stopDrawing(e); });

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stopDrawing);

        function handleBrushSizeInput(e) {
            brushSize = e.target.value;
            document.getElementById('brushSizeDisplay').textContent = 'Size: ' + brushSize;
        }
        const brushInput = document.getElementById('brushSize');
        if (brushInput) brushInput.addEventListener('input', handleBrushSizeInput);

        function setColor(color) {
            currentColor = color; const picker = document.getElementById('colorPicker'); if (picker) picker.value = color; ctx.globalCompositeOperation = 'source-over';
        }

        function setTool(tool) {
            currentTool = tool;
            document.getElementById('penTool').classList.toggle('bg-blue-700', tool === 'pen');
            document.getElementById('penTool').classList.toggle('bg-blue-600', tool !== 'pen');
            document.getElementById('eraserTool').classList.toggle('bg-gray-500', tool === 'eraser');
            document.getElementById('eraserTool').classList.toggle('bg-gray-400', tool !== 'eraser');
            ctx.globalCompositeOperation = tool === 'eraser' ? 'destination-out' : 'source-over';
        }

        function clearCanvas() {
            if (!confirm('Are you sure you want to clear the canvas?')) return;
            pushState();
            ctx.fillStyle = '#FFFFFF'; ctx.fillRect(0, 0, canvas.width, canvas.height);
            drawDesign(selectedDesign);
        }

        function downloadCanvas() {
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'coloring-' + selectedDesign + '-' + new Date().getTime() + '.png';
            link.click();
        }

        function toggleGrid() {
            if (!gridOverlay) return;
            const sizeInput = document.getElementById('gridSize');
            const size = sizeInput ? parseInt(sizeInput.value, 10) : 20;
            gridOverlay.style.backgroundSize = `${size}px ${size}px`;
            gridOverlay.classList.toggle('hidden');
            document.getElementById('gridBtn').classList.toggle('bg-yellow-300');
        }

        function toggleFullScreen() {
            if (!wrapper) return;
            if (!document.fullscreenElement) {
                wrapper.requestFullscreen().catch(err => console.error(err));
            } else {
                document.exitFullscreen();
            }
        }

        // Highlight selected card and update ARIA
        function highlightSelectedDesign(design) {
            document.querySelectorAll('.design-card').forEach(card => {
                const d = card.getAttribute('data-design');
                const badge = card.querySelector('.checkmark-badge');
                if (d === design) {
                    card.classList.add('selected');
                    card.setAttribute('aria-pressed', 'true');
                    if (badge) badge.classList.remove('hidden');
                } else {
                    card.classList.remove('selected');
                    card.setAttribute('aria-pressed', 'false');
                    if (badge) badge.classList.add('hidden');
                }
            });
        }

        // Debounced resize for performance
        let resizeTimer = null;
        function debouncedResize() {
            if (resizeTimer) clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                resizeCanvas();
            }, 120);
        }

        window.addEventListener('resize', debouncedResize);

        // Grid size input handling
        const gridSizeInput = document.getElementById('gridSize');
        if (gridSizeInput) {
            gridSizeInput.addEventListener('input', (e) => {
                const val = e.target.value;
                document.getElementById('gridSizeDisplay').textContent = val + 'px';
                if (!gridOverlay.classList.contains('hidden')) {
                    gridOverlay.style.backgroundSize = `${val}px ${val}px`;
                }
            });
        }

        // Keyboard shortcuts: Z undo, Y redo, G grid, F fullscreen, B pen, E eraser
        document.addEventListener('keydown', (e) => {
            const mod = e.ctrlKey || e.metaKey;
            if (mod && e.key.toLowerCase() === 'z') {
                e.preventDefault(); undo(); return;
            }
            if ((mod && e.key.toLowerCase() === 'y') || (mod && e.shiftKey && e.key.toLowerCase() === 'z')) {
                e.preventDefault(); redo(); return;
            }
            if (e.key.toLowerCase() === 'g') { e.preventDefault(); toggleGrid(); return; }
            if (e.key.toLowerCase() === 'f') { e.preventDefault(); toggleFullScreen(); return; }
            if (e.key.toLowerCase() === 'b') { e.preventDefault(); setTool('pen'); return; }
            if (e.key.toLowerCase() === 'e') { e.preventDefault(); setTool('eraser'); return; }
        });

        // Confirm navigation back to selection if user has drawn
        const backBtn = document.querySelector('button[onclick="backToSelection()"]');
        if (backBtn) {
            backBtn.addEventListener('click', (ev) => {
                if (undoStack.length > 0 && !confirm('You have changes on the canvas. Go back and lose changes?')) {
                    ev.stopImmediatePropagation(); ev.preventDefault();
                }
            });
        }

        // Initialize
        const initGame = () => {
            console.debug('Initializing coloring game');
            try {
                if (!canvas) {
                    console.error('Canvas element not found');
                    return;
                }
                if (canvas.width <= 0 || canvas.height <= 0) {
                    console.warn('Canvas has invalid initial dimensions, setting defaults');
                    canvas.width = 800;
                    canvas.height = 600;
                }
                resizeCanvas();
                updateHistoryButtons();
                const bs = document.getElementById('brushSize');
                if (bs) document.getElementById('brushSizeDisplay').textContent = 'Size: ' + bs.value;
                const g = document.getElementById('gridSize');
                if (g) document.getElementById('gridSizeDisplay').textContent = g.value + 'px';
                highlightSelectedDesign(selectedDesign);
                document.querySelectorAll('.design-card').forEach(card => {
                    card.addEventListener('keydown', (ev) => {
                        if (ev.key === 'Enter' || ev.key === ' ') {
                            ev.preventDefault();
                            const d = card.getAttribute('data-design');
                            if (d) selectDesign(d);
                        }
                    });
                });
                console.debug('Coloring game ready');
            } catch (err) {
                console.error('Error initializing coloring game:', err);
            }
        };
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initGame);
        } else {
            initGame();
        }
        window.addEventListener('load', initGame);
    </script>
</x-layouts::app>
