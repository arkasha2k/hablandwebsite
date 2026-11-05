{{-- 🆕 /admin — дашборд персонала --}}
@extends('layouts.admin')

@section('title', 'Админка · Habland Hotel')

@php
    $tiles = [
        ['👥', 'Игроков', number_format($users, 0, ',', ' '), route('admin.users.index'), 'violet'],
        ['🟢', 'Онлайн', (string) $online, null, 'emerald'],
        ['📰', 'Новостей', (string) $newsTotal, route('admin.news.index'), 'cyan'],
        ['🔨', 'Активных банов', (string) $bansActive, route('admin.users.index'), 'rose'],
        ['🚪', 'Визитов сегодня', number_format($visitsToday, 0, ',', ' '), null, 'fuchsia'],
    ];
    $tileColor = ['violet' => 'text-violet-300', 'emerald' => 'text-emerald-300',
                  'cyan' => 'text-cyan-300', 'rose' => 'text-rose-300', 'fuchsia' => 'text-fuchsia-300'];
@endphp

@section('admin-content')
    <h1 class="h1 mb-6">🛡 Панель управления</h1>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        @foreach ($tiles as [$icon, $label, $value, $link, $color])
            <a href="{{ $link ?? '#' }}" class="card p-4 no-underline text-inherit block {{ $link ? 'card-hover' : 'pointer-events-none' }}">
                <div class="text-2xl">{{ $icon }}</div>
                <div class="h3 !text-lg {{ $tileColor[$color] }}">{{ $value }}</div>
                <div class="small text-mute">{{ $label }}</div>
            </a>
        @endforeach
    </div>

    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.news.create') }}" class="btn btn-cyan !py-3 !px-6">✍️ Новая новость</a>
        <a href="{{ route('admin.logs') }}" class="btn-ghost !py-3 !px-6 no-underline">🧾 Все действия персонала</a>
    </div>

    {{-- Последние действия --}}
    <section class="card p-5 md:p-6">
        <h2 class="h3 mb-4">Последние действия</h2>
        @forelse ($recentLogs as $log)
            <div class="flex items-start gap-3 py-2 border-b border-line last:border-0 small">
                <span class="opacity-60 shrink-0 w-28 text-mute">{{ $log->created_at_int?->diffForHumans(locale: 'ru', short: true) }}</span>
                <span class="font-bold text-violet-300 shrink-0">{{ $log->user?->username ?? '—' }}</span>
                <span class="text-mute">{{ $log->description }}</span>
            </div>
        @empty
            <p class="small text-mute">Пока тихо. Действия админов появятся здесь.</p>
        @endforelse
    </section>
@endsection
