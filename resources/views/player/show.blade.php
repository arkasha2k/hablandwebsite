@extends('layouts.app')

@section('title', $player->username . ' — Habland Hotel')

@section('content')
<div class="max-w-3xl mx-auto fade-up">
    <div class="card overflow-hidden">
        {{-- Шапка --}}
        <div class="h-24 relative" style="background:linear-gradient(90deg,#4C1D95,#86198F,#4C1D95);">
            <div class="absolute inset-0 opacity-40" style="background-image:linear-gradient(rgba(255,255,255,.14) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.14) 1px,transparent 1px);background-size:14px 14px;"></div>
        </div>

        <div class="px-5 md:px-8 pb-8">
            <div class="flex flex-col sm:flex-row gap-5 -mt-12">
                <div class="shrink-0 mx-auto sm:mx-0">
                    <div class="floaty inline-block rounded-2xl bg-ink/80 border border-line p-3 shadow-[0_10px_30px_-10px_rgba(0,0,0,.6)]">
                        <img src="{{ $player->getAvatarUrl() }}" alt="{{ $player->username }}" width="104" height="178">
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left sm:pt-14 min-w-0">
                    <div class="flex items-center justify-center sm:justify-start gap-2.5 flex-wrap">
                        <h1 class="h2">{{ $player->username }}</h1>
                        @if($player->isOnline())
                            <span class="inline-flex items-center gap-2 small font-extrabold uppercase tracking-wider text-emerald-300 bg-emerald-500/10 border border-emerald-400/30 rounded-full px-3 py-1.5"><span class="dot"></span>В игре</span>
                        @else
                            <span class="inline-flex items-center gap-2 small font-extrabold uppercase tracking-wider text-mute bg-white/5 border border-line rounded-full px-3 py-1.5">Оффлайн</span>
                        @endif
                    </div>
                    <p class="small text-mute italic mt-2 truncate">«{{ $player->motto ?: 'Без миссии' }}»</p>
                </div>
            </div>

            {{-- Статистика --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mt-8">
                <div class="card !rounded-xl p-4"><div class="small font-extrabold uppercase tracking-wider text-mute mb-1.5">Ранг</div><div class="font-extrabold text-sm text-violet-200">{{ $player->rank_name }}</div></div>
                <div class="card !rounded-xl p-4"><div class="small font-extrabold uppercase tracking-wider text-mute mb-1.5">Кредиты</div><div class="font-extrabold text-sm text-fuchsia-300">{{ number_format($player->credits) }} 💎</div></div>
                <div class="card !rounded-xl p-4"><div class="small font-extrabold uppercase tracking-wider text-mute mb-1.5">В игре с</div><div class="font-extrabold text-sm">{{ $player->account_created?->format('d.m.Y') }}</div></div>
                <div class="card !rounded-xl p-4"><div class="small font-extrabold uppercase tracking-wider text-mute mb-1.5">В сети</div><div class="font-extrabold text-sm">{{ $player->last_online?->diffForHumans() }}</div></div>
            </div>

            @if($isOwner)
                <div class="mt-6 rounded-xl border border-violet-400/30 bg-violet-500/10 px-4 py-3.5 small text-violet-200 flex items-center gap-2.5">
                    👋 Это твой профиль. Редактирование миссии и внешности — в следующем обновлении.
                </div>
            @endif
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('players.index') }}" class="btn btn-ghost !text-[10px]">← ВСЕ ЖИТЕЛИ</a>
    </div>
</div>
@endsection
