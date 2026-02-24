<x-layouts::app :title="__('Mga Kulay - Interactive Lesson')">
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
    </style>

    <div class="page-content">
        <div class="w-full max-w-6xl mx-auto flex flex-col lg:flex-row gap-4 lg:gap-8 p-4 lg:p-8 items-center">
        <!-- Left Side - Teacher Character -->
        <div class="w-full lg:w-1/4 flex justify-start lg:pl-6">
            <div class="teacher-wrap flex items-end justify-start">
                <img src="{{ asset('image/teacher3.png') }}" alt="Teacher Character" class="w-32 sm:w-40 lg:w-full lg:max-w-xs drop-shadow-lg teacher-img">
                <div class="teacher-bubble text-sm sm:text-base">
                    Kumusta! Matuto tayo ng mga hugis.
                </div>
                <!-- Voice Over Audio Player -->
                @if($lessonData?->voice_over_path)
                <div class="mt-4 w-full">
                    <audio controls class="w-full h-10 bg-white rounded-lg">
                        <source src="{{ asset($lessonData->voice_over_path) }}" type="audio/wav">
                        Your browser does not support the audio element.
                    </audio>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Side - Content -->
        <div class="w-full lg:w-3/4">
            <!-- Blackboard Container (narrower) -->
            <div id="blackboard" class="bg-gradient-to-b from-green-700 to-green-800 rounded-lg shadow-2xl p-4 sm:p-6 lg:p-8 border-4 sm:border-8 border-amber-900 min-h-80 mx-auto w-full max-w-3xl">
                <div class="text-white">
                    <h2 id="blackboardTitle" class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 lg:mb-6 text-center drop-shadow-lg">Mga Hugis</h2>
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
        // Audio files from mga_hugis folder
        const audioFiles = {
            greeting: '{{ asset("music/mga_hugis/Girl maligayang pagdating5 1.wav") }}',
            bilog: '{{ asset("music/mga_hugis/Girl bilog 1.wav") }}',
            tatsulok: '{{ asset("music/mga_hugis/Girl tatsulok 1.wav") }}',
            rektangulo: '{{ asset("music/mga_hugis/Girl rektangulo 1.wav") }}',
            pentagon: '{{ asset("music/mga_hugis/Girl pentagon 1.wav") }}',
            heksagono: '{{ asset("music/mga_hugis/Girl hexaguno 1.wav") }}'
        };

        function playAudio(key) {
            if (!audioFiles[key]) return;
            const audio = new Audio(audioFiles[key]);
            audio.play().catch(err => console.debug('audio play failed', err));
        }

        document.addEventListener('DOMContentLoaded', ()=>{
            // Auto-play greeting on load
            setTimeout(()=>{
                try { playAudio('greeting'); } catch(e){ console.debug('autoplay error', e); }
            }, 500);
        });
    </script>

    <script>
        // Simple blackboard slide system
        const blackboardSlides = [
            {
                title: 'Mga Hugis',
                body: '<p>Maligayang pagdating! Sa araling ito, matututunan natin ang mga hugis.</p><p class="mt-4"><button onclick="playAudio(\'greeting\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Bilog',
                body: '<p>Bilog — Ito ay isang hugis na walang sulok.</p><p class="mt-4"><img src="/image/bilog.png" alt="Bilog" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-4"><button onclick="playAudio(\'bilog\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Tatsulok',
                body: '<p>Tatsulok — Ito ay isang hugis na may tatlong sulok.</p><p class="mt-4"><img src="/image/tatsulok.png" alt="Tatsulok" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-4"><button onclick="playAudio(\'tatsulok\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Parisukat',
                body: '<p>Parisukat — Ito ay isang hugis na may apat na pantay na panig.</p><p class="mt-4"><img src="/image/parisukat.png" alt="Parisukat" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Rektangulo',
                body: '<p>Rektangulo — Ito ay isang hugis na may apat na panig at apat na sulok.</p><p class="mt-4"><img src="/image/rectangulo.jpg" alt="Rektangulo" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-4"><button onclick="playAudio(\'rektangulo\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Pentagon',
                body: '<p>Pentagon — Ito ay isang hugis na may limang panig at limang sulok.</p><p class="mt-4"><img src="/image/pentagon.jpeg" alt="Pentagon" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-4"><button onclick="playAudio(\'pentagon\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Heksagono',
                body: '<p>Heksagono — Ito ay isang hugis na may anim na panig at anim na sulok.</p><p class="mt-4"><img src="/image/heksaguno.png" alt="Heksagono" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-4"><button onclick="playAudio(\'heksagono\')" class="speaker-btn">🔊 Pakinggan</button></p>'
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
            // hide teacher bubble when advancing slides
            const tb = document.querySelector('.teacher-bubble');
            if (tb) tb.style.display = 'none';

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
        });

        // speak student-provided answers - audio disabled for this lesson
        function speakStudentAnswer(inputId, prefix) {
            // no-op: this lesson uses prerecorded audio files instead of TTS
            return;
        }

        // Finish lesson: POST to lesson.mark-complete then redirect
        function finishLesson() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            fetch('{{ route("lesson.mark-complete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ lesson_slug: 'mga-hugis' })
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
