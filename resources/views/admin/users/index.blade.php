{{-- 🆕 /admin/users — список игроков с поиском, фильтром по рангу и статусом бана --}}
@extends('layouts.admin')

@section('title', 'Игроки · Админка')

@section('admin-content')
    <h1 class="h1 mb-6">👥 Игроки</h1>

    <form method="GET" class="flex flex-wrap gap-2 mb-6 max-w-2xl items-center">
        <input type="search" name="q" value="{{ $search }}" class="field flex-1 min-w-[200px]" placeholder="Ник…">
        <select name="rank" class="field w-auto">
            <option value="">Все ранги</option>
            @foreach ([7=>'Владелец',6=>'Администратор',5=>'Менеджер',4=>'Модератор',3=>'Эксперт',1=>'Житель'] as $r=>$lbl)
                <option value="{{ $r }}" @selected(request('rank') == $r)>{{ $lbl }} ({{ $r }})</option>
            @endforeach
        </select>
        <button class="btn-ghost !py-3 px-5 shrink-0">Найти</button>
    </form>

    <div class="space-y-2">
        @forelse ($items as $u)
            @php $isBanned = in_array($u->id, $banIds); @endphp
            <div class="card p-3.5 flex items-center gap-4 flex-wrap {{ $isBanned ? '!border-rose-400/40' : '' }}">
                <img src="{{ $u->getAvatarUrl(1, 'c') }}" alt="" width="44" height="44"
                     class="rounded-lg bg-panel border border-line shrink-0">
                <div class="flex-1 min-w-[200px]">
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('player.show', $u->username) }}" target="_blank" rel="noopener"
                           class="h3 hover:text-fuchsia-300 transition no-underline text-inherit">{{ $u->username }}</a>
                        <span class="small text-mute">#{{ $u->id }}</span>
                        @if($u->rank >= 4)
                            <span class="small font-bold uppercase border rounded-full px-2 py-0.5 text-fuchsia-300 border-fuchsia-400/30 bg-fuchsia-500/10">
                                🛡 {{ $u->rank_name }}
                            </span>
                        @endif
                        @if($isBanned)
                            <span class="small font-bold uppercase border rounded-full px-2 py-0.5 text-rose-300 border-rose-400/30 bg-rose-500/10">🔨 Бан</span>
                        @elseif($u->isOnline())
                            <span class="small font-bold uppercase border rounded-full px-2 py-0.5 text-emerald-300 border-emerald-400/30 bg-emerald-500/10">🟢 Онлайн</span>
                        @endif
                    </div>
                    <div class="small text-mute mt-1">
                        💰 {{ number_format($u->credits, 0, ',', ' ') }} ·
                        😴 {{ $u->last_online?->diffForHumans(locale: 'ru', short: true) ?? 'никогда' }}
                    </div>
                </div>
                <a href="{{ route('admin.users.edit', $u) }}" class="btn-nav no-underline">⚙️ Управлять</a>
            </div>
        @empty
            <p class="card p-6 text-mute small">Никого не нашли.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $items->links() }}</div>
@endsection
