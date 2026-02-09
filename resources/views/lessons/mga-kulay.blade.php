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
                    Kumusta! Matuto tayo ng mga kulay.
                </div>
            </div>
        </div>

        <!-- Right Side - Content -->
        <div class="w-full lg:w-3/4">
            <!-- Blackboard Container (narrower) -->
            <div id="blackboard" class="bg-gradient-to-b from-green-700 to-green-800 rounded-lg shadow-2xl p-4 sm:p-6 lg:p-8 border-4 sm:border-8 border-amber-900 min-h-80 mx-auto w-full max-w-3xl">
                <div class="text-white">
                    <h2 id="blackboardTitle" class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 lg:mb-6 text-center drop-shadow-lg">Mga Kulay</h2>
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
    
    <script>
        // Audio files mapping for Mga Kulay
        const audioFiles = {
            greeting: '{{ asset("music/kulay/maligayang pagdating3.aac") }}',
            pula: '{{ asset("music/kulay/pula.aac") }}',
            asul: '{{ asset("music/kulay/asul.aac") }}',
            dilaw: '{{ asset("music/kulay/dilaw.aac") }}',
            luntian: '{{ asset("music/kulay/luntian.aac") }}',
            itim: '{{ asset("music/kulay/itim.aac") }}',
            puti: '{{ asset("music/kulay/puti.aac") }}'
        };

        function playTeacherGreeting() {
            const audio = new Audio(audioFiles.greeting);
            audio.play().catch(err => console.log('Audio play error:', err));
        }

        function playAudio(key) {
            if (!audioFiles[key]) return;
            const audio = new Audio(audioFiles[key]);
            audio.play().catch(err => console.log('Audio play error:', err));
        }
    </script>

    <script>
        // Simple blackboard slide system
        const blackboardSlides = [
            {
                title: 'Mga Kulay',
                body: '<p>Maligayang pagdating! Sa araling ito, matututunan natin ang mga kulay.</p><p class="mt-4"><button onclick="playTeacherGreeting()" class="speaker-btn">🔊 Marinig ang pagbati</button></p>'
            },
            {
                title: 'Pula',
                body: '<p>Pula — Ito ay kulay ng puso at rosas.</p><p class="mt-4"><img src="{{ asset("image/red2.jpg") }}" alt="Pula" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-3"><button onclick="playAudio(\'pula\')" class="speaker-btn">🔊 Marinig ang kulay</button></p>'
            },
            {
                title: 'Asul',
                body: '<p>Asul — Ito ay kulay ng langit at dagat.</p><p class="mt-4"><img src="{{ asset("image/blue2.jpg") }}" alt="Asul" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-3"><button onclick="playAudio(\'asul\')" class="speaker-btn">🔊 Marinig ang kulay</button></p>'
            },
            {
                title: 'Dilaw',
                body: '<p>Dilaw — Ito ay kulay ng araw.</p><p class="mt-4"><img src="{{ asset("image/dilaw.png") }}" alt="Dilaw" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-3"><button onclick="playAudio(\'dilaw\')" class="speaker-btn">🔊 Marinig ang kulay</button></p>'
            },
            {
                title: 'Luntian',
                body: '<p>Luntian — Ito ay kulay ng mga puno at halaman.</p><p class="mt-4"><img src="{{ asset("image/green.jpg") }}" alt="Luntian" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-3"><button onclick="playAudio(\'luntian\')" class="speaker-btn">🔊 Marinig ang kulay</button></p>'
            },
            {
                title: 'Itim',
                body: '<p>Itim — Ito ay ang pinakamadilim na kulay.</p><p class="mt-4"><img src="{{ asset("image/black.jpg") }}" alt="Itim" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-3"><button onclick="playAudio(\'itim\')" class="speaker-btn">🔊 Marinig ang kulay</button></p>'
            },
            {
                title: 'Puti',
                body: '<p>Puti — Ito ay ang pinakamaliwanag na kulay.</p><p class="mt-4"><img src="{{ asset("image/white.jpg") }}" alt="Puti" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p><p class="mt-3"><button onclick="playAudio(\'puti\')" class="speaker-btn">🔊 Marinig ang kulay</button></p>'
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
            // Auto-play teacher greeting shortly after load
            setTimeout(()=>{
                try { playTeacherGreeting(); } catch(e){ console.log('autoplay failed', e); }
            }, 800);
        });

        // speak student-provided answers using teacher voice
        function speakStudentAnswer(inputId, prefix) {
            const el = document.getElementById(inputId);
            if (!el) return;
            const val = (el.value || '').trim();
            if (!val) {
                speakTeacher('Wala pang nilagay. Paki-type muna.');
                return;
            }
            // construct phrase: prefix + value
            const phrase = `${prefix} ${val}`;
            speakTeacher(phrase, { rate: 0.95, pitch: 1.05 });
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
                body: JSON.stringify({ lesson_slug: 'mga-kulay' })
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
   