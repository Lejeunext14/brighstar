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
    </style>

    <div class="page-content">
        <div class="w-full max-w-6xl mx-auto flex flex-col lg:flex-row gap-4 lg:gap-8 p-4 lg:p-8 items-center">
        <!-- Left Side - Teacher Character -->
        <div class="w-full lg:w-1/3 flex justify-center">
            <div class="teacher-wrap flex items-end justify-start">
                <img src="{{ asset('image/teacher3.png') }}" alt="Teacher Character" class="w-32 sm:w-40 lg:w-full lg:max-w-xs drop-shadow-lg teacher-img">
                <div class="teacher-bubble text-sm sm:text-base">
                    Kumusta! Matuto tayo ng Titik A.
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
        <div class="w-full lg:w-2/3">
            <!-- Blackboard Container -->
            <div id="blackboard" class="bg-gradient-to-b from-green-700 to-green-800 rounded-lg shadow-2xl p-4 sm:p-6 lg:p-8 border-4 sm:border-8 border-amber-900 min-h-96">
                <div class="text-white">
                    <h2 id="blackboardTitle" class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 lg:mb-6 text-center drop-shadow-lg">Ang Titik A</h2>
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
        // Voice over playback (recorded audio only)
        (function(){
            const voiceOverPath = '{{ $lessonData?->voice_over_path ? asset($lessonData->voice_over_path) : null }}';

            function playVoiceOver() {
                if (voiceOverPath && voiceOverPath !== 'null') {
                    const audio = new Audio(voiceOverPath);
                    audio.play().catch(err => {
                        console.log('Voice over audio play error:', err);
                    });
                } else {
                    console.log('No voice over available for this lesson');
                }
            }

            document.addEventListener('DOMContentLoaded', ()=>{
                const bubble = document.querySelector('.teacher-bubble');
                if (!bubble) return;
                // click to speak
                bubble.style.cursor = 'pointer';
                bubble.addEventListener('click', ()=> playVoiceOver());

                // try to auto-play greeting once (some browsers require user gesture)
                setTimeout(()=>{
                    try { playVoiceOver(); } catch(e){}
                }, 500);
            });
        })();
    </script>

    <script>
        // Simple blackboard slide system
        const blackboardSlides = [
            {
                title: 'Ang Titik A',
                body: '<p>Maligayang pagdating! Sa araling ito, matututunan natin ang titik A.</p>'
            },
            {
                title: 'Malaking A (Capital A)',
                body: '<p>Ito ang malaking anyo ng titik A. Ginagamit natin ito sa simula ng pangungusap.</p><p class="mt-2">Halimbawa: Ama, Araw, Aso</p><p class="mt-4"><img src="/image/capital_a.jpg" alt="Capital A" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Maliit na a (Lowercase a)',
                body: '<p>Ito ang maliit na anyo ng titik A. Ginagamit natin ito sa karamihan ng salita.</p><p class="mt-2">Halimbawa: ama, araw, aso</p><p class="mt-4"><img src="/image/lowercase_a.jpg" alt="Lowercase a" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Tunog ng A',
                body: '<p>Ang titik A ay may tunog na &quot;ah&quot; tulad ng sa salitang &quot;araw&quot;.</p><p class="mt-2">Magsanay: &quot;A&quot; - ah, ah, ah</p><p class="mt-4"><img src="/image/sound_a.jpg" alt="Sound A" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Salita na May A',
                body: '<p>Maraming salita ang nagsisimula sa titik A.</p><p class="mt-2">Ama, Araw, Aso, Anak, Amoy, Alam</p><p class="mt-4"><img src="/image/words_with_a.jpg" alt="Words with A" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Pagisipan ang A',
                body: '<p>Finifingerprint natin ang titik A upang maunawaan ang sulat nito.</p><p class="mt-2">Mayroon itong tatlong linya na bumubuo ng isang tatsulok na may linya sa gitna.</p><p class="mt-4"><img src="/image/trace_a.jpg" alt="Trace A" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Pagsasanay ng A',
                body: '<p>Dapat tayong magsanay na sulatin at sabihin ang titik A nang maraming beses.</p><p class="mt-2">Ito ay makakatulong sa atin na matandaan ang titik A.</p><p class="mt-4"><img src="/image/practice_a.jpg" alt="Practice A" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
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
                body: JSON.stringify({ lesson_slug: 'ang-titik-aa' })
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
