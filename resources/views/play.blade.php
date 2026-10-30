<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Игра — Habland Hotel</title>
    <meta name="robots" content="noindex">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@500;700&family=Golos+Text:wght@600;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --c-primary:#8B5CF6; --c-primary-d:#4C1D95; --c-secondary:#1B1230;
            --c-text:#F3EFFF; --c-muted:#A79ACB; --c-success:#34D399;
            --r-md:12px; --sh-btn:0 4px 0 var(--c-primary-d), 0 10px 22px rgba(139,92,246,.4);
        }
        *{ box-sizing:border-box; }
        html,body{ height:100%; margin:0; }
        body{ display:flex; flex-direction:column; background:#0B0714; color:var(--c-text);
              font-family:'Golos Text',system-ui,sans-serif; overflow:hidden; }

        .bar{ flex:0 0 auto; display:flex; align-items:center; gap:10px; padding:8px 12px;
              background:var(--c-secondary); border-bottom:1px solid rgba(139,92,246,.18); }
        .logo{ display:flex; align-items:center; gap:8px; text-decoration:none; color:#fff;
               font-family:'Unbounded',sans-serif; font-weight:700; font-size:11px; letter-spacing:.04em; }
        .logo span{ width:28px; height:28px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center;
                    background:linear-gradient(135deg,#A78BFA,#8B5CF6); font-size:14px; box-shadow:0 2px 0 var(--c-primary-d); }
        .online{ display:flex; align-items:center; gap:8px; font-family:'Unbounded',sans-serif;
                 font-size:10px; font-weight:700; color:var(--c-success); white-space:nowrap;
                 border:1px solid rgba(52,211,153,.4); background:rgba(52,211,153,.1);
                 border-radius:999px; padding:8px 12px; }
        .dot{ width:8px; height:8px; border-radius:999px; background:var(--c-success); position:relative; }
        .dot::after{ content:''; position:absolute; inset:-3px; border-radius:999px; border:2px solid var(--c-success);
                     animation:ping 1.6s ease-out infinite; }
        @keyframes ping{ 0%{opacity:.8;} 100%{transform:scale(1.9); opacity:0;} }
        .spacer{ flex:1; }

        .pbtn{ font-family:'Unbounded',sans-serif; font-size:9px; font-weight:700; letter-spacing:.04em; color:#fff;
               text-shadow:0 1px 0 rgba(0,0,0,.3); cursor:pointer; user-select:none; white-space:nowrap;
               padding:11px 14px; border:0; border-radius:var(--r-md); text-decoration:none;
               display:inline-flex; align-items:center; gap:6px;
               background:linear-gradient(135deg,#A78BFA,#8B5CF6);
               box-shadow:var(--sh-btn);
               transition:transform .12s, box-shadow .12s, filter .15s; }
        .pbtn:hover{ filter:brightness(1.1); }
        .pbtn:active{ transform:translateY(4px); box-shadow:0 1px 0 var(--c-primary-d), 0 4px 10px rgba(124,58,237,.35); }
        .pbtn-ghost{ background:transparent; color:#C4B5FD; text-shadow:none; box-shadow:inset 0 0 0 2px rgba(139,92,246,.28); }
        .pbtn-ghost:hover{ box-shadow:inset 0 0 0 2px var(--c-primary); background:rgba(139,92,246,.12); filter:none; }
        .pbtn-ghost:active{ transform:translateY(2px); }

        #game{ flex:1 1 auto; min-height:0; position:relative; background:#000; }
        #game iframe{ position:absolute; inset:0; width:100%; height:100%; border:0; display:block; }
        .warn{ position:absolute; inset:0; display:flex; align-items:center; justify-content:center; padding:20px; }
        .warn > div{ max-width:480px; text-align:center; background:var(--c-secondary); border:1px solid rgba(139,92,246,.25);
                     border-radius:18px; padding:32px; }
        .warn h2{ font-family:'Unbounded',sans-serif; font-size:14px; color:#F0ABFC; margin:0 0 12px; }
        .warn p{ color:var(--c-muted); font-size:14px; line-height:1.6; margin:0; }
        .warn code{ color:#22D3EE; background:#0B0714; padding:2px 6px; border-radius:6px; }

        @media (max-width:640px){ .hide-sm{ display:none; } .pbtn{ padding:10px 12px; font-size:8px; } }
        a:focus-visible, button:focus-visible{ outline:2px solid var(--c-primary); outline-offset:2px; }
    </style>
</head>
<body>

    <div class="bar">
        <a class="logo" href="{{ route('home') }}"><span>🏨</span><span class="hide-sm">HABLAND</span></a>

        <div class="online" title="Сейчас в отеле">
            <span class="dot"></span>
            <span>ОНЛАЙН: <span id="onlineCount">…</span></span>
        </div>

        <div class="spacer"></div>

        <button class="pbtn" id="fsBtn" title="Полноэкранный режим (F)">⛶ <span class="hide-sm">ВО ВЕСЬ ЭКРАН</span></button>
        <a class="pbtn pbtn-ghost" href="{{ $clientUrl }}" target="_blank" rel="noopener" title="Открыть в новой вкладке">⧉ <span class="hide-sm">НОВАЯ ВКЛАДКА</span></a>
        <a class="pbtn pbtn-ghost" href="{{ route('home') }}" title="На главную">✕</a>
    </div>

    <div id="game">
        @if($clientExists)
            <iframe src="{{ $clientUrl }}" allowfullscreen referrerpolicy="no-referrer" title="Habland Hotel — игра"></iframe>
        @else
            <div class="warn">
                <div>
                    <h2>КЛИЕНТ НЕ НАЙДЕН</h2>
                    <p>Положи файлы игры по пути <code>public/client/index.html</code> и обнови страницу (F5).<br><br>
                    Сейчас сервер ищет: <code>{{ public_path('client/index.html') }}</code></p>
                </div>
            </div>
        @endif
    </div>

    <script>
        const game  = document.getElementById('game');
        const fsBtn = document.getElementById('fsBtn');

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                (game.requestFullscreen || game.webkitRequestFullscreen).call(game);
            } else {
                (document.exitFullscreen || document.webkitExitFullscreen).call(document);
            }
        }
        fsBtn.addEventListener('click', toggleFullscreen);
        document.addEventListener('keydown', (e) => {
            if (e.key.toLowerCase() === 'f' && !e.ctrlKey && !e.metaKey && !e.altKey) toggleFullscreen();
        });
        document.addEventListener('fullscreenchange', () => {
            const fs = !!document.fullscreenElement;
            fsBtn.innerHTML = fs ? '⛶ <span class="hide-sm">СВЕРНУТЬ</span>' : '⛶ <span class="hide-sm">ВО ВЕСЬ ЭКРАН</span>';
            if (!fs) game.querySelector('iframe')?.focus();
        });

        async function updateOnline() {
            try {
                const res = await fetch('/api/online', { cache: 'no-store' });
                const data = await res.json();
                document.getElementById('onlineCount').textContent = data.online;
            } catch (e) {}
        }
        updateOnline();
        setInterval(updateOnline, 30000);
    </script>
</body>
</html>
