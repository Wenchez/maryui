@props(['slides' => []])

@php
    // unique id for multiple carousels on the same page
    $uid = 'carousel-'.uniqid();
    $slideCount = count($slides);
    if ($slideCount === 0) {
        // fallback: empty placeholder
        $slides = [['image' => '/photos/placeholder.jpg']];
        $slideCount = 1;
    }
@endphp

<div id="{{ $uid }}" class="relative w-full overflow-hidden rounded-lg bg-gray-100 my-6">
    <!-- slides track -->
    <div class="flex transition-transform duration-500 ease-out" style="transform: translateX(0%);">
        @foreach($slides as $s)
            <div class="min-w-full flex-shrink-0">
                <img src="{{ $s['image'] }}" alt="" class="w-full h-64 md:h-80 object-cover" loading="lazy">
            </div>
        @endforeach
    </div>

    <!-- controls -->
    <button type="button" aria-label="Anterior" class="prev absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white px-2 py-1 rounded shadow">
        ‹
    </button>
    <button type="button" aria-label="Siguiente" class="next absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white px-2 py-1 rounded shadow">
        ›
    </button>

    <!-- indicators -->
    <div class="absolute left-1/2 -translate-x-1/2 bottom-3 flex gap-2">
        @for ($i = 0; $i < $slideCount; $i++)
            <button type="button" class="dot w-3 h-3 rounded-full bg-white/60 hover:scale-105" data-index="{{ $i }}" aria-label="Ir a slide {{ $i + 1 }}"></button>
        @endfor
    </div>

    <script>
        (function(){
            const root = document.getElementById('{{ $uid }}');
            if (!root) return;
            const track = root.querySelector(':scope > div');
            const slides = Array.from(track.children);
            const prevBtn = root.querySelector('.prev');
            const nextBtn = root.querySelector('.next');
            const dots = Array.from(root.querySelectorAll('.dot'));
            let index = 0;
            const total = slides.length;
            const intervalMs = 3000; // autoplay interval
            let timer = null;

            function show(i){
                index = ((i % total) + total) % total; // wrap
                track.style.transform = 'translateX(-' + (index * 100) + '%)';
                updateDots();
            }

            function updateDots(){
                dots.forEach((d, idx) => {
                    if (idx === index) d.classList.add('bg-emerald-600');
                    else d.classList.remove('bg-emerald-600');
                });
            }

            function next(){ show(index + 1); }
            function prev(){ show(index - 1); }

            function resetTimer(){
                if (timer) clearInterval(timer);
                timer = setInterval(next, intervalMs);
            }

            // events
            if (nextBtn) nextBtn.addEventListener('click', () => { next(); resetTimer(); });
            if (prevBtn) prevBtn.addEventListener('click', () => { prev(); resetTimer(); });
            dots.forEach(d => d.addEventListener('click', (e) => { show(Number(e.currentTarget.dataset.index)); resetTimer(); }));

            // pause on hover
            root.addEventListener('mouseenter', () => { if (timer) clearInterval(timer); });
            root.addEventListener('mouseleave', () => { resetTimer(); });

            // init
            show(0);
            resetTimer();
        })();
    </script>
</div>
