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

        /* ===== Карточки ===== */
        .card{
            background:var(--c-secondary);
            border:1px solid var(--line);
            border-radius:var(--r-lg);
            box-shadow:var(--sh-card);
            transition:transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        }
        .card-hover:hover{ transform:translateY(-4px); border-color:rgba(139,92,246,.5); box-shadow:var(--sh-lift); }

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

    {{-- ШАПКА --}}
    <header class="sticky top-0 z-40 border-b border-line bg-ink/85 backdrop-blur-md">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0" aria-label="Habland Hotel — на главную">
                <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center text-lg shadow-[0_3px_0_#4C1D95]">🏨</span>
                <span class="font-display text-[13px] font-bold tracking-wide">HABLAND<span class="text-fuchsia-400">HOTEL</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-1 text-sm font-bold text-mute" aria-label="Основная навигация">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:text-white hover:bg-white/5 transition">Главная</a>
                <a href="{{ route('players.index') }}" class="px-3 py-2 rounded-lg hover:text-white hover:bg-white/5 transition">Игроки</a>
                @auth
                    <a href="{{ route('play') }}" class="btn btn-cyan !py-2.5 !px-5 !text-[10px] ml-1">▶ В ИГРУ</a>
                    <a href="{{ route('me') }}" class="px-3 py-2 rounded-lg hover:text-white hover:bg-white/5 transition">Профиль</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="btn btn-ghost !py-2.5 !px-5 !text-[10px] ml-1">ВЫХОД</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg hover:text-white transition">Вход</a>
                    <a href="{{ route('register') }}" class="btn !py-2.5 !px-5 !text-[10px] ml-1">ИГРАТЬ</a>
                @endauth
            </nav>

            <button id="menuBtn" class="md:hidden w-10 h-10 rounded-lg bg-panel border border-line flex items-center justify-center" aria-expanded="false" aria-controls="mobileMenu" aria-label="Меню">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>

        <nav id="mobileMenu" class="md:hidden hidden border-t border-line bg-panel/95 backdrop-blur-md" aria-label="Мобильная навигация">
            <div class="px-4 py-3 flex flex-col gap-1 text-sm font-bold">
                <a href="{{ route('home') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/5 transition">Главная</a>
                <a href="{{ route('players.index') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/5 transition">Игроки</a>
                @auth
                    <a href="{{ route('play') }}" class="btn btn-cyan w-full mt-2">▶ В ИГРУ</a>
                    <a href="{{ route('me') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/5 transition">Мой профиль</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-ghost w-full mt-2">Выйти</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/5 transition">Вход</a>
                    <a href="{{ route('register') }}" class="btn w-full mt-2">ИГРАТЬ БЕСПЛАТНО</a>
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
            <span>Пиксельная чат-игра · Laravel {{ app()->version() }}</span>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('menuBtn');
        const menu = document.getElementById('mobileMenu');
        btn?.addEventListener('click', () => {
            const open = menu.classList.toggle('hidden') === false;
            btn.setAttribute('aria-expanded', open);
        });
        const io = new IntersectionObserver((es) => {
            es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
        }, { threshold: .1 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));
    </script>
</body>
</html>
