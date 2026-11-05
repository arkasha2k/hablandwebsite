{{-- 🆕 /admin/logs — действия персонала (таблица activity_logs) --}}
@extends('layouts.admin')

@section('title', 'Логи · Админка')

@php
    $filters = [
        ''            => 'Все события',
        'news'        => '📰 Новости',
        'user.ban'    => '🔨 Баны',
        'user.unban'  => '✅ Разбаны',
        'user.rank'   => '🎖 Ранги',
        'user.edit'   => '📝 Правки профилей',
    ];
@endphp

@section('admin-content')
    <h1 class="h1 mb-6">🧾 Логи действий персонала</h1>

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach ($filters as $key => $label)
            <a href="{{ route('admin.logs', array_filter(['action' => $key])) }}"
               class="btn-nav no-underline {{ $action === $key ? 'is-active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm" style="border-collapse:collapse;">
            <thead>
                <tr class="text-left small text-mute uppercase tracking-wider border-b border-line">
                    <th class="p-3">Когда</th>
                    <th class="p-3">Кто</th>
                    <th class="p-3">Действие</th>
                    <th class="p-3">Описание</th>
                    <th class="p-3">IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $log)
                    <tr class="border-b border-line last:border-0 align-top">
                        <td class="p-3 text-mute whitespace-nowrap">{{ $log->created_at_int?->format('d.m.Y H:i') }}</td>
                        <td class="p-3 font-bold text-violet-300 whitespace-nowrap">{{ $log->user?->username ?? '—' }}</td>
                        <td class="p-3 whitespace-nowrap">
                            <span class="small font-bold border rounded-full px-2 py-0.5
                                {{ match($log->action_color) { 'cyan' => 'text-cyan-300 border-cyan-400/30 bg-cyan-500/10',
                                   'rose' => 'text-rose-300 border-rose-400/30 bg-rose-500/10',
                                   'fuchsia' => 'text-fuchsia-300 border-fuchsia-400/30 bg-fuchsia-500/10',
                                   default => 'text-violet-300 border-violet-400/30 bg-violet-500/10' } }}">
                                {{ $log->action_label }}
                            </span>
                        </td>
                        <td class="p-3">{{ $log->description }}</td>
                        <td class="p-3 text-mute whitespace-nowrap">{{ $log->ip ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-6 text-mute">Пусто. Как только персонал что-то изменит — запись появится здесь.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $items->links() }}</div>

    <p class="small text-mute mt-4">
        💡 Системные ошибки Laravel пишутся в <code>storage/logs/laravel.log</code>, а эмулятор ведёт свои таблицы
        (<code>bans</code>, <code>visits</code>). Здесь — только управленческие действия, зафиксированные CMS.
    </p>
@endsection
