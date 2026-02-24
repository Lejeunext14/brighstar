<x-layouts::app :title="__('Pag Papakilala sa Ibat Ibang Uri ng Tunog - Interactive Lesson')">
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
    </style>

    <div class="page-content">
        <div class="w-full max-w-6xl mx-auto flex flex-col lg:flex-row gap-4 lg:gap-8 p-4 lg:p-8 items-center">
        <!-- Left Side - Teacher Character -->
        <div class="w-full lg:w-1/3 flex justify-center">
            <div class="teacher-wrap flex items-end justify-start">
                <img src="{{ asset('image/teacher3.png') }}" alt="Teacher Character" class="w-32 sm:w-40 lg:w-full lg:max-w-xs drop-shadow-lg teacher-img">
                <div class="teacher-bubble text-sm sm:text-base">
                    Kumusta! Matuto tayo ng iba't ibang uri ng tunog.
                </div>
            </div>
        </div>

        <!-- Right Side - Content -->
        <div class="w-full lg:w-2/3">
            <!-- Blackboard Container -->
            <div id="blackboard" class="bg-gradient-to-b from-green-700 to-green-800 rounded-lg shadow-2xl p-4 sm:p-6 lg:p-8 border-4 sm:border-8 border-amber-900 min-h-96">
                <div class="text-white">
                    <h2 id="blackboardTitle" class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 lg:mb-6 text-center drop-shadow-lg">Mga Tunog</h2>
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
        // Audio mapping for various sound categories. Place your audio files in:
        // public/music/tunog/
        const audioFiles = {
            greeting: '{{ asset("music/tunog/Girl maligayang pagdating4 1.wav") }}',
            nature: '',  // No audio available yet
            bird: '',    // No audio available yet
            human: '',   // No audio available yet
            vehicle: '', // No audio available yet
            music: '',   // No audio available yet
            animal: ''   // No audio available yet
        };

        function playAudio(key) {
            if (!audioFiles[key]) {
                alert('Walang tunog file para dito.');
                return;
            }
            const a = new Audio(audioFiles[key]);
            a.play().catch(err => console.debug('audio play failed', err));
        }

        function playTeacherGreeting() {
            playAudio('greeting');
        }
    </script>

    <script>
        // Simple blackboard slide system
        const blackboardSlides = [
            {
                title: 'Mga Tunog',
                body: '<p>Maligayang pagdating! Sa araling ito, matututunan natin ang iba\'t ibang uri ng tunog.</p><p class="mt-4"><button onclick="playTeacherGreeting()" class="speaker-btn">🔊 Pakinggan ang pagbati</button></p>'
            },
            {
                title: 'Tunog ng Kalikasan',
                body: '<p>Tunog ng Kalikasan — Ang mga tunog mula sa kalikasan tulad ng ulan at hangin.</p><p class="mt-4"><button onclick="playAudio(\'nature\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Tunog ng Ibon',
                body: '<p>Tunog ng Ibon — Ang mga ibon ay gumagawa ng magandang tunog sa umaga.</p><p class="mt-4"><button onclick="playAudio(\'bird\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Tunog ng Tao',
                body: '<p>Tunog ng Tao — Mga tunog na ginagawa ng tao tulad ng pagsasalita at pagtawa.</p><p class="mt-4"><button onclick="playAudio(\'human\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Tunog ng Sasakyan',
                body: '<p>Tunog ng Sasakyan — Mga sasakyan tulad ng kotse at bus ay may tunog.</p><p class="mt-4"><button onclick="playAudio(\'vehicle\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Tunog ng Musika',
                body: '<p>Tunog ng Musika — Ang musika ay gawa ng mga natatanging tunog na maganda.</p><p class="mt-4"><button onclick="playAudio(\'music\')" class="speaker-btn">🔊 Pakinggan</button></p>'
            },
            {
                title: 'Tunog ng Hayop',
                body: '<p>Tunog ng Hayop — Iba\'t ibang hayop ay may sariling tunog tulad ng iyak ng pusa at latay ng aso.</p><p class="mt-4"><button onclick="playAudio(\'animal\')" class="speaker-btn">🔊 Pakinggan</button></p>'
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
            // Auto-play teacher greeting shortly after load (may be blocked by browser autoplay policies)
            setTimeout(()=>{
                try { playTeacherGreeting(); } catch(e){ console.debug('autoplay error', e); }
            }, 800);
        });

        // speak student-provided answers - voice disabled for this lesson
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
                body: JSON.stringify({ lesson_slug: 'pag-papakilala-sa-ibat-ibang-uri-ng-tunog' })
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
