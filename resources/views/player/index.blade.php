@extends('layouts.app')

@section('title', 'Игроки — Habland Hotel')

@section('content')
<div class="fade-up">
    <h1 class="h2 mb-2">Жители отеля</h1>
    <p class="small text-mute mb-7">{{ $players->total() }} {{ trans_choice('человек уже в игре|человека уже в игре|человек уже в игре', $players->total()) }}</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
        @foreach($players as $p)
            <a href="{{ route('player.show', $p->username) }}" class="card card-hover p-4 text-center relative">
                @if($p->isOnline())
                    <span class="absolute top-3 right-3 dot" title="В отеле"></span>
                @endif
                <div class="floaty inline-block">
                    <img src="{{ $p->getAvatarUrl() }}" alt="{{ $p->username }}" loading="lazy" width="64" height="110"
                         class="rounded-xl bg-gradient-to-b from-violet-500/25 to-transparent">
                </div>
                <div class="mt-3 font-extrabold text-sm truncate">{{ $p->username }}</div>
                <div class="small text-mute truncate">«{{ $p->motto }}»</div>
                <div class="mt-2 small font-bold text-fuchsia-300/80">{{ number_format($p->credits) }} 💎</div>
            </a>
        @endforeach
    </div>

    <div class="mt-9">{{ $players->links() }}</div>
</div>
@endsection
