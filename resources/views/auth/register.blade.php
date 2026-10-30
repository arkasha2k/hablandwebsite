@extends('layouts.app')

@section('title', 'Регистрация — Habland Hotel')

@section('content')
<div class="max-w-md mx-auto fade-up">
    <div class="card p-6 md:p-9">
        <div class="text-center mb-8">
            <span class="inline-block text-4xl mb-4" aria-hidden="true">✨</span>
            <h1 class="h2">Заселение в отель</h1>
            <p class="small text-mute mt-2">100 кредитов уже ждут тебя</p>
        </div>

        @if($errors->any())
            <div class="rounded-xl border border-rose-400/40 bg-rose-500/10 px-4 py-3 mb-5 small text-rose-300 space-y-1">
                @foreach($errors->all() as $e) <div>✖ {{ $e }}</div> @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="username" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Никнейм</label>
                <input id="username" name="username" value="{{ old('username') }}" class="field" maxlength="16" placeholder="Латиница, цифры, _ и -" required autofocus autocomplete="username">
            </div>
            <div>
                <label for="mail" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">E-mail</label>
                <input id="mail" type="email" name="mail" value="{{ old('mail') }}" class="field" placeholder="you@example.com" required autocomplete="email">
            </div>
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="password" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Пароль</label>
                    <input id="password" type="password" name="password" class="field" placeholder="Мин. 6 символов" required autocomplete="new-password">
                </div>
                <div>
                    <label for="password_confirmation" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Ещё раз</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="field" placeholder="Повтори" required autocomplete="new-password">
                </div>
            </div>
            <div>
                <span class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Персонаж</span>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="gender" value="M" class="hidden peer" @checked(old('gender') === 'M') required>
                        <div class="rounded-xl border-2 border-line bg-ink/70 p-3 text-center transition peer-checked:border-violet-500 peer-checked:bg-violet-500/15 hover:border-violet-400/50">
                            <img src="https://www.habbo.com.tr/habbo-imaging/avatarimage?figure=hr-115-42.hd-190-1.ch-215-62.lg-285-91.sh-290-62&direction=2" alt="Мужской персонаж" class="mx-auto h-24" width="64" height="96">
                            <div class="mt-2 text-sm font-extrabold">Мужской</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="gender" value="F" class="hidden peer" @checked(old('gender') === 'F')>
                        <div class="rounded-xl border-2 border-line bg-ink/70 p-3 text-center transition peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-500/15 hover:border-fuchsia-400/50">
                            <img src="https://www.habbo.com.tr/habbo-imaging/avatarimage?figure=hr-540-42.hd-605-1.ch-645-62.lg-715-91.sh-735-62&direction=2" alt="Женский персонаж" class="mx-auto h-24" width="64" height="96">
                            <div class="mt-2 text-sm font-extrabold">Женский</div>
                        </div>
                    </label>
                </div>
            </div>
            <button class="btn w-full">▶ ЗАСЕЛИТЬСЯ</button>
        </form>

        <p class="text-center small text-mute mt-7">
            Уже живёшь у нас?
            <a href="{{ route('login') }}" class="font-bold text-violet-300 hover:text-fuchsia-300 transition">Войти</a>
        </p>
    </div>
</div>
@endsection
