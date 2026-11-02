@extends('layouts.app')

@section('title', 'Habland Hotel — пиксельная чат-игра')

@section('content')
{{-- ============ HERO ============ --}}
<section class="fade-up text-center pt-6 md:pt-14 pb-12">
    <span class="inline-flex items-center gap-2.5 small font-bold uppercase tracking-widest text-emerald-300 bg-emerald-500/10 border border-emerald-400/30 rounded-full px-4 py-2 mb-7">
        <span class="dot"></span> {{ $onlineUsers }} сейчас в отеле
    </span>

    <h1 class="h1 max-w-3xl mx-auto">
        Пиксельная <span class="grad-text">чат-игра</span> для своих
    </h1>

    <p class="lead mt-6 max-w-xl mx-auto">
        Создай собственного персонажа, построй комнату мечты
        и найди единомышленников по всей стране!
    </p>

    <div class="mt-9 flex flex-col sm:flex-row items-center justify-center gap-4">
        @auth
            <a href="{{ route('me') }}" class="btn w-full sm:w-auto">МОЙ ПРОФИЛЬ →</a>
            <a href="{{ route('players.index') }}" class="btn btn-cyan w-full sm:w-auto">НАЙТИ ДРУЗЕЙ</a>
        @else
            <a href="{{ route('register') }}" class="btn w-full sm:w-auto">▶ НАЧАТЬ ИГРАТЬ</a>
            <a href="{{ route('login') }}" class="btn btn-ghost w-full sm:w-auto">У МЕНЯ ЕСТЬ АККАУНТ</a>
        @endauth
    </div>

    {{-- Статистика --}}
    <div class="mt-14 grid grid-cols-3 gap-3 max-w-lg mx-auto">
        <div class="card card-hover px-3 py-6">
            <div class="h3 !text-xl md:!text-2xl grad-text">{{ $totalUsers }}</div>
            <div class="small text-mute font-bold mt-2">жителей</div>
        </div>
        <div class="card card-hover px-3 py-6">
            <div class="h3 !text-xl md:!text-2xl text-emerald-400">{{ $onlineUsers }}</div>
            <div class="small text-mute font-bold mt-2">в сети</div>
        </div>
        <div class="card card-hover px-3 py-6">
            <div class="h3 !text-xl md:!text-2xl text-cyan-300">∞</div>
            <div class="small text-mute font-bold mt-2">комнат</div>
        </div>
    </div>
</section>

{{-- ============ НОВОСТИ ============ --}}
<section class="reveal mt-16">
    <div class="flex items-end justify-between mb-6">
        <h2 class="h2">Новости отеля</h2>
        @if($news->count())
            <a href="{{ route('news.index') }}" class="small font-bold text-violet-300 hover:text-fuchsia-300 transition">Все новости →</a>
        @endif
    </div>

    @if($news->count() === 0)
        <div class="card p-8 text-center">
            <div class="text-4xl mb-3 floaty inline-block">📰</div>
            <p class="small text-mute">Новостей пока нет — но мы скоро вернёмся с анонсами!</p>
        </div>
    @else
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach($news as $n)
                <x-news-card :item="$n" :featured="$loop->first && $n->featured" />
            @endforeach
        </div>
    @endif
</section>

{{-- ============ ФИЧИ ============ --}}
<section class="reveal">
    <h2 class="h2 text-center mb-9">Что тебя ждёт</h2>
    <div class="grid md:grid-cols-3 gap-4">
        <div class="card card-hover p-7 text-center">
            <div class="text-4xl mb-5 floaty inline-block">🧍</div>
            <h3 class="h3 text-fuchsia-300 mb-3">Свой персонаж</h3>
            <p class="small text-mute leading-relaxed">Собери уникальный образ: причёска, одежда, аксессуары. Меняй стиль когда угодно.</p>
        </div>
        <div class="card card-hover p-7 text-center">
            <div class="text-4xl mb-5 floaty inline-block">🧱</div>
            <h3 class="h3 text-cyan-300 mb-3">Свои комнаты</h3>
            <p class="small text-mute leading-relaxed">Строй и обставляй комнаты мечты. Кафе, клуб, дворец — ограничение только ваша фантазия. А в подвале отеля спрятана одна очень знакомая фраза…</p>
        </div>
        <div class="card card-hover p-7 text-center">
            <div class="text-4xl mb-5 floaty inline-block">🤝</div>
            <h3 class="h3 text-emerald-300 mb-3">Единомышленники</h3>
            <p class="small text-mute leading-relaxed">Общайся в чате, находи друзей по интересам и собирай свою компанию в отеле.</p>
        </div>
    </div>
</section>

{{-- ============ НОВЫЕ ЖИТЕЛИ ============ --}}
<section class="reveal mt-16">
    <div class="flex items-end justify-between mb-6">
        <h2 class="h2">Новые жители</h2>
        <a href="{{ route('players.index') }}" class="small font-bold text-violet-300 hover:text-fuchsia-300 transition">Все игроки →</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-4">
        @foreach($newest as $p)
            <a href="{{ route('player.show', $p->username) }}" class="card card-hover p-4 text-center no-underline text-inherit">
                <div class="floaty inline-block">
                    <x-avatar :player="$p" size="md" />
                </div>
                <div class="mt-3 font-extrabold text-sm truncate">{{ $p->username }}</div>
                <div class="small text-mute truncate">«{{ $p->motto ?: 'Без миссии' }}»</div>
            </a>
        @endforeach
    </div>
</section>

{{-- ============ ТОП ПО КРЕДИТАМ ============ --}}
<section class="reveal mt-16">
    <h2 class="h2 mb-6">Топ по кредитам</h2>
    <div class="grid sm:grid-cols-2 gap-3 md:gap-4">
        @foreach($richest as $i => $p)
            <a href="{{ route('player.show', $p->username) }}" class="card card-hover flex items-center gap-3 p-3.5">
                <span class="w-8 text-center font-display text-sm font-bold {{ $i < 3 ? 'grad-text' : 'text-mute' }}">{{ $i + 1 }}</span>
                <x-avatar :player="$p" size="sm" />
                <span class="min-w-0">
                    <span class="block font-extrabold text-sm truncate">{{ $p->username }}</span>
                    <span class="small text-mute">{{ $p->rank_name }}</span>
                </span>
                <span class="ml-auto shrink-0 text-sm font-extrabold text-fuchsia-300">{{ number_format($p->credits) }} 💎</span>
            </a>
        @endforeach
    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="reveal mt-16 text-center">
    <div class="card p-1" style="background:linear-gradient(135deg,#8B5CF6,#E879F9);">
        <div class="rounded-[17px] px-6 py-12 md:py-16" style="background:#100A1F;">
            <h2 class="h1 !text-2xl sm:!text-3xl md:!text-4xl">Готов начать<br><span class="grad-text">приключение?</span></h2>
            <p class="lead mt-4 mb-9">Регистрация занимает меньше минуты<span class="blink">_</span></p>
            {{-- Пасхалка Skyrim: 5 кликов по курсору "_" (Fus Ro Dah) --}}
            <a href="{{ route('register') }}" class="btn">▶ ЗАСЕЛИТЬСЯ В ОТЕЛЬ</a>
            <div><span id="dragonWord" title="" class="cursor-pointer select-none text-mute hover:text-fuchsia-300 transition-colors inline-block blink" aria-hidden="true">_</span></div>
        </div>
    </div>
</section>
@endsection
