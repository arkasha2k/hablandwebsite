{{-- 🆕 /admin/news — список новостей с поиском --}}
@extends('layouts.admin')

@section('title', 'Новости · Админка')

@section('admin-content')
    <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
        <h1 class="h1">📰 Новости</h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-cyan !py-3 !px-6">✍️ Создать</a>
    </div>

    <form method="GET" class="flex gap-2 mb-6 max-w-md">
        <input type="search" name="q" value="{{ $search }}" class="field" placeholder="Поиск по заголовку…">
        <button class="btn-ghost !py-3 px-5 shrink-0">Найти</button>
    </form>

    <div class="space-y-3">
        @forelse ($items as $item)
            <div class="card p-4 flex items-center gap-4 flex-wrap">
                <div class="flex-1 min-w-[220px]">
                    <div class="flex items-center gap-2 flex-wrap">
                        @if($item->featured)<span title="Главная">⭐</span>@endif
                        <a href="{{ route('news.show', $item->id) }}" target="_blank" rel="noopener"
                           class="h3 hover:text-fuchsia-300 transition no-underline text-inherit">{{ $item->title }}</a>
                        <span class="small font-bold uppercase tracking-wider border rounded-full px-2 py-0.5
                            {{ match($item->category_color) { 'cyan' => 'text-cyan-300 border-cyan-400/30 bg-cyan-500/10', 'emerald' => 'text-emerald-300 border-emerald-400/30 bg-emerald-500/10', default => 'text-fuchsia-300 border-fuchsia-400/30 bg-fuchsia-500/10' } }}">
                            {{ $item->category_label }}
                        </span>
                    </div>
                    <div class="small text-mute mt-1">
                        {{ $item->created_at_int?->format('d.m.Y H:i') }} · id {{ $item->id }}
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.news.edit', $item) }}" class="btn-nav no-underline">✏️ Править</a>
                    <form method="POST" action="{{ route('admin.news.destroy', $item) }}"
                          onsubmit="return confirm('Удалить новость «{{ addslashes($item->title) }}»?')">
                        @csrf @method('DELETE')
                        <button class="btn-nav !text-rose-300">🗑 Удалить</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="card p-6 text-mute small">Новостей нет — создайте первую!</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $items->links() }}</div>
@endsection
