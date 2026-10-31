@extends('layouts.app')

@section('title', 'Вход — Habland Hotel')

@section('content')
<div class="max-w-md mx-auto fade-up">
    <div class="card p-6 md:p-9">
        <div class="text-center mb-8">
            <span class="inline-block text-4xl mb-4" aria-hidden="true">🔑</span>
            <h1 class="h2">С возвращением</h1>
            <p class="small text-mute mt-2">Отель ждал именно тебя</p>
        </div>

        @if($errors->any())
            <div class="rounded-xl border border-rose-400/40 bg-rose-500/10 px-4 py-3 mb-5 small text-rose-300">
                <div class="font-extrabold mb-1">Проверь данные:</div>
                <ul class="list-disc list-inside space-y-0.5 marker:text-rose-400/70">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="username" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Никнейм</label>
                <input id="username" name="username" value="{{ old('username') }}"
                       class="field {{ $errors->has('username') ? '!border-rose-400' : '' }}"
                       placeholder="Твой ник в отеле" required autofocus autocomplete="username"
                       aria-required="true" @if($errors->has('username')) aria-invalid="true" aria-describedby="username-error" @endif>
                @error('username') <p id="username-error" class="small text-rose-300 mt-1.5 font-bold">✖ {{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Пароль</label>
                <input id="password" type="password" name="password"
                       class="field {{ $errors->has('password') ? '!border-rose-400' : '' }}"
                       placeholder="••••••••" required autocomplete="current-password"
                       aria-required="true" @if($errors->has('password')) aria-invalid="true" aria-describedby="password-error" @endif>
                @error('password') <p id="password-error" class="small text-rose-300 mt-1.5 font-bold">✖ {{ $message }}</p> @enderror
            </div>
            <label class="flex items-center gap-2.5 small text-mute cursor-pointer select-none">
                <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded accent-violet-500">
                Запомнить меня
            </label>
            <button class="btn w-full">▶ ВОЙТИ В ОТЕЛЬ</button>
        </form>

        <p class="text-center small text-mute mt-7">
            Нет аккаунта?
            <a href="{{ route('register') }}" class="font-bold text-violet-300 hover:text-fuchsia-300 transition">Создать за минуту</a>
        </p>
    </div>
</div>
@endsection
