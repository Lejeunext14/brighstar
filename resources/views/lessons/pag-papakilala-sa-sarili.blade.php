<x-layouts::app :title="__('Pag Papakilala sa Sarili - Interactive Lesson')">
    <style>
        /* Blurred background using a fixed pseudo-element so content stays sharp */
        body {
            position: relative;
            min-height: 100vh;
            margin: 0;
            z-index: 0;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url('{{ asset("image/classroom.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(6px);
            transform: scale(1.03);
            z-index: -1;
            pointer-events: none;
        }

        /* Ensure main page content sits above the blurred background and is centered */
        .page-content {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
        }

        /* Teacher chat bubble */
        .teacher-wrap { position: relative; }

        .teacher-bubble {
            position: absolute;
            left: -20px; /* move further left so bubble clears the head */
            top: -48px;  /* lift bubble above the head */
            background: rgba(255,255,255,0.98);
            color: #0f172a;
            padding: 12px 16px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(2,6,23,0.35);
            max-width: 220px;
            line-height: 1.25;
            font-weight: 600;
            text-align: left;
        }

        .teacher-bubble::after {
            content: '';
            position: absolute;
            left: 32px; /* position tail closer to teacher image */
            bottom: -10px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid rgba(255,255,255,0.98);
        }

        /* small helper to nudge the teacher image downward and limit size */
        .teacher-img {
            transform: translateY(28px);
            max-width: 160px !important;
            width: auto !important;
            height: auto;
        }

        /* Speaker button styling */
        .speaker-btn {
            margin-top: 8px;
            padding: 6px 12px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            transition: background 0.2s;
        }

        .speaker-btn:hover {
            background: #2563eb;
        }

        .speaker-btn:active {
            transform: scale(0.95);
        }

        /* Audio controls styling */
        audio {
            width: 100%;
            margin-top: 12px;
        }
    </style>

    <div class="page-content">
        <div class="w-full max-w-6xl mx-auto flex flex-col lg:flex-row gap-4 lg:gap-8 p-4 lg:p-8 items-center">
        <!-- Left Side - Teacher Character -->
        <div class="w-full lg:w-1/4 flex justify-start lg:pl-6">
            <div class="teacher-wrap flex items-end justify-start">
                <img src="{{ asset('image/teacher3.png') }}" alt="Teacher Character" class="w-32 sm:w-40 lg:w-full lg:max-w-xs drop-shadow-lg teacher-img">
                <div class="teacher-bubble text-sm sm:text-base">
                    Kumusta! Ako si Ms. Eka — handa ka na ba?
                </div>
            </div>
        </div>

        <!-- Right Side - Content -->
            <div class="w-full lg:w-3/4">
            <!-- Blackboard Container (narrower) -->
            <div id="blackboard" class="bg-gradient-to-b from-green-700 to-green-800 rounded-lg shadow-2xl p-4 sm:p-6 lg:p-8 border-4 sm:border-8 border-amber-900 min-h-80 mx-auto w-full max-w-3xl">
                <div class="text-white">
                    <h2 id="blackboardTitle" class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 lg:mb-6 text-center drop-shadow-lg">Pag Papakilala sa Sarili</h2>
                    <div id="blackboardBody" class="text-base sm:text-lg space-y-3 sm:space-y-4">
                        <!-- Content will be injected here -->
                    </div>
                </div>
            </div>
            <!-- Next button below blackboard -->
            <div class="flex flex-col sm:flex-row justify-center mt-4 lg:mt-6 gap-3 sm:gap-4">
                <button id="blackboardNextBtn" onclick="blackboardNext()" class="w-full sm:w-auto px-6 sm:px-8 py-2 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg transition text-sm sm:text-base">Susunod</button>
                <button id="finishBtn" style="display:none" onclick="finishLesson()" class="w-full sm:w-auto px-6 sm:px-6 py-2 sm:py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold shadow-lg transition text-sm sm:text-base">Tapusin</button>
            </div>
        </div>
        </div>
    </div>



    <script>
        // Audio files mapping
        const audioFiles = {
            greeting: '{{ asset("music/pagpapakilala/Girl Maligayang pagadating1 1.wav") }}',
            welcome: '{{ asset("music/pagpapakilala/Girl Maligayang pagadating1 1.wav") }}',
            name: '{{ asset("music/pagpapakilala/Girl Ano ang yong pangalan 1.wav") }}',
            age: '{{ asset("music/pagpapakilala/Girl ilan taon kana 1.wav") }}',
            location: '{{ asset("music/pagpapakilala/Girl saan ka nakatira 1.wav") }}'
        };

        // Play teacher greeting
        function playTeacherGreeting() {
            const audio = new Audio(audioFiles.greeting);
            audio.play().catch(err => console.log('Audio play error:', err));
        }

        // Play specific audio for slide
        function playAudio(audioKey) {
            if (audioFiles[audioKey]) {
                const audio = new Audio(audioFiles[audioKey]);
                audio.play().catch(err => console.log('Audio play error:', err));
            }
        }

        // Simple blackboard slide system
        const blackboardSlides = [
            {
                title: 'Pag Papakilala sa Sarili',
                body: '<p>Maligayang pagdating! Sa araling ito, matututunan natin kung paano magpakilala nang maayos.</p>\n<button onclick="playAudio(\'welcome\')" class="speaker-btn">🔊 Marinig ang grabacion</button>'
            },
            {
                title: 'Ano ang Iyong Pangalan?',
                body: '<p>Isulat ang iyong pangalan.</p>\n<p class="mt-4"><input id="studentName" placeholder="Isulat ang pangalan..." class="px-3 py-2 rounded-md text-black w-full"/></p>\n<button onclick="playAudio(\'name\')" class="speaker-btn">🔊 Marinig ang tanong</button>'
            },
            {
                title: 'Ilang Taon Ka Na?',
                body: '<p>Ilahad ang iyong edad. Halimbawa: "7 taong gulang" o simpleng numero.</p>\n<p class="mt-4"><input id="studentAge" placeholder="Halimbawa: 7" class="px-3 py-2 rounded-md text-black w-full"/></p>\n<button onclick="playAudio(\'age\')" class="speaker-btn">🔊 Marinig ang tanong</button>'
            },
            {
                title: 'Saan Ka Nakatira?',
                body: '<p>Sabihin kung saan ka nakatira — bayan o lungsod. Halimbawa: "Nakatira ako sa Quezon City".</p>\n<p class="mt-4"><input id="studentLocation" placeholder="Halimbawa: Quezon City" class="px-3 py-2 rounded-md text-black w-full"/></p>\n<button onclick="playAudio(\'location\')" class="speaker-btn">🔊 Marinig ang tanong</button>'
            },
            {
                title: 'Aktibidad',
                body: '<p>Mahusay! Ngayon, subukan mong pagsamahin: pangalan, edad, at kung saan ka nakatira sa isang maikling pangungusap.</p>'
            }
        ];

        let blackboardIndex = 0;

        function renderBlackboard() {
            const titleEl = document.getElementById('blackboardTitle');
            const bodyEl = document.getElementById('blackboardBody');
            const slide = blackboardSlides[blackboardIndex] || {title:'', body:''};
            titleEl.innerHTML = slide.title;
            bodyEl.innerHTML = slide.body;
            // toggle Next / Finish buttons depending on whether we're on the last slide
            const nextBtn = document.getElementById('blackboardNextBtn');
            const finishBtn = document.getElementById('finishBtn');
            if (blackboardIndex >= blackboardSlides.length - 1) {
                if (nextBtn) nextBtn.style.display = 'none';
                if (finishBtn) finishBtn.style.display = 'inline-block';
            } else {
                if (nextBtn) nextBtn.style.display = 'inline-block';
                if (finishBtn) finishBtn.style.display = 'none';
            }
        }

        function blackboardNext() {
            if (blackboardIndex < blackboardSlides.length - 1) {
                blackboardIndex++;
                renderBlackboard();
                return;
            }
            // finished slides: go to topics
            window.location.href = '{{ route("subject.topics", ["subject" => "filipino"]) }}';
        }

        // render initial slide on load
        document.addEventListener('DOMContentLoaded', ()=>{
            renderBlackboard();
            // Auto-play teacher greeting
            setTimeout(() => {
                playTeacherGreeting();
            }, 800);
        });

        // Finish lesson: POST to lesson.mark-complete then redirect
        function finishLesson() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            fetch('{{ route("lesson.mark-complete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ lesson_slug: 'pag-papakilala-sa-sarili' })
            })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json().catch(()=>({}));
            })
            .then(()=>{
                // redirect to topics
                window.location.href = '{{ route("subject.topics", ["subject" => "filipino"]) }}';
            })
            .catch(err => {
                console.error(err);
                // fallback: still redirect
                window.location.href = '{{ route("subject.topics", ["subject" => "filipino"]) }}';
            });
        }
    </script>

</x-layouts::app>
