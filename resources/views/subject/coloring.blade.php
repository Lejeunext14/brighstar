<x-layouts::app :title="__('Coloring Game')">
    <div class="w-full">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-yellow-50 to-orange-50 p-8 dark:border-neutral-700 dark:from-yellow-900/20 dark:to-orange-900/20 mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">
                    🎨 Coloring Game
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Choose a design and create beautiful artwork!</p>
            </div>
        </div>

        <!-- Selection Screen -->
        <div id="selectionScreen" class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
            <h2 class="text-3xl font-bold text-center mb-8">Choose Your Design</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-5">
                <!-- Design A -->
                <div class="border-2 border-gray-200 dark:border-neutral-700 rounded-lg p-4 cursor-pointer hover:shadow-lg hover:border-blue-500 transition-all" onclick="selectDesign('A')">
                    <div class="w-full h-40 bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center mb-4">
                        🌸
                    </div>
                    <h3 class="text-xl font-bold text-center">Design A</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Flower</p>
                </div>

                <!-- Design B -->
                <div class="border-2 border-gray-200 dark:border-neutral-700 rounded-lg p-4 cursor-pointer hover:shadow-lg hover:border-blue-500 transition-all" onclick="selectDesign('B')">
                    <div class="w-full h-40 bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center mb-4">
                        🦋
                    </div>
                    <h3 class="text-xl font-bold text-center">Design B</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Butterfly</p>
                </div>

                <!-- Design C -->
                <div class="border-2 border-gray-200 dark:border-neutral-700 rounded-lg p-4 cursor-pointer hover:shadow-lg hover:border-blue-500 transition-all" onclick="selectDesign('C')">
                    <div class="w-full h-40 bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center mb-4">
                        🌈
                    </div>
                    <h3 class="text-xl font-bold text-center">Design C</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Rainbow</p>
                </div>

                <!-- Design D -->
                <div class="border-2 border-gray-200 dark:border-neutral-700 rounded-lg p-4 cursor-pointer hover:shadow-lg hover:border-blue-500 transition-all" onclick="selectDesign('D')">
                    <div class="w-full h-40 bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center mb-4">
                        ⭐
                    </div>
                    <h3 class="text-xl font-bold text-center">Design D</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Star</p>
                </div>

                <!-- Design E -->
                <div class="border-2 border-gray-200 dark:border-neutral-700 rounded-lg p-4 cursor-pointer hover:shadow-lg hover:border-blue-500 transition-all" onclick="selectDesign('E')">
                    <div class="w-full h-40 bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center mb-4">
                        🦁
                    </div>
                    <h3 class="text-xl font-bold text-center">Design E</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Lion</p>
                </div>
            </div>
        </div>

        <!-- Canvas and Tools (Hidden until design selected) -->
        <div id="canvasScreen" class="hidden">
            <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Design <span id="selectedDesign">A</span></h2>
                    <button onclick="backToSelection()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">← Back</button>
                </div>

                <div class="grid gap-6 md:grid-cols-4 lg:grid-cols-5 mb-6">
                    <!-- Color Palette -->
                    <div class="md:col-span-full">
                        <h3 class="text-lg font-bold mb-3">Choose Color</h3>
                        <div class="flex flex-wrap gap-3">
                            <button onclick="setColor('#FF0000')" class="w-12 h-12 rounded-lg bg-red-500 hover:scale-110 transition-transform border-2 border-transparent" title="Red"></button>
                            <button onclick="setColor('#00FF00')" class="w-12 h-12 rounded-lg bg-green-500 hover:scale-110 transition-transform border-2 border-transparent" title="Green"></button>
                            <button onclick="setColor('#0000FF')" class="w-12 h-12 rounded-lg bg-blue-500 hover:scale-110 transition-transform border-2 border-transparent" title="Blue"></button>
                            <button onclick="setColor('#FFFF00')" class="w-12 h-12 rounded-lg bg-yellow-500 hover:scale-110 transition-transform border-2 border-transparent" title="Yellow"></button>
                            <button onclick="setColor('#FFA500')" class="w-12 h-12 rounded-lg bg-orange-500 hover:scale-110 transition-transform border-2 border-transparent" title="Orange"></button>
                            <button onclick="setColor('#800080')" class="w-12 h-12 rounded-lg bg-purple-500 hover:scale-110 transition-transform border-2 border-transparent" title="Purple"></button>
                            <button onclick="setColor('#FFC0CB')" class="w-12 h-12 rounded-lg bg-pink-400 hover:scale-110 transition-transform border-2 border-transparent" title="Pink"></button>
                            <button onclick="setColor('#000000')" class="w-12 h-12 rounded-lg bg-black hover:scale-110 transition-transform border-2 border-transparent" title="Black"></button>
                            <button onclick="setColor('#FFFFFF')" class="w-12 h-12 rounded-lg bg-white hover:scale-110 transition-transform border-2 border-gray-300" title="White"></button>
                            <input type="color" id="colorPicker" onchange="setColor(this.value)" class="w-12 h-12 rounded-lg cursor-pointer" title="Custom Color">
                        </div>
                    </div>

                    <!-- Tools -->
                    <div class="md:col-span-full">
                        <h3 class="text-lg font-bold mb-3">Tools</h3>
                        <div class="flex gap-3 flex-wrap">
                            <button onclick="setTool('pen')" id="penTool" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">✏️ Pen</button>
                            <button onclick="setTool('eraser')" id="eraserTool" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">🧹 Eraser</button>
                            <input type="range" id="brushSize" min="1" max="50" value="5" class="w-32" title="Brush Size">
                            <button onclick="clearCanvas()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">🗑️ Clear</button>
                            <button onclick="downloadCanvas()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">⬇️ Download</button>
                        </div>
                    </div>
                </div>

                <!-- Canvas -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-white dark:bg-neutral-800">
                    <canvas id="coloringCanvas" class="block mx-auto" width="800" height="600" style="cursor: crosshair;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('coloringCanvas');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let currentColor = '#000000';
        let currentTool = 'pen';
        let brushSize = 5;
        let selectedDesign = 'A';

        function selectDesign(design) {
            selectedDesign = design;
            document.getElementById('selectedDesign').textContent = design;
            document.getElementById('selectionScreen').classList.add('hidden');
            document.getElementById('canvasScreen').classList.remove('hidden');
            
            // Reset and draw the selected design
            setTimeout(() => {
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                drawDesign(design);
            }, 100);
        }

        function backToSelection() {
            document.getElementById('selectionScreen').classList.remove('hidden');
            document.getElementById('canvasScreen').classList.add('hidden');
        }

        function drawDesign(design) {
            ctx.strokeStyle = '#333333';
            ctx.lineWidth = 3;
            ctx.fillStyle = '#FFFFFF';

            if (design === 'A') {
                drawFlower();
            } else if (design === 'B') {
                drawButterfly();
            } else if (design === 'C') {
                drawRainbow();
            } else if (design === 'D') {
                drawStars();
            } else if (design === 'E') {
                drawLion();
            }
        }

        function drawFlower() {
            // Center circle
            ctx.beginPath();
            ctx.arc(400, 300, 50, 0, Math.PI * 2);
            ctx.stroke();

            // Petals
            for (let i = 0; i < 5; i++) {
                const angle = (i * Math.PI * 2) / 5 - Math.PI / 2;
                const x = 400 + Math.cos(angle) * 120;
                const y = 300 + Math.sin(angle) * 120;
                ctx.beginPath();
                ctx.arc(x, y, 40, 0, Math.PI * 2);
                ctx.stroke();
            }

            // Stem
            ctx.beginPath();
            ctx.moveTo(400, 350);
            ctx.lineTo(400, 550);
            ctx.stroke();

            // Leaves
            for (let i = 0; i < 2; i++) {
                const xOffset = i === 0 ? -40 : 40;
                ctx.beginPath();
                ctx.ellipse(400 + xOffset, 420, 35, 50, (i === 0 ? 0.3 : -0.3), 0, Math.PI * 2);
                ctx.stroke();
            }
        }

        function drawButterfly() {
            // Body
            ctx.beginPath();
            ctx.ellipse(400, 300, 15, 80, 0, 0, Math.PI * 2);
            ctx.stroke();

            // Upper wings
            ctx.beginPath();
            ctx.ellipse(350, 250, 60, 70, -0.3, 0, Math.PI * 2);
            ctx.stroke();

            ctx.beginPath();
            ctx.ellipse(450, 250, 60, 70, 0.3, 0, Math.PI * 2);
            ctx.stroke();

            // Lower wings
            ctx.beginPath();
            ctx.ellipse(340, 360, 50, 60, 0.3, 0, Math.PI * 2);
            ctx.stroke();

            ctx.beginPath();
            ctx.ellipse(460, 360, 50, 60, -0.3, 0, Math.PI * 2);
            ctx.stroke();

            // Antennae
            ctx.beginPath();
            ctx.moveTo(400, 220);
            ctx.lineTo(380, 180);
            ctx.stroke();

            ctx.beginPath();
            ctx.moveTo(400, 220);
            ctx.lineTo(420, 180);
            ctx.stroke();
        }

        function drawRainbow() {
            const centerX = 400;
            const centerY = 350;
            const colors = ['#FF0000', '#FFA500', '#FFFF00', '#00FF00', '#0000FF', '#4B0082', '#9400D3'];
            
            for (let i = 0; i < colors.length; i++) {
                ctx.strokeStyle = colors[i];
                ctx.lineWidth = 8;
                ctx.beginPath();
                ctx.arc(centerX, centerY, 200 - (i * 25), 0, Math.PI, false);
                ctx.stroke();
            }

            // Cloud base
            ctx.strokeStyle = '#333333';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.ellipse(250, 380, 70, 40, 0, 0, Math.PI * 2);
            ctx.stroke();

            ctx.beginPath();
            ctx.ellipse(550, 380, 70, 40, 0, 0, Math.PI * 2);
            ctx.stroke();
        }

        function drawStars() {
            function drawStar(cx, cy, size) {
                ctx.beginPath();
                for (let i = 0; i < 5; i++) {
                    const angle = (i * 4 * Math.PI) / 5 - Math.PI / 2;
                    const x = cx + size * Math.cos(angle);
                    const y = cy + size * Math.sin(angle);
                    if (i === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }
                ctx.closePath();
                ctx.stroke();
            }

            drawStar(400, 200, 50);
            drawStar(300, 300, 40);
            drawStar(500, 300, 40);
            drawStar(350, 450, 35);
            drawStar(450, 450, 35);
            drawStar(400, 520, 40);
        }

        function drawLion() {
            // Head (circle)
            ctx.beginPath();
            ctx.arc(400, 300, 80, 0, Math.PI * 2);
            ctx.stroke();

            // Mane (larger circle)
            ctx.beginPath();
            ctx.arc(400, 300, 120, 0, Math.PI * 2);
            ctx.stroke();

            // Eyes
            ctx.beginPath();
            ctx.arc(375, 280, 8, 0, Math.PI * 2);
            ctx.stroke();

            ctx.beginPath();
            ctx.arc(425, 280, 8, 0, Math.PI * 2);
            ctx.stroke();

            // Nose
            ctx.beginPath();
            ctx.ellipse(400, 310, 12, 15, 0, 0, Math.PI * 2);
            ctx.stroke();

            // Mouth
            ctx.beginPath();
            ctx.moveTo(400, 310);
            ctx.lineTo(380, 330);
            ctx.stroke();

            ctx.beginPath();
            ctx.moveTo(400, 310);
            ctx.lineTo(420, 330);
            ctx.stroke();

            // Body
            ctx.beginPath();
            ctx.ellipse(400, 450, 60, 100, 0, 0, Math.PI * 2);
            ctx.stroke();

            // Tail
            ctx.beginPath();
            ctx.moveTo(455, 480);
            ctx.quadraticCurveTo(520, 500, 540, 450);
            ctx.stroke();
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        // Touch support for mobile
        canvas.addEventListener('touchstart', handleTouch);
        canvas.addEventListener('touchmove', handleTouch);
        canvas.addEventListener('touchend', stopDrawing);

        function startDrawing(e) {
            isDrawing = true;
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        function draw(e) {
            if (!isDrawing) return;
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            brushSize = document.getElementById('brushSize').value;
            ctx.lineWidth = brushSize;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';

            if (currentTool === 'pen') {
                ctx.strokeStyle = currentColor;
                ctx.globalCompositeOperation = 'source-over';
            } else if (currentTool === 'eraser') {
                ctx.clearRect(x - brushSize / 2, y - brushSize / 2, brushSize, brushSize);
                ctx.globalCompositeOperation = 'destination-out';
            }

            ctx.lineTo(x, y);
            ctx.stroke();
        }

        function handleTouch(e) {
            e.preventDefault();
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : 'mousemove', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }

        function stopDrawing() {
            isDrawing = false;
            ctx.closePath();
        }

        function setColor(color) {
            currentColor = color;
            document.getElementById('colorPicker').value = color;
            ctx.globalCompositeOperation = 'source-over';
        }

        function setTool(tool) {
            currentTool = tool;
            document.getElementById('penTool').classList.toggle('bg-blue-700', tool === 'pen');
            document.getElementById('penTool').classList.toggle('bg-blue-600', tool !== 'pen');
            document.getElementById('eraserTool').classList.toggle('bg-gray-500', tool === 'eraser');
            document.getElementById('eraserTool').classList.toggle('bg-gray-400', tool !== 'eraser');
        }

        function clearCanvas() {
            if (confirm('Are you sure you want to clear the canvas?')) {
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                drawDesign(selectedDesign);
            }
        }

        function downloadCanvas() {
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'coloring-' + selectedDesign + '-' + new Date().getTime() + '.png';
            link.click();
        }
    </script>
</x-layouts::app>
