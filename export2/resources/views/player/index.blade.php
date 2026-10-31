@extends('layouts.app')

@section('title', 'Игроки — Habland Hotel')

@section('content')
<div class="fade-up">
    <h1 class="h2 mb-2">Жители отеля</h1>
    <p class="small text-mute mb-6">{{ $players->total() }} {{ trans_choice('человек уже в игре|человека уже в игре|человек уже в игре', $players->total()) }}</p>

    {{-- Поиск --}}
    <form method="GET" action="{{ route('players.index') }}" role="search"
          class="flex items-stretch gap-3 mb-7 max-w-md">
        <label for="q" class="sr-only">Поиск по нику или девизу</label>
        <input id="q" type="search" name="q" value="{{ $query }}"
               class="field flex-1" placeholder="Ник или девиз…" maxlength="32" autocomplete="off">
        <button class="btn !py-0 !px-5 shrink-0" aria-label="Найти">🔍</button>
        @if($query !== '')
            <a href="{{ route('players.index') }}"
               class="btn btn-ghost !py-0 !px-4 shrink-0 small no-underline" rel="nofollow">Сброс</a>
        @endif
    </form>

    @if($players->isEmpty())
        {{-- Пустое состояние --}}
        <div class="card p-10 text-center max-w-md mx-auto">
            <div class="text-5xl mb-4" aria-hidden="true">🕵️</div>
            <h2 class="h3 mb-2">Никого не нашли</h2>
            @if($query !== '')
                <p class="small text-mute mb-6">По запросу «<b>{{ $query }}</b>» жителей нет. Попробуй другое написание или сбрось поиск.</p>
                <a href="{{ route('players.index') }}" class="btn btn-ghost">← ВСЕ ЖИТЕЛИ</a>
            @else
                <p class="small text-mute mb-6">Отель пока пуст. Стань первым жителем!</p>
                <a href="{{ route('register') }}" class="btn">▶ ЗАСЕЛИТЬСЯ</a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
            @foreach($players as $p)
                <a href="{{ route('player.show', $p->username) }}"
                   class="card card-hover p-4 text-center relative no-underline text-inherit">
                    @if($p->isOnline())
                        <span class="absolute top-3 right-3 dot" title="В отеле"></span>
                    @endif
                    <div class="floaty inline-block">
                        <x-avatar :player="$p" size="md" />
                    </div>
                    <div class="mt-3 font-extrabold text-sm truncate">{{ $p->username }}</div>
                    <div class="small text-mute truncate">«{{ $p->motto ?: 'Без миссии' }}»</div>
                    <div class="mt-2 small font-bold text-fuchsia-300/80">{{ number_format($p->credits) }} 💎</div>
                </a>
            @endforeach
        </div>

        <div class="mt-9">{{ $players->links() }}</div>
    @endif
</div>
@endsection
