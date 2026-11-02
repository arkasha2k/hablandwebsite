{{-- 🆕 НОВЫЙ ФАЙЛ: resources/views/news/show.blade.php --}}
@extends('layouts.app')

@section('title', $item->title . ' — Новости — Habland Hotel')
@section('og_title', $item->title . ' — Новости Habland Hotel')
@section('og_description', Str::limit(strip_tags($item->excerpt ?? $item->content), 180))

@section('content')
<article class="fade-up pt-6 md:pt-10 max-w-3xl mx-auto">

    {{-- Хлебные крошки --}}
    <nav aria-label="Хлебные крошки" class="small mb-5">
        <a href="{{ route('home') }}" class="text-violet-300 hover:text-fuchsia-300 font-bold">Главная</a>
        <span class="text-mute mx-1.5">/</span>
        <a href="{{ route('news.index') }}" class="text-violet-300 hover:text-fuchsia-300 font-bold">Новости</a>
        <span class="text-mute mx-1.5">/</span>
        <span class="text-mute">{{ Str::limit($item->title, 40) }}</span>
    </nav>

    <div class="card p-6 md:p-10">
        <div class="flex items-center gap-2.5 flex-wrap mb-4">
            @php
                $badge = match($item->category_color) {
                    'cyan'    => 'text-cyan-300 bg-cyan-500/10 border-cyan-400/30',
                    'emerald' => 'text-emerald-300 bg-emerald-500/10 border-emerald-400/30',
                    default   => 'text-fuchsia-300 bg-fuchsia-500/10 border-fuchsia-400/30',
                };
            @endphp
            <span class="small font-bold uppercase tracking-wider border rounded-full px-2.5 py-0.5 {{ $badge }}">
                {{ $item->category_label }}
            </span>
            <time class="small text-mute" datetime="{{ $item->created_at_int?->toIso8601String() }}">
                {{ $item->created_at_int?->format('d.m.Y H:i') }}
            </time>
        </div>

        <h1 class="h1 !text-2xl sm:!text-3xl md:!text-4xl mb-6">{{ $item->title }}</h1>

        {{-- Текст новости: переносы строк -> <br>, экранирование через e() --}}
        <div class="lead whitespace-pre-line">{!! nl2br(e($item->body)) !!}</div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('news.index') }}" class="btn btn-ghost">← Все новости</a>
        @auth
            <a href="{{ route('play') }}" class="btn btn-cyan">▶ В ИГРУ</a>
        @else
            <a href="{{ route('register') }}" class="btn">▶ ЗАСЕЛИТЬСЯ</a>
        @endauth
    </div>
</article>

@if($related->count())
<section class="reveal mt-14 max-w-3xl mx-auto">
    <h2 class="h2 mb-5">Ещё почитать</h2>
    <div class="grid gap-4">
        @foreach($related as $r)
            <x-news-card :item="$r" />
        @endforeach
    </div>
</section>
@endif
@endsection
