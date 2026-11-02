<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Habland Hotel')</title>
    <meta name="description" content="Habland Hotel — пиксельная чат-игра: создай персонажа, построй комнату, найди единомышленников!">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@500;700;800&family=Golos+Text:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink:   '#0B0714',
                        panel: '#1B1230',
                        line:  'rgba(139,92,246,.18)',
                        mute:  '#A79ACB',
                    },
                    fontFamily: {
                        sans: ['"Golos Text"', 'system-ui', 'sans-serif'],
                        display: ['Unbounded', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        :root{
            /* ===== Цвета ===== */
            --c-primary:#8B5CF6; --c-primary-d:#4C1D95;
            --c-secondary:#1B1230;
            --c-text:#F3EFFF; --c-accent:#E879F9;
            --c-muted:#A79ACB;
            --c-success:#34D399; --c-error:#FB7185;
            /* ===== Скругления ===== */
            --r-sm:8px; --r-md:12px; --r-lg:18px;
            /* ===== Тени ===== */
            --sh-card:0 2px 10px rgba(5,0,20,.45);
            --sh-lift:0 18px 44px -14px rgba(139,92,246,.5);
            --sh-btn:0 6px 0 var(--c-primary-d), 0 12px 26px rgba(139,92,246,.4);
        }
        *{ box-sizing:border-box; }
        html{ scroll-behavior:smooth; }
        body{
            background-color:var(--c-text) #0B0714;
            background-color:#0B0714;
            color:var(--c-text);
            background-image:
                linear-gradient(rgba(139,92,246,.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(139,92,246,.07) 1px, transparent 1px),
                radial-gradient(ellipse 70% 40% at 50% -10%, rgba(124,58,237,.28), transparent 70%);
            background-size:24px 24px, 24px 24px, 100% 100%;
            background-attachment:fixed;
            font-size:16px; line-height:1.65;
        }
        ::selection{ background:rgba(139,92,246,.55); color:#fff; }

        /* ===== Типографика ===== */
        .h1{ font-family:'Unbounded',sans-serif; font-weight:800; font-size:28px; line-height:1.15; letter-spacing:-.01em; }
        .h2{ font-family:'Unbounded',sans-serif; font-weight:700; font-size:20px; line-height:1.25; letter-spacing:-.01em; }
        .h3{ font-family:'Golos Text',sans-serif; font-weight:800; font-size:16px; line-height:1.35; }
        .lead{ font-size:16px; line-height:1.65; color:var(--c-muted); }
        .small{ font-size:13px; line-height:1.5; }
        @media (min-width:640px){
            .h1{ font-size:40px; }
            .h2{ font-size:28px; }
            .h3{ font-size:18px; }
        }
        @media (min-width:1024px){
            .h1{ font-size:56px; }
        }
        .grad-text{ background:linear-gradient(120deg,#C4B5FD,#8B5CF6 45%,#E879F9); -webkit-background-clip:text; background-clip:text; color:transparent; }

        /* ===== Кнопки ===== */
        .btn{
            position:relative; display:inline-flex; align-items:center; justify-content:center; gap:.6rem;
            font-family:'Unbounded',sans-serif; font-weight:700; font-size:11px; letter-spacing:.04em;
            color:#fff; text-shadow:0 1px 0 rgba(0,0,0,.35);
            padding:15px 26px; border-radius:var(--r-md); user-select:none; white-space:nowrap;
            background:linear-gradient(135deg,#A78BFA 0%,#8B5CF6 50%,#D946EF 120%);
            box-shadow:var(--sh-btn);
            transition:transform .12s ease, box-shadow .12s ease, filter .15s ease;
            overflow:hidden;
        }
        .btn:hover{ filter:brightness(1.1); }
        .btn:active{ transform:translateY(5px); box-shadow:0 1px 0 var(--c-primary-d), 0 4px 12px rgba(124,58,237,.4); }
        .btn::after{
            content:''; position:absolute; top:0; left:-80%; width:45%; height:100%;
            background:linear-gradient(105deg,transparent,rgba(255,255,255,.35),transparent);
            transform:skewX(-20deg); transition:left .5s ease;
        }
        .btn:hover::after{ left:135%; }
        .btn-cyan{
            background:linear-gradient(135deg,#67E8F9,#22D3EE 55%,#0E9BB8);
            box-shadow:0 6px 0 #075E73, 0 12px 26px rgba(34,211,238,.35);
        }
        .btn-cyan:active{ box-shadow:0 1px 0 #075E73, 0 4px 12px rgba(34,211,238,.3); }
        .btn-ghost{
            background:rgba(139,92,246,.08); color:#C4B5FD; text-shadow:none;
            box-shadow:inset 0 0 0 2px rgba(139,92,246,.28);
        }
        .btn-ghost:hover{ box-shadow:inset 0 0 0 2px var(--c-primary); background:rgba(139,92,246,.16); }
        .btn-ghost:active{ transform:translateY(3px); }

        /* ===== Кнопки навигации в шапке (все элементы шапки — кнопки) ===== */
        .btn-nav{
            display:inline-flex; align-items:center; gap:.45rem;
            font-family:'Unbounded',sans-serif; font-weight:700; font-size:10px; letter-spacing:.03em;
            color:#C4B5FD; text-decoration:none; white-space:nowrap; user-select:none;
            padding:9px 14px; border-radius:var(--r-md); cursor:pointer;
            background:linear-gradient(180deg,#2A1D4D,#1B1230);
            box-shadow:0 3px 0 #120B24, inset 0 1px 0 rgba(196,181,253,.14);
            border:1px solid rgba(139,92,246,.25);
            transition:transform .1s ease, box-shadow .1s ease, color .15s ease, filter .15s ease;
        }
        .btn-nav:hover{ color:#fff; filter:brightness(1.15); }
        .btn-nav:active{ transform:translateY(2px); box-shadow:0 1px 0 #120B24, inset 0 1px 0 rgba(196,181,253,.14); }
        .btn-nav.is-active{
            color:#fff;
            background:linear-gradient(135deg,#A78BFA,#8B5CF6 55%,#D946EF);
            box-shadow:0 3px 0 var(--c-primary-d), 0 8px 18px rgba(139,92,246,.35);
            border-color:transparent; text-shadow:0 1px 0 rgba(0,0,0,.35);
        }
        .btn-nav b{ color:#fff; font-weight:800; }
        .btn-nav .dot{ margin-right:1px; }

        /* ===== Карточки ===== */
        .card{
            background:var(--c-secondary);
            border:1px solid var(--line);
            border-radius:var(--r-lg);
            box-shadow:var(--sh-card);
            transition:transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        }
        .card-hover:hover{ transform:translateY(-4px); border-color:rgba(139,92,246,.5); box-shadow:var(--sh-lift); }

        /* ===== Обрезка текста по строкам (карточки новостей) ===== */
        .line-clamp-2{ display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .line-clamp-4{ display:-webkit-box; -webkit-line-clamp:4; -webkit-box-orient:vertical; overflow:hidden; }

        /* ===== Поля ввода ===== */
        .field{
            width:100%; padding:.85rem 1.1rem; border-radius:var(--r-md);
            color:var(--c-text); background:#0F0A1D;
            border:2px solid rgba(139,92,246,.2); outline:none; font-weight:600;
            transition:border-color .15s, box-shadow .15s;
        }
        .field::placeholder{ color:#5E5280; }
        .field:focus{ border-color:var(--c-primary); box-shadow:0 0 0 4px rgba(139,92,246,.22); }

        /* ===== Индикатор онлайна ===== */
        .dot{ width:9px; height:9px; border-radius:999px; background:var(--c-success); position:relative; }
        .dot::after{
            content:''; position:absolute; inset:-4px; border-radius:999px; border:2px solid var(--c-success);
            animation:ping 1.6s ease-out infinite;
        }
        @keyframes ping{ 0%{opacity:.8;} 100%{transform:scale(1.9); opacity:0;} }

        /* ===== Анимации ===== */
        .floaty{ animation:floaty 4.5s ease-in-out infinite; }
        @keyframes floaty{ 0%,100%{transform:translateY(0);} 50%{transform:translateY(-7px);} }
        .blink{ animation:blink 1.1s steps(2) infinite; }
        @keyframes blink{ 50%{opacity:0;} }
        /* Пасхалка Марио: «звёздный» режим шапки */
        .star-mode{ animation: starCycle .4s steps(2) infinite; }
        @keyframes starCycle{
            0%  { filter: hue-rotate(0deg)   brightness(1.3); box-shadow: 0 4px 24px rgba(255,215,0,.45); }
            100%{ filter: hue-rotate(90deg)  brightness(1.1); box-shadow: 0 4px 24px rgba(232,121,249,.45); }
        }
        @keyframes fadeUp{ from{opacity:0; transform:translateY(16px);} to{opacity:1; transform:none;} }
        .fade-up{ animation:fadeUp .45s cubic-bezier(.22,1,.36,1) both; }
        .reveal{ opacity:0; transform:translateY(24px); transition:opacity .5s ease, transform .5s cubic-bezier(.22,1,.36,1); }
        .reveal.visible{ opacity:1; transform:none; }

        a:focus-visible, button:focus-visible, input:focus-visible, label:focus-visible{
            outline:2px solid var(--c-accent); outline-offset:3px; border-radius:var(--r-sm);
        }
        @media (prefers-reduced-motion: reduce){
            *,*::before,*::after{ animation-duration:.01ms !important; transition-duration:.01ms !important; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    {{-- ШАПКА: всё кнопками, включая счётчик онлайна --}}
    <header class="sticky top-0 z-40 border-b border-line bg-ink/85 backdrop-blur-md">
        <div class="max-w-6xl mx-auto px-3 md:px-4 h-16 flex items-center justify-between gap-2">

            {{-- Лого --}}
            <a href="{{ route('home') }}" id="logoBtn" class="flex items-center gap-2.5 shrink-0 mr-1" aria-label="Habland Hotel — на главную">
                <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center text-lg shadow-[0_3px_0_#4C1D95]">🏨</span>
                <span class="font-display text-[13px] font-bold tracking-wide hidden sm:block">HABLAND<span class="text-fuchsia-400">HOTEL</span></span>
            </a>

            {{-- Кнопки навигации (десктоп) --}}
            <nav class="hidden md:flex items-center gap-2" aria-label="Основная навигация">
                <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif
                   class="btn-nav {{ request()->routeIs('home') ? 'is-active' : '' }}">🏠 Главная</a>
                <a href="{{ route('players.index') }}" @if(request()->routeIs('players.*', 'player.*')) aria-current="page" @endif
                   class="btn-nav {{ request()->routeIs('players.*', 'player.*') ? 'is-active' : '' }}">👥 Игроки</a>
                <a href="{{ route('news.index') }}" @if(request()->routeIs('news.*')) aria-current="page" @endif
                   class="btn-nav {{ request()->routeIs('news.*') ? 'is-active' : '' }}">📰 Новости</a>

                {{-- Онлайн — тоже кнопка, клик обновляет счётчик --}}
                <button type="button" id="onlineBtn" class="btn-nav" title="Обновить счётчик онлайна">
                    <span class="dot"></span>&nbsp;Онлайн: <b id="onlineCount">{{ \App\Http\Controllers\HomeController::onlineCount() }}</b>
                </button>

                @auth
                    <a href="{{ route('play') }}" @if(request()->routeIs('play')) aria-current="page" @endif
                       class="btn btn-cyan !py-2.5 !px-5 !text-[10px] ml-1">▶ В ИГРУ</a>
                    <a href="{{ route('me') }}" @if(request()->routeIs('me', 'player.show')) aria-current="page" @endif
                       class="btn-nav {{ request()->routeIs('me', 'player.show') ? 'is-active' : '' }}">🙂 Профиль</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="btn-nav">🚪 Выход</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" @if(request()->routeIs('login')) aria-current="page" @endif
                       class="btn-nav {{ request()->routeIs('login') ? 'is-active' : '' }}">🔑 Вход</a>
                    <a href="{{ route('register') }}" class="btn !py-2.5 !px-5 !text-[10px] ml-1">ИГРАТЬ</a>
                @endauth
            </nav>

            {{-- Мобильный переключатель --}}
            <button id="menuBtn" class="md:hidden w-10 h-10 rounded-lg bg-panel border border-line flex items-center justify-center" aria-expanded="false" aria-controls="mobileMenu" aria-label="Меню">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>

        {{-- Мобильное меню: те же кнопки, складываются в столбик --}}
        <nav id="mobileMenu" class="md:hidden hidden border-t border-line bg-panel/95 backdrop-blur-md" aria-label="Мобильная навигация">
            <div class="px-3 py-3 flex flex-wrap gap-2">
                <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif
                   class="btn-nav {{ request()->routeIs('home') ? 'is-active' : '' }}">🏠 Главная</a>
                <a href="{{ route('players.index') }}" @if(request()->routeIs('players.*', 'player.*')) aria-current="page" @endif
                   class="btn-nav {{ request()->routeIs('players.*', 'player.*') ? 'is-active' : '' }}">👥 Игроки</a>
                <a href="{{ route('news.index') }}" @if(request()->routeIs('news.*')) aria-current="page" @endif
                   class="btn-nav {{ request()->routeIs('news.*') ? 'is-active' : '' }}">📰 Новости</a>
                <button type="button" class="btn-nav" onclick="location.reload()">
                    <span class="dot"></span>&nbsp;Онлайн: <b>{{ \App\Http\Controllers\HomeController::onlineCount() }}</b>
                </button>
                @auth
                    <a href="{{ route('play') }}" class="btn btn-cyan !py-2.5 !px-5 !text-[10px]">▶ В ИГРУ</a>
                    <a href="{{ route('me') }}" class="btn-nav">🙂 Мой профиль</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="btn-nav">🚪 Выход</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">🔑 Вход</a>
                    <a href="{{ route('register') }}" class="btn !py-2.5 !px-5 !text-[10px]">ИГРАТЬ</a>
                @endauth
            </div>
        </nav>
    </header>

    {{-- КОНТЕНТ --}}
    <main class="flex-1 w-full max-w-6xl mx-auto px-4 py-8 md:py-12">
        @if(session('success'))
            <div class="fade-up card !border-emerald-400/40 !bg-emerald-500/10 px-5 py-3.5 mb-6 font-bold text-emerald-300 flex items-center gap-2">▶ {{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-line py-6">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2 small text-mute">
            <span class="font-display text-[10px] tracking-wide">© {{ date('Y') }} HABLAND HOTEL</span>
            {{-- Пасхалка Portal: клик по тексту открывает торт --}}
            <a href="#" id="cakeLink" title="" class="hover:text-hot transition-colors">Торт — ложь · Пасхалки: <span id="eggsFound">0</span>/5</a>
        </div>
    </footer>

    {{-- Оверлей пасхалок --}}
    <div id="eggModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/70 p-4" role="dialog" aria-modal="true" aria-labelledby="eggTitle">
        <div class="bg-panel border border-line rounded-[18px] shadow-[0_12px_40px_rgba(0,0,0,.6)] max-w-md w-full p-6 relative text-mute">
            <button id="eggClose" class="absolute top-3 right-3 btn-nav px-2 py-1" aria-label="Закрыть">✕</button>
            <h2 id="eggTitle" class="font-display text-lg font-bold text-fuchsia-400 mb-3"></h2>
            <p id="eggText" class="text-sm leading-relaxed"></p>
        </div>
    </div>

    <script>
        const btn = document.getElementById('menuBtn');
        const menu = document.getElementById('mobileMenu');
        btn?.addEventListener('click', () => {
            const open = menu.classList.toggle('hidden') === false;
            btn.setAttribute('aria-expanded', open);
        });

        // Кнопка «Онлайн» в шапке: клик подтягивает свежее число из /api/online
        const onlineBtn = document.getElementById('onlineBtn');
        const refreshOnline = async () => {
            try {
                const d = await (await fetch('/api/online')).json();
                const el = document.getElementById('onlineCount');
                if (el) el.textContent = d.online;
            } catch (e) { /* тихо: оставим прошлое значение */ }
        };
        onlineBtn?.addEventListener('click', () => {
            onlineBtn.disabled = true;
            refreshOnline().finally(() => { onlineBtn.disabled = false; });
        });
        // фоновое автообновление раз в 60 секунд
        setInterval(refreshOnline, 60000);

        const io = new IntersectionObserver((es) => {
            es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
        }, { threshold: .1 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        /* ================= ПАСХАЛКИ ================= */
        const EGGS = {
            konami:  { title: '🎮 GTA-режим активирован', text: 'Вы ввели легендарный Konami-код (↑↑↓↓←→←→BA). Как в GTA — вам выдано «оружие массового обаяния», как в Contra — 30 жизней. Отдыхать запрещено!' },
            mojang:  { title: '⛏️ Крипер не взорвался', text: 'Вы кликнули по логотипу 7 раз. В Mojang за это дали бы… ничего, но мы добрее: +1 к карме и знание того, что вы очень внимательны.' },
            mario:   { title: '🍄 Super! Вы большая звезда', text: 'Нажатие «*» — как неуязвимость Марио. Теперь следующие 8 секунд вас невозможно «выбить» из отеля (на самом деле нет, но выглядит круто).' },
            cake:    { title: '🎂 The cake is a lie', text: 'Из Portal: «Торт — это ложь». GLaDOS бы вами гордилась. Торт здесь действительно не обещали.' },
            zelda:   { title: '🗡️ It\'s dangerous to go alone!', text: 'Ник "link" получает Мастер-меч. Сокровище спрятано в этом сообщении:Take this sword... оно теперь ваше.' },
        };
        let found = JSON.parse(localStorage.getItem('hablandEggs') || '[]');

        function unlock(id) {
            if (!EGGS[id] || found.includes(id)) return;
            found.push(id);
            localStorage.setItem('hablandEggs', JSON.stringify(found));
            showEgg(EGGS[id].title, EGGS[id].text);
            updateCounter();
        }
        function updateCounter() {
            const el = document.getElementById('eggsFound');
            if (el) el.textContent = found.length;
        }
        updateCounter();

        // Модалка
        const modal = document.getElementById('eggModal');
        function showEgg(title, text) {
            document.getElementById('eggTitle').textContent = title;
            document.getElementById('eggText').textContent = text;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function hideEgg() { modal.classList.add('hidden'); modal.classList.remove('flex'); }
        document.getElementById('eggClose')?.addEventListener('click', hideEgg);
        modal?.addEventListener('click', (e) => { if (e.target === modal) hideEgg(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') hideEgg(); });

        // 1) Konami-код: ↑↑↓↓←→←→BA
        const KONAMI = ['ArrowUp','ArrowUp','ArrowDown','ArrowDown','ArrowLeft','ArrowRight','ArrowLeft','ArrowRight','b','a'];
        let kIdx = 0;
        document.addEventListener('keydown', (e) => {
            kIdx = (e.key.toLowerCase() === KONAMI[kIdx]?.toLowerCase()) ? kIdx + 1 : (e.key.toLowerCase() === KONAMI[0] ? 1 : 0);
            if (kIdx === KONAMI.length) { kIdx = 0; unlock('konami'); confetti(); }
        });

        // Конфетти для Konami
        function confetti() {
            for (let i = 0; i < 60; i++) {
                const c = document.createElement('div');
                c.textContent = ['🟨','⭐','🧱','💎','🔥'][i % 5];
                c.style.cssText = `position:fixed;left:${Math.random()*100}vw;top:-2rem;font-size:${12+Math.random()*14}px;z-index:999;pointer-events:none;transition:transform 2.5s ease-in,opacity 2.5s;`;
                document.body.appendChild(c);
                requestAnimationFrame(() => { c.style.transform = `translateY(105vh) rotate(${Math.random()*720-360}deg)`; c.style.opacity = '0'; });
                setTimeout(() => c.remove(), 2600);
            }
        }

        // 2) Логотип: 7 кликов (Mojang-пасхалка с крипером)
        const logo = document.getElementById('logoBtn');
        let logoClicks = 0, logoTimer = null;
        logo?.addEventListener('click', () => {
            logoClicks++; clearTimeout(logoTimer);
            logoTimer = setTimeout(() => { logoClicks = 0; }, 2000);
            if (logoClicks >= 7) { logoClicks = 0; unlock('mojang'); }
        });

        // 3) Звезда «*» — неуязвимость Марио (8 сек свечения шапки)
        document.addEventListener('keydown', (e) => {
            if (e.key === '*' && !e.repeat) {
                unlock('mario');
                const header = document.querySelector('header');
                header?.classList.add('star-mode');
                setTimeout(() => header?.classList.remove('star-mode'), 8000);
            }
        });

        // 4) Торт — это ложь (Portal): клик по ссылке в подвале
        document.getElementById('cakeLink')?.addEventListener('click', (e) => {
            e.preventDefault();
            unlock('cake');
        });

        // 5) Ник "link" — меч из Zelda (проверяем серверную переменку)
        @auth
            @if(strtolower(auth()->user()->username) === 'link')
                unlock('zelda');
            @endif
        @endauth
    </script>
</body>
</html>
