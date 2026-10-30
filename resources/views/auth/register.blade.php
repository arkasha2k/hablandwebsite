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
            <div class="rounded-xl border border-rose-400/40 bg-rose-500/10 px-4 py-3 mb-5 small text-rose-300">
                <div class="font-extrabold mb-1">Проверь данные:</div>
                <ul class="list-disc list-inside space-y-0.5 marker:text-rose-400/70">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="username" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Никнейм</label>
                <input id="username" name="username" value="{{ old('username') }}"
                       class="field {{ $errors->has('username') ? '!border-rose-400' : '' }}"
                       maxlength="16" placeholder="Латиница, цифры, _ и -" required autofocus autocomplete="username"
                       aria-required="true" aria-describedby="username-hint"
                       @if($errors->has('username')) aria-invalid="true" aria-describedby="username-error" @endif>
                @error('username')
                    <p id="username-error" class="small text-rose-300 mt-1.5 font-bold">✖ {{ $message }}</p>
                @else
                    <p id="username-hint" class="small text-mute mt-1.5">3–16 символов: латиница, цифры, «_» и «-»</p>
                @enderror
            </div>
            <div>
                <label for="mail" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">E-mail</label>
                <input id="mail" type="email" name="mail" value="{{ old('mail') }}"
                       class="field {{ $errors->has('mail') ? '!border-rose-400' : '' }}"
                       placeholder="you@example.com" required autocomplete="email"
                       aria-required="true" @if($errors->has('mail')) aria-invalid="true" aria-describedby="mail-error" @endif>
                @error('mail') <p id="mail-error" class="small text-rose-300 mt-1.5 font-bold">✖ {{ $message }}</p> @enderror
            </div>
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="password" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Пароль</label>
                    <input id="password" type="password" name="password"
                           class="field {{ $errors->has('password') ? '!border-rose-400' : '' }}"
                           placeholder="Мин. 6 символов" required autocomplete="new-password"
                           aria-required="true" @if($errors->has('password')) aria-invalid="true" aria-describedby="password-error" @endif>
                    @error('password') <p id="password-error" class="small text-rose-300 mt-1.5 font-bold">✖ {{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Ещё раз</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="field {{ $errors->has('password') ? '!border-rose-400' : '' }}"
                           placeholder="Повтори" required autocomplete="new-password" aria-required="true">
                </div>
            </div>
            <div>
                <span id="gender-label" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Персонаж</span>
                <div class="grid grid-cols-2 gap-3" role="radiogroup" aria-labelledby="gender-label"
                     @if($errors->has('gender')) aria-describedby="gender-error" @endif>
                    <label class="cursor-pointer">
                        <input type="radio" name="gender" value="M" class="hidden peer" @checked(old('gender', 'M') === 'M') required>
                        <div class="rounded-xl border-2 border-line bg-ink/70 p-3 text-center transition peer-checked:border-violet-500 peer-checked:bg-violet-500/15 hover:border-violet-400/50">
                            <span class="mx-auto h-24 flex items-center justify-center text-6xl select-none" aria-hidden="true">🧍‍♂️</span>
                            <div class="mt-2 text-sm font-extrabold">Мужской</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="gender" value="F" class="hidden peer" @checked(old('gender') === 'F')>
                        <div class="rounded-xl border-2 border-line bg-ink/70 p-3 text-center transition peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-500/15 hover:border-fuchsia-400/50">
                            <span class="mx-auto h-24 flex items-center justify-center text-6xl select-none" aria-hidden="true">🧍‍♀️</span>
                            <div class="mt-2 text-sm font-extrabold">Женский</div>
                        </div>
                    </label>
                </div>
                @error('gender') <p id="gender-error" class="small text-rose-300 mt-1.5 font-bold">✖ {{ $message }}</p> @enderror
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
