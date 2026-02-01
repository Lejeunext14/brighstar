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
            background-image: url('/image/classroom.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(6px);
            transform: scale(1.03);
            z-index: -1;
            pointer-events: none;
        }

        /* Ensure main page content sits above the blurred background */
        .page-content {
            position: relative;
            z-index: 1;
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

        /* small helper to nudge the teacher image downward */
        .teacher-img {
            transform: translateY(28px);
        }
    </style>

    <div class="page-content flex flex-col lg:flex-row gap-4 lg:gap-8 p-4 lg:p-8">
        <!-- Left Side - Teacher Character -->
        <div class="w-full lg:w-1/4 flex justify-center">
            <div class="teacher-wrap flex items-end justify-center">
                <img src="/image/teacher3.png" alt="Teacher Character" class="w-32 sm:w-40 lg:w-full lg:max-w-xs drop-shadow-lg teacher-img">
                <div class="teacher-bubble text-sm sm:text-base">
                    Kumusta! Matuto tayo ng paggamit ng Po at Opo.
                </div>
            </div>
        </div>

        <!-- Right Side - Content -->
        <div class="w-full lg:w-3/4">
            <!-- Blackboard Container -->
            <div id="blackboard" class="bg-gradient-to-b from-green-700 to-green-800 rounded-lg shadow-2xl p-4 sm:p-6 lg:p-8 border-4 sm:border-8 border-amber-900 min-h-96">
                <div class="text-white">
                    <h2 id="blackboardTitle" class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 lg:mb-6 text-center drop-shadow-lg">Paggamit ng Po at Opo</h2>
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
        // Teacher speech synthesis
        (function(){
            let selectedVoice = null;

            function pickVoice() {
                const voices = window.speechSynthesis.getVoices();
                if (!voices || voices.length === 0) return null;

                // Prefer Filipino / Tagalog voices (lang startsWith fil or tl or contains -PH),
                // then names that mention Tagalog/Filipino, then any Philippine locale, then Google voices.
                const byLang = v => (v.lang || '').toLowerCase();

                let v = voices.find(v => {
                    const lang = byLang(v);
                    return lang.startsWith('fil') || lang.startsWith('tl') || /-ph$/.test(lang) || lang.includes('ph');
                });

                if (!v) v = voices.find(v => /tagalog|filipino/i.test(v.name));
                if (!v) v = voices.find(v => /-ph/i.test(v.lang || ''));
                if (!v) v = voices.find(v => /google/i.test(v.name));
                return v || voices[0];
            }

            function speakTeacher(text, opts = {}){
                if (!('speechSynthesis' in window)) return;
                const utter = new SpeechSynthesisUtterance(text);
                // ensure voices list loaded
                if (!selectedVoice) selectedVoice = pickVoice();
                if (selectedVoice) utter.voice = selectedVoice;
                utter.lang = selectedVoice?.lang || 'fil-PH';
                utter.rate = opts.rate ?? 0.95;
                utter.pitch = opts.pitch ?? 1.05;
                utter.volume = opts.volume ?? 1;
                window.speechSynthesis.cancel();
                window.speechSynthesis.speak(utter);
            }

            // when voices are loaded, cache selection
            window.speechSynthesis.onvoiceschanged = function(){
                selectedVoice = pickVoice();
            };

            document.addEventListener('DOMContentLoaded', ()=>{
                const bubble = document.querySelector('.teacher-bubble');
                if (!bubble) return;
                // click to speak
                bubble.style.cursor = 'pointer';
                bubble.addEventListener('click', ()=> speakTeacher(bubble.textContent.trim()));

                // try to auto-speak greeting once (some browsers require user gesture)
                setTimeout(()=>{
                    try { speakTeacher(bubble.textContent.trim()); } catch(e){}
                }, 500);
            });
        })();
    </script>

    <script>
        // Simple blackboard slide system
        const blackboardSlides = [
            {
                title: 'Paggamit ng Po at Opo',
                body: '<p>Maligayang pagdating! Sa araling ito, matututunan natin kung paano gumagamit ng Po at Opo.</p>'
            },
            {
                title: 'Ano ang Po?',
                body: '<p>Po — Ito ay isang particle na ginagamit upang magpakita ng paggalang sa mas matanda.</p><p class="mt-2">Halimbawa: "Magandang umaga, po!"</p><p class="mt-4"><img src="/image/po.jpg" alt="Po" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Ano ang Opo?',
                body: '<p>Opo — Ito ay isang particle na ginagamit bilang "yes" o "oo" na may paggalang.</p><p class="mt-2">Halimbawa: "Opo, sasagot ako."</p><p class="mt-4"><img src="/image/opo.jpg" alt="Opo" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Kailan Gumagamit ng Po?',
                body: '<p>Gumagamit ng Po kapag nagsasalita sa mga magulang, guro, at matatanda.</p><p class="mt-4"><img src="/image/po_usage.jpg" alt="Po Usage" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Kailan Gumagamit ng Opo?',
                body: '<p>Gumagamit ng Opo bilang positive na tugon o pagsang-ayon sa mga magulang at matatanda.</p><p class="mt-4"><img src="/image/opo_usage.jpg" alt="Opo Usage" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Katuwang ng Po at Opo',
                body: '<p>Ang Po at Opo ay ginagamit upang ipakita ang respeto at edukasyon.</p><p class="mt-4"><img src="/image/respect.jpg" alt="Respect" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
            },
            {
                title: 'Pagsasanay ng Po at Opo',
                body: '<p>Dapat tayong masanay na gumagamit ng Po at Opo araw-araw sa ating mga pamilya at paaralan.</p><p class="mt-4"><img src="/image/practice.jpg" alt="Practice" style="width:200px; height:auto; margin:0 auto; display:block; border-radius:8px;"/></p>'
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
                body: JSON.stringify({ lesson_slug: 'paggamit-ng-po-at-opo' })
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
