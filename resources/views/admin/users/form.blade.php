{{-- 🆕 /admin/users/{id}/edit — карточка игрока: правка + баны --}}
@extends('layouts.admin')

@section('title', $user->username . ' · Админка')

@section('admin-content')
    <div class="flex items-center gap-4 mb-6 flex-wrap">
        <img src="{{ $user->getAvatarUrl(0, 'm') }}" alt="" width="64" height="64"
             class="rounded-xl bg-panel border border-line">
        <div>
            <h1 class="h1 !text-2xl md:!text-3xl">{{ $user->emoji }} {{ $user->username }}</h1>
            <p class="small text-mute">#{{ $user->id }} · {{ $user->rank_name }} · регистрация
                {{ $user->account_created?->format('d.m.Y') ?? '—' }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 items-start">
        {{-- Правка --}}
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="card p-5 space-y-4">
            @csrf @method('PUT')
            <h2 class="h3">✏️ Правка профиля</h2>

            <div>
                <label for="motto" class="small text-mute block mb-1">Девиз</label>
                <input id="motto" name="motto" maxlength="64" class="field" value="{{ old('motto', $user->motto) }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="credits" class="small text-mute block mb-1">Кредиты 💰</label>
                    <input id="credits" name="credits" type="number" min="0" max="999999"
                           class="field" value="{{ old('credits', $user->credits) }}">
                </div>
                <div>
                    <label for="rank" class="small text-mute block mb-1">Ранг</label>
                    <select id="rank" name="rank" class="field">
                        @foreach ([0=>'Обычный (0)',1=>'Житель (1)',3=>'Эксперт (3)',4=>'Модератор (4)',5=>'Менеджер (5)',6=>'Администратор (6)',7=>'Владелец (7)'] as $r=>$lbl)
                            <option value="{{ $r }}" @selected(old('rank', $user->rank) == $r)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @error('rank')<p class="small text-rose-300">{{ $message }}</p>@enderror

            <button class="btn btn-cyan !py-3 w-full">💾 Сохранить</button>
        </form>

        {{-- Выдать бан --}}
        <form method="POST" action="{{ route('admin.ban.store', $user) }}" class="card p-5 space-y-4 !border-rose-400/30">
            @csrf
            <h2 class="h3">🔨 Выдать бан</h2>

            <div>
                <label for="reason" class="small text-mute block mb-1">Причина</label>
                <input id="reason" name="reason" maxlength="200" required class="field"
                       placeholder="Оскорбления в чате…">
                @error('reason')<p class="small text-rose-300">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="type" class="small text-mute block mb-1">Тип</label>
                    <select id="type" name="type" class="field">
                        <option value="account">Аккаунт</option>
                        <option value="ip">По IP</option>
                        <option value="machine">По железу</option>
                        <option value="super">SUPER (всё сразу)</option>
                    </select>
                </div>
                <div>
                    <label for="days" class="small text-mute block mb-1">Срок, дней (0 = навсегда)</label>
                    <input id="days" name="days" type="number" min="0" max="3650" value="1" class="field">
                </div>
            </div>

            <button class="btn !bg-gradient-to-br !from-rose-500 !to-fuchsia-700 !shadow-[0_6px_0_#881337] !py-3 w-full">
                🔒 Забанить
            </button>
        </form>
    </div>

    {{-- История банов игрока --}}
    <section class="card p-5 mt-6">
        <h2 class="h3 mb-3">🧾 Бан этой учётной записи</h2>
        @forelse ($bans as $ban)
            <div class="flex items-center gap-3 py-2.5 border-b border-line last:border-0 small flex-wrap">
                <span class="{{ $ban->is_active ?? $ban->isActive() ? 'text-rose-300 font-bold' : 'text-mute line-through' }}">
                    {{ $ban->isActive() ? '🔴 активен' : '⚪ истёк/снят' }}
                </span>
                <span class="font-bold">{{ $ban->type_label }}</span>
                <span class="text-mute flex-1">{{ $ban->ban_reason ?: '—' }}
                    · с {{ \Carbon\Carbon::createFromTimestamp($ban->timestamp)->format('d.m.Y') }}
                    @if($ban->expires_at) по {{ $ban->expires_at->format('d.m.Y H:i') }} @else · навсегда @endif
                    · выдал: {{ $ban->staff?->username ?? '#' . $ban->user_staff_id }}
                </span>
                <form method="POST" action="{{ route('admin.ban.destroy', $ban) }}">
                    @csrf @method('DELETE')
                    <button class="btn-nav !text-emerald-300">✅ Снять</button>
                </form>
            </div>
        @empty
            <p class="small text-mute">Б банов нет. Молодец, гражданин! 👏</p>
        @endforelse
    </section>

    <a href="{{ route('admin.users.index') }}" class="btn-ghost !py-3 px-6 no-underline inline-block mt-6">← К списку игроков</a>
@endsection
